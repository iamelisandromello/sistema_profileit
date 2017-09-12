<?php

class Answer extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'answers';
	}

  public function relations()
  {
    return array(
    	'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
    );
  }

  public static function preQuestionnaire ($user) {
    $questionnaire_data = array();    

    //Pergunta 2 - Experiência
    $total = User::experiencia($user);
    $experiencia = 0;

    if ($total >= 8) {
      $experiencia = 1; 
    }
    else if ( $total < 8 && $total >= 5 ) {
      $experiencia = 2;
    }
    else if ( $total < 5 && $total >= 3 ) {
      $experiencia = 3;
    }
    else if ( $total < 3 && $total >= 1 ) {
      $experiencia = 4;
    }
    else if ( $total < 1) {
      $experiencia = 5;
    }
    $questionnaire_data[0] = $experiencia;
    
    //Pergunta 4,5,6 e 7 - Formação Acadêmica
    $graduacao = Academic::listFormations($user);
    $questionnaire_data[1] = $graduacao[0];
    $questionnaire_data[2] = $graduacao[1];
    $questionnaire_data[3] = $graduacao[2];
    $questionnaire_data[4] = $graduacao[3];

    return $questionnaire_data;
  }
  
  public static function verificar($user_id)
  {
    $user = Answer::find_by_user_id($user_id);
    $answerbackObj = new \stdClass;// Cria classe vazia
    $answerbackObj->status = false;// Propriedade Status da Classe False

    if ($user) {
      $answerbackObj->status = true;
      return $answerbackObj;
    }
    
    return $answerbackObj;
  }

  public static function cadastrar(array $post, $user_id)
  {
    $callbackObj = new \stdClass;// Cria classe vazia
    $callbackObj->answer = null;// Propriedade user da classe null
    $callbackObj->status = false;// Propriedade Status da Classe False
    $callbackObj->errors = array();// Array padrão de erros vazio

    //array de informações adicionais para Novo Questionário
    $answer_data = array(
      'user_id'  => $user_id
    );
   
    $post = array_merge($post, $answer_data);

    $cadastrar = self::create($post);

    if ($cadastrar->is_valid()) {
      $callbackObj->answer = $cadastrar;
      $callbackObj->status = true;
      return $callbackObj;
    }

    $errors = $cadastrar->errors->get_raw_errors();

    foreach ($errors as $field => $message) {
      array_push($callbackObj->errors, $message[0]);
    }

    return $callbackObj;
  }

}