<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace apps\main\controllers;
	
	
	use fw\App\Controller;
	use fw\DI\DI;
	use fw\Helper\Common;
	
	class Main_Controller extends Controller
	{
		public function __construct(DI $DI, array $route)
		{
			parent::__construct($DI, $route);
			
			Common::print(
				'Main_Controller!!!',
				$route
			);
		}
	}