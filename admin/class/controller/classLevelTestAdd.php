<?php
class classLevelTestAdd extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$aData['sPageTitle'] = "Add New Level Test";
		$this->importJS("class/classLevelTest");
		$aData['sDate'] = date("Y-m-d");
		
		$this->display("class/tpl/classLevelTestManage", $aData);
	}
}