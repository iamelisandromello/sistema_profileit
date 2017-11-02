<?php

class ComunidadeController extends \HXPHP\System\Controller
{

   public function loadAction($colega_id = null)
   {
        $this->view->setFile('index');
        $this->view->setHeader('comunidade/header')
               ->setFooter('comunidade/footer');

		$user_id = $this->auth->getUserId();
		$logado = User::find($user_id);
		$user = User::find($colega_id);
		$definition = Definition::find_by_user_id($colega_id);
		$profile = Profile::find_by_type($definition->profile_id);
		$preference = preference::find_by_user_id($colega_id);
		$idadeUsuario = User::idade($user->birth_date);
		$celular = Registry::formatoTelefone($user->registry->celular);
		$cep = Registry::formatoCep($user->registry->zipcode);
		$total = User::experiencia($user);
		$analiseQualificacoes = User::analyzeSkill($colega_id);
		$resumos = User::summaries($colega_id);
		$sugestoes = User::suggestions($resumos, $colega_id);

		$this->view->setTitle('HXPHP - Administrativo')
						->setVars([
							'user' 		=> $user,
							'logado' 	=> $logado,
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

    public function __construct($configs)
	{
		parent::__construct($configs);

		$this->load(
			'Services\Auth',
			$configs->auth->after_login,
			$configs->auth->after_logout,
			true
		);

		$this->view->setFile('index');
		$this->view->setHeader('comunidade/header')
		      ->setFooter('comunidade/footer');

		$this->auth->redirectCheck();

		$this->load(
			'Helpers\Menu',
			$this->request,
			$this->configs,
			$this->auth->getUserRole()
		);
	}

}