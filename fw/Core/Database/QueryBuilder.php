<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace fw\Core\Database;

use \Exception;
use fw\Helper\Common;
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
	
	/**
	 * @param null $where
	 * @return $this
	 */
	public function where($where=null)
	{
		$whereString = $this->recursiveWhere($where);
		//Common::print($whereString);
		if ( !empty($whereString) )
		{
			$this->sql .= " WHERE $whereString";
		}
		
		Common::print($this->sql);
		Common::print($this->bind);
		
		return $this;
	}
	
	/**
	 * @param   $where
	 * @return  string
	 *
	 * @example ['id'=>5]
	 * @result  WHERE id = 5
	 *
	 * @example ['id'=>['>=', 7]]
	 * @result  WHERE id >= 7
	 *
	 * @example ['id'=>['<', 4], ['or', 'id'=>['>', 6]]]
	 * @result  WHERE id < 4 || id > 6
	 *
	 * @example ['id'=>['like', '%test%']]
	 * @result  WHERE id LIKE '%test%'
	 *
	 * @example ['date'=>['between', ['2019-03-03', '2019-03-05']]]
	 * @result  WHERE date BETWEEN '2019-03-03' AND '2019-03-05'
	 *
	 * @example ['date'=>['in', ['2019-03-04', '2019-03-11']]]
	 * @result  WHERE date IN ('2019-03-04', '2019-03-11')
	 */
	private function recursiveWhere($where)
	{
		$result = '';
		
		if (!empty($where))
		{
			
			if (is_array($where))
			{
				$result = '';
				foreach ($where as $key => $item) {
					if (is_numeric($key) && is_array($item))
					{
						if ($this->isset_glue($item))
						{
							$glue = $this->get_glue($item);
							
							foreach ($item as $ikey => $value)
							{
								if ( is_numeric($ikey) )
								{
									$tmp = $this->recursiveWhere($value);
									if (!empty($tmp))
										$result .= " $glue ($tmp)";
								}
								else
								{
									$tmp = $this->parseValueWhere($value);
									if (!empty($tmp))
										$result .= " $glue $ikey $tmp";
								}
							}
						}
						else
						{
							$tmp = $this->recursiveWhere($item);
							
							if (!empty($tmp))
							{
								if ( !empty($result) ) $result .= " && ";
								$result .= '(' . $tmp . ')';
							}
						}
						
					}
					elseif(is_string($key) && !empty($key))
					{
						if(is_scalar($item))
						{
							if ( !empty($result) ) $result .= " && ";
							$bindName = ":where" . count($this->bind);
							$this->bind[$bindName] = $item;
							$result .= "$key = $bindName";
						}
						elseif (is_null($item))
						{
							if ( !empty($result) ) $result .= " && ";
							$result .= "$key IS NULL";
						}
						elseif (count($item) == 2 && isset($item[0]) && is_string($item[0]))
						{
							$tmp = $this->parseValueWhere($item);
							if (!empty($tmp))
							{
								if ( !empty($result) ) $result .= " && ";
								$result .= "$key $tmp";
							}
						}
						else
						{}
					}
				}
			}
			elseif(is_string($where))
			{
				#
			}
			else
			{
				#
			}
		}
		
		return $result;
	}
	
	/**
	 * @param array $item
	 * @return bool
	 */
	private function isset_glue(array $item)
	{
		return (count($item) == 2 && isset($item[0]) && in_array(strtoupper($item[0]), ['AND','OR','&&','||']));
	}
	
	/**
	 * @param array $item
	 * @return string
	 */
	private function get_glue(array $item)
	{
		return (in_array(strtoupper(array_shift($item)), ['OR','||']) ? '||' : '&&');
	}
	
	/**
	 * @param array $array
	 * @return string
	 */
	private function parseValueWhere(array $array)
	{
		$result = '';
		$operator = strtoupper(array_shift($array));
		foreach ($array as $value)
		{
			if (in_array($operator, ['=','>','<','>=','<=','<>','LIKE']) && is_scalar($value))
			{
				$bindName = ":where" . count($this->bind);
				$this->bind[$bindName] = $value;
				$result .= "$operator $bindName";
			}
			elseif ($operator == 'BETWEEN' && is_array($value) && count($value) == 2 && is_scalar($value[0]) && !empty($value[0]) && is_scalar($value[1]) && !empty($value[1]))
			{
				$result = "$operator ";
				
				$bindName = ":where" . count($this->bind);
				$this->bind[$bindName] = $value[0];
				$result .= $bindName;
				
				$result .= " AND ";
				
				$bindName = ":where" . count($this->bind);
				$this->bind[$bindName] = $value[1];
				$result .= $bindName;
			}
			elseif ($operator == 'IN' && is_array($value) && !empty($value) )
			{
				$in = [];
				foreach ($value as $inValue)
				{
					if ( is_scalar($inValue) || is_null($inValue) )
					{
						$in[] = $inValue;
					}
					else
					{
						$in = [];
						break;
					}
				}
				if (!empty($in))
				{
					foreach ($in as $key => $item)
					{
						$bindName = ":where" . count($this->bind);
						$this->bind[$bindName] = $item;
						$in[$key] = $bindName;
					}
					$result = "$operator (" . implode(',', $in) . ")";
				}
			}
			break;
		}
		
		return $result;
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

	public function limit(int $l1, int $l2=null)
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
			if (preg_match('#^insert#is', $this->sql))
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
					$statement->bindValue($key, $value);
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