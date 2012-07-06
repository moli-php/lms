<?php
include('../../__library/controller.php');
class teacher extends Simplexi_Controller
{
    public function run($aArgs) #add $aArgs parameter / change init to run
    {
        /*include common library*/
        $this->library('common');
        $this->library('checkLogin');
        $this->importJS('teacher/jquery.ui.datepicker');
        $this->importJS('teacher/teacher');

        $sAction = Common::getParam('action');
        $sAction = $sAction != "" ? "exec" . ucwords($sAction) : "execTeacher_list";
        $this->$sAction($aArgs);

    }
/*f*/

    public function execTeacher_list($aArgs)
    {

        $aData['sSearch'] = isset($aArgs['search']) ? $aArgs['search'] : '';

        $sWhere = ($_SESSION['grade_idx'] == 8) ? "branch_idx =".$_SESSION['idx']." AND grade_idx = 6 AND (name LIKE '%".$aData['sSearch']."%' OR user_id LIKE '%".$aData['sSearch']."%') AND quit_flag = 0": "grade_idx IN (6,7) AND (name LIKE '%".$aData['sSearch']."%' OR user_id LIKE '%".$aData['sSearch']."%') AND quit_flag = 0";

        /*pagination*/
        $aData['iCurPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
        $aData['iRowPerPage'] = isset($aArgs['rows']) ? $aArgs['rows'] : 20;
        $aData['iRowTotRow'] = count($this->select("tb_user",null,$sWhere)->execute());
        $aData['iOffset'] = ($aData['iCurPage'] - 1) * $aData['iRowPerPage'];

        /*query database*/
        $aData['aTeacher'] = $this->select("tb_user",null,$sWhere)->orderBy('idx', 'DESC')->limit($aData['iOffset'],$aData['iRowPerPage'])->execute();
        foreach($aData['aTeacher'] as $k=>$t){
            $countStudent = $this->query('SELECT COUNT(DISTINCT student_idx) AS number_of_students FROM tb_class_schedule WHERE teacher_branch = '.$_SESSION['idx'].' AND teacher_idx = '.$t['idx']);
            $countClass = $this->query('SELECT COUNT(DISTINCT class_idx) AS number_of_class FROM tb_class_schedule WHERE teacher_branch = '.$_SESSION['idx'].' AND teacher_idx = '.$t['idx']);
            $countCancel = $this->query('SELECT COUNT(DISTINCT sched_status) AS number_of_cancelled FROM tb_class_schedule WHERE teacher_branch = '.$_SESSION['idx'].' AND sched_status="cancelled" AND teacher_idx = '.$t['idx']);
            $aData['aTeacher'][$k]['number'] = $countStudent[0]['number_of_students'];
            $aData['aTeacher'][$k]['numberClass'] = $countClass[0]['number_of_class'];
            $aData['aTeacher'][$k]['numberCancel'] = $countCancel[0]['number_of_cancelled'];
        }

        $this->display("teacher/tpl/teacher_list", $aData);

    }

    public function execDeleteThis($aArgs)
    {

        $aIdx = implode(',', $aArgs['idx']);
        //$sQuery = "DELETE FROM tb_teacher_management WHERE idx IN($aIdx)";
        
        /*query database*/
        $mResult = $this->query("UPDATE tb_user SET quit_flag = '1' WHERE idx IN ($aIdx)");

        if($mResult > 0){
            echo "success";
        }
        else{
            echo "warning";
        }
    }

    public function execGrade_manage()
    {
        $sWhere = ($_SESSION['grade_idx'] == 8) ? "branch_idx =".$_SESSION['idx']." AND status = 'active' " : "status = 'active'";
        $sQueryTeacher = $this->select("tb_teacher_management",null,$sWhere);
        /*pagination*/
        $aData['iCurPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
        $aData['iRowPerPage'] = isset($aArgs['rows']) ? $aArgs['rows'] : 20;
        $aData['iRowTotRow'] = count($sQueryTeacher->execute());
        $aData['iOffset'] = ($aData['iCurPage'] - 1) * $aData['iRowPerPage'];
        /*query database*/
        $aData['aTbData'] = $sQueryTeacher->orderBy('idx', 'DESC')->execute();

        $this->display("teacher/tpl/grade_manage", $aData);
    }

    public function execModifyGrade($aArgs)
    {
        $aFieldName = array('grade_name' => $aArgs['gradeName'], 'description' => $aArgs['description'], 'branch_idx' => $_SESSION['idx']);

        /*query database*/
        $sUpdate = $this->update("tb_teacher_management",$aFieldName,"idx='".$aArgs['idx']."'")->execute();
        if($sUpdate > 0){
            echo "success";
            $this->execGrade_manage();

            $this->display("teacher/tpl/grade_manage");
        }
        else{
            echo "warning";
        }

    }

    public function execGet_idx($aArgs)
    {
        $sQuery = $this->select("tb_teacher_management",null,"idx='".$aArgs['idx']."'")->execute();
        echo json_encode($sQuery);
    }

    public function execSaveGrade($aArgs)
    {

        $aFieldName = array('grade_name' => $aArgs['gradeName'], 'description' => $aArgs['description'], 'branch_idx' => $_SESSION['idx']);

        /*query database*/
        $sInsert = $this->insert("tb_teacher_management",$aFieldName)->execute();
        if($sInsert > 0){
            echo "success";
            $this->execGrade_manage();

            $this->display("teacher/tpl/grade_manage");
        }
        else{
            echo "warning";
        }

    }

    public function execDeleteThisGrade($aArgs)
    {
        $aIdx = implode(',', $aArgs['idx']);
        //$sQuery = "DELETE FROM tb_teacher_management WHERE idx IN($aIdx)";
        $aFieldName = array("status" => 'deleted');
        /*query database*/
        $mResult = $this->query("UPDATE tb_teacher_management SET status = 'deleted' WHERE idx IN ($aIdx)");

        if($mResult > 0){
            echo "success";
        }
        else{
            echo "warning";
        }
    }

    public function execStatistic_personnel($aArgs)
    {
        $aData['sSearch'] = isset($aArgs['userid']) ? $aArgs['userid'] : '';
        $aData['sDayStart'] = isset($aArgs['sDate']) ? $aArgs['sDate']: '';
        $aData['sDayEnd'] = isset($aArgs['eDate']) ? $aArgs['eDate'] : '';
        $sWhere = ($_SESSION['grade_idx'] == 8) ? "branch_idx =".$_SESSION['idx']." AND grade_idx IN (6,7) AND (name LIKE '%{$aData['sSearch']}%' OR user_id LIKE '%{$aData['sSearch']}%')" : "grade_idx IN (6,7) AND (name LIKE '%{$aData['sSearch']}%' OR user_id LIKE '%{$aData['sSearch']}%')";

        $aQueryUser = $this->select("tb_user",null,$sWhere)->execute();

        $teacher = array();
            if($aQueryUser){

                foreach($aQueryUser as $key){
                    $teacher = array('idx'=>$key['idx'],'name'=>$key['name'],'user_id'=>$key['user_id'],'from'=> $aData['sDayStart'], 'to'=>$aData['sDayEnd']);
                }

                $aData['sQuery'] = $this->query("SELECT idx,daystart,sched_status,memo, COUNT(class_idx) AS iClass FROM tb_class_schedule WHERE teacher_branch = ".$_SESSION['idx']." AND teacher_name LIKE '%{$teacher['name']}%' AND daystart BETWEEN '".$aData['sDayStart']."' AND '".$aData['sDayEnd']."' GROUP BY daystart");

            }
        $aData['aTbData'] = ($aData['sSearch']) ? $teacher : "";
        $this->display("teacher/tpl/statistic_personnel", $aData);

    }

    public function execSaveMemo($aArgs)
    {
        $aFieldName = array('memo' => $aArgs['memo']);
        $sUpdate = $this->update("tb_class_schedule",$aFieldName,"teacher_branch = ".$_SESSION['idx']." AND idx='".$aArgs['idx']."'")->execute();
        if($sUpdate > 0){
            echo "success";
        }
        else{
            echo "warning";
        }
    }

    public function execStatistic_total($aArgs)
    {

        $this->display("teacher/tpl/statistic_total");

    }

    public function execGetStatTotal($aArgs)
    {
        $aFieldName = array('year' => $aArgs['dateAssigned']);
        $last = $this->query("SELECT LAST_DAY('".$aFieldName['year']."') AS last");
        /*query database*/
        $sWhere = " WHERE daystart BETWEEN '".$aFieldName['year']."' AND '".$last[0]['last']."'";

        $sIMax = $this->query("SELECT teacher_name, COUNT(DISTINCT teacher_name) AS max_teacher FROM tb_class_schedule WHERE teacher_branch = ".$_SESSION['idx']." AND daystart BETWEEN '".$aFieldName['year']."' AND '".$last[0]['last']."' GROUP BY teacher_name ORDER BY max_teacher DESC ");
        $iMin = $this->query("SELECT teacher_name, COUNT(DISTINCT teacher_name) AS min_teacher FROM tb_class_schedule WHERE teacher_branch = ".$_SESSION['idx']." AND daystart BETWEEN '".$aFieldName['year']."' AND '".$last[0]['last']."' GROUP BY teacher_name ORDER BY min_teacher ASC");
        
        $aData['max_teacher'] = isset($sIMax[0]['max_teacher']) == true ? $sIMax[0]['max_teacher'] :0;
        $aData['min_teacher'] = isset($iMin[0]['min_teacher']) == true ? $iMin[0]['min_teacher'] :0;
        $aData['max_teacher_name'] = isset($sIMax[0]['teacher_name']) == true ? $sIMax[0]['teacher_name'] :0;
        $aData['min_teacher_name'] = isset($iMin[0]['teacher_name']) == true ? $iMin[0]['teacher_name'] :0;
        $iTeacher = $this->query("SELECT COUNT(DISTINCT teacher_name) AS total_teacher FROM tb_class_schedule WHERE teacher_branch = ".$_SESSION['idx']." AND  teacher_name != '' AND daystart BETWEEN '".$aFieldName['year']."' AND '".$last[0]['last']."'");
        $aData['iTeacher'] = ($iTeacher[0]['total_teacher']) ? $iTeacher[0]['total_teacher'] : 0;
        $aData['iClass'] = count($this->query("SELECT DISTINCT class_idx FROM tb_class_schedule {$sWhere}"));
        $aData['iAttend'] = count($this->query("SELECT sched_status FROM tb_class_schedule WHERE teacher_branch = ".$_SESSION['idx']." AND  sched_status = 'attended' AND daystart BETWEEN '".$aFieldName['year']."' AND '".$last[0]['last']."'"));
        $aData['iCancelled'] = count($this->query("SELECT sched_status FROM tb_class_schedule WHERE teacher_branch = ".$_SESSION['idx']." AND  sched_status = 'cancelled' AND daystart BETWEEN '".$aFieldName['year']."' AND '".$last[0]['last']."'"));
        $aData['iPostponed'] = count($this->query("SELECT sched_status FROM tb_class_schedule WHERE teacher_branch = ".$_SESSION['idx']." AND  sched_status = 'posponed' AND daystart BETWEEN '".$aFieldName['year']."' AND '".$last[0]['last']."'"));
        $aData['iLTPostponed'] = count($this->query("SELECT sched_status FROM tb_class_schedule WHERE teacher_branch = ".$_SESSION['idx']." AND sched_status = 'longterm'"));

        echo json_encode($aData);
    }

}

$oClass = new teacher();
$oClass->run($aArgs); #initialize here