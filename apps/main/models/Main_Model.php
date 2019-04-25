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
		public function getInfoPageFromPath(string $path)
		{
			$result = [
				'type' => 'error',
				'name' => 404
			];
			
			$split = $this->splitParentsFromPath($path);
			
			if (empty($unique = $split['name']))
			{	$result = [
					'type' => 'index'
				];
				$unique = $this->getIndexId();
			}
			
			if ($object = $this->getObjectData($unique))
			{
				if (empty($split['parents']) || (!empty($split['parents']) && $this->checkParentSequence($object, $parents=$split['parents'])))
				{
					
					$result = $object;
				}
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
				'name'    => $matches[2],
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
		public function getObjectData($unique)
		{
			return $this->DI->getModule('main')->objects->get($unique);
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
	}