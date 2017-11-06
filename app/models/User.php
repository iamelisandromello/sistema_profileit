<?php

class User extends \HXPHP\System\Model
{
	//Relacionamnetos 1:1 entre as tabelas
	static $belongs_to = array(
		array('role'),
      array('registry', 'foreign_key' => 'registry_id', 'class_name' => 'Registry'),
      array('network', 'foreign_key' => 'network_id', 'class_name' => 'Network'),
		array('definition', 'foreign_key' => 'user_id', 'class_name' => 'Definition'),
      array('preference', 'foreign_key' => 'user_id', 'class_name' => 'Preference'),
      array('answer', 'foreign_key' => 'user_id', 'class_name' => 'Answer')
	);

	//Relacionamnetos 1:n entre as tabelas
	static $has_many = array(
		array('professionals'),
		array('certifications'),
		array('recommendations'),
		array('messages'),
		array('academics'),
		array('competencies'),
		array('opportunities'),
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

      $role = Role::find_by_role('temp');// Define a Role de Usuario para o novo objeto

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
		$experienciaTotal = array();
		foreach ($user->professionals as $professional) {
			$d1 =  date_format($professional->date_entry, 'y-m-d');
			if ($professional->date_out == null) {
				$d2 = date_format(new DateTime(), 'y-m-d');//captura a data atual do sistema e formata
			}
			else {
				$d2 =  date_format($professional->date_out, 'y-m-d');
			}

			$date = User::diffDate($d1,$d2,'D');
			$total += (int) $date;
		}

		$anos  = (int)($total / 360);
		$meses = (int)(($total % 360)/ 30);
		$dias  = (int)(($total % 360)% 30);
		$experienciaTotal[0] = $anos;
		$experienciaTotal[1] = $meses;
		$experienciaTotal[2] = $dias;
		return $experienciaTotal;
	}

	public static function analyzeSkill($id_user)
	{
		$userSkill;//Declara variável de Retorno
		$skill = Competency::find_by_user_id($id_user);
		if ($skill) {
			$userSkill = true;
		} else { $userSkill = false; }
		return $userSkill;
	}

	public static function analyzeRecommendation($id_user)
	{
		$userRecommnedation;//Declara variável de Retorno
		$recommendation = Recommendation::find_by_user_id($id_user);
		if (!$recommendation) {
			$userRecommendation = false;
		} else { $userRecommendation = true; }
		return $userRecommendation;
	}

	public static function analyzeAdviser($id_user)
	{
		$userAdviser;//Declara variável de Retorno
		$adviser = Recommendation::find_by_adviser_id($id_user);
		if (!$adviser) {
			$userAdviser = false;
		} else { $userAdviser = true; }
		return $userAdviser;
	}

	public static function analyzePreferences($id_user)
	{
		$userPreference;//Declara variável de Retorno
		$preference = Preference::find_by_user_id($id_user);
		if (!$preference) {
			$userPreference = false;
		} else { $userPreference = true; }
		return $userPreference;
	}

	public static function suggestions(array $suggestions, $id_user )
	{

		$userSuggestions	= array();//Declara array de Sugestões

		if ($suggestions['PMI'] == null && $suggestions['Agile'] == null && $suggestions['Itil'] == null) {
			$userSuggestions['Processos'] = 'Certificação em Processos';
		}
		else $userSuggestions['Processos'] = null;

		if ($suggestions['Graduacao'] == null) {
			$userSuggestions['Academico'] =  'Conclua uma Graduação';
		}
		else if ($suggestions['Status'] == 1 || $suggestions['Status'] == 2) {
			$userSuggestions['Academico'] =  'Conclua seu ' . $suggestions['Academico'];
		}
		else if ($suggestions['Status'] == 3) {
			if($suggestions['ctrAcademico'] >= 3){
				if($suggestions['Academico'] == 'Bacharelado') {
					$userSuggestions['Academico'] =  'Realize uma Pós Graduação';
				}
				else if($suggestions['Academico'] == 'MBA') {
					$userSuggestions['Academico'] =  'Realize um Mestrado';
				}
			}
		}

		if ($suggestions['Microsoft']			== null) {
			$userSuggestions['Microsoft']		=  'Realize uma Certificação Microsoft';
		}
		else if ($suggestions['Microsoft'] 	== 'Certificação MCP') {
			$userSuggestions['Microsoft']		=  'Realize Certificação MCSA';
		}
		else if ($suggestions['Microsoft'] 	== 'Certificação MCTIP') {
			$userSuggestions['Microsoft'] 	=  'Realize Certificação MCSA';
		}
		else if ($suggestions['Microsoft'] 	== 'Certificação MCSA') {
			$userSuggestions['Microsoft'] 	=  'Realize Certificação MCSE';
		}
		else if ($suggestions['Microsoft'] 	== 'Certificação MCSE') {
			$userSuggestions['Microsoft'] 	=  null;
		}

		return $userSuggestions; //retorna array de sugestões
	}


