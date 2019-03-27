<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace apps\main;
	
	use apps\main\controllers\Default_Controller;
	
	class App
	{
		/**
		 * App constructor.
		 * @param $DI
		 * @param array $route
		 */
		public function __construct($DI, array $route)
		{
			$pathRoutes = $this->getPathRoutes();
			
			$appInfo    = $this->getInfoByRoutes($pathRoutes,$route);
			
			$controller = new $appInfo['controller']($DI,$route);
			
			if (isset($appInfo['method']))
			{
				call_user_func_array([$controller, $appInfo['method']], [$appInfo['arguments']]);
			}
		}
		
		
		
		
		/**
		 * @return array
		 */
		private function getPathRoutes()
		{
			return require __DIR__ . "/routes.php";
		}
		
		
		
		
		/**
		 * @param array $pathRoutes
		 * @param array $route
		 * @return array
		 */
		private function getInfoByRoutes(array $pathRoutes, array $route)
		{
			$appInfo['controller'] = Default_Controller::class;
			
			foreach ($pathRoutes as $pattern => $pathRoute) {
				$pattern = "#^$pattern\$#iu";
				if (preg_match($pattern, $route['uri']['path'], $matches))
				{
					$controller = $pathRoute['controller'];
					$method = preg_replace($pattern, $pathRoute['method'], $route['uri']['path']);
					
					if (method_exists($controller, $method))
					{
						unset($matches[0]);
						$appInfo['controller'] = $controller;
						$appInfo['method']     = $method;
						$appInfo['arguments']  = explode(',', preg_replace($pattern, $pathRoute['arguments'], $route['uri']['path']));
						break;
					}
				}
			}
			return $appInfo;
		}
	}