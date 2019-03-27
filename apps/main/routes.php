<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	return [
		'users/([A-z]+)'    => [
			'controller'    => apps\main\controllers\Users_Controller::class,
			'method'        => '$1',
			'arguments'     => null
		],
		'mail/([A-z]+)'    => [
			'controller'    => 'controllers\Mail_Controller',
			'method'        => '$1',
			'arguments'     => null
		],
		'news/([A-z]+)'    => [
			'controller'    => 'controllers\News_Controller',
			'method'        => '$1',
			'arguments'     => null
		]
		
	];