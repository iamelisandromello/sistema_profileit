<?php

class Professional extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'professioals';
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
    $callbackObj->network = null;// Propriedade usser da classe null
    $callbackObj->status = false;// Propriedade Status da Classe False
    $callbackObj->errors = array();// Array padrão de erros vazio

    $historic = array(
      'company'     => $post[0],
      'function'    => $post[1],
      'date_entry'  => date('Y-m-d',strtotime($post[2])), 
      'date_out'    => date('Y-m-d',strtotime($post[3])), 
      'assignments' => $post[4],
      'user_id'     => $user_id
    );    
       
    $cadastrar = self::create($historic);

    if ($cadastrar->is_valid()) {
      $callbackObj->network = $cadastrar;
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