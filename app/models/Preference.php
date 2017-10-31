<?php

class Preference extends \HXPHP\System\Model
{
	static function table_name()
	{
		return 'preferences';
	}

	//Relacionamnetos 1:1 entre as tabelas
	static $belongs_to = array(
      array('user', 'foreign_key' => 'user_id', 'class_name' => 'User')
	);

	// Método de validação de registro único na tabela pesquisada (utilizado em conjunto com is_valid())
	//cria uma variável static ($validates_uniqueness_of), que recebe true ou false se o registro já existe
	static $validates_uniqueness_of = array(
		array(
			'user_id',
			'message' => 'Já Foi definida o perfil de preferências para este usuário. Você pode alterar as preferências, editando seu perfil.'
		)
	);

	public static function cadastrar(array $post, $id_user)
	{
		$callbackObj = new \stdClass;// Cria classe vazia
		$callbackObj->preference = null;// Propriedade usser da classe null
		$callbackObj->status = false;// Propriedade Status da Classe False
		$callbackObj->errors = array();// Array padrão de erros vazio

      //array de informações adicionais para Preferencias
      $preference_data = array(
      	'user_id'  => $id_user
      );

		$post = array_merge($post, $preference_data);
		$cadastrar = self::create($post);

		if ($cadastrar->is_valid()) {
			$callbackObj->preference = $cadastrar;
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