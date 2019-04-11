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
			
			Common::print('Main_Model');
		}
		
		public function route($path)
		{
			if (empty($path))
			{
				return 'index';
			}
			else
			{
				return $path;
				//  routes:
				//      pattern => [module, service, action]
			}
		}
	}