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
		
		/**
		 * Main_Controller constructor.
		 * @param DI $DI
		 * @param array $route
		 */
		public function __construct(DI $DI, array $route)
		{
//			Common::print(
//				'Main_Controller!!!',
//				$route
//			);
			
			// Родительский конструктор
			parent::__construct($DI, $route);
			
			// Подключаем модель
			$this->model = new Main_Model($DI);
			// Подключаем представление
			$this->view  = new Main_View($DI);
			
			
			$path = $route['uri']['path'];
			$result = $this->model->getDataPageFromPath($path);
			
			$this->view->render($result['unique'], $result['data'], $result['error']);
			
			Common::print('$result :', $result);
			
			
			$allObjects = $this->DI->getServices('db')
				->select('name')
				->from('objects')
				->all();
			Common::print('All items from table objects:', $allObjects);
		}
	}