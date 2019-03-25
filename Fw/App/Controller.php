<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace Fw\App;

use \Fw\DI\DI;

/**
 * Class Controller
 * @package Fw\App
 */
abstract class Controller
{
	/**
	 * @var \Fw\DI\DI
	 */
	public $DI;

	/**
	 * @var
	 */
	protected $route;
	
	/**
	 * Controller constructor.
	 * @param \Fw\DI\DI $DI
	 * @param array $route
	 */
	public function __construct(DI $DI, array $route)
	{
		$this->DI = $DI;
		$this->route = $route;
	}


//	public function __get($name)
//	{
//		return $this->DI->get($name);
//	}
}