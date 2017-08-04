<?php 

class TempController extends \HXPHP\System\Controller
{
	
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
}