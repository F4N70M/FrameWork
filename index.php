<?php

/**
 *	Точка входа
 *
 *	@author Коновальчук Эдуард <edkontr@gmail.com>
 *	@version 0.1
 */

$start = microtime(true);
$startMemory = 0;
$startMemory = memory_get_usage();

//  Поехали :)
require 'bootstrap.php';

//  Приехали
echo "\r\n\r\n";
print_r('php memory: ' . round( (memory_get_usage() - $startMemory) / 1024 * 100 ) / 100 . ' Kb' . PHP_EOL);
print_r('php pick memory: ' . round( memory_get_peak_usage() / 1024 * 100 ) / 100 . ' Kb' . PHP_EOL);
print_r('Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.');

//  Что делать то?
use \Fw\Helper\Common;
Common::print('Объекты зависят только от входных параметров (по цепочке) или от DI');
Common::print('Последнее: Fw\Core\Database\QueryBuilder');
