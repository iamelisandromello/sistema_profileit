<?php 

class QuestionarioController extends \HXPHP\System\Controller
{

	public function indexAction()
	{
		//$this->view->setAssets('css', $this->configs->baseURI . 'public/css/register.css');
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

		$user_id = $this->auth->getUserId();

		$this->view->setTitle('ProfileIT - Questionario de Perfil')
					->setVar('user', User::find($user_id));
	}

	public function responderAction()
	{

		$this->view->setFile('index');
         $this->view->setHeader('questionario/header')
            ->setFooter('questionario/footer');

		$user_id = $this->auth->getUserId();		

	
	}
}