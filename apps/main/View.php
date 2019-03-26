<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace apps\main;

use fw\Helper\Common;

/**
 * Class Controller
 * @package apps\main
 */
class View extends \fw\App\View
{
	
	public function render($object, $mode='html', $template=null)
	{
		Common::print($object,$mode,$template);
		
		//TODO: написать метод рендера страницы
	}
}