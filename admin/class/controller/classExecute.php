<?php
class classExecute extends Simplexi_Controller
{
	public function run($aArgs)
	{
	    $this->library(array("checkLogin", "common"));
	    $this->model(array("getmodel", "execmodel"));
		$sAction = "exec" . ucfirst($aArgs['exec']);
		unset($aArgs['exec']);
		unset($aArgs['action']);
		$this->$sAction($aArgs);
	}
	
	private function execGetUserData($aArgs)
	{
		$sSearch = $aArgs['search'];
		
		$aResult = $this->db->getmodel->getData("tb_user", array("where" => "(user_id = '" . $sSearch . "' OR name = '" . $sSearch . "') AND grade_idx = 1"), "row");
		
		echo json_encode($aResult);
	}
	
	private function execGetTeacher($aArgs)
	{
		$iIdx = $aArgs['testIdx'];
		$sString = "";
		
		$aData['aTest'] = $this->query("SELECT idx, name FROM tb_user 
			WHERE branch_idx = (SELECT tu.branch_idx FROM tb_class_level_test AS tclt LEFT JOIN tb_user AS tu ON tclt.student_idx = tu.idx WHERE tclt.idx = " . $iIdx . ") 
			AND grade_idx = 6 
			AND teacher_type_idx = " . $aArgs['type']);
			
		$aData['aHoliday'] = $this->db->getmodel->getTotalRows("tb_class_holiday", "ass_holiday = '" . $aArgs['date'] . "'");
			
		foreach ($aData['aTest'] as $iKey => $aValue)	
			$aData['aSchedule'][$iKey] = $this->query("(SELECT 
			tcs.time_start, tcs.time_end , 'class' AS tablename, tcs.idx
			FROM 
			tb_class_schedule AS tcs
			WHERE
			tcs.daystart = '" . $aArgs['date'] . "' AND tcs.teacher_idx = " . $aValue['idx'] . ")

			UNION ALL

			(SELECT 
			tclt.time_start, tclt.time_end, 'test' AS tablename, tclt.idx
			FROM 
			tb_class_level_test AS tclt
			WHERE 
			tclt.date_test = '" . $aArgs['date'] . "' AND tclt.teacher_idx = " . $aValue['idx'] . ")");

		echo json_encode($aData);
	}
	
	private function execSaveLevelTest($aArgs)
	{
		$aData = array(
			"branch_idx" => USER_ID,
			"student_idx" => $aArgs['studentidx'],
			"type" => $aArgs['level_type'],
			"datetime_desired" => strtotime($aArgs['desired_date'] . " " . $aArgs['desired_hours'] . ":" . $aArgs['desired_minutes'] . ":00"),
			"memo" => $aArgs['level_memo'],
			"status" => "only_applied",
			"datetime_create" => time(),
			"datetime_update" => time()
		);
		
		$aResult = $this->db->execmodel->insertData("tb_class_level_test", $aData);
		
		if ($aResult === false) {
			$this->message("warning", "Saving failed.");
			echo false;
		} else {
			$this->message("success", "Successfully saved.");
			echo true;
		}
	}
	
	private function execEditLevelTest($aArgs)
	{
		$aData = array(
			"type" => $aArgs['level_type'],
			"datetime_desired" => strtotime($aArgs['desired_date'] . " " . $aArgs['desired_hours'] . ":" . $aArgs['desired_minutes'] . ":00"),
			"memo" => $aArgs['level_memo'],
			"status" => "only_applied",
			"datetime_update" => time()
		);
		
		$aResult = $this->db->execmodel->updateData("tb_class_level_test", $aData, "idx = " . $aArgs['test_idx']);
		
		if ($aResult === false) {
			$this->message("warning", "Saving failed.");
			echo false;
		} else {
			$this->message("success", "Successfully saved.");
			echo true;
		}
	}
	
	private function execGetLevelTestData($aArgs)
	{
		$aTest = $this->db->getmodel->getTotalRows("tb_class_level_test", "student_idx = " . $aArgs['userIdx'] . " AND delete_flag = 0");
		
		echo json_encode($aTest);
	}
	
	private function execSaveSchedule($aArgs)
	{
		$aData = array(
			"teacher_idx" => $aArgs['teacherIdx'],
			"date_test" => $aArgs['test_date'],
			"time_start" => $aArgs['timeStart'],
			"time_end" => $aArgs['timeEnd'],
			"status" => 1
		);
		
		$aResult = $this->db->execmodel->updateData("tb_class_level_test", $aData, "idx = " . $aArgs['idx']);
		
		if ($aResult === false) {
			$this->message("warning", "Saving failed.");
			echo false;
		} else {
			$this->message("success", "Successfully saved.");
			echo true;
		}
	}
	
	private function execDeleteSchedule($aArgs)
	{
		$aData = array(
			"teacher_idx" => null,
			"time_start" => null,
			"time_end" => null,
			"status" => 0
		);
		
		$aResult = $this->db->execmodel->updateData("tb_class_level_test", $aData, "idx = " . $aArgs['idx']);
		
		if ($aResult === false) {
			$this->message("warning", "Deleting failed.");
			echo false;
		} else {
			$this->message("success", "Successfully deleted.");
			echo true;
		}
	}
	
	private function execSaveTestResult($aArgs)
	{
		$aData = array(
			"tester_level" => $aArgs['tester_level'],
			"tester_comment" => $aArgs['tester_comment'],
			"score_listening" => $aArgs['score_listening'],
			"score_speaking" => $aArgs['score_speaking'],
			"score_pronunciation" => $aArgs['score_pronunciation'],
			"score_vocabulary" => $aArgs['score_vocabulary'],
			"score_reading" => $aArgs['score_reading'],
			"score_writing" => $aArgs['score_writing'],
			"score_grammar" => $aArgs['score_grammar'],
			"status" => 2
		);
		
		$aResult = $this->db->execmodel->updateData("tb_class_level_test", $aData, "idx = " . $aArgs['testIdx']);
		
		if ($aResult === false) {
			$this->message("warning", "Saving failed.");
			echo false;
		} else {
			$this->message("success", "Successfully saved.");
			echo true;
		}
	}
	
	private function execDeleteLevelTest($aArgs)
	{
		$aData = array(
			"delete_flag" => 1,
			"datetime_delete" => time()
		);
	
		foreach ($aArgs['idxArrayList'] as $iValue) {
			$aResult = $this->db->execmodel->updateData("tb_class_level_test", $aData, "idx = " . $iValue);
			
			if ($aResult === false) {
				echo false;
				exit;	
			}
		}

		echo true;
	}
}