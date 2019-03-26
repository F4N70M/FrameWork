<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\Modules\Template;

use fw\Core\Template\TemplateEngine;
use fw\Modules\AbstractProvider;

/**
 * Class Provider
 * @package fw\Modules\Template
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