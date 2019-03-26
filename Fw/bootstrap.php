<?php

/**
 * Функция автозагрузки классов ядра фраймворка
 * @param $class
 * @return bool
 * @throws Exception
 */
function fw_autoload($class)
{
	$file = ROOT_DIR . '/' . trim( str_replace('\\', '/', $class), '/' ) . '.php';

	if (file_exists($file))
	{
		require_once $file;

		return true;
	}
	throw new Exception('Ошибка автоподключения класса "' . $class . '": файл не найден (' . $file . ')<br>');
}

/**
 * Константа FW_DIR
 */
define( 'FW_DIR', str_replace('\\', '/', __DIR__) );

/**
 * Запускаем автозагрузчики классов
 */
spl_autoload_register('fw_autoload');

/**
 * Объект Dependency Injection
 */
$DI = new \fw\DI\DI();

/**
 * Подключение модулей в DI
 */
$modules = require FW_DIR . "/Config/Modules.php";
foreach ($modules as $module)
{
	$provider = new $module($DI);
	$provider->init();
}

/**
 * Поиск приложения
 */
$router = $DI->get('router');

/**
 * Получение информации о приложении для запуска
 */
$route = $router->getAppInfo();

try
{
	/**
	 * Создание объекта приложения
	 */
	$app = new $route['class']($DI,$route);
}
catch (Exception $e)
{
	echo $e->getMessage();
}
