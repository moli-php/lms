<?php
class classList extends Simplexi_Controller
{
	public function run($aArgs)
	{
	    $this->library('common');
	    $this->library('tinymce');
	    $this->importJS('class/class_list');
	    $this->importJS('send_sms');
	    $this->importJS('message/message');
	    Tinymce::init();

	    if(isset($_SESSION['idx'])){
	        $this->checkStatus($aArgs);
	        $this->classListReady($aArgs);
        }
        else {
            echo "<script>location.href='" . BASE_URL . "admin/'</script>";
        }
    }

    private function checkStatus($aArgs)
    {
        $sGetId = $this->query('SELECT DISTINCT class_idx FROM tb_class_schedule');
        foreach($sGetId as $cK=>$sClass){
            $sCheckFinished = $this->select('tb_class_schedule', null, 'changed_flag = 0 AND class_idx = '.$sClass['class_idx'])->execute();
            foreach($sCheckFinished as $sK=>$sCheck){
                $sStatusFinished[$cK]['sched_status'][] = $sCheck['sched_status'];
                $sStatusFinished[$cK]['class_idx'] = $sCheck['class_idx'];
            }

            $sSchedStatus = $sStatusFinished[$cK]['sched_status'];
            if((count(array_unique($sSchedStatus)) == 1 && $sSchedStatus[0] == 'attended') || (!in_array('waiting', $sSchedStatus) && (in_array('cancelled', $sSchedStatus) || (in_array('absent', $sSchedStatus))) && in_array('attended', $sSchedStatus))){
                $aFieldSched = array( 'class_status' => "finished" );
            } else if(count(array_unique($sSchedStatus)) == 1 && $sSchedStatus[0] == 'cancelled'){
                $aFieldSched = array( 'class_status' => "cancelled" );
            } else {
                $aFieldSched = null;
            }
            if($aFieldSched !=null){
                $sUpdateClass = $this->update("tb_class", $aFieldSched,"idx=".$sStatusFinished[$cK]['class_idx'])->execute();
            }
        }
    }

