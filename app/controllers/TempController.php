<?php 

class TempController extends \HXPHP\System\Controller
{
	
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
	}


	public function indexAction()
	{
	$cep = '94025-260';	
	$this->load(
		'Services\Correios',
		$cep // 00000-000
	);

	$retornoJSON = $this->correios->getDados();
	$enderecoObj = json_decode($retornoJSON);
	var_dump($enderecoObj);
	die();
	}

	public function atualizarAction($competency_id = null, $level = null)
	{

		if (is_numeric($competency_id) && is_numeric($level)) {
			$competency = Competency::find_by_id($competency_id);
	
			if (!is_null($competency)) {
				$competency->level = $level;
				$competency->save(false);

				$this->view->setVar('user', $user_id);
			}
		}
		else{

			var_dump('teste');
			die();
		}
	}

}