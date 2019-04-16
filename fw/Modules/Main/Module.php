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
		public $cookie;
		public $options;
		public $objects;
		public $pages;
		public $posts;
		public $users;
		public $account;
		public $nav;
		public $files;
		
		/**
		 * Module constructor.
		 * @param DI $DI
		 */
		public function __construct(DI $DI)
		{
			parent::__construct($DI);
			
			$this->cookie  = new Services\Cookie();
			$this->options = new Services\Options($DI);
			$this->objects = new Services\Objects($DI);
			$this->pages   = new Services\Pages($DI);
			$this->posts   = new Services\Posts($DI);
			$this->users   = new Services\Users($DI);
			$this->account = new Services\Account($DI);
			$this->nav     = new Services\Nav($DI);
			$this->files   = new Services\Files($DI);
		}
	}