<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules\Main;
	
	use fw\DI\DI;
	use fw\Modules\AbstractModule;
	
	class Module extends AbstractModule
	{
		public $page;
		public $post;
		public $user;
		
		public function __construct(DI $DI)
		{
			parent::__construct($DI);
			
			$this->page = new Classes\Page();
		}
	}