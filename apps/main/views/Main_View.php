<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace apps\main\views;
	
	
	use fw\App\View;
	use fw\DI\DI;
	use fw\Helper\Common;
	
	class Main_View extends View
	{
		public function __construct(DI $DI)
		{
			parent::__construct($DI);
			
			Common::print('Main_View');
		}
	}