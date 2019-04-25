<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules\Main\Services;
	
	
	use fw\DI\DI;
	
	class Relations
	{
		public $DI;
		
		public function __construct(DI $DI)
		{
			$this->DI = $DI;
		}
		
		public function getParents($id,$table)
		{
			return $this->DI->getServices('db')
				->select()
				->from('relations')
				->where(['child_id'=>$id, 'child_table'=>$table, 'parent_table'=>$table])
				->all();
		}
	}