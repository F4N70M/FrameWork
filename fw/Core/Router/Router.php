<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\Core\Router;

/**
 * Class Router
 * @package fw\Core\Router
 */
class Router
{
	/**
	 * @var array
	 */
	private $routes = [];
	/**
	 * @var array
	 */
	private $appInfo = null;

	/**
	 * Router constructor.
	 * @param array $routes
	 */
	public function __construct(array $routes)
	{
		$this->routes = $routes;

		$this->appInfo = $this->parseUri();
	}

	/**
	 * @return array|null
	 */
	private function parseUri()
	{
		$result = [];

		$uri = trim( parse_url($_SERVER['REQUEST_URI'])['path'], '/' );

		foreach ($this->routes as $prefix => $file)
		{
			$pattern = '#^' . $prefix . '(' . (empty($prefix) ? '' : '/') . '(.*))?$#i';

			if ( preg_match( $pattern, $uri, $matches ) )
			{
				if ( !isset($matches[2]) ) $matches[2] = '';
				//	Совпадение найдено
				$path = trim( $matches[2], '/' );

				$result = [
					'file'		=>	$file,
					'pattern'	=>	$pattern,
					'uri'       =>  [
						'full'		=>	$uri,
						'prefix'	=>	$prefix,
						'path'		=>	$path,
					]
				];

				//	Завершаем цикл
				break;
			}
		}

		return $result;
	}

	public function getAppInfo()
	{
		return $this->appInfo;
	}
}