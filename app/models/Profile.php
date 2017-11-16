<?php

class Profile extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'profiles';
	}

  //Relacionamnetos 1:1 entre as tabelas
  static $belongs_to = array(
    array('pattern', 'foreign_key' => 'profile_id', 'class_name' => 'Pattern'),
    array('opportunity', 'foreign_key' => 'profile_id', 'class_name' => 'Opportunity')
  );

  //Relacionamnetos 1:n entre as tabelas
  static $has_many = array(
    array('definitions')
  );

  public static function backProfile($idProfile)
  {
    $respostaspl = Pattern::find_by_profile_id($idProfile);
    $pesos = array();

    for ($i=1; $i < 16 ; $i++) {
      $questao = 'answer_' . $i; //concatena a expresão com o contador, para formar o campo
      $valor = $respostaspl->$questao; //recupera a opção do Analista na Patterns
      $quesito = Parameter::find_by_id($i); //Recupera o Atributo (Idioma, Experiencia...)
      $weigths = $quesito->weight_id; //ID do Atributo a ser recuperado o peso
      $pesosRecuperados = Weight::find_by_id($weigths);//Recupera os Pesos do Atributo
      $opcao = 'option_' . $valor; //Concatena a expressao com a Opcao Selecionada p/Usuario
      $pesos[$i-1] = $pesosRecuperados->$opcao; //Array com os Pesos do Analista
    }
    return $pesos;
  }

  public static function backUserWeights($idUser){
    $respostasusuario = Answer::find_by_user_id($idUser);
    $pesos_usuario = array();

    for ($i=1; $i < 16 ; $i++) {
      $questao = 'question_' . $i; //concatena a expresão com o contador, para formar o campo
      $valor = $respostasusuario->$questao; //recupera a opção selecionada pelo Usuario na Answers
      $quesito = Parameter::find_by_id($i); //Recupera o Atributo (Idioma, Experiencia...)
      $weigths = $quesito->weight_id; //ID do Atributo a ser recuperado o peso
      $pesosRecuperados = Weight::find_by_id($weigths);//Recupera os Pesos do Atributo
      $opcaoUser = 'option_' . $valor; //Concatena a expressao com a Opcao Selecionada p/Usuario
      $pesos_usuario[$i-1] = $pesosRecuperados->$opcaoUser; //Array com os Pesos do Usuario
    }
    return $pesos_usuario;
  }

  public static function backChargeWeights($idAttribute){
    $atributosVaga = Attribute::find_by_id($idAttribute);
    $pesos_vaga = array();

    for ($i=1; $i < 16 ; $i++) {
      $atributo = 'attribute_' . $i; //concatena a expresão com o contador, para formar o campo
      $valor = $atributosVaga->$atributo; //recupera a opção selecionada pelo Usuario na Answers
      $quesito = Parameter::find_by_id($i); //Recupera o Atributo (Idioma, Experiencia...)
      $weigths = $quesito->weight_id; //ID do Atributo a ser recuperado o peso
      $pesosRecuperados = Weight::find_by_id($weigths);//Recupera os Pesos do Atributo
      $opcaoUser = 'option_' . $valor; //Concatena a expressao com a Opcao Selecionada p/Usuario
      $pesos_vaga[$i-1] = $pesosRecuperados->$opcaoUser; //Array com os Pesos do Usuario
    }
    return $pesos_vaga;
  }

  public static function calculoPesos($peso, $pesoProfile, $pesoUsuario)
  {
    return $valor = ($peso * abs ($pesoProfile - $pesoUsuario)**2);
  }

  public static function calculoFinal($pesos_usuario, $pesos_analista)
  {
   $calcularPesos = 0.0000;
    for ($i=0; $i < 15; $i++) {
      $idParameter = Parameter::find_by_id($i+1);
      $pesoDominio = $idParameter->heft;
      $pesoU = $pesos_usuario[$i];
      $pesoA = $pesos_analista[$i];
      $valor = self::calculoPesos($pesoDominio, $pesoU, $pesoA);
      $calcularPesos = $calcularPesos + $valor;
    }
    $calcularPesos = ($calcularPesos**(1/2));
    return $calcularPesos;
  }

   public static function defineProfile($pesos_usuario)
   {
    $profilesAll = Profile::all();//Recuper Perfis Padrões (Junior, Pleno e Sênior)
    $ctr = array();
    $ctr[0] = 0.00;

      foreach ($profilesAll as $profile) {
         $type = $profile->type;
         $pesos = self::backProfile($type);
         $callBack = self::calculoFinal($pesos_usuario, $pesos);

         if($callBack == 0){ //Verfica se Cálculo Retorna Desvio Padrão 0.00
           $ctr[0] = $callBack;//caso desvio 0.00 já define o perfil
           $ctr[1] = $type;
           break;//Interrompe a análise e retorna $ctr (Desvio Padrão e Tipo Perfil)
         }
         if ($ctr[0] == 0.00) { //Primeiro verificação atribui os parametros
           $ctr[0] = $callBack;
           $ctr[1] = $type;
         }
         else if ($callBack <= $ctr[0]) { //Verifica se Desvio é < que atual armazenado
           $ctr[0] = $callBack; //Desvio Padrão
           $ctr[1] = $type; //Tipo de Perfil (1,2,3)
         }
      }
      return $ctr;
   }

   public static function recalculateProfile($id_usuario)
   {
      $callbackObj = new \stdClass;// Cria classe vazia
      $callbackObj->profile = null;// Propriedade user da classe null
      $callbackObj->status = false;// Propriedade Status da Classe False
      $callbackObj->errors = array();// Array padrão de erros vazio

      $pesos_backUser = Profile::backUserWeights($id_usuario);
      if (!$pesos_backUser) {
         array_push($callbackObj->errors, 'Oops! Não foi possível recuperar os parametros de cálculo do Perfil Informado. Por favor, revise informações e tente novamente');
         return $callbackObj;
      }

      $controle = Profile::defineProfile($pesos_backUser);
      if (!$controle) {
         array_push($callbackObj->errors, 'Oops! Não foi possível realizar o cálculo de definição do Perfil Informado. Por favor, revise informações e tente novamente');
         return $callbackObj;
      }

      $atualizarDefinition = Definition::atualizar($controle, $id_usuario);
      if ($atualizarDefinition) {
         $callbackObj->definition = $atualizarDefinition;
         $callbackObj->status = true;
         return $callbackObj;
      }

      $errors = $atualizarDefinition->errors->get_raw_errors();
      foreach ($errors as $field => $message) {
         array_push($callbackObj->errors, $message[0]);
      }
      return $callbackObj;
   }
}