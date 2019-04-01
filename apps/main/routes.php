<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	return [
		'(signup|signin|signout|recovery)'    => [
			'controller'    => 'Users_Controller',
			'method'        => '$1',
			'arguments'     => null
		],
		'mail/(callback)'    => [
			'controller'    => 'Mail_Controller',
			'method'        => '$1',
			'arguments'     => null
		],
		'news/([A-z]+)'    => [
			'controller'    => 'News_Controller',
			'method'        => '$1',
			'arguments'     => null
		]
		
	];