<?php

/**
 * Class DI
 */

namespace fw\DI;

class DI
{
	/**
	 * @var array
	 */
	private $container = [];

	/**
	 * @param string $key
	 * @param $object
	 * @return $this
	 */
	public function set(string $key, $object)
	{
		$this->container[$key] = $object;

		return $this;
	}

	/**
	 * @param $key
	 * @return mixed
	 */
	public function get($key)
	{
		if ($this->has($key)) return $this->container[$key];

		return null;
	}

	/**
	 * @param $key
	 * @return bool
	 */
	public function has($key)
	{
		return isset($this->container[$key]);
	}
}