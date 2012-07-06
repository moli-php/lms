<?php
class classLevelTestEdit extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->model("getmodel");
		$aData['sPageTitle'] = "Edit Level Test";
		$this->importJS("class/classLevelTest");
		
		$aData['sDate'] = date("Y-m-d");
		$aData['aTest'] = $this->db->getmodel->getData("tb_class_level_test", array("where" => "idx = " . $aArgs['idx']), "row");
	
		$this->display("class/tpl/classLevelTestManage", $aData);
	}
}