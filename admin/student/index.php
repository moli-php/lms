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
		$sAction = Common::getParam('action');
		$sAction = $sAction != "" ? "exec" . ucwords($sAction) : "execStudent_list";
		$this->$sAction($aArgs);
		
	}

	/*for the user list*/
	public function execStudent_list($aArgs){
		
		/*pagination*/
		$aData['sSearch'] = isset($aArgs['search']) ? trim($aArgs['search']) : ''; //search
		$aData['iCurPage'] = isset($aArgs['page'])?$aArgs['page']:1;
		$aData['iRowPerPage'] = isset($aArgs['rows']) ? $aArgs['rows'] : 10; //show rows
		$iOffset = ($aData['iCurPage'] - 1) * $aData['iRowPerPage'];
		
		$sWhere = "  grade_idx = 1 AND quit_flag = 0";
		
		$aData['aTbData'] = $this->select("tb_user",null,$sWhere)->orderBy('date_reg','desc')->limit($iOffset,$aData['iRowPerPage'])->execute();
		
		$aData['iRowTotRow'] = count($this->select("tb_user",null,$sWhere)->execute());
		
		/*else display student list template*/
		$this->display("student/tpl/student_list", $aData);
		
	}
	
	/*ajax data getter*/
	public function _getDataBy($sTb, $sField,$sWhere = '',$bRow = false){
		if($bRow == false){
			$sReturn =  $this->selectRow( $sTb, $sField,$sWhere)->execute();
			return  $sReturn[$sField];
		}else{
			$sReturn =  $this->select( $sTb,$sField,$sWhere)->execute();
			return  $sReturn;
		}
	}
}

$oClass = new index();
$oClass->run($aArgs); #initialize here

