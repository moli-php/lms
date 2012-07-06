<?php
class classHoliday extends Simplexi_Controller
{
	public function run($aArgs)
	{
	    $this->library("common");
	    $this->model("execmodel");
	    $this->model("getmodel");

	    if (isset($aArgs['exec'])) {
			$sAction = "exec" . ucfirst($aArgs['exec']);
			$this->$sAction($aArgs);
		} else{
			$this->instializeData($aArgs);
		}
	}
	
	public function instializeData($aArgs)
	{
		$this->importCss('class/class');
		$this->importJS('class/classHoliday');
	    $this->display("class/tpl/classHoliday");
	}
	
	private function execGetHolidays($aArgs)
	{
		$month = $aArgs['month'];
		$result = array();
		for($i = 1; $i <= $aArgs['day']; $i++){
			
				$aOptions = array(
					"where" => "ass_holiday = '" . $aArgs['year']."-". $month."-".$i."'"
				);
				$result[] = $this->db->getmodel->getData("tb_class_holiday", $aOptions, "row");
		}
		echo json_encode($result);
	}
	
	private function execInsertHoliday($aArgs)
	{
		// view date =date("Y-m-d H:i:s", $val['date_reg'])
		
		$aData = array("user_id"=>$_SESSION['user_id'],"ass_holiday"=>$aArgs['dateAssign'],"reason"=>$aArgs['reason'],"typeHoliday"=>$aArgs['typeHoliday'],"date_assigned"=>time());
		
		$result = $this->db->execmodel->insertData("tb_class_holiday", $aData);
		
		echo json_encode("Successfully Added");
	}
	private function execModifyHoliday($aArgs)
	{
	// view date =date("Y-m-d H:i:s", $val['date_reg'])
		$aOptions = array("where" =>"idx = ".$aArgs['idx']);
		$aData = array("reason"=>$aArgs['reason'],"typeHoliday"=>$aArgs['typeHoliday'],"date_assigned"=>time());
		
		$result = $this->db->execmodel->updateData("tb_class_holiday", $aData,"idx = ".$aArgs['idx']);
		
		echo json_encode("Successfully Change");
	}
	
}