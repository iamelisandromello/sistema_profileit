<?php

class Registry extends \HXPHP\System\Model
{
	// Método de validação da presença de campos obrigatórios no post recebido do formulário
	//cria uma variável static ($validates_presence_of), que recebe true ou false se os campos estão preenchidos
	static $validates_presence_of = array(
		array(
			'address',
			'message' => 'O Endereço é um campo obrigatório.'
		),
		array(
			'zipcode',
			'message' => 'O CEP é um obrigatório.'
		),
		array(
			'celular',
			'message' => 'O Celular é um campo obrigatório.'
		),
		array(
			'burgh',
			'message' => 'O Bairro é um campo obrigatório.'
		),
		array(
			'city',
			'message' => 'A Cidade é um campo obrigatório.'
		),
		array(
			'state',
			'message' => 'O Estado  é um campo obrigatório.'
		),
		array(
			'about',
			'message' => 'A Descrição Sobre mim é obrigatória.'
		)
	);

	static function table_name()
	{
		return 'registries';
	}

	//Relacionamnetos 1:1 entre as tabelas
	static $belongs_to = array(
      array('user', 'foreign_key' => 'registry_id', 'class_name' => 'User')
	);

	/**
	* Formata 1234567890 em (12) 3456-7890
	*
	* @param   int    $numero  Numero a ser formatado
	* @return  string
	**/
    public static function formatoTelefone($numero)
    {
        return preg_replace('/(\d{2})(\d{4})(\d*)/', '($1) $2-$3', $numero);
    }

	/**
	* Formata 90050123 em 90.050-123
	*
	* @param   int    $numero  Numero a ser formatado
	* @return  string
	**/
   public static function formatoCep($input)
   {
      return preg_replace('/^(\d{2})(\d{3})(\d{3})$/', '\\1.\\2-\\3', $input);
   }

   public static function cadastrar(array $post)
	{
		$callbackObj = new \stdClass;// Cria classe vazia
		$callbackObj->registry = null;// Propriedade usser da classe null
		$callbackObj->status = false;// Propriedade Status da Classe False
		$callbackObj->errors = array();// Array padrão de erros vazio

		$cadastrar = self::create($post);

		if ($cadastrar->is_valid()) {
			$callbackObj->registry = $cadastrar;
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
		$user 	 		= User::find($user_id);
		$registry_id	= $user->registry_id;
		$registry  		= self::find($registry_id);

		$registry->about			= $post['sobremim'];
		$registry->celular		= $post['celular'];
		$registry->address		= $post['address'];
		$registry->zipcode		= $post['zipcode'];
		$registry->burgh			= $post['burgh'];
		$registry->city 			= $post['city'];
		$registry->state 			= $post['state'];

		$atualizar = $registry->save();

		if($atualizar) {
			$callbackObj->user = $user;
			$callbackObj->status = true;
			array_push($callbackObj->errors, 'Uhuul! Perfil atualizado com sucesso!.');
			return $callbackObj;
		}

		$callbackObj->user = $user;
		$errors = $registry->errors->get_raw_errors();
		foreach ($errors as $field => $message) {
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;
	}

}