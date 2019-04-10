<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules;
	
	
	class Provider
	{
		protected $DI;
		
		/**
		 * Provider constructor.
		 * @param \fw\DI\DI $DI
		 * @param array $modules
		 */
		public function __construct(\fw\DI\DI $DI, array $modules)
		{
			$this->DI = $DI;
			
			foreach ($modules as $moduleName => $moduleClass)
			{
				$this->init($moduleName, $moduleClass);
			}
		}
		
		/**
		 * @param string $moduleName
		 * @param $moduleClass
		 */
		public function init(string $moduleName, $moduleClass)
		{
			$object = new $moduleClass($this->DI);
			$this->DI->setModule($moduleName, $object);
		}
	}