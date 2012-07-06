<?php
class ModelContent extends Simplexi_Controller
{
	private $where;
	public function init()
	{
	}
	public function db_insert($table,$aFields){
		$this->insert($table, array($aFields))->vs();
	}
	public function db_delete($table,$sWhere = null){
		if(!$this->where)
			$this->setWhere($sWhere);
		if($sWhere)
			$this->deleteBy($table, $this->where)->vs();
		else
			$this->delete($table)->vs();
		$this->where = "";
	}
	public function db_update($table,$aFields,$sWhere = null){
		if(!$this->where)
			$this->setWhere($aFields);
		$this->update($table, $aFields, $this->where)->vs();
		$this->where = "";
	}
	public function db_select($stable,$aFields = null,$sWhere = null,$order = null,$limit = null,$offset = null){
		if(!$this->where)
			$this->setWhere($sWhere);
		if($aFields)
			return $this->selectRow($stable, $aFields, $this->where)->vs();
		else
			return $this->selectAll($stable, $aFields)->vs();
		$this->where = "";
	}
	function db_where($affields){
		if(is_array($affields))
			$this->where = $this->_setValue($affields);
		else
			$this->where = $affields;
	}
	private function setWhere($affields){
		if($affields)
			$this->where .= $this->_setValue($affields);
	}
	private function _setValue($array){
		$str = "";
		if($array){
			for($i=0;$i<count($array);$i++){
					$str .= key($array);
					$str .= " = ";
					$str .= " '".addslashes($array[key($array)])."'";
				next($array);
				if($i<count($array)-1)
					$str .= " AND ";
			}
		}
		return $str;
	}
}
$oClass = new ModelContent();
?>