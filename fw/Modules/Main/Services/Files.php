<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules\Main\Services;
	
	
	use fw\DI\DI;
	
	class Files
	{
		public $DI;
		
		public function __construct(DI $DI)
		{
			$this->DI = $DI;
		}
	}