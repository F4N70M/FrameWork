<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace Fw\Modules\Database;

use Fw\Core\Database\Db;
use Fw\Modules\AbstractProvider;
use Fw\Core\Database\Connection;

/**
 * Class Provider
 * @package Fw\Modules\Database
 */
class Provider extends AbstractProvider
{
	/**
	 * @var string
	 */
	public $moduleName = 'db';

	/**
	 * Initialization
	 */
	public function init()
	{
		$configs = require FW_DIR . '/Config/Database.php';

		$object = null;

		$connection = null;
		foreach ($configs as $config)
		{
			$connection = new Connection($config);
			if ($connection->check()) break;
		}

		$object = new Db($connection->getLink());

		$this->DI->set($this->moduleName, $object);
	}
}