<?php
include('../../__library/controller.php');
class index extends Simplexi_Controller
{
	/*add $aArgs parameter / change init to run*/
	public function run($aArgs){
	
		/*include common library*/
		$this->library("common");
		
		/*check if session start*/
		$this->library("checkLogin");
	
		/*for the exec functions*/
		$this->library("tinymce");
		Tinymce::init();
		$sAction = Common::getParam('action');
		$sAction = $sAction != "" ? "exec" . ucwords($sAction) : "execSchedule";
		$this->$sAction($aArgs);
		
	}

	/*for the user list*/
	public function execSchedule($aArgs){
		$this->importCss('schedule_management/schedule');
		$this->importJS('schedule_management/schedule');
		$this->importJS('message/message');
		

		$aData['test'] = "test";
		/*else display user list template*/
		$this->display("schedule/tpl/schedule", $aData);
		
	}
	/*for the user list*/
	public function execSelectSchedule($aArgs){
	
		$aParam = Common::getParams();
		
		//$aData = $this->select( 'tb_class_schedule',null," daystart = '".$aParam['dateAssign']."'")->execute(); 
		$aData = $this->query( "SELECT tb_class_schedule.*,tb_class.p_class_idx,tb_product_class.type,tb_user.phone_mob,tb_user.name,tb_user.email,tb_user.ssn, FLOOR(DATEDIFF('".$aParam['dateAssign']."',CONCAT(CASE WHEN LEFT(ssn,2)>'12' 
		THEN '19' ELSE '20' END ,LEFT(ssn,2),'-',SUBSTRING(ssn,3,2),'-',SUBSTRING(ssn,5,2)))/366)
		AS age
		FROM tb_class_schedule
		RIGHT JOIN tb_class ON tb_class_schedule.class_idx = tb_class.idx
		RIGHT JOIN tb_product_class ON tb_class.p_class_idx = tb_product_class.idx
		RIGHT JOIN tb_user ON tb_class_schedule.student_idx = tb_user.idx
		WHERE  daystart = '".$aParam['dateAssign']."' ORDER BY time_start ASC"); 
		
		
		//$aDatas['dateAssign'] = isset($aData) == true ? $aData : 0;
		
		echo json_encode($aData);
		
	}
		/*for the all user list*/
	public function execSelectAll($aArgs){
	
		$aParam = Common::getParams();
		
		//$aData = $this->select( 'tb_class_schedule',null," daystart = '".$aParam['dateAssign']."'")->execute(); 
		
		$aData = $this->query( "SELECT tb_class_schedule.*,tb_class.p_class_idx,tb_product_class.type,tb_user.phone_mob,tb_user.name,tb_user.branch_idx,tb_user.email,tb_user.ssn, FLOOR(DATEDIFF('".$aParam['dateAssign']."',CONCAT(CASE WHEN LEFT(ssn,2)>'12' 
		THEN '19' ELSE '20' END ,LEFT(ssn,2),'-',SUBSTRING(ssn,3,2),'-',SUBSTRING(ssn,5,2)))/366)
		AS age
		FROM tb_class_schedule
		RIGHT JOIN tb_class ON tb_class_schedule.class_idx = tb_class.idx
		RIGHT JOIN tb_product_class ON tb_class.p_class_idx = tb_product_class.idx
		RIGHT JOIN tb_user ON tb_class_schedule.student_idx = tb_user.idx
		WHERE tb_class_schedule.student_idx = '".$aParam['stdId']."' ORDER BY tb_class_schedule.daystart ASC"); 
		
		echo json_encode($aData);
		
	}
	public function execSelectBranch($aArgs){
	
		$aParam = Common::getParams();
		
		$aData = $this->query("SELECT ftitle AS depth2,t2.fcategory_name AS dept1,t3.fcategory_name AS maindept
		FROM tb_ulearning_unit AS t1
		INNER JOIN tb_ulearning_category t2 ON t1.fcategory_id = t2.fcategory_id
		INNER JOIN tb_ulearning_category t3 ON t2.fdepth2 = t3.fcategory_id
		WHERE t1.funit_id = '".$aParam['unitsId']."'  ORDER BY t1.funit_id ASC"); 
		
		echo json_encode($aData);
		
	}
	public function execUpdateSchedule($aArgs){
	
		$aParam = Common::getParams();
		
		$aCount = $this->query("SELECT count(*) as count from tb_class_schedule_teacher where class_schedule_idx = '".$aParam['classIdx']."'");
		
		if($aCount[0]['count'] != 0){
		
			  $aData = array(
				"teacher_idx" =>USER_ID,
				"student_idx" =>$aArgs['studIdx'],
				"listening" => $aArgs['listening'],
				"speaking" => $aArgs['speaking'],
				"pronounciation" => $aArgs['pronounciation'],
				"vocabulary" => $aArgs['vocabulary'],
				"grammar" => $aArgs['grammar'],
				"comment" => $aArgs['comment'],
				"date_update" => time()
			  );
			  $aSchedStat = array('sched_status' => $aParam['attendance']);
			  $sUpdateClass = $this->update("tb_class_schedule", $aSchedStat,"idx=".$aParam['classIdx'])->execute();
			  $sUpdateClass = $this->update("tb_class_schedule_teacher", $aData,"class_schedule_idx=".$aParam['classIdx'])->execute();
			  $aData = 'Successfully Change';
		
		}else{
			$aData = array(
			"class_schedule_idx" => $aArgs['classIdx'],
			"teacher_idx" =>USER_ID,
			"student_idx" =>$aArgs['studIdx'],
			"listening" => $aArgs['listening'],
			"speaking" => $aArgs['speaking'],
			"pronounciation" => $aArgs['pronounciation'],
			"vocabulary" => $aArgs['vocabulary'],
			"grammar" => $aArgs['grammar'],
			"comment" => $aArgs['comment'],
			"date_update" => time()
			);
			$aSchedStat = array( 'sched_status' => $aParam['attendance']);
			$sUpdateClass = $this->update("tb_class_schedule", $aSchedStat,"idx=".$aParam['classIdx'])->execute();
			
			$aResult = $this->insert("tb_class_schedule_teacher",$aData)->execute();

			if ($aResult === false) {
				$aData = "Saving failed.";
			} else {
				$aData = "Successfully saved.";
			}
			
		
		}
		echo json_encode($aData);
		
	}
	public function execSelectLevels($aArgs){
	
		$aParam = Common::getParams();
		
		$aData = $this->query("SELECT * from tb_class_schedule_teacher
		WHERE  class_schedule_idx = '".$aParam['classIdx']."'"); 
		
		echo json_encode($aData);
		
	}

	
}

$oClass = new index();
$oClass->run($aArgs); #initialize here

