<?php 

class HomeController extends \HXPHP\System\Controller
{
	
    public function indexAction()
    {
        $this->view->setHeader('home/header')
               ->setFooter('home/footer');
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

	public function bloqueadaAction()
	{
		$this->auth->roleCheck(array(
			'administrator',
			'user'
		));
	}
}