<?php
class classListExecute extends Simplexi_Controller
{
    private $aShedule = Array();

	public function run($aArgs)
	{
	    $this->library("common");
		$sAction = "exec" . ucfirst($aArgs['exec']);
		unset($aArgs['exec']);
		unset($aArgs['action']);
		$this->$sAction($aArgs);
	}

	private function execFindUserId($aArgs)
    {
	    $sWhere = "quit_flag=0 AND grade_idx=1 AND user_id='".strtolower($aArgs['user_id'])."'";
	    $sWhere .= ($_SESSION['grade_idx'] == 8) ? ' AND branch_idx = '.$_SESSION['idx'] : '';
	    $aResult = $this->select("tb_user",null,$sWhere)->execute();

	    if($aArgs['check'] == '1'){
	        if(count($aResult)!=0){
	            $aSchedCheck = $this->select("tb_class_schedule","idx","student_idx=".$aResult[0]['idx']." AND sched_status = 'waiting'")->execute();
                if(count($aSchedCheck) >=1){
    	            $aResultClass[0]['name'] = stripslashes(ucwords(strtolower($aResult[0]['name'])));
    	            $aResultUser = $this->select("tb_class",null,"class_status='scheduled' AND student_idx = ".$aResult[0]['idx'])->execute();

    	            foreach($aResultUser as $k=>$vClass){
    	                $aResultRunClass = $this->select("tb_product_class",null,"delete_flag=0 AND idx=".$vClass['p_class_idx'])->execute();
    	                if(!empty($aResultRunClass)){
    	                    $aResultClass[$k]['class_name'] = $aResultRunClass[0]['name'];
    	                    $aResultClass[$k]['class_id'] = $vClass['idx'];
    	                }
    	            }
    	            if(!empty($aResultRunClass)){
    	                echo json_encode($aResultClass);
    	            } else {
    	                echo json_encode("deleted_class");
    	            }

    	        } else if(count($aSchedCheck)<1){
    	            echo json_encode("no_sched");
    	        }
	        } else {
	            echo json_encode("not_student");
	        }
	    } else if(count($aResult)!=0 && $aArgs['check'] == '0'){
	        echo json_encode(stripslashes(ucwords(strtolower($aResult[0]['name']))));
	    }
	}

	private function execGetMonths($aArgs)
	{
	    $aResultClass = $this->select("tb_class",null,"idx=".$aArgs['class_id'])->execute();
	    $aResultProd = $this->select("tb_product_class",null,"idx=".$aResultClass[0]['p_class_idx'])->execute();
	    return $aResultProd;
	}

	private function execGetRemaining($aArgs)
	{
        $aResultSched = $this->select("tb_class_schedule",null,"class_idx=".$aArgs['class_id']." AND sched_status = 'waiting'")->execute();
	    echo json_encode(count($aResultSched));
	}

	private function execGetWatingClasses($aArgs)
	{
	    $aResultWait = $this->select("tb_class_schedule",null,"class_idx=".$aArgs['class_id']." AND sched_status = 'waiting'")->execute();
	    $sMonth = $this->execGetMonths($aArgs);
	    $aResultWait[0]['total_months'] = $sMonth[0]['total_months'];
	    echo json_encode($aResultWait);
	}

	private function execSaveLongterm($aArgs)
	{
	    /*Get ID of the user*/
	    $sStudName = $this->select('tb_user', null, 'user_id="'.$aArgs['username'].'"')->limit(0,1)->execute();
	    $sWhere = "class_idx = ".$aArgs['class_id']." AND student_idx = ".$sStudName[0]['idx']." AND sched_status = 'waiting'";
	    /*Get Idx*/
	    $aGetIdx = $this->select('tb_class_schedule', 'idx', $sWhere)->execute();
	    foreach($aGetIdx as $kId=>$vId){
	        $aIdx[] = $vId['idx'];
	    }
        $aSchedule = $_SESSION['sched'];

	    /*Update Long term*/
        for($i = 0; $i < count($aIdx); $i++){
	        $strUpdate = "UPDATE tb_class_schedule SET longterm_flag = 1, daystart = '".$aSchedule[$i]."' WHERE ".$sWhere." AND idx =".$aIdx[$i];
	        $sUpdateWait = $this->query($strUpdate);
        }
        echo json_encode(count($sUpdateWait));
	}

