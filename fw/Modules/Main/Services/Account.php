<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules\Main\Services;
	
	use fw\DI\DI;
	
	class Account
	{
		public $DI;
		private $current;
		private $list = [];
		
		public function __construct(DI $DI)
		{
			$this->DI = $DI;
		}
		
		public function create()
		{
		
		}
		
		public function authorize(int $id)
		{
		
		}
		
		public function exit(int $id)
		{
		
		}
		
		public function get()
		{
			if (!empty($this->current) && $this->has($this->current))
			{
				return $this->list[$this->current];
			}
			
			return null;
		}
		
		public function has($id)
		{
			return isset($this->list[$id]);
		}
		
		public function list()
		{
			return $this->list;
		}
		
		public function switch(int $id)
		{
			if ($this->has($id))
				$this->current = $id;
		}
	}