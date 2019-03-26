<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\App;

/**
 * Class View
 * @package fw\App
 */
abstract class View
{
	protected $DI;
	
	public function __construct(\fw\DI\DI $DI)
	{
		$this->DI = $DI;
	}
}