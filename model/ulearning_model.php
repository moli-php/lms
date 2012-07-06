<?php
class Ulearning_model extends model{
	private $sql;
	private $where;
	function db_insert($table,$arrayField){
		$this->sql = "INSERT INTO $table (";
		$array2= array();
		$array2 = $this->_index2string($arrayField);
		$this->sql .= $this->_field($array2);
		$this->sql .= ") VALUES (";
		$this->sql .= $this->_sfield($arrayField);
		$this->sql .= ")";
		$query = $this->query($this->sql);
		return $query;
	}
	function db_delete($table,$arrayWhere = null){
		$this->sql = "DELETE FROM $table";
		$this->setWhere($arrayWhere);
		$query = $this->query($this->sql);
		$this->where = "";
		return $query;
	}
	function db_update($table,$arrayField,$arrayWhere = null){
		$this->sql = "UPDATE $table SET ";
		$this->sql .= $this->_setValue($arrayField,',');
		$this->setWhere($arrayWhere);
		$query = $this->query($this->sql);
		$this->where = "";
		return $query;
	}
	function db_select($table,$arrayField = null,$arrayWhere = null,$order = null,$limit = null,$offset = null){
		$this->sql = "SELECT ";
		if($arrayField){
			$this->sql .= $this->_field($arrayField);
		}
		else
			$this->sql .= "*";
		$this->sql .= " FROM $table";
		$this->setWhere($arrayWhere);
		if($order)
			$this->sql .= $this->_order($order);
		if($offset && $limit)
			$this->sql .= " LIMIT $offset, $limit";
		else if($limit)
			$this->sql .= " LIMIT $limit";
		$query = $this->query($this->sql);
		$this->where = "";
		return $query;
	}
	function db_select_distinct($table,$arrayField = null,$arrayWhere = null,$order = null,$limit = null,$offset = null){
		$this->sql = "SELECT DISTINCT ";
		if($arrayField){
			$this->sql .= $this->_field($arrayField);
		}
		else
			$this->sql .= "*";
		$this->sql .= " FROM $table";
		$this->setWhere($arrayWhere);
		if($order)
			$this->sql .= $this->_order($order);
		if($offset && $limit)
			$this->sql .= " LIMIT $offset, $limit";
		else if($limit)
			$this->sql .= " LIMIT $limit";
		$query = $this->query($this->sql);
		$this->where = "";
		return $query;
	}
	function db_count($table,$arrayWhere = null){
		$this->sql = "SELECT COUNT(*) as count FROM $table";
		$this->setWhere($arrayWhere);
		$query = $this->query($this->sql);
		$this->where = "";
		return $query[0]['count'];
	}
	function db_max($table,$max,$arrayWhere = null){
		$this->sql = "SELECT MAX($max) as $max FROM $table";
		$this->setWhere($arrayWhere);
		$query = $this->query($this->sql);
		$this->where = "";
		return $query[0][$max];
	}
	function db_sum($table,$sum,$arrayWhere = null){
		$this->sql = "SELECT SUM($sum) as $sum FROM $table";
		$this->setWhere($arrayWhere);
		$query = $this->query($this->sql);
		$this->where = "";
		return $query[0][$sum];
	}
	function db_where($arrayWhere){
		if(is_array($arrayWhere))
			$this->where = $this->_where($arrayWhere);
		else
			$this->where = " WHERE ".$arrayWhere;
	}
	private function getWhere(){
		return $this->where;
	}
	private function setWhere($arrayWhere){
		if($arrayWhere)
			$this->sql .= $this->_where($arrayWhere);
		else
			$this->sql .= $this->getWhere();
	}
	private function _order($order){
		$str = " ORDER BY ";
		for($i=0;$i<count($order);$i++){
			$str .= $order[key($order)]." ".key($order)." ";
			next($order);
			if($i<count($order)-1){
				$str .= ", ";
			}
		}
		return $str;
	}
	private function _where($arrayWhere){
		$str = "";
		if($arrayWhere){
			$str .= " WHERE ";
			$str .= $this->_setValue($arrayWhere);
		}
		return $str;
	}
	private function _setValue($array,$delimiter = null){
		$str = "";
		if($array){
			for($i=0;$i<count($array);$i++){
					$str .= key($array);
					if(!strpos(key($array),"LIKE"))
					$str .= "= ";
					$str .= " '".addslashes($array[key($array)]);
					if(strpos(key($array),"LIKE"))
					$str .= "%";
					$str .= "'";
				next($array);
				if($i<count($array)-1){
					if($delimiter)
						$str .= "$delimiter ";
					else
						$str .= " AND ";
				}
			}
		}
		return $str;
	}
	private function _field($array){
		$str = "";
		$str = implode(", ",$array);
		return $str;
	}
	private function _sfield($array){
		$str ="";
		for($i=0;$i<count($array);$i++){
			$str .= "'".addslashes($array[key($array)])."'";
			next($array);
			if($i<count($array)-1){
				$str .= ", ";
			}
		}
		return $str;
	}
	private function _index2string($array){
		$array2 = array();
		for($i=0;$i<count($array);$i++){
			$array2[key($array)] = key($array);
			next($array);
		}
		return $array2;
	}

}
?>