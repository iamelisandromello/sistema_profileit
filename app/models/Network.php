<?php

class Network extends \HXPHP\System\Model
{

	//Relacionamnetos 1:1 entre as tabelas
	static $belongs_to = array(
      array('user', 'foreign_key' => 'network_id', 'class_name' => 'User')
	);

	public static function cadastrar(array $post)
	{
		$callbackObj = new \stdClass;// Cria classe vazia
		$callbackObj->network = null;// Propriedade usser da classe null
		$callbackObj->status = false;// Propriedade Status da Classe False
		$callbackObj->errors = array();// Array padrão de erros vazio

		$cadastrar = self::create($post);

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