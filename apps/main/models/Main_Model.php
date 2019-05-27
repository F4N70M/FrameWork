<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace apps\main\models;
	
	use fw\App\Model;
	use fw\DI\DI;
	use fw\Helper\Common;
	
	class Main_Model extends Model
	{
		/**
		 * Main_Model constructor.
		 * @param DI $DI
		 */
		public function __construct(DI $DI)
		{
			parent::__construct($DI);
		}
		
		/**
		 * @param string $path
		 * @return array
		 */
		public function getDataPageFromPath(string $path)
		{
			// Default
			$result = [
				'data'  => null,
				'unique'=> null,
				'errors'=> false
			];
			// Проверяем алиасы
			$alias = $this->checkAliasFromPath($path);
			
			//  Если найден алиас пути
			if ($alias)
			{
				$unique = $alias;
			}
			else
			{
				$split = $this->splitParentsFromPath($path);
				
				$unique = ( ( empty($split['name']) ) ? $this->getIndexId() : $split['name'] );
			}
			
			$result['unique'] = $unique;
			
			$data = $this->getElementData($unique);
			
			
			if ($data)
			{
				//Common::print($split,$data);
				if (
					($alias)
					||
					(empty($split['name']) && empty($split['parents']) && $this->DI->getModule('main')->options->getValue('index') == $data['id'])
					||
					(!empty($split['parents']) && $this->checkParentSequence($data, $split['parents']))
				)
				{
					if ($this->checkAccess($data))
					{
						$result['data'] = $data;
					}
					else
					{
						$result['error'] = 403;
					}
				}
				else
				{
					$result['error'] = 404;
				}
			}
			else
			{
				$result['error'] = 404;
			}
			
			return $result;
		}
		
		/**
		 * @param array $object
		 * @param string $parents
		 * @return string|bool
		 */
		private function checkParentSequence(array $object, string $parents)
		{
			return
				in_array($parents, $object['parentsSequences'])
					? $object['parentsSequences'][array_search($parents, $object['parentsSequences'])]
					: false;
		}
		
		public function splitParentsFromPath(string $path)
		{
			$matches = [];
			preg_match('#^/*(?:((?:[^/]+/?)*)/)*([^/]*)/*$#', $path, $matches);
			
			$result = [
				'name'    => !empty($matches[2]) ? $matches[2] : null,
				'parents' => !empty($matches[1]) ? $matches[1] : null
			];
			
			return $result;
		}
		
		/**
		 * @return int|null
		 */
		public function getIndexId()
		{
			return $this->DI->getModule('main')->options->getValue('index');
		}
		
		/**
		 * @param $unique
		 * @return array|false
		 */
		public function getElementData($unique)
		{
			return $this->DI->getModule('main')->elements->get($unique);
		}
		
		public function checkAccess($pageInfo)
		{
			if (isset($pageInfo['access']))
			{
				//TODO: Написать проверку доступа
				//$this->DI->getModule('main')->Account->
				return true;
			}
			else
			{
				return true;
			}
		}
		
		private function checkAliasFromPath(string $path)
		{
			//TODO: Написать метод проверки алиасов Uri
			
			$result = $this->DI->getServices('db')
				->select()
				->from('aliases')
				->where([
					'path' => $path
				])
				->one();
			if ($result)
			{
				return $result['object'];
			}
			
			return false;
		}
	}