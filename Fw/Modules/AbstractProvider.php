<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace Fw\modules;


abstract class AbstractProvider
{
	protected $DI;

	public function __construct(\Fw\DI\DI $DI)
	{
		$this->DI = $DI;
	}

	abstract public function init();
}