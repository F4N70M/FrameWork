<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace apps\main;

use Fw\Helper\Common;

/**
 * Class Controller
 * @package apps\main
 */
class Model extends \Fw\App\Model
{
	/**
	 * @param $path
	 * @return array
	 */
	public function getInfoByUriPath($path)
	{
		$parse = $this->parseUriPath($path);
		//Common::print($parse);
		
		$object = $this->getObject($parse['object'], $parse['parents']);
		//Common::print($object);
		
		$result['object']  = ($object ? $object : null);
		$result['method']  = ($object ? 'page' : '404');
		$result['mode']    = $parse['mode'];
		
		return $result;
	}
	
	/**
	 * @param $idOrName
	 * @param array $parents
	 * @return mixed
	 */
	private function getObject($idOrName, array $parents)
	{
		$db = $this->DI->get('db');
		
		$result = $db->select()
			->from('objects')
			->where("id='$idOrName' OR name='$idOrName'")
			->one();
		
		if ( $result )
		{
			$result['parents'] = $parents;
			//TODO: Слеать проверку по иерархии свазей объекта
		}
		
		return $result;
	}
	
	/**
	 * @param $path
	 * @return array
	 */
	public function parseUriPath($path)
	{
		preg_match("#^(?:(.*)/)?([A-z0-9\-_]+)(?:.([A-z]+))?$#", $path, $matches);
		
		$info['object']  = (isset($matches[2]) && !empty($matches[2]) ? $matches[2] : null);
		$info['parents'] = (isset($matches[1]) && !empty($matches[1]) ? explode("/", $matches[1]) : []);
		$modes = ['json','xml'];
		$info['mode']    = (isset($matches[3]) && !empty($matches[3] && in_array($matches[3],$modes)) ? $matches[3] : 'html');
		
		return $info;
	}
	
	public function loadTemplate($object)
	{
		//TODO: Написать лоадер шаблона страницы
		$settings = file_get_contents(__DIR__ . '/settings.json');
		$settings = Common::json($settings, false);
		Common::print("settings:",$settings);
		
		$templatePath = __DIR__ . "/templates/" . $settings['template'] . "/base.tpl";
		return file_get_contents($templatePath);
	}
}