<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules;
	
	use fw\DI\DI;
	
	class AbstractModule
	{
		protected $DI;
		
		public function __construct(DI $DI)
		{
			$this->DI = $DI;
		}
	}