	private function execSavePoint($aArgs)
	{
	    $sStudName = $this->select('tb_user', null, 'user_id="'.$aArgs['username'].'"')->limit(0,1)->execute();
	    $sCheckReason = $this->select("tb_points_reason",null,"reason='Long Term Postponed Class' AND branch_idx=".$sStudName[0]['branch_idx'])->execute();
        /*Insert Points Reason*/
        if(count($sCheckReason)<1){
    	    $aPtReason[] = array(
    	            'reason' => 'Long Term Postponed Class',
    	            'amount' => $aArgs['point'],
    	            'isActive' => 'no',
    	            'branch_idx' => $sStudName[0]['branch_idx']
    	    );
    	    $sInsertReason = $this->insert("tb_points_reason", $aPtReason)->execute();
        }
        $sWherePts = "reason='Long Term Postponed Class' AND branch_idx=".$sStudName[0]['branch_idx']." AND user_id='".$sStudName[0]['user_id']."'";
        $sCheckPts = $this->select("tb_points",null,$sWherePts)->execute();
        if(count($sCheckPts)>0){
            $iSumpts = $aArgs['point'] + $sCheckPts[0]['amount_points'];
            /*Update Point*/
            $sInsertPts = $this->query("UPDATE tb_points SET isDeleted = 'no', amount_points = ".$iSumpts." WHERE ".$sWherePts);
        } else {
            /*Insert Point*/
            $aPts[] = array(
                    'user_id' => $sStudName[0]['user_id'],
                    'amount_points' => $aArgs['point'],
                    'reason' => 'Long Term Postponed Class',
                    'status' => 'get',
                    'branch_idx' => $sStudName[0]['branch_idx'],
                    'date_registered' => time(),
                    'isDeleted' => 'no'
            );
            $sInsertPts = $this->insert("tb_points", $aPts)->execute();
        }
        /*Change waiting to cancelled in class sched table*/
        $sUpdateSched = $this->query("UPDATE tb_class_schedule SET sched_status = 'cancelled' WHERE sched_status='waiting' AND student_idx='".$sStudName[0]['idx']."' AND class_idx='".$aArgs['class_id']."'");
        /*Change scheduled to finshed in tb_class*/
        $sUpdateClass = $this->query("UPDATE tb_class SET class_status = 'finished' WHERE student_idx='".$sStudName[0]['idx']."' AND idx='".$aArgs['class_id']."'");

	    echo json_encode($sUpdateClass);
	}

	private function execShowClass($aArgs)
	{
	    $sWhere = "teacher_type=".$aArgs['country']." AND type='".$aArgs['type']."'";
	    if(isset($aArgs['total_months'])!=""){
	        $sWhere.=" AND total_months=".$aArgs['total_months'];
	    }
	    $sCheckAdmin = $this->select("tb_user",null,'quit_flag=0 AND user_id="'.$aArgs['user_id'].'"')->execute();
	    $sAdWhere = ($_SESSION['grade_idx'] == 9 && $aArgs['user_id']!="") ?' AND branch_idx = '.$sCheckAdmin[0]['branch_idx'] : '';
        $sWhere .= ($_SESSION['grade_idx'] == 8) ? ' AND branch_idx = '.$_SESSION['idx'] : $sAdWhere;

	    $aResult = $this->select("tb_product_class",null,$sWhere.' AND delete_flag=0')->orderBy('total_months','ASC')->execute();
	    echo json_encode($aResult);
	}

	private function execShowCourses($aArgs)
	{
	    $aResult = $this->select($aArgs['table'],null)->orderBy('name','ASC')->execute();
	    echo json_encode($aResult);
	}

	private function execFindID($aArgs)
	{
	    $sWhere = "quit_flag=0 AND idx=".$aArgs['idx'];
	    $sWhere .= ($_SESSION['grade_idx'] == 8) ? ' AND branch_idx = '.$_SESSION['idx'] : '';
	    $aResult = $this->select("tb_user",null,$sWhere)->execute();
	    if($aResult){
	        echo json_encode($aResult[0]['user_id']);
	    } else {
	        echo json_encode(null);
	    }
	}

