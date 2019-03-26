<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\Modules\Router;

use fw\Core\Router\Router;
use fw\modules\AbstractProvider;

/**
 * Class Provider
 * @package fw\Modules\Router
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