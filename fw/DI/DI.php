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
	private $container = [
		'modules'  => null,
		'services' => null
	];
	
	/**
	 * @param string $serviceName
	 * @param $object
	 */
	public function setService(string $serviceName, $object)
	{
		$this->container['services'][$serviceName] = $object;
	}
	
	/**
	 * @param string $serviceName
	 * @return object|null
	 */
	public function getServices(string $serviceName)
	{
		return (($this->has($serviceName)) ? $this->container['services'][$serviceName] : null);
	}
	
	/**
	 * @param $serviceName
	 * @return bool
	 */
	public function has($serviceName)
	{
		return isset($this->container['services'][$serviceName]);
	}
	
	/**
	 * @param string $moduleName
	 * @param $object
	 */
	public function setModule(string $moduleName, $object)
	{
		$this->container['modules'][$moduleName] = $object;
	}
	
	/**
	 * @param string $moduleName
	 * @return object|null
	 */
	public function getModule(string $moduleName)
	{
		return (($this->hasModule($moduleName)) ? $this->container['modules'][$moduleName] : null);
	}
	
	/**
	 * @param $moduleName
	 * @return bool
	 */
	public function hasModule($moduleName)
	{
		return isset($this->container['modules'][$moduleName]);
	}
}