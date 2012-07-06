<?php
class classLevelTestInfo extends Simplexi_Controller
{
	public function run($aArgs)
	{
		if (!isset($aArgs['idx']) || $aArgs['idx'] == "")
			header("location:" . common::getClassUrl("classList"));
		
		$this->importJS("class/" . __CLASS__);
		$this->model("getmodel");
		$aData['sPageTitle'] = "Level Test Information | Class";
		$sTest = "";
		
		if (isset($aArgs['testIdx'])){
			$sTest = " AND idx = " . $aArgs['testIdx'];
		}
		
		$aData['aTeacherType'] = $this->db->getmodel->getData("tb_teacher_management");
		$aData['aUser'] = $this->db->getmodel->getData("tb_user", array("where" => "idx = " . $aArgs['idx']), "row");
		$aData['aAllTest'] = $this->db->getmodel->getData("tb_class_level_test", array("where" => "student_idx = " . $aArgs['idx'] . " AND delete_flag = 0", "order" => "datetime_create DESC"));
		$aData['aTest'] = $this->db->getmodel->getData("tb_class_level_test", array("where" => "student_idx = " . $aArgs['idx'] . " AND delete_flag = 0" . $sTest, "order" => "datetime_create DESC"));
		if ($aData['aTest'][0]['status'] != 0)
			$aData['aTeacher'] = $this->db->getmodel->getData("tb_user", array("where" => "idx = " . $aData['aTest'][0]['teacher_idx']), "row");

		$this->display("class/tpl/" . __CLASS__, $aData);
	}
}