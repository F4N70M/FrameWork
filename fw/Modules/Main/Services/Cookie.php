<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules\Main\Services;
	
	
	class Cookie
	{
		private $cookies = [];
		
		public function __construct()
		{
			$this->cookies = $_COOKIE;
		}
		
		public function get(string $name=null)
		{
			if (!empty($name))
			{
				return ($this->has($name) ? $this->cookies[$name] : null);
			}
			else
			{
				return $this->cookies;
			}
		}
		
		private function has($name)
		{
			return isset($this->cookies[$name]);
		}
		
		public function set($name, string $value="", int $expire=0, string $path="", string $domain="", bool $sequre=false, bool $httponly=false)
		{
			$result = setcookie($name, $value, $expire, $path, $domain, $sequre, $httponly);
			
			if ($result)
			{
				$this->cookies[$name] = $value;
				
				if ($expire <= time() && $expire != 0)
					$this->del($name);
			}
			
			return $result;
		}
		
		public function del($name)
		{
			$result = setcookie($name, "", -3600);
			
			if ($result)
			{
				unset($this->cookies[$name]);
			}
			
			return $result;
		}
	}