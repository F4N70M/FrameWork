<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules\Blog;
	
	
	use fw\Modules\AbstractProvider;
	
	class Provider extends AbstractProvider
	{
		
		/**
		 * @var string
		 */
		protected $moduleName = 'blog';
		
		public function init()
		{
			$object = new Module($this->DI);
			$this->DI->setModule($this->moduleName, $object);
		}
	}