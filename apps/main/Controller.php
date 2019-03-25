<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace apps\main;

use Fw\DI\DI;
use \Fw\Helper\Common as Helper;

/**
 * Class Controller
 * @property \Fw\Core\Database\QueryBuilder db
 * @package apps\main
 */
class Controller extends \Fw\App\Controller
{
	//TODO: Настроить зоны видимости свойств класса
	
	// MVC
	public $model;
	public $view;
	public $form;
	// object \Fw\Core\Database\Db
	public $db;
	//
	public $object;
	public $method;
	public $mode;
	public $template;
	//
	public $data;
	
	/**
	 * Controller constructor.
	 * @param DI $DI
	 * @param array $route
	 */
	public function __construct(DI $DI, array $route)
	{
		/**
		 * Parent construct
		 */
		parent::__construct($DI, $route);
		
		/**
		 * Properties
		 */
		$this->model = new Model($DI);
		$this->view = new View($DI);
		$this->form = new Form($DI);
		$this->db = $this->DI->get('db');
		
		/**
		 * Main sequence
		 */
		/*Helper::print(
			"Hello, I\'m Main App",
			"\r\nroute:",
			$this->route,
			"\r\nDI:",
			$this->DI,
			"\r\ndata:",
			$this->data
		);*/
		
		//TODO: Определить объект и метод
		$prepare = $this->model->getInfoByUriPath($this->route['uri']['path']);
		Helper::print($prepare);
		
		$this->object = $prepare['object'];
		$this->method = $prepare['method'];
		$this->mode = $prepare['mode'];
		
		//TODO: Сформировать данные для рендера
		//$this->data = $this->model->get_data();
		
		if ( $this->mode == 'html' )
		{
			//TODO: Загрузить шаблон страницы
			$this->template = $this->model->loadTemplate($this->object);
		}
		
		//TODO: Рендер
		$this->view->render($this->object,$this->mode,$this->template);
		
		
		/*$result = $this->db
			->update('objects')
			->set(['description2'=>'lol2','content'=>'kek2'])
			->do();
		Helper::print("update:",$result);
		
		$result = $this->db
			->insert('objects_taxonomy')
			->values(['type'=>1, 'meta_key'=>'test4'])
			->do();
		Helper::print("insert:",$result);
		
		$result = $this->db
			->query("SELECT * FROM users")
			->all();
		Helper::print("all:",$result);
		
		$result = $this->db
			->select(['id','email','phone','date'])
			->from('users')
			->orderBy(['date'=>false])
			->all();
		Helper::print("all:",$result);
		
		$result = $this->db
			->select()
			->from('objects')
			->limit(1,2)
			->one();
		Helper::print("one:",$result);*/
	}
}