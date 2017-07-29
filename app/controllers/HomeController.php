<?php 

class HomeController extends \HXPHP\System\Controller
{
	
   public function indexAction()
   {
      $this->view->setHeader('home/header')
           ->setFooter('home/footer');

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);
		$role = Role::find($user->role_id);
		$total = User::experiencia($user);

		$this->auth->roleCheck(array(
		'user', 'administrator'
		));
		$this->auth->redirectCheck();

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

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);
		$role = Role::find($user->role_id);
		$total = User::experiencia($user);

		$this->auth->redirectCheck();
		$this->auth->roleCheck(array(
		'user', 'administrator'
		));


		$this->load(
			'Helpers\Menu',
			$this->request,
			$this->configs,
			$role->role
		);

		$this->view->setTitle('HXPHP - Administrativo')
					->setFile('index')
					->setVars([
						'user' => $user,
						'total' => $total,
						'users' => User::all()
					]);
	}

}