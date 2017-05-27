<?php 

class RegistriesController extends \HXPHP\System\Controller
{
	public function __construct($configs)
	{
		parent::__construct($configs);
	}

	public function indexAction()
	{
		var_dump(get_class_methods(Registry::find(1)));
		die();
	}

}