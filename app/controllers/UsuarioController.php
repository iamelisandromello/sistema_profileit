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
		$idinstitution = 1;
		$idinstitution2 = 2;

		$user = User::find($user_id);
		$idadeUsuario = User::idade($user->birth_date);
		$celular = Registry::formatoTelefone($user->registry->celular);
		$cep = Registry::formatoCep($user->registry->zipcode);
		
		$this->view->setTitle('HXPHP - Administrativo')
					->setVars([
						'user' => $user,
						'idade' => $idadeUsuario,
						'celular' => $celular,
						'cep' => $cep,
						'escolas' => Academic::all()						
					]);				
	}

	public function pesquisarAction()
	{
		$this->view->setFile('index');

		$post = $this->request->post();

		if (!empty($post)) {
			$pesquisarUsuario = User::pesquisar($post);

			if ($cadastrarUsuario->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
					$cadastrarUsuario->errors
				));
			}
			else {
				$this->auth->login($cadastrarUsuario->user->id, $cadastrarUsuario->user->username);
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