<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules\Main\Services;
	
	use fw\DI\DI;
	use fw\Helper\Common;
	
	class Objects
	{
		public $DI;
		
		public function __construct(DI $DI)
		{
			$this->DI = $DI;
		}
		
		public function get($unique)
		{
			$object = $this->DI->getServices('db')
				->select()
				->from('objects')
				->where([
					$this->defineUnique($unique) => $unique
				])
				->one();
			
			return $object;
		}
		
		public function defineUnique($unique)
		{
			return ((is_numeric($unique) && (int) $unique == $unique) ? 'id' : 'name');
		}
	}