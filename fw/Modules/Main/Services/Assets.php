<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules\Main\Services;
	
	use fw\DI\DI;
	
	class Assets
	{
		public  $DI;
		private $css = [
			'start' => [],
			'end' => [],
		];
		private $js = [
			'start' => [],
			'end' => [],
		];
		
		public function __construct(DI $DI)
		{
			$this->DI = $DI;
		}
		
		public function setCss($sourceUri, $start=false)
		{
			$path = ROOT_DIR . $sourceUri;
			if (file_exists($path))
			{
				$this->css[($start ? 'start' : 'end')][] = $sourceUri;
			}
		}
		
		public function setJs($sourceUri, $start=false)
		{
			$path = ROOT_DIR . $sourceUri;
			if (file_exists($path))
			{
				$this->js[($start ? 'start' : 'end')][] = $sourceUri;
			}
		}
		
		/**
		 * @param bool $start
		 * @return array
		 */
		public function getCss(bool $start)
		{
			return $this->css[($start ? 'start' : 'end')];
		}
		
		/**
		 * @param bool $start
		 * @return array
		 */
		public function getJs(bool $start)
		{
			return $this->js[($start ? 'start' : 'end')];
		}
	}