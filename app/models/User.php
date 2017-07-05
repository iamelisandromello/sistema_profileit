<?php

class User extends \HXPHP\System\Model
{
	//Relacionamnetos 1:1 entre as tabelas
	static $belongs_to = array(
		array('role'),
      array('registry', 'foreign_key' => 'registry_id', 'class_name' => 'Registry'),
      array('network', 'foreign_key' => 'network_id', 'class_name' => 'Network'),
	);

	//Relacionamnetos 1:n entre as tabelas
	static $has_many = array(
		array('professionals'),
		array('recommendations'),
		array('academics'),
		array('competencies'),
		array('skills', 'through' => 'competencies')
	);

	// Método de validação da presença de campos obrigatórios no post recebido do formulário
	//cria uma variável static ($validates_presence_of), que recebe true ou false se os campos estão preenchidos
	static $validates_presence_of = array(
		array(
			'name',
			'message' => 'O nome é um campo obrigatório.'
		),
		array(
			'email',
			'message' => 'O e-mail é um campo obrigatório.'
		),
		array(
			'username',
			'message' => 'O nome de usuário é um campo obrigatório.'
		),
		array(
			'password',
			'message' => 'A senha é um campo obrigatório.'
		)
	);

	// Método de validação de registro único na tabela pesquisada (utilizado em conjunto com is_valid())
	//cria uma variável static ($validates_uniqueness_of), que recebe true ou false se o registro já existe
	static $validates_uniqueness_of = array(
		array(
			'username',
			'message' => 'Já existe um usuário com este nome de usuário cadastrado.'
		),
		array(
			'email',
			'message' => 'Já existe um usuário com este e-mail cadastrado.'
		)
	);

