<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace apps\main;
	
	use apps\main\controllers\Main_Controller;
	use fw\Helper\Common;
	
	class App
	{
		/**
		 * App constructor.
		 * @param $DI
		 * @param array $route
		 */
		public function __construct(\fw\DI\DI $DI, array $route)
		{
			$pathRoutes = $this->getPathRoutes();
			
			$appInfo    = $this->getInfoByRoutes($pathRoutes, $route);
			
			$controller = new $appInfo['controller']($DI, $route);
			
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
			$uriPath = $route['uri']['path'];
			
			foreach ($pathRoutes as $pattern => $pathRoute)
			{
				$pattern = "#^$pattern\$#iu";
				
				if ($matches = $this->getMatches($pattern, $uriPath))
				{
					if ($controllerClass = $this->getControllerClass($pathRoute['controller']))
					{
						$methodName = preg_replace($pattern, $pathRoute['method'], $uriPath);
						
						if (method_exists($controllerClass, $methodName))
						{
							$result['controller'] = $controllerClass;
							$result['method']     = $methodName;
							$result['arguments']  = explode(',', preg_replace($pattern, $pathRoute['arguments'], $uriPath));
							return $result;
						}
					}
				}
			}
			//  default result
			return ['controller' => Main_Controller::class];
		}
		
		/**
		 * @param string $pattern
		 * @param string $path
		 * @return array|bool
		 */
		private function getMatches(string $pattern, string $path)
		{
			return preg_match($pattern, $path, $matches) ? $matches : false;
		}
		
		/**
		 * @param string $name
		 * @return string|false
		 */
		private function getControllerClass(string $name)
		{
			$className = __NAMESPACE__ . '\\controllers\\' . $name;
			
			return class_exists($className) ? $className : false;
		}
	}