<?php

class LoginController extends \HXPHP\System\Controller
{
	public function __construct($configs)
	{
		parent::__construct($configs);

		$this->load(
			'Services\Auth',
			$configs->auth->after_login,
			$configs->auth->after_logout,
			$configs->auth->answer_login,
			true
		);
	}

	public function indexAction()
	{
		$this->auth->redirectCheck(true);
      $this->view->setHeader('login/header')
                 ->setFooter('login/footer');		
	}

	public function logarAction()
	{
		$this->auth->redirectCheck(true);
      $this->view->setHeader('login/header')
                 ->setFooter('login/footer');		

		$this->view->setFile('index');

		$post = $this->request->post();

		if (!empty($post)) {
			$login = User::login($post);

			if ($login->status === true) {
	      	$answer = Answer::verificar($login->user->id);
				if($answer->status === false){
					$this->auth->loginTemp($login->user->id, $login->user->username, $login->user->role->role);
				}
				else{
					$this->auth->login($login->user->id, $login->user->username, $login->user->role->role);
				}
			}
			else {
				$this->load('Modules\Messages', 'auth');
				$this->messages->setBlock('alerts');
				$error = $this->messages->getByCode($login->code, array(
					'message' => $login->tentativas_restantes
				));

				$this->load('Helpers\Alert', $error);
			}
		}
	}

	public function sairAction()
	{
		return $this->auth->logout();
	}

}