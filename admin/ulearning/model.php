<?php
class Model
{
	public function init()
	{
	    $this->library('common');
		$sTableName = "my_table";

		$aFields = array(

		'first_name' ,

		'last_name' 

		);
		$sWhere = "idx  = 1";
		$this->select($sTableName,$aFields,$sWhere )->vs();
	}
}
$oClass = new index();
?>