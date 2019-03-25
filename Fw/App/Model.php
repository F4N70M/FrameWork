<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace Fw\App;

/**
 * Class Model
 * @package Fw\App
 */
abstract class Model
{
	protected $DI;
	
	public function __construct(\Fw\DI\DI $DI)
	{
		$this->DI = $DI;
	}
}