<?php

class Professional extends \HXPHP\System\Model
{
  public function relations()
   {
      return array(
      	'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
      );
   }

  public static function cadastrar(array $post, $user_id)
  {
    $callbackObj = new \stdClass;// Cria classe vazia
    $callbackObj->professional = null;// Propriedade usser da classe null
    $callbackObj->status = false;// Propriedade Status da Classe False
    $callbackObj->errors = array();// Array padrão de erros vazio

    $dateOut = $post[3];
    if ($post[3] == null ) {
      $dateOut = null;
    }
    else {
      $dateOut = implode("-",array_reverse(explode("/",$dateOut )));
    }
    $dataEntry = implode("-",array_reverse(explode("/",$post[2] )));

    $historic = array(
      'company'     => $post[0],
      'function'    => $post[1],
      'date_entry'  => $dataEntry,
      'date_out'    => $dateOut,
      'assignments' => $post[4],
      'user_id'     => $user_id
    );

    $cadastrar = self::create($historic);

    if ($cadastrar->is_valid()) {
      $callbackObj->professional = $cadastrar;
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