<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	use \fw\Helper\Common;
	
	/** @var array $route */
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
	}
	else
	{
		
		new \apps\main\controllers\Default_Controller($DI,$route);
	}