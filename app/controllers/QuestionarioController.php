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
		$this->auth->roleCheck(array(
		'temp'
		));

		$this->view->setFile('index');
         $this->view->setHeader('questionario/header')
            ->setFooter('questionario/footer');

		$user_id 			= $this->auth->getUserId();
		$user 				= User::find($user_id);
		$preQuestionnaire = Answer::preQuestionnaire($user);
		$calculoExp 		= $preQuestionnaire[0];
		$formacao 			= $preQuestionnaire[1];
		$sitFormacao 		= $preQuestionnaire[2];
		$pos 					= $preQuestionnaire[3];
		$sitPos 				= $preQuestionnaire[4];

		$this->view->setTitle('ProfileIT - Questionario de Perfil')
					->setVars([
						'user' => $user,
						'calculoExp' => $calculoExp,
						'formacao' => $formacao,
						'sitFormacao' => $sitFormacao,
						'pos' => $pos,
						'sitPos' => $sitPos
					]);
	}

	public function responderAction()
	{

		$this->view->setFile('index');
         $this->view->setHeader('questionario/header')
            ->setFooter('questionario/footer');

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);
		$experiencia = Answer::preQuestionnaire($user);

		$this->view->setTitle('ProfileIT - Questionario de Perfil')
					->setVars([
						'user' => $user,
						'experiencia' => $experiencia
					]);

		$post = $this->request->post();

		if (!empty($post)) {
			$connection = Definition::connection();
			$connection->transaction();

			$cadastrarAnswers = Answer::cadastrar($post, $user_id);
			if ($cadastrarAnswers->status === true) {
				/*Calculo RBC para Novo Perfil*/
				$pesos_backUser = Profile::backUserWeights($user_id);
				$controle = Profile::defineProfile($pesos_backUser);
			}
			else {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
					$cadastrarAnswers->errors
				));
			}
		}

		if (!empty($controle)) {
			$cadastrarDefinition = Definition::cadastrar($controle, $user_id);
			if ($cadastrarDefinition->status === true) {
				$updateRole = User::upRole($user_id);
				$this->auth->update($updateRole->role);
				try
				{
					$connection->commit();
					$this->redirectTo('/profileit/home/');
				}
				catch (\Exception $e)
				{
					$connection->rollback();
					throw $e;
					$this->load('Helpers\Alert', array(
						'danger',
						'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
						$cadastrarDefinition->errors
					));
				}
			}
			else {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
					$cadastrarDefinition->errors
				));
			}
		}
	}
}