    private function classListReady($aArgs)
    {
	    /*Data to be passed*/
	    $aData['name'] = (isset($aArgs['name'])) ? $aArgs['name'] : "";
	    $aData['class'] = (isset($aArgs['class'])) ? $aArgs['class'] : "";
	    $aData['teacher'] = (isset($aArgs['teacher'])) ? $aArgs['teacher'] : "";
	    $aData['branch'] = (isset($aArgs['branch'])) ? $aArgs['branch'] : "";
	    $aData['edate'] = (isset($aArgs['edate'])) ? $aArgs['edate'] : "";
	    $aData['sdate'] = (isset($aArgs['sdate'])) ? $aArgs['sdate'] : "";
	    $aData['iCurPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
	    $aData['iRowPerPage'] = isset($aArgs['rows']) ? $aArgs['rows'] : 10;

	    /*Data for the queries*/
	    $iOffset = $aData['iRowPerPage'] * ($aData['iCurPage']-1);
	    $sName = (@$aArgs['name']!="") ? ' AND (u.name LIKE "%'.$aArgs['name'].'%" OR u.user_id LIKE "%'.$aArgs['name'].'%")' : "";
	    $sCourse = (@$aArgs['class']!="") ? ' AND p.idx = '.$aArgs['class'] : "";
	    $sTeacher = (@$aArgs['teacher']!="") ? ' AND  e.teacher_idx = "'.$aArgs['teacher'].'"' : "";
	    $seBranch = (@$aArgs['branch']!="" && $_SESSION['grade_idx'] == 9) ? ' AND  u.branch_idx = "'.$aArgs['branch'].'"' : "";
	    $aData['view'] = (isset($aArgs['view'])) ? $aArgs['view'] : null;
	    $sView = (@$aArgs['view']!="") ? ' AND c.class_status = "'.$aArgs['view'].'"' : '';
	    $sJoinDate = (@$aArgs['sdate']!="" || @$aArgs['edate']!="") ? " INNER JOIN tb_class_schedule d ON d.class_idx = c.idx " : "";
	    $sDate = (@$aArgs['sdate']!="" || @$aArgs['edate']!="") ? " AND (d.daystart BETWEEN '{$aData['sdate']}' AND '{$aData['edate']}')" : '';
	    $viewBranch = ($_SESSION['grade_idx'] == 8) ? ' AND u.branch_idx = '.$_SESSION['idx'].'' : '';
	    $sBranch = ($_SESSION['grade_idx'] == 8) ? ' AND branch_idx = '.$_SESSION['idx'] : '';
        $sQuit = (@$aArgs['view'] != 'deleted') ? ' AND u.quit_flag = 0 AND p.delete_flag = 0' : ' AND u.quit_flag = 0';

	    /*Get All Information*/
	    $sQueryAll = 'SELECT DISTINCT c.idx AS main_idx, u.user_id AS user_name, u.email AS email, u.idx AS user_id, u.name AS full_name,
                        u.nickname AS nickname, u.phone_home AS tel, phone_mob AS cell, p.name AS classname, c.class_status AS class_status,
                        c.datetime_created, c.datetime_deleted, s.amount, s.payment_method, s.sale_status, u.branch_idx AS branchname,
                        s.idx AS class_id, p.price AS total_price, p.discount, p.type, p.teacher_type
                        FROM tb_sales_product s INNER JOIN tb_class c ON s.class_idx = c.idx
                        INNER JOIN tb_product_class p ON c.p_class_idx = p.idx
                        INNER JOIN tb_user u ON c.student_idx = u.idx
                        INNER JOIN tb_class_ext e ON e.class_idx = c.idx'.$sJoinDate.'
                        WHERE u.quit_flag = 0 AND p.delete_flag = 0 AND c.class_status NOT IN ("cancelled","postponed")'.
	                $viewBranch.$sName.$sCourse.$sTeacher.$sDate.$seBranch;
	    $sOrderS = (@$aArgs['view'] != 'deleted') ? 'c.datetime_created' : 'c.datetime_deleted';
	    $aData['studentInfo'] = $this->query($sQueryAll.$sQuit.$sView.' ORDER BY '.$sOrderS.' DESC LIMIT '.$aData['iRowPerPage'].' OFFSET '.$iOffset.'');
	    $aData['iTotalRow'] = count($this->query($sQueryAll.$sQuit.$sView));

	    /*Search Information*/
	    $aData['branchName'] = $this->select("tb_user",null,'quit_flag=0 AND grade_idx = 8')->execute();    /*Get All Branch*/

	    foreach($aData['branchName'] as $b=>$sBranchId){
	        $sQueryBranch = $this->select("tb_user",null,'branch_idx = '.$sBranchId['idx'].' AND quit_flag=0 AND grade_idx IN (6,7)'.$sBranch)->execute();    /*Get All Teachers*/
	        $sClass = ($_SESSION['grade_idx'] == 8) ? 'branch_idx = '.$_SESSION['idx'] : 'branch_idx = '.$sBranchId['idx'];
	        $aClassName = $this->select("tb_product_class",null,$sClass.' AND delete_flag=0')->execute();    /*Get All Classes*/

            if($sQueryBranch!=null){
                foreach($sQueryBranch as $sq=>$sBrId){
                    $aData['branchName'][$b]['teacher_name'][] = $sBrId['name'];
                    $aData['branchName'][$b]['teacher_id'][] = $sBrId['idx'];
                }
            }

            if($aClassName!=null){
                foreach($aClassName as $sa=>$sClassN){
                    $aData['branchName'][$b]['class_name'][] = $sClassN['name'];
                    $aData['branchName'][$b]['class_id'][] = $sClassN['idx'];
                }
            }
	    }

	    /*Get total number of each status*/
        $aStat = array('only_applied', 'scheduled', 'finished', 'deleted');
	    foreach($aStat as $stat){
	        $sStatus = ($stat == 'deleted') ? '"'.$stat . '" AND u.quit_flag = 0' : '"'.$stat . '" AND u.quit_flag = 0 AND p.delete_flag = 0';
	        $aData[$stat] = count($this->query($sQueryAll. ' AND c.class_status = '.$sStatus));
	    }
	    $aData['all'] = count($this->query($sQueryAll.' AND u.quit_flag = 0 AND p.delete_flag = 0'));

	    $i = 0;
	    if(count($aData['studentInfo']) >=1) {
	        foreach($aData['studentInfo'] as $key=>$val) {
	            $sWhereSched = 'teacher_idx != 0 AND teacher_name!= "" AND student_idx ='.$val['user_id'].' AND class_idx='.$val['main_idx'];
	            $sSched = $this->select('tb_class_schedule', null, $sWhereSched)->orderBy('daystart', 'ASC')->limit(0,1)->execute();

	            /*Remaining Classes*/
	            $aData['studentInfo'][$key]['rest_classes'] = count($this->select('tb_class_schedule', null, $sWhereSched.' AND sched_status = "waiting" AND changed_flag = 0')->execute());
                if($aData['studentInfo'][$key]['rest_classes'] <=2 && $aData['studentInfo'][$key]['rest_classes'] >=1){
                    $aData['studentInfo'][$key]['check_classes'] = "red_class";
                } else {
                    $aData['studentInfo'][$key]['check_classes'] = "normal_class";
                }

                /*Configuration for Scheduled Class*/
                $iAppNo = $this->query('SELECT SUBSTR(RAND('.$val['class_id'].'),-10) AS appno');
                $aBranch = $this->query('SELECT name AS branchname FROM tb_user WHERE quit_flag=0 AND idx = (SELECT idx FROM tb_user WHERE idx='.$val['branchname'].')');
                $aTeacher = (count($sSched)>=1 && $sSched[0]['teacher_idx']!=null) ? $this->query('SELECT name AS teachername, quit_flag FROM tb_user WHERE idx='.$sSched[0]['teacher_idx']) : null;
                $aTeacher[0]['teachername'] = (count($sSched)>=1 && $aTeacher[0]['teachername']!=NULL) ? $aTeacher[0]['teachername'] : "";

                /*Teacher Column*/
                if($aTeacher[0]['teachername']!=""){
                    if($aTeacher[0]['quit_flag'] == 0){
                            $aData['studentInfo'][$key]['teacher_name'] = ucwords($aTeacher[0]['teachername']);
                    } else if($aTeacher[0]['quit_flag'] == 1){
                        $aData['studentInfo'][$key]['teacher_name'] = '<img src = "../../images/class/warning.png" title="Teacher is no longer a member." style="width:14px;margin:0;">&nbsp;Student needs a new teacher.';
                    }
                } else {
                    $aData['studentInfo'][$key]['teacher_name'] = 'None';
                }

                /*Color*/
                if($val['class_status'] == "only_applied") {
                    $sColor = "yellow";
                } else if($val['class_status'] == "finished") {
                    $sColor = "purple";
                } else if($val['class_status'] == "deleted") {
                    $sColor = "grey";
                } else {
                    $sColor = "green";
                }

                if($aData['studentInfo'][$key]['check_classes'] == "red_class"){
                    $sColor = "red";
                }

                if(count($sSched)>=1 && $sSched[0]['class_days']!=NULL){
                    $sDay = explode(',',$sSched[0]['class_days']);
                    $aCDays = "";
                    foreach($sDay as $kday=>$vday){
                        $aCDays .= substr($vday,0,3) . " ";
                    }
                }

                $aData['studentInfo'][$key]['color'] = $sColor;
                $aData['studentInfo'][$key]['appno'] = $iAppNo[0]['appno'];    /*Application Number*/
                $aData['studentInfo'][$key]['branchname'] = ($aBranch[0]['branchname']!="") ? ucwords($aBranch[0]['branchname']): "None";    /*Branch Name of specific student*/
	            $aData['studentInfo'][$key]['startdate'] = (count($sSched)>=1 && $sSched[0]['daystart']!=NULL) ? $sSched[0]['daystart'] : 0;    /*Class Start Date*/
                $aData['studentInfo'][$key]['class_days'] = (count($sSched)>=1 && $sSched[0]['class_days']!=NULL) ? $aCDays : "";    /*Class Days*/
	            $aData['studentInfo'][$key]['time_start'] = (count($sSched)>=1 && $sSched[0]['time_start']!=NULL) ? $sSched[0]['time_start'] : "";    /*Time Start*/
	            $aData['studentInfo'][$key]['time_end'] = (count($sSched)>=1 && $sSched[0]['time_end']!=NULL) ? $sSched[0]['time_end'] : "";    /*Time End*/
                $aData['studentInfo'][$key]['iCount'] = $aData['iTotalRow'] - $iOffset - $i;   /*Displays Number*/

                ++$i;
	        }
	    }

	    $this->display("class/tpl/classList", $aData);
    }
}