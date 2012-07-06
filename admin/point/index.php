<?php
include('../../__library/controller.php');
class Point extends Simplexi_Controller
{
    public function run($aArgs) #add $aArgs parameter / change init to run
    {
        /*include common library*/
        $this->library('common');
        $this->library('checkLogin');
        $this->importJS('point/jquery.ui.datepicker');
        $this->importJS('point/point');

        $sAction = Common::getParam('action');
        $sAction = $sAction != "" ? "exec" . ucwords($sAction) : "execPoint_history";
        $this->$sAction($aArgs);

    }
/*g*/
    public function execPoint_history($aArgs)
    {
        /*pagination*/
        $aData['iCurPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
        $aData['sSearch'] = isset($aArgs['userid']) ? $aArgs['userid'] : null;
        $aData['sStartDate'] = isset($aArgs['sDate']) ? $aArgs['sDate'] : null;
        $aData['sEndDate'] = isset($aArgs['eDate']) ? $aArgs['eDate'] : null;
        
        $sDate = strtotime($aData['sStartDate']);
        $eDate = strtotime($aData['sEndDate']);           
        $aData['iRowPerPage'] = isset($aArgs['rows']) ? $aArgs['rows'] : 20;
        $aData['iOffset'] = ($aData['iCurPage'] - 1) * $aData['iRowPerPage'];
        
        $aDeletedUser = $this->select("tb_user","quit_flag,user_id","quit_flag=1")->execute();
        
        foreach($aDeletedUser as $index){
            $aUpdateField = array('isDeleted' => 'yes');
            $aUpdate = $this->query("UPDATE tb_points SET isDeleted = 'yes' WHERE user_id LIKE '%".$index['user_id']."%'");
        }
                
        $where1 = ($_SESSION['grade_idx'] == 8) ? "branch_idx = '".$_SESSION['idx']."' AND " : null;
        $sWhere = ($aData['sSearch']) ? "user_id LIKE '%{$aData['sSearch']}%' AND isDeleted = 'no' AND date_registered BETWEEN '".$sDate."' AND '".$eDate."'" : "{$where1} isDeleted = 'no'";
        $aData['iRowTotRow'] = count($this->query("SELECT DISTINCT * FROM tb_points WHERE {$sWhere} "));      
 
        /*sub page*/
        $sSubPage = isset($aArgs['sub']) ? $aArgs['sub'] : null;

        if($sSubPage != null){
            $this->writeJS('$(function(){ $(".menu_curpage_breadcrumb").append("&nbsp;&gt;&nbsp;Give Points");});');
            $this->writeJS('$(function(){ $(".menu_title_breadcrumb").html("Give Points");});');
                
            $aData['reason'] = isset($aArgs['reason']) ? $aArgs['reason'] : null;
            $aData['user'] = isset($aArgs['user']) ? $aArgs['user'] : "";
            $aData['sQuery'] = $this->query("SELECT * FROM tb_points_reason WHERE isActive='yes'");// AND branch_idx = ".$_SESSION['idx']);
            $this->display("point/tpl/".$sSubPage, $aData);
        }
        else {
            $aData['query'] = $this->select("tb_points",null,$sWhere)->limit($aData['iOffset'],$aData['iRowPerPage'])->execute();
            $aData['paginate'] = Common::paginate($aData['iCurPage'], $aData['iRowPerPage'], $aData['iRowTotRow']);
            
            $this->display("point/tpl/point_history", $aData);
        }
        
    }

    public function execVerifyUserId($aArgs)
    {
        
        $sWhere = ($_SESSION['grade_idx'] == 8) ? "branch_idx = ".$_SESSION['idx']." AND (name = '".strtolower($aArgs['get_user_id'])."' OR user_id='".strtolower($aArgs['get_user_id'])."') AND quit_flag = 0" : "(name = '".strtolower($aArgs['get_user_id'])."' OR user_id='".strtolower($aArgs['get_user_id'])."') AND quit_flag = 0";
        
        $aResult = $this->select("tb_user",null,$sWhere)->execute();
        if(count($aResult) > 0){
            echo json_encode(stripslashes(ucwords(strtolower($aResult[0]['name']))));
        } else {
            echo json_encode(null);
        }
          
    }
    
    public function execSavePoints()
    {
        $aParam = Common::getParams();
        $user_id = ($aParam['userid']) ? $aParam['userid'] : $aParam['id'];
        $aFieldName = array('user_id' => $user_id, 'isDeleted' => 'no', 'amount_points' => $aParam['amount'] ,'reason' => $aParam['reason'], 'branch_idx' => $_SESSION['idx'], 'date_registered' => time());
        /*query database*/
        $select = $this->query("SELECT * FROM tb_points WHERE user_id = '{$user_id}' AND reason = '{$aParam['reason']}'");
          
        if(count($select) > 0){
            
            $sum = $select[0]['amount_points'] + $aParam['amount'];
            $fields = array('amount_points' => $sum ,'reason' => $aParam['reason'],'isDeleted' => 'no');
            $sUpdate = $this->update("tb_points",$fields,"user_id = '".$select[0]['user_id']."' AND reason ='".$aParam['reason']."'")->execute();
            if($sUpdate > 0){
                echo "success";
            }
            else{
                echo "warning";
            }

        }else{
            $sInsert = $this->insert("tb_points",$aFieldName)->execute();
            if($sInsert > 0){
                echo "success";
            }
            else{
                echo "warning";
            }
        }
        

        
    }
        
    public function execPoint_configuration($aArgs)
    {
        $aData['sQuery'] = $this->query("SELECT * FROM tb_points_reason");
        $this->display("point/tpl/point_configuration", $aData);
    }

    public function execDeleteThis($aArgs)
    {

        $aIdx = implode(',', $aArgs['idx']);
        //$sQuery = "DELETE FROM tb_teacher_management WHERE idx IN($aIdx)";
        
        /*query database*/
        $mResult = $this->query("UPDATE tb_points SET isDeleted = 'yes' WHERE idx IN ($aIdx)");

        if($mResult > 0){
            echo "success";
        }
        else{
            echo "warning";
        }
        
    }
    
    public function execManage($aArgs)
    {
       $aFieldName = array('amount' => $aArgs['amount'], 'isActive' => $aArgs['isActive'], 'branch_idx' => $_SESSION['idx']);
        
        /*query database*/
        $sUpdate = $this->update("tb_points_reason",$aFieldName,"idx='".$aArgs['idx']."'")->execute();
        if($sUpdate > 0){
            echo "success";
            
        }
        else{
            echo "warning".$aArgs['amount'];
        }
    }
	
}

$oClass = new Point();
$oClass->run($aArgs); #initialize here