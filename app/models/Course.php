<?php

class Course extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'courses';
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
    $callbackObj->course = null;// Propriedade usser da classe null
    $callbackObj->status = false;// Propriedade Status da Classe False
    $callbackObj->errors = array();// Array padrão de erros vazio

    $schedule = implode("-",array_reverse(explode("/",$post[4] )));
    $course = array(
      'title'       => $post[0],
      'institution' => $post[1],
      'segment'     => $post[2],
      'workload'    => $post[3],
      'schedule'    => $schedule,
      'user_id'     => $user_id
    );

    $cadastrar = self::create($course);

    if ($cadastrar->is_valid()) {
      $callbackObj->course = $cadastrar;
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