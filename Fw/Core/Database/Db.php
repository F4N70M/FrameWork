<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\Core\Database;

use \PDO;

class Db
{
	private $link;

	/**
	 * Db constructor.
	 * @param PDO $link
	 */
	public function __construct(PDO $link)
	{
		$this->link = $link;
	}
	
	/**
	 * @param string $sql
	 * @param array $params
	 * @return QueryBuilder
	 */
	public function query(string $sql, array $params = [])
	{
		$object = new QueryBuilder($this->link);
		$object->custom($sql,$params);
		
		return $object;
	}
	
	/**
	 * @param mixed $columns
	 * @return QueryBuilder
	 * @throws \Exception
	 */
	public function select($columns=null)
	{
		$object = new QueryBuilder($this->link, "SELECT");
		$object->columns($columns);
		
		return $object;
	}
	
	/**
	 * @param $table
	 * @return QueryBuilder
	 */
	public function insert($table)
	{
		$object = new QueryBuilder($this->link, "INSERT");
		$object->into($table);
		
		return $object;
	}
	
	/**
	 * @param string $table
	 * @return QueryBuilder
	 */
	public function update(string $table)
	{
		$object = new QueryBuilder($this->link, "UPDATE");
		$object->table($table);
		
		return $object;
	}
	
	/**
	 * @return QueryBuilder
	 */
	public function delete()
	{
		$object = new QueryBuilder($this->link, "DELETE");
		
		return $object;
	}
}