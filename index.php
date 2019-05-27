<?php

/**
 *	Точка входа
 *
 *	@author Коновальчук Эдуард <edkontr@gmail.com>
 *	@version 0.1
 */
	
$startMemory = memory_get_usage();
$start = microtime(true);

//  Поехали :)
require 'bootstrap.php';

//  Приехали
use \fw\Helper\Common;
Common::print(
	'php memory: ' . round( (memory_get_usage() - $startMemory) / 1024 * 100 ) / 100 . ' Kb' . PHP_EOL,
	'php pick memory: ' . round( memory_get_peak_usage() / 1024 * 100 ) / 100 . ' Kb' . PHP_EOL,
	'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.'
);

//  Что делать то?
Common::print(
	'type	name	title	color	size	price	count',
	'good	dress	Палтье			2000	',
	'good			Розов	44		3',
	'var			Розов	46		5',
	'var			Голуб	44		2',
	'var			Голуб	46		6'
);
Common::print(
	'type	name	title	color	size	price	count',
	'page	dress	Палтье			2000	',
	'good			Розов	44		3',
	'var			Розов	46		5',
	'var			Голуб	44		2',
	'var			Голуб	46		6'
);