<?php 
class classScheduleManageExecute extends Simplexi_Controller
{
	public function run($aArgs)
	{
	    $this->library("common");
	    $this->model("execmodel");
	    $this->model("getmodel");

		$sAction = "exec" . ucfirst($aArgs['exec']);
		unset($aArgs['exec']);
		unset($aArgs['action']);
		$this->$sAction($aArgs);
	}
	
	private function execGetCmSecondCat($aArgs)
	{
		$aOptions = array(
			"where" => "fdepth1 = 1 AND fdepth2 = " . $aArgs['cmFirstCat']	
		);
		$result = $this->db->getmodel->getData("tb_ulearning_category", $aOptions);
		echo json_encode($result);
	}
	
	private function execGetCmUnit($aArgs)
	{
		$result = $this->query("SELECT funit_id FROM tb_ulearning_unit WHERE fcategory_id = " . $aArgs['secCat']);
		echo json_encode($result);
	}
	
	private function execGetUlSecondCat($aArgs)
	{
		$aOptions = array(
			"where" => "fdepth1 = 2 AND fdepth2 = " . $aArgs['ulFirstCat']
		);
		$result = $this->db->getmodel->getData("tb_ulearning_category", $aOptions);
		echo json_encode($result);
	}
	
	private function execGetTeachers($aArgs)
	{
		if($aArgs['type'] == "0"){
			$result = $this->query("SELECT * FROM tb_user WHERE grade_idx = 6");
		}else{
			$result = $this->query("SELECT * FROM tb_user WHERE teacher_type_idx = " . $aArgs['type']);
		}
		echo json_encode($result);
	}
	
	private function execGetTeacherName($aArgs){
		$result = $this->query("SELECT name FROM tb_user WHERE idx = " . $aArgs['teacherId']);
		echo json_encode($result);
	}
	
