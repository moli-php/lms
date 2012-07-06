<?php
class classLpostponed extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library("common");
		$this->importJS("class/class_long_term");

		if(isset($_SESSION['idx'])){
		    $this->classLpostponedReady($aArgs);
		}
		else {
		    echo "<script>location.href='" . BASE_URL . "admin/'</script>";
		}
	}

	private function classLpostponedReady($aArgs)
	{
	    $sView = ''; $sName = ''; $sCourse = ''; $sTeacher=''; $sDate =""; $viewBranch = ""; $sDelete = ""; $seBranch= ""; $aIdx = array();

	    /*Data to be passed*/
	    $aData['name'] = (isset($aArgs['name'])) ? $aArgs['name'] : "";
	    $aData['class'] = (isset($aArgs['class'])) ? $aArgs['class'] : "";
	    $aData['teacher'] = (isset($aArgs['teacher'])) ? $aArgs['teacher'] : "";
	    $aData['branch'] = (isset($aArgs['branch'])) ? $aArgs['branch'] : "";
	    $aData['edate'] = (isset($aArgs['edate'])) ? $aArgs['edate'] : "";
	    $aData['sdate'] = (isset($aArgs['sdate'])) ? $aArgs['sdate'] : "";
	    $aData['iCurPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
	    $aData['iRowPerPage'] = isset($aArgs['rows']) ? $aArgs['rows'] : 10;

	    $iOffset = $aData['iRowPerPage'] * ($aData['iCurPage']-1);
	    $sName = (@$aArgs['name']!="") ? ' AND (u.name LIKE "%'.$aArgs['name'].'%" OR u.user_id LIKE "%'.$aArgs['name'].'%")' : "";
	    $sCourse = (@$aArgs['class']!="") ? ' AND p.idx = '.$aArgs['class'] : "";
	    $sTeacher = (@$aArgs['teacher']!="") ? ' AND  e.teacher_idx = "'.$aArgs['teacher'].'"' : "";
	    $seBranch = (@$aArgs['branch']!="" && $_SESSION['grade_idx'] == 9) ? ' AND  u.branch_idx = "'.$aArgs['branch'].'"' : "";
	    $sDate = (@$aArgs['sdate']!="" || @$aArgs['edate']!="") ? " AND (d.daystart BETWEEN '{$aData['sdate']}' AND '{$aData['edate']}')" : '';
	    $viewBranch = ($_SESSION['grade_idx'] == 8) ? ' AND u.branch_idx = '.$_SESSION['idx'].'' : '';
	    $sBranch = ($_SESSION['grade_idx'] == 8) ? ' AND branch_idx = '.$_SESSION['idx'] : '';

	    $aLong = $this->query('SELECT DISTINCT(class_idx) FROM tb_class_schedule WHERE longterm_flag = 1 AND changed_flag = 0');
	    foreach($aLong as $vLong){
	        array_push($aIdx, $vLong['class_idx']);
	    }
	    $sIdx = implode(",",$aIdx);

	    if($sIdx != ""){
    	    /*Get All Information*/
    	    $sQueryAll = 'SELECT DISTINCT c.idx AS main_idx, u.user_id AS user_name, u.idx AS user_id, u.name AS full_name, p.name AS classname,
                    	    u.branch_idx AS branchname, s.idx AS class_id, p.type AS type, d.time_end, d.time_start, d.teacher_name
                    	    FROM tb_user u, tb_sales_product s, tb_class c, tb_product_class p, tb_class_ext e, tb_class_schedule d
                    	    WHERE u.idx = s.user_idx
                    	    AND s.class_idx = c.idx
                    	    AND s.class_idx IN ('.$sIdx.')
                    	    AND c.p_class_idx = p.idx
                    	    AND c.student_idx = u.idx
                    	    AND s.user_idx = e.student_idx
                    	    AND c.idx = e.class_idx
                    	    AND d.class_idx = c.idx
                    	    AND d.student_idx = u.idx
                    	    AND c.class_status = "scheduled"
                    	    AND d.changed_flag = 0
                    	    AND u.quit_flag = 0
                    	    AND p.delete_flag = 0'
                    	    .$viewBranch.$sName.$sCourse.$sTeacher.$sDate.$seBranch;
    	    $sLimit = ' ORDER BY d.daystart DESC LIMIT '.$aData['iRowPerPage'].' OFFSET '.$iOffset.'';
    	    $aData['longTerm'] = $this->query($sQueryAll.$sLimit);
    	    $aData['iTotalRow'] = count($this->query($sQueryAll));

    	    $i = 0;
    	    if($aData['iTotalRow'] >=1) {
    	        foreach($aData['longTerm'] as $key=>$val) {
    	            $sClassDate = $this->select('tb_class_schedule',"daystart", "class_idx = ".$val['main_idx'])->limit(0,1)->execute();
    	            $aData['longTerm'][$key]['classdate'] = $sClassDate[0]['daystart'];
    	            $aData['longTerm'][$key]['iCount'] = $aData['iTotalRow'] - $iOffset - $i;
    	            ++$i;
    	        }
    	    }
	    } else {
	        $aData['longTerm'] = null;
	        $aData['iTotalRow'] = 0;
	    }

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

		$this->display("class/tpl/classLpostponed", $aData);
	}
}