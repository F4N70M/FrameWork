<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace Fw\App;

/**
 * Class Form
 * @package Fw\App
 */
abstract class Form
{
	protected $DI;
	
	public function __construct(\Fw\DI\DI $DI)
	{
		$this->DI = $DI;
	}
}