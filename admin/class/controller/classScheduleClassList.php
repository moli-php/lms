<?php
class classScheduleClassList extends Simplexi_Controller
{
	public function run($aArgs){
		$this->library("common");
		$this->importJS('class/classScheduleClassList');
		
		if(isset($aArgs['exec'])){
			$sAction = "exec" . ucfirst($aArgs['exec']);
			unset($aArgs['exec']);
			unset($aArgs['action']);
			$this->$sAction($aArgs);
		}else{
			$this->classScheduleClassListReady($aArgs);
		}
	}
	
	private function classScheduleClassListReady($aArgs){
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
		$schedule[] = $this->query("SELECT daystart, 
											teacher_name, 
											teacher_idx, 
											sched_status
									FROM tb_class_schedule
									WHERE class_idx = " . $aArgs['class_id'] . "
									AND changed_flag = 0");
		
		$aData['classTime'] = $this->query("SELECT DISTINCT time_start, 
													time_end, 
													class_days
											FROM tb_class_schedule
											WHERE student_idx = " . $aArgs['uid'] . "
											AND class_idx = " . $aArgs['class_id'] . "
											AND changed_flag = 0");
		
		
		$aData['student'] = $this->query("SELECT name, user_id 
											FROM tb_user WHERE idx = " . $aArgs['uid']);
		$aData['studentClass'] = $studentClass;
		$aData['uid'] = $aArgs['uid'];
		$aData['classId'] = $aArgs['class_id'];
		$aData['schedule'] = $schedule[0];
		
		$this->display('class/tpl/classScheduleClassList', $aData);
	}
	
	private function execEditSingleScheduleStatus($aArgs){
		$uid = $aArgs['student'];
		$class = $aArgs['classId'];
		$date = $aArgs['date'];
		
		$result = $this->query("SELECT 
									teacher_idx,
									teacher_name, 
									daystart, 
									time_start, 
									time_end, 
									sched_status
								FROM tb_class_schedule
								WHERE student_idx = {$uid}
								AND class_idx = {$class}
								AND daystart = '{$date}' 
								AND changed_flag = 0");
		echo json_encode($result);
	}
	
	private function execUpdateSingleSchedule($aArgs){
		$classId = $aArgs['classId'];
		$date = $aArgs['date'];
		$teacher = $aArgs['teacher'];
		$aDay = array();
		$aSched = array();
	
		if($_POST['scheduleStatus'] == "postponed"){
			$startdate = $this->query("SELECT MAX(daystart) as daystart, class_days, teacher_name, student_idx, class_idx, unit, time_start, time_end, teacher_branch
										FROM tb_class_schedule
										WHERE class_idx = " . $classId . "
										AND changed_flag = 0");
			$totalSchedule = $this->query("");
	
			$aDays = explode(",", $startdate[0]['class_days']);
			foreach($aDays as $val){
				array_push($aDay, $val);
			}
	
			$startDate = explode("-",$startdate[0]['daystart']);
			$iDay = $startmonth = $startDate[1];
			$startday = (int)$startDate[2] + 1;
			$year = (int)$startDate[0];
			$iTotalMonths = (int)$startmonth + 1;
			$dayCount = 0;
	
			for($i = $startmonth; $i <= $iTotalMonths; $i++){
				if ($iDay > 12){
					$iDay = 1;
					$year++;
				}
				$iDays = cal_days_in_month(CAL_GREGORIAN, $iDay, $year);
				for ($j=$startday; $j <= $iDays; $j++) {
					$j = ($j < 10)?"0".$j:$j;
					$aDays[$year][$iDay][$j] = date("l", strtotime($year."-".$iDay."-".$j));
					foreach($aDay as $val){
						if($val == $aDays[$year][$iDay][$j]){
	
							$holidayConflict = $this->query("SELECT ass_holiday
															FROM tb_class_holiday
															WHERE ass_holiday = '". $year."-".$iDay."-".$j ."'");
	
							if(!isset($holidayConflict[0])){
	
								$conflict = $this->query("SELECT tb_class_schedule.teacher_idx,
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
										WHERE tb_class_schedule.teacher_idx = ".$teacher."
										AND (tb_class_schedule.daystart = \"".$year."-".$iDay."-".$j."\"
										OR tb_class_level_test.date_test = \"".$year."-".$iDay."-".$j."\")
										AND (tb_class_schedule.time_start = '".$startdate[0]['time_start']."' AND tb_class_schedule.time_end = '".$startdate[0]['time_end']."')
										OR (tb_class_level_test.time_start = '".$startdate[0]['time_start']."' AND tb_class_level_test.time_end = '".$startdate[0]['time_end']."') 
										AND tb_class_schedule.change_flag = 0");
	
								if(!$conflict){
									if($dayCount < 1){
										array_push($aSched, $year."-".$iDay."-".$j);
										$dayCount++;
									}
								}
							}
						}
						if($j == $iDays){
							$startday = 1;
						}
					}
				}
				$iDay++;
				$iDay = ($iDay < 10)?"0".$iDay:$iDay;
			}
	
	
			$aFields = array(
					"teacher_idx" => $teacher,
					"teacher_name" => $startdate[0]['teacher_name'],
					"student_idx" => $startdate[0]['student_idx'],
					"class_idx" => $classId,
					"sched_status" => "waiting",
					"unit" => $startdate[0]['unit'],
					"daystart" => $aSched[0],
					"class_days" => $startdate[0]['class_days'],
					"time_start" => $startdate[0]['time_start'],
					"time_end" => $startdate[0]['time_end'],
					"teacher_branch" => $startdate[0]['teacher_branch'],
					"date_created" => date("Y-m-d")
			);
			$inserted  = $this->insert("tb_class_schedule", $aFields)->execute();
		}else{
			$inserted = 1;
		}
	
		//upload file
		if(isset($_FILES['scheduleFile']['name'])){
			$ext = explode(".", $_FILES['scheduleFile']['name']);
			$target_filepath = SERVER_DOCUMENT_ROOT. "/uploads/schedule/" . $classId ."_".$date."_". $_FILES['scheduleFile']['name'];
			$path = "schedule/" . $classId ."_".$date."_".$_FILES['scheduleFile']['name'];
	
			move_uploaded_file($_FILES['scheduleFile']['tmp_name'], $target_filepath);
	
			$result = $this->query("UPDATE tb_class_schedule
									SET
									sched_status = '" . $_POST['scheduleStatus'] . "',
									file = '".$path."',
									comment = '".$_POST['scheduleComment']."'
									WHERE class_idx = " . $classId . "
									AND daystart = '". $date ."'");
		}else{
			$result = $this->query("UPDATE tb_class_schedule
									SET
									sched_status = '" . $_POST['scheduleStatus'] . "',
									comment = '".$_POST['scheduleComment']."'
									WHERE class_idx = " . $classId . "
									AND daystart = '". $date ."'");
		}
	
		if($result == 1 && $inserted == 1){
			echo json_encode(1);
		}
	
	}
}