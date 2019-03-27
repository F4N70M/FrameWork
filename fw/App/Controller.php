<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\App;

use \fw\DI\DI;
use fw\Helper\Common;

/**
 * Class Controller
 * @package fw\App
 */
abstract class Controller
{
	/**
	 * @var \fw\DI\DI
	 */
	public $DI;

	/**
	 * @var
	 */
	protected $route;
	
	/**
	 * Controller constructor.
	 * @param \fw\DI\DI $DI
	 * @param array $route
	 */
	public function __construct(DI $DI, array $route)
	{
		$this->DI = $DI;
		$this->route = $route;
	}
	
	public function error($error)
	{
		Common::print("Error: $error");
	}
}