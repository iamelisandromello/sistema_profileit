<?php

class Definition extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'definitions';
	}

  //Relacionamnetos 1:1 entre as tabelas
  static $belongs_to = array(
    array('definition', 'foreign_key' => 'user_id', 'class_name' => 'Definition')
  );

  public static function cadastrar(array $controle, $user_id)
  {
    $callbackObj = new \stdClass;// Cria classe vazia
    $callbackObj->definition = null;// Propriedade user da classe null
    $callbackObj->status = false;// Propriedade Status da Classe False
    $callbackObj->errors = array();// Array padrão de erros vazio

    //array de informações adicionais para Novo Questionário
//    var_dump("Profile_ID: " . $controle[1] . "  Detour: " . $controle[0]);
 //   die();

    $definition = array(
      'user_id'     => $user_id,
      'detour'      => $controle[0],
      'profile_id'  => $controle[1]
    );

    $cadastrar = self::create($definition);

    if ($cadastrar->is_valid()) {
      $callbackObj->definition = $cadastrar;
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