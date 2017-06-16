<?php

class Academic extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'academics';
	}

  public function relations()
   {
      return array(
      	'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
      );
   }

  public static function cadastrar(array $post, $user_id)
  {
    $callbackObj = new \stdClass;// Cria classe vazia
    $callbackObj->academic = null;// Propriedade user da classe null
    $callbackObj->status = false;// Propriedade Status da Classe False
    $callbackObj->errors = array();// Array padrão de erros vazio

    $academic = array(
      'institution' => $post[0],
      'local'       => $post[1],
      'course'      => $post[2],
      'level'       => $post[3],
      'date_conclusion' => date('Y-m-d',strtotime($post[4])),
      'status'      => $post[5],
      'user_id'     => $user_id
    );    
       
    $cadastrar = self::create($academic);

    if ($cadastrar->is_valid()) {
      $callbackObj->academic = $cadastrar;
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