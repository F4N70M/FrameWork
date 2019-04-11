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
		public $pages;
		public $posts;
		public $users;
		public $account;
		
		/**
		 * Module constructor.
		 * @param DI $DI
		 */
		public function __construct(DI $DI)
		{
			parent::__construct($DI);
			
			$this->pages   = new Services\Pages($DI);
			$this->posts   = new Services\Posts($DI);
			$this->users   = new Services\Users($DI);
			$this->account = new Services\Account($DI);
		}
	}