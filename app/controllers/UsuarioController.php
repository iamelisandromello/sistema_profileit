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
		$idadeUsuario = User::idade($user->birth_date);
		$celular = Registry::formatoTelefone($user->registry->celular);
		$cep = Registry::formatoCep($user->registry->zipcode);
		$total = User::experiencia($user);

		$this->view->setTitle('HXPHP - Administrativo')
						->setVars([
							'user' => $user,
							'idade' => $idadeUsuario,
							'celular' => $celular,
							'total' => $total,
							'cep' => $cep
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