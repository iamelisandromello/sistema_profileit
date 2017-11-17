<?php

class HomeController extends \HXPHP\System\Controller
{

   public function indexAction()
   {
      $this->view->setFile('index');
      $this->view->setHeader('home/header')
           ->setFooter('home/footer');
		$this->auth->redirectCheck();
		$this->auth->roleCheck(array(
		'user', 'administrator'
		));
   }

	public function __construct($configs)
	{
		parent::__construct($configs);

		$this->load(
			'Services\Auth',
			$configs->auth->after_login,
			$configs->auth->after_logout,
			true
		);

		$this->auth->redirectCheck();
		$this->auth->roleCheck(array(
		'user', 'administrator'
		));

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);
		$role = Role::find($user->role_id);
		$definition = Definition::find_by_user_id($user_id);
		$profile = Profile::find_by_type($definition->profile_id);
		$preference = preference::find_by_user_id($user_id);
		$total = User::experiencia($user);
		$resumos = User::summaries($user_id);
		$analiseQualificacoes = User::analyzeSkill($user_id);
		$analiseRecomendacoes = User::analyzeRecommendation($user_id);
		$analiseRecomendador = User::analyzeAdviser($user_id);
		$analisePreferencias = User::analyzePreferences($user_id);
		$sugestoes = User::suggestions($resumos, $user_id);
		$qualificacoes = Qualification::find('all', array('order' => 'qualification asc'));

		//$options = array('limit' => 3);
      //$comunidade = User::all($options );
		/*Consulta Randomica de Usuarios*/
		$comunidade = User::find_by_sql('select * from users order by rand() limit 10');
		//$vagas = Opportunity::find('all', array('conditions' => array('profile_id in (?)', array($profile->type))));

		$vagas = Opportunity::all(array('conditions' => array('user_id <> ? AND profile_id in (?)', $user_id, $profile->type)));

		$myMessages = Message::all(array('conditions' => array('user_id = ? AND status = ?', $user_id, 2)));

		$ctrMeter = 0;

		if ($analiseQualificacoes) {
			$ctrMeter++;
		}
		if ($analiseRecomendacoes) {
			$ctrMeter++;
		}
		if ($analiseRecomendador) {
			$ctrMeter++;
		}
		if ($analisePreferencias) {
			$ctrMeter++;
		}

		$this->load(
			'Helpers\Menu',
			$this->request,
			$this->configs,
			$role->role
		);

