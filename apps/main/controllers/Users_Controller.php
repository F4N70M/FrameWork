<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace apps\main\controllers;
	
	
	use fw\App\Controller;
	use fw\DI\DI;
	use fw\Helper\Common;
	
	class Users_Controller extends Controller
	{
		public function __construct(DI $DI, array $route)
		{
			parent::__construct($DI, $route);
			
			Common::print(
				'Users_Controller!!!',
				$route
			);
		}
		
		public function signup()
		{
			Common::print(
				'SignUp!!!'
			);
		}
		
		public function signin()
		{
			Common::print(
				'SignIn!!!'
			);
		}
		
		public function signout()
		{
			Common::print(
				'SignOut!!!'
			);
		}
		
		public function recovery()
		{
			Common::print(
				'Recovery!!!'
			);
		}
	}