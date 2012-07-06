<?php
class classLevelTestSchedule extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->model("getmodel");
		$aData['sPageTitle'] = "Level Test Manage";
		
		$aData['aTeacherType'] = $this->db->getmodel->getData("tb_teacher_management");
		$aData['iTestIdx'] = $aArgs['idx'];

		$this->display("class/tpl/" . __CLASS__, $aData, false);
	}
}