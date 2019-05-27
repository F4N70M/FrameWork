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

// Константа FW_DIR
define( 'FW_DIR', str_replace('\\', '/', __DIR__) );

// Запускаем автозагрузчики классов
spl_autoload_register('fw_autoload');

// Объект Dependency Injection
$DI = new \fw\DI\DI();

// Подключение сервисов в DI
	$services = require FW_DIR . "/Config/Services.php";
	foreach ($services as $service)
	{
		$provider = new $service($DI);
		$provider->init();
	}

// Подключение модулей в DI
$modules = require FW_DIR . "/Config/Modules.php";
new \fw\Modules\Provider($DI, $modules);

// Получение информации о приложении для запуска
$route = $DI->getServices('router')->getAppInfo();

try
{
	// Создание объекта приложения
	$app = new $route['class']($DI,$route);
}
catch (Exception $e)
{
	//TODO: написать исключение
	echo $e->getMessage();
}


//if (isset($route['file']) && file_exists($route['file']))
//{
//	require $route['file'];
//}
//else
//{
//	//TODO: написать сценарий если необходимое приложение не нашлось
//}