	public static function cadastrar(array $post, $id_registry, $id_network)
	{
		$callbackObj = new \stdClass;// Cria classe vazia
		$callbackObj->user = null;// Propriedade usser da classe null
		$callbackObj->status = false;// Propriedade Status da Classe False
		$callbackObj->errors = array();// Array padrão de erros vazio
       
      $role = Role::find_by_role('administrator');// Define a Role de Usuario para o novo objeto

		// Verifica se a Role Default de Usuario existe
		if (is_null($role)) {
			array_push($callbackObj->errors, 'A role user não existe. Contate o administrador');
			return $callbackObj;
		}
		
		//array de informações adicionais para Novo Usuário
		$user_data = array(
			'birth_date'	=> date('Y-m-d',strtotime($post['birth_date'])),
			'role_id'		=> $role->id,
			'registry_id'	=> $id_registry,
			'network_id'	=> $id_network,
			'status'			=> 1
		);

		$password = \HXPHP\System\Tools::hashHX($post['password']);

		$post = array_merge($post, $user_data, $password);

		$cadastrar = self::create($post);

		if ($cadastrar->is_valid()) {
			$callbackObj->user = $cadastrar;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();

		foreach ($errors as $field => $message) {
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;
	}

	public static function idade($birth_date)
	{	
      $dn = new DateTime($birth_date);//recebe a data de aniversário do User
		$agora = new DateTime();//captura a data atual do sistema
		$idade = $agora->diff($dn);//calacula a diferença entre as duas datas  
		return $idade->y; //retorna o calculo da diferença em anos
	}

	public static function experiencia($user)
	{	
		$total = 0;
		foreach ($user->professionals as $professional) {
			$d1 =  date_format($professional->date_entry, 'y-m-d');
			$d2 =  date_format($professional->date_out, 'y-m-d');

			$date = User::diffDate($d1,$d2,'D');
			$total += (int) $date;
		}

		$total = ($total/30)/12;
		return round($total, 2);
	}

	public static function diffDate($d1, $d2, $type='', $sep='-')
	{
		 $d1 = explode($sep, $d1);
		 $d2 = explode($sep, $d2);
		 switch ($type)
		 {
		 case 'A':
		 $X = 31536000;
		 break;
		 case 'M':
		 $X = 2592000;
		 break;
		 case 'D':
		 $X = 86400;
		 break;
		 case 'H':
		 $X = 3600;
		 break;
		 case 'MI':
		 $X = 60;
		 break;
		 default:
		 $X = 1;
		 }
		 return floor( ( ( (mktime(0, 0, 0, $d2[1], $d2[2], $d2[0])) - (mktime(0, 0, 0, $d1[1], $d1[2], $d1[0] )) ) / $X ) );
	}

	public static function recursive_show_array($arr)
	{
		foreach($arr as $value)	{
			if(is_array($value))	{
		  		User::recursive_show_array($value);
			}
			else {
		  		echo "Campo: {$value}<br>";
			}
		}
	}

	public static function pesquisar(array $post)
	{
		$callbackObj = new \stdClass;
		$callbackObj->user = null;
		$callbackObj->status = false;
		$callbackObj->errors = array();
       
      $role = Role::find_by_role('user');

		if (is_null($role)) {
			array_push($callbackObj->errors, 'A role user não existe. Contate o administrador');
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

		if (isset($post['password']) && !empty($post['password'])) {
			$password = \HXPHP\System\Tools::hashHX($post['password']);

			$post = array_merge($post, $password);
		}

		$user = self::find($user_id);

		$user->name = $post['name'];
		$user->email = $post['email'];
		$user->username = $post['username'];

		if (isset($post['salt'])) {
			$user->password = $post['password'];
			$user->salt = $post['salt'];
		}

		$exists_mail = self::find_by_email($post['email']);

		if (!is_null($exists_mail) && intval($user_id) !== intval($exists_mail->id)) {
			array_push($callbackObj->errors, 'Oops! Já existe um usuário com este e-mail cadastrado. Por favor, escolha outro e tente novamente');

			return $callbackObj;
		}

		$exists_username = self::find_by_username($post['username']);

		if (!is_null($exists_username) && intval($user_id) !== intval($exists_username->id)) {
			array_push($callbackObj->errors, 'Oops! Já existe um usuário com o login <strong>' . $post['username'] . '</strong> cadastrado. Por favor, escolha outro e tente novamente');

			return $callbackObj;
		}

		$atualizar = $user->save(false);

		if ($atualizar) {
			$callbackObj->user = $user;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();

		foreach ($errors as $field => $message) {
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;
	}

	public static function login(array $post)
	{
		$callbackObj = new \stdClass;
		$callbackObj->user = null;
		$callbackObj->status = false;
		$callbackObj->code = null;
		$callbackObj->tentativas_restantes = null;

		$user = self::find_by_username($post['username']);

		if (!is_null($user)) {
			$password = \HXPHP\System\Tools::hashHX($post['password'], $user->salt);

			if ($user->status === 1) {
				if (LoginAttempt::ExistemTentativas($user->id)) {
					if ($password['password'] === $user->password) {
						$callbackObj->user = $user;
						$callbackObj->status = true;

						LoginAttempt::LimparTentativas($user->id);
					}
					else {
						if (LoginAttempt::TentativasRestantes($user->id) <= 3) {
							$callbackObj->code = 'tentativas-esgotando';
							$callbackObj->tentativas_restantes = LoginAttempt::TentativasRestantes($user->id);
						}
						else {
							$callbackObj->code = 'dados-incorretos';
						}
						
						LoginAttempt::RegistrarTentativa($user->id);
					}
				}
				else {
					$callbackObj->code = 'usuario-bloqueado';

					$user->status = 0;
					$user->save(false);
				}
			}
			else {
				$callbackObj->code = 'usuario-bloqueado';
			}
		}
		else {
			$callbackObj->code = 'usuario-inexistente';
		}

		return $callbackObj;
	}

	public static function atualizarSenha($user, $newPassword)
	{
		$user = self::find_by_id($user->id);

		$password = \HXPHP\System\Tools::hashHX($newPassword);

		$user->password = $password['password'];
		$user->salt = $password['salt'];

		return $user->save(false);
	}
}