		$this->view->setTitle('ProfileIT - Home')
					->setFile('index')
					->setVars([
						'user'		=> $user,
						'total'		=> $total,
						'resumos'	=> $resumos,
						'sugestoes'	=> $sugestoes,
						'profile'	=> $profile,
						'preference'=> $preference,
						'ctrMeter'	=> $ctrMeter,
						'vagas'		=> $vagas,
						'myMessages'=>	$myMessages,
						'qualificacoes'			=> $qualificacoes,
						'analiseQualificacoes'	=> $analiseQualificacoes,
						'analiseRecomendacoes'	=> $analiseRecomendacoes,
						'analiseRecomendador'	=> $analiseRecomendador,
						'analisePreferencias'	=> $analisePreferencias,
						'comunidade'		=> $comunidade
					]);
	}

	/*
	* Método Controller para aprovação de
	* Recomendação
	*/
	public function apprecommendationAction($recommendation_id = null)
	{
		$this->view->setFile('index');
         $this->view->setHeader('home/header')
            ->setFooter('home/footer');

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);
		$status = 1;

		$atualizarRecommendation = Recommendation::atualizar($recommendation_id, $user_id, $status);

		if ($atualizarRecommendation->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar suas competências. <br> Verifique os erros abaixo:',
				$atualizarRecommendation->errors
			));
		}
		$this->view->setVar('user', $user);
	}

	/*
	* Método Controller para reprovação de
	* Recomendação
	*/
	public function disrecommendationAction($recommendation_id = null)
	{
		$this->view->setFile('index');
         $this->view->setHeader('home/header')
            ->setFooter('home/footer');

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		$status = 3;
		$atualizarRecommendation = Recommendation::atualizar($recommendation_id, $user_id, $status);

		if ($atualizarRecommendation->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar suas competências. <br> Verifique os erros abaixo:',
				$atualizarRecommendation->errors
			));
		}
		$this->view->setVar('user', $user);
	}

	/*
	* Método Controller's de Cadastrar Skill
	* de Competências e Resumo Profissional
	*/
	public function cadastrarskillAction()
	{
		$this->view->setFile('index');
         $this->view->setHeader('home/header')
            ->setFooter('home/footer');

		$post = $this->request->post();
		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		$cadastrarSkill = Competency::cadastrar($post, $user_id);

		if ($cadastrarSkill->status == false) {
			$this->load('Helpers\Alert', array(
				'error',
				'Ops! Não foi possível atualizar suas competências. <br> Verifique os erros abaixo:',
				$cadastrarSkill->errors
			));
		}

		//$this->view->setVar('user', $user);
		$this->redirectTo('/profileit/usuario/');
	}

	/*
	* Método Controller's de Cadastrar Preferências
	* e areas de atuação
	*/
	public function addpreferenceAction()
	{
		$this->view->setFile('index');
         $this->view->setHeader('home/header')
            ->setFooter('home/footer');

		$post = $this->request->post();
		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		if (!empty($post)) {
			$cadastrarPreference = Preference::cadastrar($post, $user_id);
			if ($cadastrarPreference->status == false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível atualizar suas preferências. <br> Verifique os erros abaixo:',
					$cadastrarPreference->errors
				));
			}
		}
		//$this->view->setVar('user', $user);
		$this->redirectTo('/profileit/usuario/');
	}

	/*
	* Método Controller's de Cadastrar Preferências
	* e areas de atuação
	*/
	public function addrecommnedationAction()
	{
		$this->view->setFile('index');
         $this->view->setHeader('home/header')
            ->setFooter('home/footer');

		$post = $this->request->post();
		$adviser_id = $this->auth->getUserId();
		$user = User::find($adviser_id);

		$recommendation_data = array(
			'relationship'				 	=> $post['relationship'],
			'charge_recommendation'		=> $post['charge_recommendation'],
			'charge_recommended' 		=> $post['charge_recommended'],
			'description'	 				=> $post['description'],
			'user_id' 						=> $post['user_id'],
			'adviser_id' 					=> $adviser_id,
			'approved' 						=> 2
		);

		if (!empty($post)) {
			$cadastrarPreference = Recommendation::cadastrar($recommendation_data);
			if ($cadastrarPreference->status == false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível enviar sua recomendação. <br> Verifique os erros abaixo:',
					$cadastrarPreference->errors
				));
			}
		}
		$this->view->setVar('user', $user);
	}

	/*
	* Método Controller's de Cadastrar Preferências
	* e areas de atuação
	*/
	public function addMessageAction()
	{
		$this->view->setFile('index');
         $this->view->setHeader('home/header')
            ->setFooter('home/footer');

		$post = $this->request->post();
		$sender_id = $this->auth->getUserId();
		$user = User::find($sender_id);

		$message_data = array(
			'message'				 		=> $post['textoMensagem'],
			'user_id' 						=> $post['user_id'],
			'sender_id' 					=> $sender_id,
			'status' 						=> 2
		);

		if (!empty($post)) {
			$cadastrarMensagem = Message::cadastrar($message_data);
			if ($cadastrarMensagem->status == false) {
				$this->load('Helpers\Alert', array(
					'error',
					'Ops! Não foi possível enviar sua recomendação. <br> Verifique os erros abaixo:',
					$cadastrarMensagem->errors
				));
			}
		}
		$this->view->setVar('user', $user);
	}

	public function checkMessageAction()
	{
		//Alterar o cabeçalho para não gerar cache do resultado
		header('Cache-Control: no-cache, must-revalidate');
		//Alterar o cabeçalho para que o retorno seja do tipo JSON
		header('Content-Type: application/json; charset=utf-8');
		$aDados = $_POST;//Copia o Post
		/*atribui os dados do post para um array*/
		$check_data = array(
			'user_id'				=> $aDados['user_id'],
			'message_id'			=> $aDados['message_id'],
			'status'					=> 1

		);
		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		$atualizarMessage = Message::atualizar($check_data['message_id'], $check_data['user_id'], $check_data['status']);

		if ($atualizarMessage->status == false) {
			$mensagem = $atualizarMessage->errors;
		}
		else {
			$mensagem = "Mensagem Lida";
		}

		//cria o array associativo
		$dados = array("nome" => $user->name, "mensagem" => $mensagem, "idmessage" => $check_data['message_id'], "status" => $check_data['status']);
		//converte o conteúdo do array associativo para uma string JSON
		$json_str = json_encode($dados);
		echo "$json_str";
		die();
	}

	public function validaAction()
	{
		//Alterar o cabeçalho para não gerar cache do resultado
		header('Cache-Control: no-cache, must-revalidate');
		//Alterar o cabeçalho para que o retorno seja do tipo JSON
		header('Content-Type: application/json; charset=utf-8');
		$aDados = $_POST;//Copia o Post
		/*atribui os dados do post para um array*/
		$attributes_data = array(
			'attribute_1'			=> $aDados['atributo_1'],
			'attribute_2'			=> $aDados['atributo_2'],
			'attribute_3'			=> $aDados['atributo_3'],
			'attribute_4'			=> $aDados['atributo_4'],
			'attribute_5'			=> $aDados['atributo_5'],
			'attribute_6'			=> $aDados['atributo_6'],
			'attribute_7'			=> $aDados['atributo_7'],
			'attribute_8'			=> $aDados['atributo_8'],
			'attribute_9'			=> $aDados['atributo_9'],
			'attribute_10'			=> $aDados['atributo_10'],
			'attribute_11'			=> $aDados['atributo_11'],
			'attribute_12'			=> $aDados['atributo_12'],
			'attribute_13'			=> $aDados['atributo_13'],
			'attribute_14'			=> $aDados['atributo_14'],
			'attribute_15'			=> $aDados['atributo_15']
		);
		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);
		//Recupera os pesos da Vaga definida pelo Usuario
		$pesos_backVaga	= Opportunity::backVagaWeights($attributes_data);
		//Envia Pesos da vaga p/Cálculo de Perfil, e retorna o Desvio Padrão e o Tipo
		$controle 			= Profile::defineProfile($pesos_backVaga);
		//cria o array associativo
		$dados = array("desvio" => $controle[0], "perfil" => $controle[1], "nome" => $user->name);
		//converte o conteúdo do array associativo para uma string JSON
		$json_str = json_encode($dados);
		echo "$json_str";
		die();
	}

	/*
	* Método Controller's de Cadastrar Oportunidade
	* de Emprego
	*/
	public function cadastrarvagaAction()
	{
		$this->view->setFile('index');
         $this->view->setHeader('home/header')
            ->setFooter('home/footer');

		$post = $this->request->post();
		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);

		//Recebendo atributos selecionados,
		//definindo requisitos para a oportunidade
		$attributes_data = array(
			'attribute_1'			=> $post['attribute_1'],
			'attribute_2'			=> $post['attribute_2'],
			'attribute_3'			=> $post['attribute_3'],
			'attribute_4'			=> $post['attribute_4'],
			'attribute_5'			=> $post['attribute_5'],
			'attribute_6'			=> $post['attribute_6'],
			'attribute_7'			=> $post['attribute_7'],
			'attribute_8'			=> $post['attribute_8'],
			'attribute_9'			=> $post['attribute_9'],
			'attribute_10'			=> $post['attribute_10'],
			'attribute_11'			=> $post['attribute_11'],
			'attribute_12'			=> $post['attribute_12'],
			'attribute_13'			=> $post['attribute_13'],
			'attribute_14'			=> $post['attribute_14'],
			'attribute_15'			=> $post['attribute_15']
		);

		//Recebendo informações dos checkboxs de Beneficios
		//e ajusta valores para selecionados e não selecionados
		$_POST['health']		= ( isset($_POST['health']) )		? 1 : 0;
		$_POST['feeding']		= ( isset($_POST['feeding']) )	? 1 : 0;
		$_POST['dental'] 		= ( isset($_POST['dental']) )		? 1 : 0;
		$_POST['fuel']  		= ( isset($_POST['fuel']) )		? 1 : 0;
		$_POST['parking'] 	= ( isset($_POST['parking']) )	? 1 : 0;
		$_POST['foresight']  = ( isset($_POST['foresight']) )	? 1 : 0;
		$_POST['meal']  		= ( isset($_POST['meal']) )		? 1 : 0;
		$_POST['transport']  = ( isset($_POST['transport']) )		? 1 : 0;

		//array de informações para inclusão de Beneficios
		$benefits_data = array(
			'health'			=> $_POST['health'],
			'feeding'		=> $_POST['feeding'],
			'dental'			=> $_POST['dental'],
			'fuel'			=> $_POST['fuel'],
			'parking'		=> $_POST['parking'],
			'foresight'		=> $_POST['foresight'],
			'meal'			=> $_POST['meal'],
			'transport'		=> $_POST['transport']
		);

		$connection = Opportunity::connection();
		$connection->transaction();

		if (!empty($attributes_data)) {
			$cadastrarAttributes = Attribute::cadastrar($attributes_data);

			if ($cadastrarAttributes->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
					$cadastrarAttributes->errors
				));
			}
			else {
				$attribute_id = $cadastrarAttributes->attribute->id;
			}
		}

		if (!empty($benefits_data)) {
			$cadastrarBenefits = Benefit::cadastrar($benefits_data);

			if ($cadastrarBenefits->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
					$cadastrarBenefits->errors
				));
			}
			else {
				$benefit_id = $cadastrarBenefits->benefit->id;
			}
		}

		/*Calculo RBC para Novo Perfil*/
		$pesos_backUser 	= Profile::backChargeWeights($attribute_id);
		$controle 			= Profile::defineProfile($pesos_backUser);

		$profile_data = array(
			'company'				=> $post['oppCompany'],
			'contact'				=> $post['oppContact'],
			'assignments'			=> $post['assignments'],
			'distortion'			=> $controle[0],
			'profile_id'			=> $controle[1],
			'benefit_id'			=> $benefit_id,
			'attribute_id'			=> $attribute_id,
			'user_id'				=> $user_id
		);

		if (!empty($profile_data)) {
			$cadastrarProfile = Opportunity::cadastrar($profile_data);

			if ($cadastrarProfile->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
					$cadastrarProfile->errors
				));
			}
		}

		try
		{
			$connection->commit();
		}
		catch (\Exception $e)
		{
			$connection->rollback();
			throw $e;
		}

		$this->view->setVar('user', $user);
	}

}