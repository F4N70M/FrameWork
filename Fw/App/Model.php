<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\App;

/**
 * Class Model
 * @package fw\App
 */
abstract class Model
{
	protected $DI;
	
	public function __construct(\fw\DI\DI $DI)
	{
		$this->DI = $DI;
	}
}