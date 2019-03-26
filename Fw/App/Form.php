<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\App;

/**
 * Class Form
 * @package fw\App
 */
abstract class Form
{
	protected $DI;
	
	public function __construct(\fw\DI\DI $DI)
	{
		$this->DI = $DI;
	}
}