	public static function summaries($id_user)
	{
		$userSummaries	= array();//Declara array de Resumo
		$usuario 			= User::find_by_id($id_user);//localiza o objeto Usuário

		/*Selecona Última Empresa e Status Empregado/Desempregado*/
		$posts = Professional::find_by_sql('select * from professionals where user_id in (65) order by date_out desc');
		//$testes= Professional::find('all', array('conditions' => array('user_id in (?)', array($id_user))));
		//$testes= Professional::find('all', array('order' => 'date_out ASC', 'limit' => 3));

		foreach ($posts as $post) :
	  		$userSummaries['Empresa']	= $post->company;
	  		$userSummaries['Empregado']	= ($post->date_out) ? $post->date_out : false;
	  	endforeach;

		/*Controle de Fluência no Inglês*/
		$validaIdioma = Answer::find_by_user_id($id_user);
		if ($validaIdioma) {
			$userSummaries["Idioma"]  = ($validaIdioma->question_1 == 4) ? 'Fluente' :null;
		}

		/*Controle de Formação Acadêmica*/
		$controle = 0;
		$nivel = 0;
		foreach ($usuario->academics as $academic):
			if ($academic->level == 'Medio') {
				$controle = 1;
			}
			else if ($academic->level == 'Tecnico') {
				$controle = 2;
			}
			else if ($academic->level == 'Tecnologo') {
				$controle = 3;
			}
			else if ($academic->level == 'Bacharelado') {
				$controle = 4;
			}
			else if ($academic->level == 'MBA') {
				$controle = 5;
			}
			else if ($academic->level == 'Mestrado') {
				$controle = 6;
			}
			else if ($academic->level == 'Doutorado') {
				$controle = 7;
			}
			else if ($academic->level == 'PHD') {
				$controle = 8;
			}

			if ($nivel <= $controle) {
				$userSummaries["Academico"]	= $academic->level;
				$userSummaries["Curso"]		 	= $academic->course;
				$userSummaries["Status"]		= $academic->status;
				$userSummaries["ctrAcademico"]= $controle;
				$nivel = $controle;
			}

		endforeach;

		if ($nivel >= 3) {
			if ($userSummaries["Status"] == 3) {
				$userSummaries["Graduacao"]	= 'Sim';
			}
			else {
				$userSummaries["Graduacao"]	= null;
			}
		}
		else {
			$userSummaries["Graduacao"]	= null;
		}

		/*Percorre a Tabela de Certificações
		*Avaliando Certificações;
		*/
		foreach ($usuario->certifications as $certification):
			$microsoft = $certification->microsoft;
			if ($certification->linux == 'Nao') {
				$userSummaries['Linux'] = null;
			} else { $userSummaries['Linux'] = $certification->linux; }

			if ($certification->virtualizacao == 'Nao') {
				$userSummaries['Virtualizacao'] = null;
			} else { $userSummaries['Virtualizacao'] = $certification->virtualizacao; }

			if ($certification->cisco == 'Nao') {
				$userSummaries['Cisco'] = null;
			} else { $userSummaries['Cisco'] = $certification->cisco; }

			if ( $certification->itil == 'Nao') {
				$userSummaries['Itil'] = null;
			} else { $userSummaries['Itil'] = $certification->itil; }

			if(  $certification->agile == 'Nao') {
				$userSummaries['Agile'] = null;
			} else { $userSummaries['Agile'] = $certification->agile; }

			if ($certification->pmi == 'Nao' ) {
				$userSummaries['PMI'] = null;
			} else {$userSummaries['PMI'] = $certification->agile;;}

			if($certification->microsoft == 'Nao') {
				$userSummaries['Microsoft'] = null;
			}
			else if ($certification->microsoft == 'MCP' ) {
				$userSummaries['Microsoft'] = 'Certificação MCP';
			}
			else if ($certification->microsoft == 'MCTIP' ) {
				$userSummaries['Microsoft'] = 'Certificação MCTIP';
			}
			else if ($certification->microsoft == 'MCSA' ) {
				$userSummaries['Microsoft'] = 'Certificação MCSA';
			}
			else if ($certification->microsoft == 'MCSE' ) {
				$userSummaries['Microsoft'] = 'Certificação MCSE';
			}
		endforeach;

		return $userSummaries; //retorna array de sugestões

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

		$errors = $pesquisar->errors->get_raw_errors();

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


	public static function upRole($user_id)
	{
		$callbackObj = new \stdClass;
		$callbackObj->role = null;
		$callbackObj->status = false;
		$callbackObj->errors = array();

		$role = Role::find_by_role('user');// Define a Role de Usuario para o novo objeto

		// Verifica se a Role Default de Usuario existe
		if (is_null($role)) {
			array_push($callbackObj->errors, 'A role user não existe. Contate o administrador');
			return $callbackObj;
		}

		$user = self::find($user_id);
		$user->role_id = $role->id;
		$atualizar = $user->save(false);

		if ($atualizar) {
			$callbackObj->role = $role->role;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $atualizar->errors->get_raw_errors();

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