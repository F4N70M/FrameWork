<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules\Main\Services;
	
	use fw\DI\DI;
	use fw\Helper\Common;
	
	class Options
	{
		public $DI;
		private $list = [];
		
		public function __construct(DI $DI)
		{
			$this->DI = $DI;
			$this->list = $DI->getServices('db')
				->select()
				->from('options')
				->all('name');
			//Common::print($this->list);
		}
		
		public function get($option)
		{
			if ($this->has($option))
			{
				return $this->list[$option];
			}
			
			return false;
		}
		
		public function getValue($option)
		{
			if ($this->has($option))
			{
				return $this->list[$option]['value'];
			}
			
			return false;
		}
		
		public function getDescription($option)
		{
			if ($this->has($option))
			{
				return $this->list[$option]['description'];
			}
			
			return false;
		}
		
		public function has($option)
		{
			return isset($this->list[$option]);
		}
		
		public function list()
		{
			return $this->list;
		}
	}