<?php 
class classScheduleManage extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library("common");
		$this->model("getmodel");
		$this->importJS('class/classCalendar');
		$this->importJS('class/classScheduleManage');
		
		
		$this->classScheduleManageReady($aArgs);
	}
	
	private function classScheduleManageReady($aArgs)
	{
		$aOptions = array("where" =>	"fdepth1 = 1 AND fdepth2 = 0");
		$aOptions2 = array("where" => "fdepth1 = 2 AND fdepth2 = 0"	);
		$aOptions3 = array("where" => "branch_idx = " . $_SESSION['idx']);
		$userWhere = "idx = " . $aArgs['uid'];
		
		$aData['user'] = $this->selectRow("tb_user", null, $userWhere)->execute();	
		$aData['branch'] = $this->query("SELECT name FROM tb_user WHERE idx =" . $aData['user']['branch_idx']);
		$aData['class'] = $this->query("SELECT total_days, total_months FROM tb_product_class WHERE idx = (SELECT p_class_idx FROM tb_class WHERE idx = " . $aArgs['class'] ." AND student_idx = ".$aArgs['uid'].")");
		$aData['oClass'] = $this->query("SELECT idx, name FROM tb_product_class WHERE idx = (SELECT p_class_idx FROM tb_class WHERE idx = " . $aArgs['class'] ." AND student_idx = ".$aArgs['uid'].")");
		$aData['class_idx'] = $aArgs['class'];
		$aData['teacher'] = $this->query("SELECT * FROM tb_teacher_management WHERE branch_idx = (SELECT branch_idx FROM tb_class WHERE idx = " . $aArgs['class'] . " AND student_idx = ". $aArgs['uid'] .")");

		$aData['classMaterial'] = $this->db->getmodel->getData("tb_ulearning_category", $aOptions);
		$aData['classMaterial2'] = $this->db->getmodel->getData("tb_ulearning_category", $aOptions2);
		$this->display("class/tpl/classScheduleManage", $aData, false);
		
	}
	
}