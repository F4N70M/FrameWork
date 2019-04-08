<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\Services\Router;

use fw\Core\Router\Router;
use fw\Services\AbstractProvider;

/**
 * Class Provider
 * @package fw\Services\Router
 */
class Provider extends AbstractProvider
{
	/**
	 * @var string
	 */
	protected $serviceName = 'router';

	/**
	 * Initialization
	 */
	public function init()
	{
		$routes = require FW_DIR . '/Config/AppRoutes.php';

		$object = new Router($routes);

		$this->DI->setService($this->serviceName, $object);
	}
}