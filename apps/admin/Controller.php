<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace apps\admin;

use Fw\DI\DI;
use Fw\Helper\Common as Helper;

/**
 * Class Controller
 * @package apps\main
 */
class Controller extends \Fw\App\Controller
{
	public $model;
	public $view;
	public $form;
	
	/**
	 * Controller constructor.
	 * @param DI $DI
	 * @param array $route
	 */
	public function __construct(DI $DI, array $route)
	{
		parent::__construct($DI, $route);
		
		$this->model = new Model($DI);
		$this->view = new View($DI);
		$this->form = new Form($DI);
		
		
		Helper::print(
			"Hello, I\'m Admin App",
			$this->route,
			$this->DI
		);
	}
}