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

   public static function preQuestionnaire ($user, $user_id) {
      $questionnaire_data = array();

      //Pergunta 2 - Experiência
      $total = User::experiencia($user);
      $experiencia = 0;

      if ($total[0] >= 8) {
         $experiencia = 5;
      }
      else if ( $total[0] < 8 && $total[0] >= 5 ) {
         $experiencia = 4;
      }
      else if ( $total[0] < 5 && $total[0] >= 3 ) {
         $experiencia = 3;
      }
      else if ( $total[0] < 3 && $total[0] >= 1 ) {
         $experiencia = 2;
      }
      else if ( $total[0] < 1) {
         $experiencia = 1;
      }
      $questionnaire_data[0] = $experiencia;

      //Pergunta 4,5,6 e 7 - Formação Acadêmica
      $graduacao = Academic::listFormations($user);
      $questionnaire_data[1] = $graduacao[0];
      $questionnaire_data[2] = $graduacao[1];
      $questionnaire_data[3] = $graduacao[2];
      $questionnaire_data[4] = $graduacao[3];

      //Pergunta 4,5,6 e 7 - Formação Acadêmica
      $resumo    = User::summaries($user_id);
      if ($resumo['Microsoft'] == null) {
         $questionnaire_data[5] =  1;
      }
      else if ($resumo['Microsoft'] == 'Certificação MCP') {
         $questionnaire_data[5] =  2;
      }
      else if ($resumo['Microsoft'] == 'Certificação MCTIP') {
         $questionnaire_data[5] =  3;
      }
      else if ($resumo['Microsoft'] == 'Certificação MCSA') {
         $questionnaire_data[5] =  4;
      }
      else if ($resumo['Microsoft'] == 'Certificação MCSE') {
         $questionnaire_data[5] =  5;
      }

      if ($resumo['Itil'] == 'Nao') {
         $questionnaire_data[6] =  null;
      }
      else if($resumo['Itil'] == 'Foundation' || $resumo['Itil'] == 'Expert') {
         $questionnaire_data[6] =  4;
      }
      else if($resumo['Itil'] == 'Master') {
         $questionnaire_data[6] =  5;
      }

      $questionnaire_data[7]  = ($resumo['Virtualizacao']) ? 4 : null;
      $questionnaire_data[8]  = ($resumo['Cisco']) ? 4 : null;
      $questionnaire_data[9]  = ($resumo['Agile']) ? 4 : null;
      $questionnaire_data[10] = ($resumo['PMI'])   ? 4 : null;
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