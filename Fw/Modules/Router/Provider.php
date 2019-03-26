<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace Fw\Modules\Router;

use Fw\Core\Router\Router;
use Fw\modules\AbstractProvider;

/**
 * Class Provider
 * @package Fw\Modules\Router
 */
class Provider extends AbstractProvider
{
	/**
	 * @var string
	 */
	private $moduleName = 'router';

	/**
	 * Initialization
	 */
	public function init()
	{
		$routes = require FW_DIR . '/Config/AppRoutes.php';

		$object = new Router($routes);

		$this->DI->set($this->moduleName, $object);
	}
}