	private function execGetTeacherSched($aArgs)
	{
		$teacherType = (int)$aArgs['type'];
		$startDate = $aArgs['datestart'];
		$aClassdays = $aArgs['classdays'];
		$totalMonths = $aArgs['totalmonths'];
		$totalDays = $aArgs['totalDays'];
		$tempTotalDays = (int)$aArgs['totalDays'];
		
		//variables for creating calendar
		$aClass = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
		$startDate = explode("/", $startDate);
		$startmonth = (int)$startDate[0];
		$startday = (int)$startDate[1];
		$year = (int)$startDate[2];
		$iTotalMonths = $startmonth + (int)$totalMonths + 1;
		$totalDays = ($tempTotalDays * 4) * $totalMonths;
		$iDay = $startmonth;
		$dayCount = 0;
		$aSched = array();
		$aDay = array();
		$teacher_idx = array();
		
		//gets class days
		foreach($aClassdays as $val){
			$day = $aClass[$val];
			array_push($aDay, $day);
		}
		
		//get schedule for student
		for($i = $startmonth; $i < $iTotalMonths; $i++){
			if ($iDay > 12){
				$iDay = 1;
				$year++;
			}
			$iDays = cal_days_in_month(CAL_GREGORIAN, $iDay, $year);
			for ($j=$startday; $j <= $iDays; $j++) {
				$aDays[$year][$iDay][$j] = date("l", strtotime($year."-".$iDay."-".$j));
				foreach($aDay as $val){
					if($val == $aDays[$year][$iDay][$j]){
						if($dayCount < $totalDays){
							array_push($aSched, $year."-".$iDay."-".$j);
							$dayCount++;
						}
					}
					if($j == $iDays){
						$startday = 1;
					}
				}
			}
			$iDay++;
		}
		
		$temp_teacher_idx = $this->query("SELECT idx FROM tb_user WHERE teacher_type_idx = " . $teacherType);
		
		foreach($temp_teacher_idx as $val){
			foreach($aSched as $schedVal){
				$conflict[] = $this->query("SELECT tb_class_schedule.teacher_idx, 
												tb_class_schedule.daystart, 
												tb_class_level_test.date_test,
												tb_class_schedule.time_start AS sched_time_start, 
												tb_class_schedule.time_end AS sched_time_end, 
												tb_class_schedule.class_days,
												tb_class_level_test.time_start,
												tb_class_level_test.time_end
											FROM tb_class_schedule 
											LEFT OUTER JOIN tb_class_level_test 
											ON tb_class_schedule.teacher_idx =  tb_class_level_test.teacher_idx
											WHERE 
											tb_class_schedule.teacher_idx = ".$val['idx']."
											AND (tb_class_schedule.daystart = \"".$schedVal."\"
											OR tb_class_level_test.date_test = \"".$schedVal."\")");
			}
		}
		
		echo json_encode($conflict);
	}
	
	private function execGetHolidays($aArgs)
	{
		$teacherType = (int)$aArgs['type'];
		$startDate = $aArgs['datestart'];
		$aClassdays = $aArgs['classdays'];
		$totalMonths = $aArgs['totalmonths'];
		$totalDays = $aArgs['totalDays'];
		$tempTotalDays = (int)$aArgs['totalDays'];
		$check = 0;
		
		//variables for creating calendar
		$aClass = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
		$startDate = explode("/", $startDate);
		$startmonth = (int)$startDate[0];
		$startday = (int)$startDate[1];
		$year = (int)$startDate[2];
		$iTotalMonths = $startmonth + (int)$totalMonths + 1;
		$totalDays = ($tempTotalDays * 4) * $totalMonths;
		$iDay = $startmonth;
		$dayCount = 0;
		$aSched = array();
		$aDay = array();
		$aHoliday = array();
		$aConflictedHoliday = array();
		
		//gets class days
		foreach($aClassdays as $val){
			$day = $aClass[$val];
			array_push($aDay, $day);
		}
		
		//get schedule for student
		$holidays = $this->query("SELECT DISTINCT ass_holiday FROM tb_class_holiday WHERE typeHoliday = 1");
		foreach($holidays as $val){
			array_push($aHoliday, $val['ass_holiday']);
		}
		
		for($i = $startmonth; $i < $iTotalMonths; $i++){
			if ($iDay > 12){
				$iDay = 1;
				$year++;
			}
			$iDays = cal_days_in_month(CAL_GREGORIAN, $iDay, $year);
			for ($j=$startday; $j <= $iDays; $j++) {
				$aDays[$year][$iDay][$j] = date("l", strtotime($year."-".$iDay."-".$j));
				foreach($aDay as $val){
					if($val == $aDays[$year][$iDay][$j]){
						$tempSchedDate = date("Y-m-d", strtotime($year."-".$iDay."-".$j));
						if(!in_array($tempSchedDate, $aHoliday)){
							if($dayCount < $totalDays){
								array_push($aSched, $tempSchedDate);
								$dayCount++;
							}
						}else{
							array_push($aConflictedHoliday, $tempSchedDate);
						}
					}
					if($j == $iDays){
						$startday = 1;
					}
				}
			}
			$iDay++;
		}
		
		$aData['schedule'] = $aSched;
		$aData['holiday'] = $aConflictedHoliday;
		
		echo json_encode($aData);
	}
	
	private function execSaveSchedule($aArgs)
	{
		$aClass = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
		$tempTotalDays = (int)$aArgs['totalDays'];
		$totalMonths = $aArgs['totalmonths'];
		$aClassdays = $aArgs['classdays'];
		$teacherBranch = $aArgs['branch'];
		$startDate = $aArgs['datestart'];
		$teacherName = $aArgs['teacher'];
		$unitType = $aArgs['unitType'];
		$oClass = $aArgs['oClass'];
		$units = $aArgs['units'];
		$aTime = $aArgs['time'];
		$user = $aArgs['user'];
		$aDay = array();
		$aHoliday = array();
		
		$startDate = explode("/", $startDate);
		$eTime = explode("_", $aTime[0]);
		$aSched = array();
		
		$endTime = explode("_", $aTime[count($aTime) - 1]);
		$sStartTime = (int)$endTime[1];
		$sEndTime = (int)$endTime[2] + 5;
		if($sEndTime == 60){
			$sStartTime+=1;
			$sEndTime = 0;
			if($sStartTime<10){
				$sStartTime = "0" + $sStartTime;
			}else{
				$sStartTime = $endTime[1];
			}
		}
		if($sEndTime < 10){
			$sEndTime = "0" . $sEndTime;
		}
		if($sStartTime < 10){
			$sStartTime = "0" . $sStartTime;
		}
		$endTime = $sStartTime.":".$sEndTime;
		$startTime = $eTime[1] .":".$eTime[2];
		$teacher = (int)$eTime[0];
		
		$startmonth = (int)$startDate[0];
		$startday = (int)$startDate[1];
		$year = (int)$startDate[2];
		$aDays = array();
		
		$iTotalMonths = $startmonth + (int)$totalMonths + 1;
		$totalDays = ($tempTotalDays * 4) * $totalMonths;
		$iDay = $startmonth;
		$dayCount = 0;
		
		//gets class days 
		foreach($aClassdays as $val){
			$day = $aClass[$val];
			array_push($aDay, $day);
		}
		
		//get schedule for student
		$holidays = $this->query("SELECT DISTINCT ass_holiday FROM tb_class_holiday WHERE typeHoliday = 1");
		foreach($holidays as $val){
			array_push($aHoliday, $val['ass_holiday']);
		}
		
		for($i = $startmonth; $i < $iTotalMonths; $i++){
			if ($iDay > 12){
				$iDay = 1;
				$year++;
			}
			$iDays = cal_days_in_month(CAL_GREGORIAN, $iDay, $year);
			for ($j=$startday; $j <= $iDays; $j++) {
				$aDays[$year][$iDay][$j] = date("l", strtotime($year."-".$iDay."-".$j));
				foreach($aDay as $val){
					if($val == $aDays[$year][$iDay][$j]){
						$tempSchedDate = date("Y-m-d", strtotime($year."-".$iDay."-".$j));
						if(!in_array($tempSchedDate, $aHoliday)){
							if($dayCount < $totalDays){
								array_push($aSched, $tempSchedDate);
								$dayCount++;
							}
						}
					}
					if($j == $iDays){
						$startday = 1;
					}
				}
			}
			$iDay++;
		}
		
		$classdays = implode(",", $aDay);
		$sUnits = implode(",", $units);
		$sTableName = "tb_class_schedule";
		$sTableName2 = "tb_class";
		$sTableName3 = "tb_class_ext";
		$aFields2 = array("class_status" => "scheduled");
		$aFields3 = array(
				"teacher_idx" => $teacher,
				"daystart" => $aSched[0],
		);
		$sWhere = "idx = " . $oClass;
		$sWhere2 = "student_idx = "  . $user . " AND class_idx = " . $oClass;
		
 		//insert schedule depending on units
		if($unitType == "classMaterial"){
			foreach($aSched as $val){
				$aFields = array(
						"teacher_idx" => $teacher,
						"teacher_name" => $teacherName,
						"student_idx" => $user,
						"class_idx" => $oClass,
						"sched_status" => "waiting",
						"unit" => $sUnits,
						"daystart" => $val,
						"class_days" => $classdays,
						"time_start" => $startTime,
						"time_end" => $endTime,
						"teacher_branch" => $teacherBranch,
						"date_created" => date("Y-m-d")
				);
				
				$result = $this->insert($sTableName, $aFields)->execute();
				$result2 = 1;
			}
		}else{
			$cUnit  = count($units);
			$cSched = count($aSched);
			for($ctr=0;$ctr<$cUnit;$ctr++){
				$ulFields = array(
						"teacher_idx" => $teacher,
						"teacher_name" => $teacherName,
						"student_idx" => $user,
						"class_idx" => $oClass,
						"sched_status" => "waiting",
						"unit" => $units[$ctr],
						"daystart" => $aSched[$ctr],
						"class_days" => $classdays,
						"time_start" => $startTime,
						"time_end" => $endTime,
						"teacher_branch" => $teacherBranch,
						"date_created" => date("Y-m-d")
				);
				$result = $this->insert($sTableName, $ulFields)->execute();
			}
			
			for($ctr=$cUnit;$ctr<$cSched;$ctr++){
				$ulFields2 = array(
						"teacher_idx" => $teacher,
						"teacher_name" => $teacherName,
						"student_idx" => $user,
						"class_idx" => $oClass,
						"sched_status" => "waiting",
						"unit" => "",
						"daystart" => $aSched[$ctr],
						"class_days" => $classdays,
						"time_start" => $startTime,
						"time_end" => $endTime,
						"teacher_branch" => $teacherBranch,
						"date_created" => date("Y-m-d")
				);
				$result2 = $this->insert($sTableName, $ulFields2)->execute();
			}
		}
		
		//updates both tb_class and tb_class_ext
		$this->update($sTableName2, $aFields2, $sWhere)->execute();
		$this->update($sTableName3, $aFields3, $sWhere2)->execute();
		
		if($result == 1 && $result2 == 1){
			echo json_encode(1);
		}
	}
}