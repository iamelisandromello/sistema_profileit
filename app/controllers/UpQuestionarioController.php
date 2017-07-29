<?php 

class UpQuestionarioController extends \HXPHP\System\Controller
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
		$this->auth->roleCheck(array(
		'administrator', 'user'
		));

		$this->view->setFile('index');
         $this->view->setHeader('upquestionario/header')
            ->setFooter('upquestionario/footer');

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);
		$reply = Answer::find_by_user_id($user_id);
		
		$this->view->setTitle('ProfileIT - Editar Questionario de Perfil')
						->setVars([
							'user' => $user,
							'reply' => $reply
						]);
	}

	public function editarAction()
	{

		$this->view->setFile('index');
         $this->view->setHeader('questionario/header')
            ->setFooter('questionario/footer');
	}
}