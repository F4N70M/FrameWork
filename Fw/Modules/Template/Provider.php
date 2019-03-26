<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace Fw\Modules\Template;

use Fw\Core\Template\TemplateEngine;
use Fw\Modules\AbstractProvider;

/**
 * Class Provider
 * @package Fw\Modules\Template
 */
class Provider extends AbstractProvider
{
	/**
	 * @var string
	 */
	public $moduleName = 'template';

	/**
	 * Initialization
	 */
	public function init()
	{
		$object = new TemplateEngine();
		
		$this->DI->set($this->moduleName, $object);
	}
}