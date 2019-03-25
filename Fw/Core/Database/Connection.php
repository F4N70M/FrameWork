<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace Fw\Core\Database;

use \PDO;
use \PDOException;

/**
 * Class Connection
 * @package Fw\Core\Database
 */
class Connection
{
	/**
	 * @var
	 */
	private $link;

	/**
	 * Connection constructor.
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		try
		{
			$dsn = "mysql:host=".$config['HOST'].";dbname=".$config['BASE'].";charset=utf8";
			$user = $config['USER'];
			$pass = $config['PASS'];

			$this->link = new PDO($dsn, $user, $pass);
		}
		catch (PDOException $e)
		{
			//TODO: Написать исключение
		}
	}

	/**
	 * @return bool
	 */
	public function check()
	{
		return ($this->link) ? true : false;
	}

	/**
	 * @return PDO
	 */
	public function getLink()
	{
		return $this->link;
	}
}