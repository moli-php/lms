<?php
class classCalendar extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->model("getmodel");
		$this->importJS("class/classTeacherCalendar");
		
		if (isset($aArgs['exec'])){
			$sAction = "exec" . ucfirst($aArgs['exec']);
			unset($aArgs['exec']);
			unset($aArgs['action']);
			$this->$sAction($aArgs);
		} else {
			$this->initiateData($aArgs);
		}
	}
	
	private function initiateData($aArgs)
	{
		$aData['sPageTitle'] = "Class Calendar";
		
		$sAddtionalQuery = (USER_ID == 1 ? "grade_idx = 6" : "grade_idx = 6 AND branch_idx = " . USER_ID);
		$aOption['where'] = $sAddtionalQuery;
		$aData['aTeacher'] = $this->db->getmodel->getData("tb_user", $aOption);

		$this->display("class/tpl/" . __CLASS__, $aData);
	}
	
	private function execGetCalendarData($aArgs)
	{
		$sDate = $aArgs['date'];
		if ($aArgs['changeAction'] == "next")
			$sDate = date('Y-m-d', strtotime('+1 day', strtotime($sDate)));
		else if ($aArgs['changeAction'] == "prev")
			$sDate = date('Y-m-d', strtotime('-1 day', strtotime($sDate)));
			
		$sAddtionalQuery = (USER_ID == 1 ? "grade_idx = 6" : "grade_idx = 6 AND branch_idx = " . USER_ID);
		$aOption['where'] = $sAddtionalQuery;
		$aOption['select'] = "idx, user_id, name";

		$aData['aTeacher'] = $this->db->getmodel->getData("tb_user", $aOption);

		foreach ($aData['aTeacher'] as $iKey => $aValue){
			$aData['aTeacher'][$iKey]['aClass'] = $this->query("(SELECT tcs.student_idx, tcs.time_start, tcs.time_end, tu.name, tcs.sched_status, 'class' AS stype
				FROM tb_class_schedule AS tcs 
				LEFT JOIN tb_user AS tu ON tcs.student_idx = tu.idx
				WHERE tcs.teacher_idx = " . $aValue['idx'] . " AND tcs.daystart = '" . $sDate . "')

				UNION ALL

				(SELECT 
				tclt.student_idx, tclt.time_start, tclt.time_end, tu.name, tclt.status, 'test' AS stype
				FROM 
				tb_class_level_test AS tclt
				LEFT JOIN tb_user AS tu ON tclt.student_idx = tu.idx
				WHERE 
				tclt.date_test = '" . $sDate . "' AND tclt.teacher_idx = " . $aValue['idx'] . ")");	
		}
		
		$aData['date'] = $sDate;
		
		echo json_encode($aData);
	}
}