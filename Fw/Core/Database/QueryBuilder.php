<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\Core\Database;

use \Exception;
use \PDO;
use \PDOException;
use \PDOStatement;

class QueryBuilder
{
	private $link;
	private $sql;
	private $bind = [];
	private $statement;
	
	/**
	 * QueryBuilder constructor.
	 * @param PDO $link
	 * @param null $query
	 */
	public function __construct(PDO $link, $query=null)
	{
		$this->link = $link;
		$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->sql = $query;
	}

	public function custom($sql, $params=[])
	{
		$this->sql = $sql;
		$this->bind = $params;
	}
	
	/**
	 * @param $columns
	 * @return $this
	 * @throws Exception
	 */
	public function columns($columns=null)
	{
		if (empty($columns)) {
			$this->sql .= " *";
		}
		elseif (is_array($columns))
		{
			$this->sql .= " " . implode(', ', $columns);
		}
		elseif (is_string($columns))
		{
			$this->sql .= " " . $columns;
		}
		else
		{
			throw new Exception('Request Error: Invalid query result column format');
		}
		
		return $this;
	}
	
	/**
	 * @param string $table
	 * @return $this
	 */
	public function from(string $table)
	{
		$this->sql .= " FROM $table";
		
		return $this;
	}
	
	/**
	 * @param string $table
	 * @return $this
	 */
	public function into(string $table)
	{
		$this->sql .= " INTO $table";
		
		return $this;
	}
	
	/**
	 * @param string $table
	 * @return $this
	 */
	public function table(string $table)
	{
		$this->sql .= " $table";
		
		return $this;
	}
	
	/**
	 * @param array $values
	 * @return $this
	 * @throws Exception
	 */
	public function set(array $values=[])
	{
		if (!empty($values)) {
			$this->sql .= " SET";
			
			$bindValues = [];
			foreach ($values as $key => $value)
			{
				$bindValues[$key] = " $key = :$key";
				$this->bind[":$key"] = $value;
			}
			$this->sql .= implode(",", $bindValues);
		}
		else
		{
			throw new Exception('Request failed: no values to update');
		}
		
		return $this;
	}
	
	/**
	 * @param array $values
	 * @return $this
	 * @throws Exception
	 */
	public function values(array $values=[])
	{
		if (!empty($values)) {
			$this->sql .= " (";
			$this->sql .= implode(", ", array_keys($values));
			$this->sql .= ") VALUES (";
			foreach ($values as $key => $value)
			{
				$bindValues[$key] = ":$key";
				$this->bind[":$key"] = $value;
			}
			$this->sql .= implode(", ", $bindValues);
			$this->sql .= ")";
		}
		else
		{
			throw new Exception('Request failed: no values to update');
		}
		
		return $this;
	}

	public function where($where=null)
	{
		if ( !empty($where) )
		{
			$this->sql .= " WHERE $where";
		}
		//TODO: Написать обрабочик условия запроса
		return $this;
	}
	
	/**
	 * @param $orderBy
	 * @return $this
	 */
	public function orderBy($orderBy)
	{
		if (!empty($orderBy))
		{
			$this->sql .= " ORDER BY";
			
			if ( is_array($orderBy) )
			{
				foreach ($orderBy as $key => $value)
				{
					if (is_numeric($key))
					{
						$this->sql .= " $value ASC";
					}
					else
					{
						$this->sql .= " $key " . ((!$value || strtoupper($value) == "DESC") ? "DESC" : "ASC");
					}
				}
			}
			elseif(preg_match('/^[A-z0-9\-_, ]+$/', $orderBy))
			{
				$this->sql .= " $orderBy";
			}
		}
		
		return $this;
	}

	public function limit(int $l1,int $l2=null)
	{
		$this->sql .= " LIMIT $l1" . ($l2 !== null ? ", $l2" : "");
		return $this;
	}
	
	/**
	 * @return array
	 * @throws Exception
	 */
	public function all()
	{
		$result = $this->do();
		
		if ( $result )
		{
			$result = $this->statement->fetchAll(PDO::FETCH_ASSOC);
		}
		
		return $result;
	}
	
	/**
	 * @return array
	 * @throws Exception
	 */
	public function one()
	{
		$result = $this->do();
		
		if ( $result )
		{
			$result = $this->statement->fetch(PDO::FETCH_ASSOC);
		}
		
		return $result;
	}
	
	/**
	 * @return bool|string
	 * @throws Exception
	 */
	public function do()
	{
		$this->statement = $this->prepare($this->sql, $this->bind);
		
		$this->statement = $this->execute($this->statement);
		
		
		if($this->statement)
		{
			if (preg_match('#^insert#is',$this->sql))
			{
				$result = $result = $this->link->lastInsertId();
			}
			else
			{
				$result = true;
			}
		}
		else
		{
			$result = false;
		}
		
		return $result;
	}
	
	/**
	 * @param $sql
	 * @param array $bind
	 * @return bool|PDOStatement
	 */
	private function prepare($sql, array $bind)
	{
		try
		{
			$statement = $this->link->prepare($sql);
			if (!empty($bind))
			{
				foreach ($bind as $key => $value)
				{
					$statement->bindValue($key,$value);
				}
			}
		}
		catch (PDOException $e)
		{
			echo "Request failed: ";
			echo $e->getMessage();
			$statement = null;
		}
		
		return $statement;
	}
	
	/**
	 * @param PDOStatement $statement
	 * @return PDOStatement
	 * @throws Exception
	 */
	private function execute(PDOStatement $statement)
	{
		//Common::print($this->sql);
		try
		{
			$statement->execute();
		}
		catch (PDOException $e)
		{
			//throw new Exception("Request error: " . $e->getMessage());
			echo "Request error: ";
			echo $e->getMessage();
			//throw $e;
			
			$statement = false;
		}
		return $statement;
	}
}