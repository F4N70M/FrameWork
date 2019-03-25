<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace Fw\App;

/**
 * Class View
 * @package Fw\App
 */
abstract class View
{
	protected $DI;
	
	public function __construct(\Fw\DI\DI $DI)
	{
		$this->DI = $DI;
	}
}