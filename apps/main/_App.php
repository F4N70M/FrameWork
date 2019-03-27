<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace apps\main;
	
	use apps\main\controllers\Default_Controller;
	use fw\Helper\Common;
	
	class App
	{
		/**
		 * App constructor.
		 * @param $DI
		 * @param array $route
		 */
		public function __construct($DI, array $route)
		{
			Common::print('$route', $route);
			$pathRoutes = require __DIR__ . "/routes.php";
			//Common::print('$pathRoutes', $pathRoutes);
			
			//$appInfo = null;
			foreach ($pathRoutes as $pattern => $pathRoute) {
				$pattern = "#^$pattern$#iu";
				if (preg_match($pattern, $route['uri']['path'], $matches))
				{
					unset($matches[0]);
					$appInfo['controller'] = $pathRoute['controller'];
					$appInfo['method']     = preg_replace($pattern, $pathRoute['method'], $route['uri']['path']);
					$appInfo['arguments']  = preg_replace($pattern, $pathRoute['arguments'], $route['uri']['path']);
					Common::print('$app', $appInfo);
				}
			}
			
			if (isset($appInfo) && class_exists($appInfo['controller']) && method_exists($appInfo['controller'], $appInfo['method']))
			{
				$route = array_merge($route,$appInfo);
				$controller = new $appInfo['controller']($DI,$route);
				call_user_func_array([$controller, $appInfo['method']], [$appInfo['arguments']]);
			}
			else
			{
				new Default_Controller($DI,$route);
			}
		}
	}