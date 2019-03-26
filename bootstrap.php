<?php

//	Определяем корневую директорию
define('ROOT_DIR', str_replace('\\', '/', getcwd()) );

//	Получаем настройки фреймворка
//$__Config = require ROOT_DIR . '/__Config.php';

//	Подключаем фреймворк
require ROOT_DIR . '/fw/bootstrap.php';

//	Инициализируем Фреймворк
//FW::init($__Config);


//	Определяем приложение для запуска
//$appInfo = Routes::findApp($routes);