<?php
include('../../__library/controller.php');
class dashboard extends Simplexi_Controller
{
	public function run($aArgs)
	{
	    $this->library('common');
	    $this->importCSS('dashboard/dashboard');
	    $this->importJS('dashboard/dashboard');
	    $this->importJS('ulearning/test_evaluation');
	    $this->model("dashboard_management_model");

	    $sAction = Common::getParam('action');
	    $sAction = $sAction != "" ? "exec" . ucwords($sAction) : "execDashboard";
	    if(isset($_SESSION['idx'])){
	        $this->$sAction($aArgs);
        }
        else {
            echo "<script>location.href='" . BASE_URL . "admin/'</script>";
        }
	}

	public function checkString($sName, $iCnt){
	    return (strlen($sName) > $iCnt) ? substr($sName,0,$iCnt)." ..." : $sName;
	}

	private function execDashboard($aArgs)
	{
	    $sTotal = "";
	    $sList = "";
	    $aData['limit'] = isset($_SESSION['total_limit']) ? $_SESSION['total_limit'] : null;
	    $aData['query'] = $this->db->dashboard_management_model->getAllData("");

	    $sView = ($_SESSION['grade_idx'] == 8) ? ' branch_idx = '.$_SESSION['idx'].'' : '';	//If it is branch
	    $sViewAnd = ($_SESSION['grade_idx'] == 8) ? ' AND branch_idx = '.$_SESSION['idx'].'' : '';	//If it is branch
	    $sViewU = ($_SESSION['grade_idx'] == 8) ? ' AND c.branch_idx = '.$_SESSION['idx'].'' : '';	//If it is branch

	    $aData['query'][0]['item_name'] = explode(',',$aData['query'][0]['item_name']);
	    foreach($aData['query'][0]['item_name'] as $key=>$sItemName){
	        $sDetails = $aData['query'][0]['item_name'];
	        //USER
	        if($sItemName == "user"){
	            $sTotal = count($this->select('tb_user',null, 'quit_flag = 0 AND (grade_idx!=9)'.$sViewAnd)->execute());
	            $sList = $this->select('tb_user', null, ' quit_flag = 0 AND (grade_idx!=9 OR grade_idx !=8)'.$sViewAnd)->orderBy('date_reg', 'DESC')->limit(0,5)->execute();

	            $aNum = array('1'=>'no_students', '6'=>'no_teachers', '8'=>'no_branches', '7'=>'no_teachers_head');
	            foreach($aNum as $kNum=>$vNum){
	                $sDetails[$vNum] = count($this->select('tb_user',null, 'quit_flag = 0 AND grade_idx = '.$kNum.''.$sViewAnd)->execute());
	            }

	        //CLASS
	        } else if($sItemName == "class"){
	            $sLimit = ""; $sTotal = "";
	            $sOnly = ' AND c.class_status = "only_applied"';
	            $sQuit = ' AND u.quit_flag = 0 AND p.delete_flag=0';
	            $sQueryAll = 'SELECT c.idx AS main_idx, u.idx AS user_id, u.name AS full_name,
                            p.name AS classname, c.datetime_created AS datetime_created, p.total_months AS period,
                            s.amount AS amount, e.teacher_idx AS teacher_id, p.price AS total_price, p.discount AS discount
                            FROM tb_user u, tb_sales_product s, tb_class c, tb_product_class p, tb_class_ext e
                            WHERE u.idx = s.user_idx AND s.class_idx = c.idx
                            AND s.user_idx = e.student_idx
        	                AND c.idx = e.class_idx
                            AND c.p_class_idx = p.idx'.$sViewU;
	            $sLimit = ' ORDER BY c.datetime_created DESC LIMIT 5 OFFSET 0';
	            $sList = $this->query($sQueryAll.$sQuit.$sOnly.$sLimit);

	            $aStat = array('only_applied', 'scheduled', 'finished', 'deleted');                         /*Get Total*/
	            foreach($aStat as $stat){
	                $sStatus = ($stat == 'deleted') ? '"'.$stat . '" AND u.quit_flag = 0' : '"'.$stat . '" AND u.quit_flag = 0 AND p.delete_flag = 0';
	                $sDetails[$stat] = count($this->query($sQueryAll. ' AND c.class_status = '.$sStatus));
	                $sTotal += $sDetails[$stat];
	            }
	            $sTotal = $sTotal;
	            if(count($sList) >=1){
    	            foreach($sList as $k=>$val){
    	                if($val['discount']!=""){
        	                $sPerc = $this->query('SELECT ((SUM(amount) *(0.01)) * ('.$val['total_price'].')) + ('.$val['total_price'].') AS sum_percent FROM tb_product_discount WHERE delete_flag = 0 AND type="percent" AND idx IN('.$val['discount'].')');
        	                $sAmnt = $this->query('SELECT SUM(amount) AS sum_amount FROM tb_product_discount WHERE delete_flag = 0 AND type="amount" AND idx IN('.$val['discount'].')');
        	                $sTotalQ = $sPerc[0]['sum_percent'] + $sAmnt[0]['sum_amount'];
        	                $aAnswer = $this->query('SELECT FORMAT(ROUND('.$sTotalQ.',2),2) AS amount FROM DUAL');
        	                $sDetails['c_amount'][] = $aAnswer[0]['amount'];
    	                } else {
    	                    $sDetails['c_amount'][] = number_format($val['total_price'], 2, '.', ',');
    	                }
    	            }
	            }

	        //MESSAGE
	        } else if($sItemName == "message"){
	            $sTotal = count($this->select('tb_msg_adv', null, 'parent_idx = 0'.$sViewAnd)->execute());
	            $sList = $this->select('tb_msg_adv', null, 'parent_idx = 0'.$sViewAnd)->orderBy('date_reg', 'DESC')->limit(0,5)->execute();

	            if(count($sList) >=1){
    	            foreach($sList as $k=>$val){
    	                $sDetails['m_number'][] = count($this->select('tb_msg_adv', null, 'parent_idx >=1 AND parent_idx ='.$val['idx'])->orderBy('date_reg', 'DESC')->limit(0,5)->execute());
    	            }
	            }

	            $sReadMain = $this->select('tb_msg_adv', null, 'read_status = "Y" AND parent_idx=0'.$sViewAnd)->execute();
	            $sUnreadMain = $this->select('tb_msg_adv', null, 'read_status = "N" AND parent_idx=0'.$sViewAnd)->execute();
	            $sDetails['m_unread_main'] = count($sUnreadMain);
	            $sDetails['m_read_main'] = count($sReadMain);

	        //PRODUCT
	        } else if($sItemName == "product"){
	            $sTotal = count($this->select('tb_product_class', null, 'delete_flag = 0'.$sViewAnd)->execute());
	            $sList = $this->select('tb_product_class', null, 'delete_flag = 0'.$sViewAnd)->orderBy('datetime_update', 'DESC')->limit(0,5)->execute();

	            $sActive = $this->select('tb_product_class', null, 'delete_flag = 0 AND status = 1'.$sViewAnd)->execute();
	            $sInactive = $this->select('tb_product_class', null, 'delete_flag = 0 AND status = 0'.$sViewAnd)->execute();
	            $sDetails['p_active'] = count($sActive);
	            $sDetails['p_inactive'] = count($sInactive);

	        //EVENT
	        } else if($sItemName == "event"){
	            $sViewE = ($_SESSION['grade_idx'] == 8) ? 'user_id='.$_SESSION['idx'].'' : '';
	            $sViewAndE = ($_SESSION['grade_idx'] == 8) ? ' AND user_id='.$_SESSION['idx'].'' : '';
	            $sTotal = count($this->select('tb_event_add_popup', null, $sViewE)->execute());
	            $sList = $this->select('tb_event_add_popup', null, $sViewE)->orderBy('date_created', 'DESC')->limit(0,5)->execute();

	            if(count($sList) >=1){
	                foreach($sList as $k=>$val){
    	                 $sUsername = $this->select('tb_user', null,'idx='.$val['user_id'])->execute();
    	                 $sList[$k]['user_id'] = $sUsername[0]['name'];
    	            }
	            }
	            $sDetails['e_active'] = count($this->select('tb_event_add_popup', null, 'status="Active"'.$sViewAndE)->execute());
	            $sDetails['e_inactive'] = $sTotal - $sDetails['e_active'];

	        //ULEARNING
	        } else if($sItemName == "ulearning"){
	            $sViewUlearn = ($_SESSION['grade_idx'] == 8) ? 'u.fbranch_idx='.$_SESSION['idx'].'' : '';
	            $sUlearn = 'tb_ulearning_unit u
    	                    INNER JOIN tb_ulearning_category c1 ON u.fcategory_id = c1.fcategory_id
    	                    INNER JOIN tb_ulearning_category c2 ON c1.fdepth2 = c2.fcategory_id
    	                    INNER JOIN tb_ulearning_category c3 ON c2.fdepth1 = c3.fcategory_id';
	            $sTotal = count($this->select($sUlearn, null, $sViewUlearn)->execute());
	            $sList = $this->select($sUlearn, 'u.funit_id, u.ftitle, u.fdate, c3.fcategory_name AS cat_main, c2.fcategory_name AS cat_depth1, c1.fcategory_name AS cat_depth2, c3.fcategory_id As u_cat_main_idx',
	                     $sViewUlearn)->orderBy('u.fdate', 'DESC')->limit(0,5)->execute();

	        //TEST RESULT --
	        } else if($sItemName == "test_result"){
	            $sViewTest = ($_SESSION['grade_idx'] == 8) ? ' t2.branch_idx='.$_SESSION['idx'].'' : '';
	            $sSelect = "tb_ulearning_test_evaluation t1 INNER JOIN tb_user t2 ON t1.user_idx = t2.idx
                            INNER JOIN tb_ulearning_assign t3 ON t1.fassign_id = t3.fassign_id
                            INNER JOIN tb_ulearning_unit t4 ON t3.funit_id=t4.funit_id
                            INNER JOIN tb_ulearning_category t5 ON t5.fcategory_id = t4.fcategory_id
                            INNER JOIN tb_ulearning_category t6 ON t5.fdepth2 = t6.fcategory_id
                            INNER JOIN tb_ulearning_category t7 ON t6.fdepth1 = t7.fcategory_id";
	            $sList= $this->select($sSelect, 'ftitle,user_idx,eval_id,t3.fassign_id,sdate,edate,name,t4.funit_id,t7.fcategory_name,t6.fcategory_name as fcategory_name2,t5.fcategory_name as fcategory_name3', $sViewTest)->limit(0,5)->execute();
	            $sTotal = count($this->select($sSelect, 't1.eval_id', $sViewTest)->execute());

                if(count($sList) >=1){
                    foreach($sList as $k=>$val){
                        $sGrade = $this->query('SELECT ROUND(AVG(fgrade),2) AS ave FROM tb_ulearning_user_grade WHERE feval_id = '.$val['eval_id'].'');
                        $sList[$k]['average'] = $sGrade[0]['ave'];
                    }
                }

	        //BRANCH
	        } else if($sItemName == "branch"){
	            $sViewAndB = ($_SESSION['grade_idx'] == 8) ? ' AND idx='.$_SESSION['idx'].'' : '';
	            $sTotal = count($this->select('tb_user',null,'quit_flag=0 AND grade_idx = 8'.$sViewAndB)->execute());
	            $sList = $this->select('tb_user', null, 'quit_flag=0 AND grade_idx = 8'.$sViewAndB)->orderBy('date_reg', 'DESC')->limit(0,5)->execute();

	            $sDetails['b_active'] = count($this->select('tb_branch_detail', null));
	            $sDetails['b_inactive'] = $sTotal - $sDetails['b_active'];

	            if(count($sList) >=1){
    	            foreach($sList as $k=>$val){
    	                $sDetails['b_stud'][] = count($this->select('tb_user', null, 'quit_flag=0 AND grade_idx = 1 AND branch_idx ='.$val['idx'])->execute());
    	                $sDetails['b_teacher'][] = count($this->select('tb_user', null, 'quit_flag=0 AND grade_idx=6 AND branch_idx ='.$val['idx'])->execute());
    	                $sDetails['b_head_teacher'][] = count($this->select('tb_user', null, 'quit_flag=0 AND grade_idx=7 AND branch_idx ='.$val['idx'])->execute());
    	            }
	            }

	        //POINT
	        } else if($sItemName == "point"){
	            $sViewPt = ($_SESSION['grade_idx'] == 8) ? ' AND p.branch_idx='.$_SESSION['idx'].'' : '';
	            $sLimit = ' LIMIT 5 OFFSET 0';
	            $sQueryAll = 'SELECT u.user_id, u.name, p.amount_points, p.reason, p.date_registered FROM tb_user u, tb_points p
                              WHERE u.quit_flag=0 AND u.user_id=p.user_id AND isDeleted="no"'.$sViewPt.' ORDER BY date_registered DESC';
                $sList = $this->query($sQueryAll.$sLimit);
                $sTotal = count($this->query($sQueryAll));

	        //ABSENT STUDENT
	        } else if($sItemName == "absent_student"){
	            $sLimit = "";
	            $sQueryAll = 'SELECT DISTINCT c.idx AS main_idx, u.user_id AS user_name, u.idx AS user_id, u.name AS full_name,
                    p.name AS classname, d.daystart AS classdate, u.branch_idx AS branchname, s.idx AS class_id, p.type AS type
                    FROM tb_user u, tb_sales_product s, tb_class c, tb_product_class p, tb_class_ext e, tb_class_schedule d
                    WHERE u.idx = s.user_idx
                    AND s.class_idx = c.idx
                    AND c.p_class_idx = p.idx
                    AND c.student_idx = u.idx
                    AND s.user_idx = e.student_idx
                    AND c.idx = e.class_idx
                    AND d.class_idx = c.idx
                    AND d.student_idx = u.idx
                    AND d.sched_status = "absent"
                    AND c.class_status != "deleted"
                    AND u.quit_flag = 0
            	    AND p.delete_flag = 0'.$sViewU;
	            $sLimit = ' ORDER BY d.daystart DESC LIMIT 5 OFFSET 0';
	            $sList = $this->query($sQueryAll.$sLimit);
	            $sTotal = count($this->query($sQueryAll));

	            if(count($sList) >=1){
	               foreach($sList as $k=>$val) {
	                    $sWhereSched = 'teacher_idx != 0 AND teacher_name!= "" AND student_idx ='.$val['user_id'].' AND class_idx='.$val['main_idx'];
	                    $sSched = $this->select('tb_class_schedule', null, $sWhereSched)->orderBy('daystart', 'ASC')->limit(0,1)->execute();
	                    $aTeacher = $this->query('SELECT name AS teachername FROM tb_user WHERE  quit_flag=0 AND idx='.$sSched[0]['teacher_idx']);

	                    $sDetails['teacher_name'][] = (count($sSched)>=1 && $sSched[0]['teacher_idx']!=NULL) ? $aTeacher[0]['teachername'] : 0;
	                    $sDetails['time_start'][] = (count($sSched)>=1 && $sSched[0]['time_start']!=NULL) ? $sSched[0]['time_start'] : '';
	                    $sDetails['time_end'][] = (count($sSched)>=1 && $sSched[0]['time_end']!=NULL) ? $sSched[0]['time_end'] : '';
	                }
	            }

	         //CANCELLED CLASS
	        } else if($sItemName == "cancelled_class"){
	            $sLimit = "";
	            $sQueryAll = 'SELECT DISTINCT c.idx AS main_idx, u.user_id AS user_name, u.idx AS user_id, u.name AS full_name,
                    p.name AS classname, d.daystart AS classdate, u.branch_idx AS branchname, s.idx AS class_id, p.type AS type
                    FROM tb_user u, tb_sales_product s, tb_class c, tb_product_class p, tb_class_ext e, tb_class_schedule d
                    WHERE u.idx = s.user_idx
                    AND s.class_idx = c.idx
                    AND c.p_class_idx = p.idx
                    AND c.student_idx = u.idx
                    AND s.user_idx = e.student_idx
                    AND c.idx = e.class_idx
                    AND d.class_idx = c.idx
                    AND d.student_idx = u.idx
                    AND d.sched_status = "cancelled"
                    AND c.class_status != "deleted"
                    AND u.quit_flag = 0
            	    AND p.delete_flag = 0'.$sViewU;
	            $sLimit = ' ORDER BY d.daystart DESC LIMIT 5 OFFSET 0';
	            $sList = $this->query($sQueryAll.$sLimit);
	            $sTotal = count($this->query($sQueryAll));

	            if(count($sList) >=1){
	               foreach($sList as $k=>$val) {
	                    $sWhereSched = 'teacher_idx != 0 AND teacher_name!= "" AND student_idx ='.$val['user_id'].' AND class_idx='.$val['main_idx'];
	                    $sSched = $this->select('tb_class_schedule', null, $sWhereSched)->orderBy('daystart', 'ASC')->limit(0,1)->execute();
	                    $aTeacher = $this->query('SELECT name AS teachername FROM tb_user WHERE quit_flag=0 AND idx='.$sSched[0]['teacher_idx']);

	                    $sDetails['teacher_name'][] = (count($sSched)>=1 && $sSched[0]['teacher_idx']!=NULL) ? $aTeacher[0]['teachername'] : 0;
	                    $sDetails['time_start'][] = (count($sSched)>=1 && $sSched[0]['time_start']!=NULL) ? $sSched[0]['time_start'] : '';
	                    $sDetails['time_end'][] = (count($sSched)>=1 && $sSched[0]['time_end']!=NULL) ? $sSched[0]['time_end'] : '';
	                }
	            }
	        }

	        $sDetails['item_name'] = $sItemName;
	        $sDetails['total'] = $sTotal;
	        $sDetails['list'] = $sList;
	        $aData['details'][$key] = $sDetails;
	    }
		$this->display("dashboard/tpl/dashboard", $aData);
	}

	public function execSaveSettings($aArgs)
	{
	    $this->db->dashboard_management_model->deleteAllData();
	    $this->db->dashboard_management_model->saveSettings();
	}
}

$oClass = new dashboard();
$oClass->run($aArgs);
