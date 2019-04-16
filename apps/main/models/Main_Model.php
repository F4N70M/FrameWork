<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace apps\main\models;
	
	use fw\App\Model;
	use fw\DI\DI;
	use fw\Helper\Common;
	
	class Main_Model extends Model
	{
		public function __construct(DI $DI)
		{
			parent::__construct($DI);
			
			//Common::print('Main_Model');
		}
		
		public function getIndexId()
		{
			return $this->DI->getModule('main')->options->getValue('index');
		}
		
		public function getObject($unique)
		{
			return $this->DI->getModule('main')->objects->get($unique);
		}
	}