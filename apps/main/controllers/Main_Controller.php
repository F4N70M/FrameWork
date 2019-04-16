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
			
			/* COOKIE */
			$cookie = $DI->getModule('main')->cookie;
			//$cookie->del('test');
			//$value = (int) $cookie->get('test') + 1;
			//$cookie->set('test', $value);
			//setcookie('test', (int) $_COOKIE['test']+1, 0);
			Common::print($cookie->get('test'));
			Common::print($cookie->get());
			/* /COOKIE */
			
			
			Common::print(
				'Main_Controller!!!',
				$route
			);
			
			$this->model = new Main_Model($DI);
			$this->view  = new Main_View($DI);
			
			$path = $route['uri']['path'];
			if (empty($path))
			{
				$unique = $this->model->getIndexId();
			}
			else
			{
				$unique = array_pop(explode('/', $path));
			}
			$data    = $this->model->getObject($unique);
			Common::print('$data =', $data);
		}
	}