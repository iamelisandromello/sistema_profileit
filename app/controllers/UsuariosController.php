<?php

class UsuariosController extends \HXPHP\System\Controller
{
	public function __construct($configs)
	{
		parent::__construct($configs);

	   //$this->view->setAssets('css', $this->configs->baseURI . 'public/css/register.css');
	   $this->view->setHeader('usuarios/header')
	              ->setFooter('usuarios/footer');
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

		$user_id = $this->auth->getUserId();
		$user = User::find($user_id);
		$role = Role::find($user->role_id);

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
						'users' => User::all()
					]);
	}

	public function indexAction()
	{
	   //$this->view->setAssets('css', $this->configs->baseURI . 'public/css/register.css');
	   $this->view->setHeader('usuarios/header')
	              ->setFooter('usuarios/footer');
	}

	public function bloquearAction($user_id = null)
	{
		if (is_numeric($user_id)) {
			$user = User::find_by_id($user_id);

			if (!is_null($user)) {
				$user->status = 0;
				$user->save(false);

				$this->view->setVar('users', User::all());
			}
		}
	}

	public function desbloquearAction($user_id = null)
	{
		if (is_numeric($user_id)) {
			$user = User::find_by_id($user_id);

			if (!is_null($user)) {
				$user->status = 1;
				$user->save(false);

				$this->view->setVar('users', User::all());
			}
		}
	}

	public function excluirAction($user_id = null)
	{
		if (is_numeric($user_id)) {
			$connection = Network::connection();
			$connection->transaction();

			$user = User::find_by_id($user_id);
			$answer = Answer::find_by_user_id($user_id);
			$academic = Academic::find_by_user_id($user_id);
			$definition = Definition::find_by_user_id($user_id);
			$professional = Professional::find_by_user_id($user_id);
			$course = Course::find_by_user_id($user_id);
			$certification = Certification::find_by_user_id($user_id);
			$registry_id = $user->registry_id;
			$network_id = $user->network_id;
			$registry = Registry::find_by_id($registry_id);
			$network = Network::find_by_id($network_id);

			if (!is_null($user)) {
				$definition->delete();
				$answer->delete();
				$academic->delete();
				$professional->delete();
				$course->delete();
				$certification->delete();
				$user->delete();
				$registry->delete();
				$network->delete();

				$this->view->setVar('users', User::all());
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

		}
	}
}