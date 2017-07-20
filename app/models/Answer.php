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