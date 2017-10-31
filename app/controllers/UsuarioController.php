<?php

class UsuarioController extends \HXPHP\System\Controller
{

    public function indexAction()
    {
        $this->view->setHeader('usuario/header')
               ->setFooter('usuario/footer');
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

		$this->load(
			'Helpers\Menu',
			$this->request,
			$this->configs,
			$this->auth->getUserRole()
		);

		$user_id = $this->auth->getUserId();

		$user = User::find($user_id);
		$definition = Definition::find_by_user_id($user_id);
		$profile = Profile::find_by_type($definition->profile_id);
		$preference = preference::find_by_user_id($user_id);
		$idadeUsuario = User::idade($user->birth_date);
		$celular = Registry::formatoTelefone($user->registry->celular);
		$cep = Registry::formatoCep($user->registry->zipcode);
		$total = User::experiencia($user);
		$analiseQualificacoes = User::analyzeSkill($user_id);
		$resumos = User::summaries($user_id);
		$sugestoes = User::suggestions($resumos, $user_id);

		$this->view->setTitle('HXPHP - Administrativo')
						->setVars([
							'user' 		=> $user,
							'idade'		=> $idadeUsuario,
							'celular'	=> $celular,
							'resumos'	=> $resumos,
							'sugestoes'	=> $sugestoes,
							'total' 		=> $total,
							'definition'=> $definition,
							'profile'	=> $profile,
							'preference'=> $preference,
							'cep' 		=> $cep,
							'analiseQualificacoes'	=> $analiseQualificacoes
						]);
	}

	public function pesquisarAction()
	{
		$this->view->setFile('index');

		$post = $this->request->post();

		if (!empty($post)) {
			$pesquisarUsuario = User::pesquisar($post);

			if ($pesquisarUsuario->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível localizar nenhum Usuário. <br> Verifique as Mensagens abaixo:',
					$pesquisarUsuario->errors
				));
			}
		}
	}

	public function bloqueadaAction()
	{
		$this->auth->roleCheck(array(
			'administrator',
			'user'
		));
	}
}