	private function execAddClass($aArgs)
	{
    	if($aArgs['p_class_idx']!=0){
    	    $sStudName = $this->select('tb_user', null, 'user_id="'.$aArgs['student_idx'].'"')->limit(0,1)->execute();
            $aFieldClass[] = array(
                    'p_class_idx' => $aArgs['p_class_idx'],
                    'class_status' => 'only_applied',
                    'branch_idx' => $sStudName[0]['branch_idx'],
                    'datetime_created' => time(),
                    'datetime_deleted' => "",
                    'student_idx' => $sStudName[0]['idx']
            );
            $this->insert("tb_class", $aFieldClass)->execute();
            $aResult = $this->query("SELECT max(idx) AS latest FROM tb_class");
            $iMaxId = $aResult[0]['latest'];

            $aFieldSales[] = array(
                'branch_idx' => $sStudName[0]['branch_idx'],
                'product_idx' => $aArgs['p_class_idx'],
                'class_idx' => $iMaxId,
                'datetime_purchase' => time(),
                'amount' => 0,
                'user_idx' => $sStudName[0]['idx'],
                'payment_method' => $aArgs['payment_method'],
                'sale_status' => $aArgs['sale_status']
            );

            $aFieldSched[] = array(
                'student_idx' => $sStudName[0]['idx'],
                'class_idx' => $iMaxId
            );

    	    $this->insert("tb_class_ext", $aFieldSched)->execute();
    	    $sInsert = $this->insert("tb_sales_product", $aFieldSales)->execute();
	    } else {
	        $sInsert = null;
	    }
	    echo json_encode($sInsert);
	}

    private function execUpdateClass($aArgs)
	{
        $aFieldSched = array(
                'payment_method' => $aArgs['payment_method'],
                'sale_status' => $aArgs['sale_status']
        );

        $sUpdateSched = $this->update("tb_sales_product", $aFieldSched,"class_idx=".$aArgs['cid'])->execute();
        echo json_encode($sUpdateSched);
	}

	private function execDeleteClass($aArgs)
	{
	    $aFieldClass = array(
	            'class_status' => 'deleted',
	            'datetime_deleted' => time()
	    );
	    $sUpdate = $this->update("tb_class", $aFieldClass,"idx IN(".$aArgs['idx'].")")->execute();
	    echo json_encode($sUpdate);
	}

	private function execGetDates($aArgs)
	{
	    $startDate = $aArgs['datestart'];
	    $aClassdays = $aArgs['classdays'];
	    $totalMonths = $aArgs['totalMonth'];
	    $totalDays = $aArgs['totalDays'];
	    $tempTotalDays = (int)$aArgs['totalDays'];

	    //variables for creating calendar
	    $startDate = explode("-", $startDate);
	    $startmonth = (int)$startDate[1];
	    $startday = (int)$startDate[2];
	    $year = (int)$startDate[0];
	    $iTotalMonths = $startmonth + (int)$totalMonths + 1;
	    $iDay = $startmonth;
	    $dayCount = 0;
	    $aSched = array();
	    $aDay = array();
	    $aHoliday = array();
	    $aConflictedHoliday = array();
	    $aClasses = array();

	    //gets class days
	    $aClassdays = explode(",",$aClassdays);
	    $aDay = $aClassdays;

	    foreach($aDay as $val){
	        if($val == "Sunday") $iVal = '0';
	        else if($val == "Monday") $iVal = '1';
	        else if($val == "Tuesday") $iVal = '2';
	        else if($val == "Wednesday") $iVal = '3';
	        else if($val == "Thursday") $iVal = '4';
	        else if($val == "Friday") $iVal = '5';
	        else if($val == "Saturday") $iVal = '6';
	        array_push($aClasses, $iVal);
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

        foreach($aSched as $schedVal){
            $aConflict[] = $this->query("SELECT
                    tb_class_schedule.daystart AS daystart
                    FROM tb_class_schedule
                    LEFT OUTER JOIN tb_class_level_test
                    ON tb_class_schedule.teacher_idx =  tb_class_level_test.teacher_idx
                    WHERE
                    tb_class_schedule.class_idx != ".$aArgs['class_id']." AND
                    tb_class_schedule.teacher_idx = ".$aArgs['teacherId']."
                    AND (tb_class_schedule.daystart = \"".$schedVal."\"
                    OR tb_class_level_test.date_test = \"".$schedVal."\")
                    AND ((tb_class_schedule.time_start >= '".$aArgs['start_time']."' AND tb_class_schedule.time_end <= '".$aArgs['end_time']."')
                    OR (tb_class_level_test.time_start >= '".$aArgs['start_time']."' AND tb_class_level_test.time_end <= '".$aArgs['end_time']."'))
                    ");
        }

        $_SESSION['sched'] = $aSched;
        $aData['conflict'] = $aConflict;
	    $aData['schedule'] = $aSched;
	    $aData['holiday'] = $aConflictedHoliday;
	    $aData['class_days'] = $aClasses;

	    echo json_encode($aData);
	}
}