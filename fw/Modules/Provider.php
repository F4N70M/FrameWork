<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules;
	
	
	class Provider
	{
		protected $DI;
		
		public function __construct(\fw\DI\DI $DI, array $modules)
		{
			$this->DI = $DI;
			
			foreach ($modules as $moduleName => $moduleClass)
			{
				$this->init($moduleName, $moduleClass);
			}
		}
		
		public function init(string $moduleName, $moduleClass)
		{
			$object = new $moduleClass($this->DI);
			$this->DI->setModule($moduleName, $object);
		}
	}