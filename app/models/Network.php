<?php

class Network extends \HXPHP\System\Model
{

	//Relacionamnetos 1:1 entre as tabelas
	static $belongs_to = array(
      array('user', 'foreign_key' => 'network_id', 'class_name' => 'User')
	);

	// Método de validação da presença de campos obrigatórios no post recebido do formulário
	//cria uma variável static ($validates_presence_of), que recebe true ou false se os campos estão preenchidos
	static $validates_presence_of = array(
		array(
			'facebook',
			'message' => 'O Facebook é um campo obrigatório.'
		),
		array(
			'linkedin',
			'message' => 'O Linkedin é um campo obrigatório.'
		)
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

	public static function atualizar($user_id, array $post)
	{

		$callbackObj = new \stdClass;
		$callbackObj->user = null;
		$callbackObj->status = false;
		$callbackObj->errors = array();
		$user 	 	= User::find($user_id);
		$network_id = $user->network_id;
		$network  	= self::find($network_id);

		if ($post['facebook'] == "" || $post['linkedin'] == "" ) {
			if ($post['facebook'] == "") {
				array_push($callbackObj->errors, 'Oops! O usuário de Facebook é um campo obrigatório.');
			}
			if ($post['linkedin'] == "") {
				array_push($callbackObj->errors, 'Oops! O usuário do Linkedin é um campo obrigatório.');
			}
			$callbackObj->user = $user;
			return $callbackObj;
		}

		$network->facebook	= $post['facebook'];
		$network->twitter		= $post['twitter'];
		$network->github		= $post['github'];
		$network->instagram	= $post['instagram'];
		$network->linkedin	= $post['linkedin'];
		$network->web 			= $post['web'];

		$atualizar = $network->save(false);

		if ($atualizar) {
			$callbackObj->user = $user;
			$callbackObj->status = true;
			array_push($callbackObj->errors, 'Uhuul! Perfil atualizado com sucesso!.');

			return $callbackObj;
		}

		$errors = $atualizar->errors->get_raw_errors();

		foreach ($errors as $field => $message) {
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;
	}
}