<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules\Main\Services;
	
	
	use fw\DI\DI;
	
	class Nav
	{
		public $DI;
		
		public function __construct(DI $DI)
		{
			$this->DI = $DI;
		}
	}