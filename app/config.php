<?php
	//Constantes
	$configs = new HXPHP\System\Configs\Config;

	$configs->env->add('development');

	$configs->env->development->baseURI = '/profileit/';

	$configs->env->development->database->setConnectionData(array(
		'host' => 'localhost',
		'user' => 'root',
		'password' => '',
		'dbname' => 'sistematcc'
	));

	$configs->env->development->auth->setURLs('/profileit/home/', '/profileit/login/', '/profileit/questionario/responder/');

    $configs->env->development->menu->setMenus(array(
        'Home/dashboard' => '%baseURI%/home',
        'Projetos/briefcase' => '%baseURI%/projetos',
        'Editar perfil/cog' => '%baseURI%/perfil/editar',
    ), 'administrator');

    $configs->env->development->menu->setMenus(array(
        'Home/dashboard' => '%baseURI%/home',
        'Projetos/briefcase' => '%baseURI%/projetos',
    ), 'user');

    $configs->env->development->menu->setMenus(array(
        'Home/dashboard' => '%baseURI%/home'
    ));

	$configs->env->development->menu->setConfigs(array(
		'container' => 'nav',
		'container_class' => 'navbar navbar-default',
		'menu_class' => 'nav navbar-nav'
	));

	$configs->env->add('production');

	$configs->env->production->baseURI = '/';

	$configs->env->production->database->setConnectionData(array(
		'host' => 'localhost',
		'user' => 'hxphp190_sistema',
		'password' => '^EKI1LK(&kV[',
		'dbname' => 'hxphp190_sistemahx'
	));

	$configs->env->production->auth->setURLs('/home/', '/login/', '/questionario/responder/' );

	return $configs;
