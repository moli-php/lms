<?php 
class classScheduleChange extends Simplexi_Controller
{
	public function run($aArgs){
		$this->library("common");
		$this->importJS('class/classScheduleChange');
		
		if(isset($aArgs['exec'])){
			$sAction = "exec" . ucfirst($aArgs['exec']);
			unset($aArgs['exec']);
			unset($aArgs['action']);
			$this->$sAction($aArgs);
		}else{
			$this->classScheduleChangeReady($aArgs);
		}
		
	}
	
	private function classScheduleChangeReady($aArgs){
		$studentClassId = $this->query("SELECT DISTINCT idx, 
												p_class_idx
										FROM tb_class
										WHERE student_idx = " . $aArgs['uid'] . "
										AND class_status != 'only_applied'");
		foreach($studentClassId as $val){
			$studentClass[] = $this->query("SELECT tb_product_class.name, 
													tb_class.idx,
													tb_class.class_status
											FROM tb_product_class
											INNER JOIN tb_class
											ON tb_product_class.idx = tb_class.p_class_idx
											WHERE tb_class.p_class_idx = ".$val['p_class_idx']."
											AND tb_class.student_idx = " . $aArgs['uid'] . "
											AND tb_class.idx = " . $val['idx']);
		}
		
		$schedule[] = $this->query("SELECT tb_class_schedule.sched_status as sched_status,
												tb_class_schedule.daystart as daystart,
												tb_class_schedule.class_days as class_days,
												tb_class_schedule.time_start as time_start,
												tb_class_schedule.time_end as time_end,
												tb_product_class.name as name
											FROM tb_class_schedule
											LEFT OUTER JOIN tb_class
											ON tb_class.idx = {$aArgs['class_id']}
											LEFT OUTER JOIN tb_product_class
											ON tb_product_class.idx = tb_class.p_class_idx
											WHERE tb_class_schedule.student_idx = {$aArgs['uid']}
											AND tb_class_schedule.class_idx = {$aArgs['class_id']}
											AND tb_class_schedule.changed_flag = 0
											AND tb_class_schedule.sched_status = 'waiting'
											ORDER BY daystart");
		
		$aData['student'] = $this->query("SELECT name, user_id
											FROM tb_user WHERE idx = " . $aArgs['uid']);
		$aData['teacher'] = $this->query("SELECT DISTINCT tb_class_schedule.teacher_idx,
											tb_user.teacher_type_idx,
											tb_teacher_management.grade_name,
											tb_teacher_management.idx
										FROM tb_class_schedule
										LEFT OUTER JOIN tb_user
										ON tb_class_schedule.teacher_idx = tb_user.idx
										LEFT OUTER JOIN tb_teacher_management
										ON tb_teacher_management.idx = tb_user.teacher_type_idx
										WHERE student_idx = {$aArgs['uid']}
										AND class_idx = {$aArgs['class_id']}");
		$oldSchedId = $this->query("SELECT changed_flag 
									FROM tb_class_schedule 
									WHERE student_idx = {$aArgs['uid']} 
									AND class_idx = {$aArgs['class_id']} 
									AND changed_flag != 0");
		$aData['old_schedule'] = $this->query("SELECT tb_class_schedule.teacher_name,
													tb_class_schedule.class_days,
													tb_class_schedule.daystart,
													tb_class_schedule.time_start,
													tb_class_schedule.time_end,
													tb_class_schedule.changed_flag,
													tb_product_class.name
												FROM tb_class_schedule
												LEFT OUTER JOIN tb_class
												ON tb_class.idx = {$aArgs['class_id']}
												LEFT OUTER JOIN tb_product_class
												ON tb_product_class.idx = tb_class.p_class_idx
												WHERE tb_class_schedule.student_idx = {$aArgs['uid']}
												AND tb_class_schedule.class_idx = {$aArgs['class_id']}
												AND tb_class_schedule.changed_flag != 0");
		foreach($oldSchedId as $val){
			$new_schedule[] = $this->query("SELECT tb_class_schedule.teacher_name,
													tb_class_schedule.class_days,
													tb_class_schedule.daystart,
													tb_class_schedule.time_start,
													tb_class_schedule.time_end,
													tb_class_schedule.changed_flag,
													tb_product_class.name
												FROM tb_class_schedule
												LEFT OUTER JOIN tb_class
												ON tb_class.idx = {$aArgs['class_id']}
												LEFT OUTER JOIN tb_product_class
												ON tb_product_classdx = tb_class.p_class_idx
												WHERE tb_class_schedul.ie.idx = {$val['changed_flag']}");
		}
		
		$aData['studentClass'] = $studentClass;
		$aData['uid'] = $aArgs['uid'];
		$aData['classId'] = $aArgs['class_id'];
		$aData['schedule'] = $schedule[0];
		if(isset($new_schedule)){
			$aData['new_schedule'] = $new_schedule;
		}
		
		$this->display("class/tpl/classScheduleChange", $aData);
	}
	
	private function execCancelSingleSchedule($aArgs){
		$date = $aArgs['date'];
		$student = $aArgs['user_id'];
		$class = $aArgs['class_id'];
		
		$result = $this->query("UPDATE tb_class_schedule
								SET sched_status = 'cancelled' 
								WHERE student_idx = {$student} 
								AND class_idx = {$class} 
								AND daystart = '{$date}'");
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
	
	private function execGetTeacherSched($aArgs)
	{
		$teacherType = (int)$aArgs['type'];
		$startDate = $aArgs['datestart'];
		$aClassdays = explode(",",$aArgs['classdays']);
	
		//variables for creating calendar
		$startDate = explode("/", $startDate);
		$startmonth = (int)$startDate[0];
		$startday = (int)$startDate[1];
		$year = (int)$startDate[2];
		$iDay = $startmonth;
		$dayCount = 0;
		$aSched = array();
		$aDay = array();
		$teacher_idx = array();
	
		//get schedule for student
		for($i = $startmonth; $i < ($startmonth + 3); $i++){
			if ($iDay > 12){
				$iDay = 1;
				$year++;
			}
			$iDays = cal_days_in_month(CAL_GREGORIAN, $iDay, $year);
			for ($j=$startday; $j <= $iDays; $j++) {
				$aDays[$year][$iDay][$j] = date("l", strtotime($year."-".$iDay."-".$j));
				foreach($aClassdays as $val){
					if($val == $aDays[$year][$iDay][$j]){
						if($dayCount < 1){
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
		$aClassdays = explode(",",$aArgs['classdays']);
		$studentId = $aArgs['userid'];
		$classId = $aArgs['classid'];
		$check = 0;
	
		//variables for creating calendar
		$startDate = explode("/", $startDate);
		$startmonth = (int)$startDate[0];
		$startday = (int)$startDate[1];
		$year = (int)$startDate[2];
		$iDay = $startmonth;
		$dayCount = 0;
		$studentSched = array();
		$aSched = array();
		$aDay = array();
		$aHoliday = array();
		$aConflictedHoliday = array();
		$aConflictSched = array();
	
		//get schedule for student
		$sSched = $this->query("SELECT daystart FROM tb_class_schedule WHERE class_idx = {$classId}");
		$holidays = $this->query("SELECT DISTINCT ass_holiday FROM tb_class_holiday WHERE typeHoliday = 1");
		foreach($sSched as $val){
			array_push($studentSched, $val['daystart']);
		}
		foreach($holidays as $val){
			array_push($aHoliday, $val['ass_holiday']);
		}
	
		for($i = $startmonth; $i < ($startmonth + 5); $i++){
			if ($iDay > 12){
				$iDay = 1;
				$year++;
			}
			$iDays = cal_days_in_month(CAL_GREGORIAN, $iDay, $year);
			for ($j=$startday; $j <= $iDays; $j++) {
				$aDays[$year][$iDay][$j] = date("l", strtotime($year."-".$iDay."-".$j));
				foreach($aClassdays as $val){
					if($val == $aDays[$year][$iDay][$j]){
						$tempSchedDate = date("Y-m-d", strtotime($year."-".$iDay."-".$j));
						if((!in_array($tempSchedDate, $aHoliday)) && (!in_array($tempSchedDate, $studentSched))){
							if($dayCount < 1){
								array_push($aSched, $tempSchedDate);
								$dayCount++;
							}
						}else if(in_array($tempSchedDate, $aHoliday)){
							array_push($aConflictedHoliday, $tempSchedDate);
						}else{
							array_push($aConflictSched, $tempSchedDate);
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
		$aData['conflict'] = $aConflictSched;
	
		echo json_encode($aData);
	}
	
	private function execSaveSchedule($aArgs)
	{
		$dateToChange = $aArgs['dateToChange'];
		$aClassdays = explode(",",$aArgs['classdays']);
		$startDate = $aArgs['datestart'];
		$oClass = $aArgs['oClass'];
		$aTime = $aArgs['time'];
		$user = $aArgs['user'];
		$aDay = array();
		$aHoliday = array();
		$studentSched = array();
	
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
	
		$iDay = $startmonth;
		$dayCount = 0;
	
		//get schedule for student
		$holidays = $this->query("SELECT DISTINCT ass_holiday FROM tb_class_holiday WHERE typeHoliday = 1");
		$sSched = $this->query("SELECT daystart FROM tb_class_schedule WHERE class_idx = {$oClass}");
		$teacherName = $this->query("SELECT name FROM tb_user WHERE idx = {$teacher}");
		
		foreach($sSched as $val){
			array_push($studentSched, $val['daystart']);
		}
		foreach($holidays as $val){
			array_push($aHoliday, $val['ass_holiday']);
		}
	
		for($i = $startmonth; $i < ($startmonth + 3); $i++){
			if ($iDay > 12){
				$iDay = 1;
				$year++;
			}
			$iDays = cal_days_in_month(CAL_GREGORIAN, $iDay, $year);
			for ($j=$startday; $j <= $iDays; $j++) {
				$aDays[$year][$iDay][$j] = date("l", strtotime($year."-".$iDay."-".$j));
				foreach($aClassdays as $val){
					if($val == $aDays[$year][$iDay][$j]){
						$tempSchedDate = date("Y-m-d", strtotime($year."-".$iDay."-".$j));
						if(!in_array($tempSchedDate, $aHoliday) && !in_array($tempSchedDate, $studentSched)){
							if($dayCount < 1){
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
		
		$schedToChange = $this->query("SELECT idx,
												teacher_idx,
												teacher_name,
												unit,
												daystart
												class_days,
												time_start,
												time_end,
												teacher_branch,
												date_created
										FROM tb_class_schedule
										WHERE student_idx = {$user} 
										AND class_idx = {$oClass} 
										AND daystart = '{$dateToChange}'");
		
		$aFields = array(
					"teacher_idx" => $schedToChange[0]['teacher_idx'],
					"teacher_name" => $schedToChange[0]['teacher_name'],
					"student_idx" => $user,
					"class_idx" => $oClass,
					"sched_status" => "postponed",
					"unit" => $schedToChange[0]['unit'],
					"daystart" => $dateToChange,
					"class_days" => $aArgs['classdays'],
					"time_start" => $schedToChange[0]['time_start'],
					"time_end" => $schedToChange[0]['time_end'],
					"teacher_branch" => $schedToChange[0]['teacher_branch'],
					"date_created" => $schedToChange[0]['date_created'],
					"changed_flag" => $schedToChange[0]['idx']
				);
		
 		$insertOldSched = $this->insert("tb_class_schedule", $aFields)->execute();
		$updateOldSched = $this->query("UPDATE tb_class_schedule
										SET 
											teacher_idx = {$teacher},
											teacher_name = '{$teacherName[0]['name']}',
											student_idx = {$user},
											class_idx = {$oClass},
											sched_status = 'waiting',
											unit = '{$schedToChange[0]['unit']}',
											daystart = '{$aSched[0]}',
											class_days = '{$aArgs['classdays']}',
											time_start = '{$startTime}',
											time_end = '{$endTime}',
											teacher_branch = {$schedToChange[0]['teacher_branch']},
											date_created = '" .date("Y-m-d") . "'
										WHERE student_idx = {$user} 
										AND class_idx = {$oClass} 
										AND daystart = '{$dateToChange}'
										AND changed_flag = 0");
		
		if($insertOldSched == 1 && $updateOldSched == 1){
			echo json_encode(1);
		}
	}
}