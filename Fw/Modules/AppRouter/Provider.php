<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace Fw\Modules\AppRouter;

use Fw\Core\Router\AppRouter;
use Fw\modules\AbstractProvider;

/**
 * Class Provider
 * @package Fw\Modules\AppRouter
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

		$object = new AppRouter($routes);

		$this->DI->set($this->moduleName, $object);
	}
}