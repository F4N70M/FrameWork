<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace apps\main\controllers;
	
	
	use fw\App\Controller;
	use fw\DI\DI;
	use fw\Helper\Common;
	
	class Default_Controller extends Controller
	{
		public function __construct(DI $DI, array $route)
		{
			parent::__construct($DI, $route);
			
			Common::print(
				'HELLO WORLD!!! Im Default_Controller!!!',
				$route
			);
		}
	}