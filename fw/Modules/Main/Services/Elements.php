<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace fw\Modules\Main\Services;
	
	use fw\DI\DI;
	
	class Elements
	{
		public $DI;
		
		/**
		 * Elements constructor.
		 * @param DI $DI
		 */
		public function __construct(DI $DI)
		{
			$this->DI = $DI;
		}
		
		/**
		 * @param $unique
		 * @return array|false
		 */
		public function get($unique)
		{
			$object = $this->DI->getServices('db')
				->select()
				->from('objects')
				->where([
					$this->defineUnique($unique) => $unique
				])
				->one();
			if ($object)
			{
				$object['parentsSequences'] = $this->getParents($object['id']);
			}
			return $object;
		}
		
		/**
		 * @param int $id
		 * @return array
		 */
		public function getParents(int $id)
		{
			return $this->recursiveParents($id,'objects');
		}
		
		/**
		 * @param int $id
		 * @param string $table
		 * @return array
		 */
		public function recursiveParents(int $id, string $table)
		{
			$result = [];
			
			$relations = $this->DI->getModule('main')->relations->getParents($id,$table);
			
			foreach ($relations as $relation)
			{
				$parentObject = $this->DI->getServices('db')
					->select()
					->from('objects')
					->where(['id' => $relation['parent_id']])
					->one();
				$parentsSequence = $parentObject['name'];
				
				$parentRelations = $this->recursiveParents($relation['parent_id'], $relation['parent_table']);
				if (!empty($parentRelations))
				{
					foreach ($parentRelations as $parentRelation)
					{
						$result[] = $parentRelation . '/' . $parentsSequence;
					}
				}
				else
				{
					$result[] = $parentsSequence;
				}
			}
			
			return $result;
		}
		
		/**
		 * @param $unique
		 * @return string
		 */
		public function defineUnique($unique)
		{
			return ((is_numeric($unique) && (int) $unique == $unique) ? 'id' : 'name');
		}
	}