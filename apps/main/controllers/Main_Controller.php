<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace apps\main\controllers;
	
	use apps\main\models\Main_Model;
	use apps\main\views\Main_View;
	use fw\App\Controller;
	use fw\DI\DI;
	use fw\Helper\Common;
	
	class Main_Controller extends Controller
	{
		public $model;
		public $view;
		
		public function __construct(DI $DI, array $route)
		{
			parent::__construct($DI, $route);
			
			Common::print(
				'Main_Controller!!!',
				$route
//				,
//				$DI->getModule('main')->account->list()
			);
			
			$this->model = new Main_Model($DI);
			$this->view  = new Main_View($DI);
			
			$action = $this->model->route($route['uri']['path']);
			Common::print($action);
		}
	}