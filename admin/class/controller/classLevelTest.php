<?php
class classLevelTest extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->model("getmodel");
		$aData['sPageTitle'] = "Level Test";
		$this->importJS("class/" . __CLASS__);
		$aData['iPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
		$aData['sOrder'] = isset($aArgs['order']) ? $aArgs['order'] : "datetime_create";
		$aData['sSort'] = isset($aArgs['sort']) ? $aArgs['sort'] : "desc";
		$aData['sKeyword'] = isset($aArgs['keyword']) ? $aArgs['keyword'] : null;
		$aData['iRows'] = isset($aArgs['row']) ? $aArgs['row'] : 10;
		$aData['sStatus'] = isset($aArgs['status']) ? $aArgs['status'] : null;
		$aData['sType'] = isset($aArgs['type']) ? $aArgs['type'] : null;
		$aData['sStartDate'] = isset($aArgs['startdate']) ? $aArgs['startdate'] : null;
		$aData['sEndDate'] = isset($aArgs['enddate']) ? $aArgs['enddate'] : null;
		$aData['iTeacher'] = isset($aArgs['teacheridx']) ? $aArgs['teacheridx'] : null;
		$sAddtionalQuery = (USER_GRADE == 9 ? "delete_flag = 0" : "delete_flag = 0 AND branch_idx = " . USER_ID);
		$aOption['where'] = $sAddtionalQuery;
		
		if ($aData['sKeyword'] != null)
			$aOption['where'] .= ($aOption['where'] != "" ? " AND " : "") . "student_idx IN (SELECT idx FROM tb_user WHERE grade_idx = 1 AND name LIKE '%" . $aData['sKeyword'] . "%')";
		if ($aData['iTeacher'] != null)
			$aOption['where'] .= ($aOption['where'] != "" ? " AND " : "") . "teacher_idx = " . $aData['iTeacher'];
		if ($aData['sStatus'] != null)
			$aOption['where'] .= ($aOption['where'] != "" ? " AND " : "") . "status = " . $aData['sStatus'];
		if ($aData['sStartDate'] != null && $aData['sEndDate'] != null)
			$aOption['where'] .= ($aOption['where'] != "" ? " AND " : "") . "date_test BETWEEN '" . $aData['sStartDate'] . "' AND '" . $aData['sEndDate'] . "'";
		
		$aOption = array(
			"where" => $aOption['where'],
			"order" => $aData['sOrder'] . " " . strtoupper($aData['sSort']),
			"offset" => ($aData['iRows'] * ($aData['iPage'] - 1)),
			"limit" => $aData['iRows']
		);

		$aData['aTest'] = $this->db->getmodel->getData("tb_class_level_test", $aOption);

		if (count($aData['aTest']) > 0 && $aData['aTest'] !== false){
			foreach ($aData['aTest'] as $iKey => $aValue){
				$aUser = $this->db->getmodel->getData("tb_user", array("where" => "idx = " . $aValue['student_idx'], "select" => "user_id, name"), "row");
				$aTeacher = $this->db->getmodel->getData("tb_user", array("where" => "idx = " . $aValue['teacher_idx'], "select" => "name"), "row");
				$aData['aTest'][$iKey]['userid'] = $aUser['user_id'];
				$aData['aTest'][$iKey]['fullname'] = $aUser['name'];
				$aData['aTest'][$iKey]['teacher'] = $aTeacher['name'];
			}
		}
		
		$aData['aBranch'] = $this->db->getmodel->getData("tb_user", array("where" => (USER_GRADE == 9 ? "grade_idx = 8" : "idx = " . USER_ID), "select" => "idx, name"));

		$aData['aTeacher'] = $this->query("SELECT DISTINCT tu.idx, tu.branch_idx, name 
			FROM tb_user AS tu WHERE tu.branch_idx IN (SELECT idx FROM tb_user WHERE grade_idx = 8) AND tu.grade_idx = 6");
			
		$_SESSION['adminClassFullUrl'] = FULL_URL;

		$aData['iTotalData'] = $this->db->getmodel->getTotalRows("tb_class_level_test", $sAddtionalQuery);
		$aData['iTotalRows'] = $this->db->getmodel->getTotalRows("tb_class_level_test", $aOption['where']);
		$aData['iActivated'] = $this->db->getmodel->getTotalRows("tb_class_level_test", "status != 0 AND " . $sAddtionalQuery);
		$aData['iOnlyApplied'] = $this->db->getmodel->getTotalRows("tb_class_level_test", "status = 0 AND " . $sAddtionalQuery);
		$aData['sPagination'] = common::paginate($aData['iPage'], $aData['iRows'], (count($aData['aTest']) > 0 ? $aData['iTotalRows'] : 0));

		$this->display("class/tpl/" . __CLASS__, $aData);
	}
}