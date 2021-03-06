<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\Services\Template;

use fw\Core\Template\TemplateEngine;
use fw\Services\AbstractProvider;

/**
 * Class Provider
 * @package fw\Services\Template
 */
class Provider extends AbstractProvider
{
	/**
	 * @var string
	 */
	protected $serviceName = 'template';

	/**
	 * Initialization
	 */
	public function init()
	{
		$object = new TemplateEngine();
		
		$this->DI->setService($this->serviceName, $object);
	}
}