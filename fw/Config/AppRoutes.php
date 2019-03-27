<?php
/**
 * @author: KONARD
 * @version: 1.0
 * @return: array
 */
//TODO: Исправить роуты приложений
return [
	//'setup'		=>	\apps\setup\Controller::class,
	'admin'		=>	\apps\admin\App::class,
	null        =>	\apps\main\App::class
	//'admin'		=>	ROOT_DIR . '/apps/admin/__app.php',
	//null        =>	ROOT_DIR . '/apps/main/__app.php'
];