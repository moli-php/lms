<?php
require_once('models/email_model.php');

class Email_mngt extends Simplexi_Controller
{
    private $TB_MSG_EMAIL = 'tb_msg_email_log';
    private $oModel;

    public function run($aArgs)
    {
	
		

        $this->oModel = new Email_model();
		
		$this->library('tinymce');
		Tinymce::init();

        $aInfo = array();
        $aData = array();

        $this->library('common');
		$this->library("checkLogin");
	    $this->importJS('message/email_mngt');
		$this->importJS('message/message');
	    if(isset($aArgs['pageaction'])){
	        $sAction = $aArgs['pageaction'] == 'send_email' ? 'send_email' : 'error';
	    }else{
	        $sAction = 'email_mngt';
	    }
		

	    /*pagination*/

	    $aInfo['iRowPerPage'] = isset($aArgs['row']) ? $aArgs['row'] : '20';
	    $aInfo['iCurPage'] = isset($aArgs['page'])?$aArgs['page']:'1';


	    $iLimit =  ($aInfo['iCurPage'] - 1) * $aInfo['iRowPerPage'];
	    $iOffset = $aInfo['iRowPerPage'];
		
		$sSearch = isset($aArgs['keyword']) ? ' AND mail_title LIKE "%'.$aArgs['keyword'].'%"' : '';
		
		if(isset($aArgs['field']) && isset($aArgs['order'])) {
		
			if($aArgs['field']=='title'){
			$field = 'mail_title';
			}else if($aArgs['field']=='sent'){
			$field = 'sent_count';
			}else if($aArgs['field']=='reg'){
			$field = 'reg_date';
			}else{
			$field = 'mail_title';
			}
			
			$order = (($aArgs['order']=='asc')||($aArgs['order']=='desc'))? $aArgs['order']:'asc';

			$sOrder = ' ORDER BY '.$field.' '.$order;
		}else{
			$sOrder = ' ORDER BY idx desc';
		}
		
		$sBranch = USER_ID!='1' ? " WHERE branch=".USER_ID : " WHERE branch like '%%'";
		
	    $aContents = $this->selectAll($this->TB_MSG_EMAIL .$sBranch .$sSearch.$sOrder)->limit($iLimit, $iOffset)->execute();

	    $aAll = $this->selectAll($this->TB_MSG_EMAIL . $sBranch . $sSearch)->execute();
		$iTotalIdx = count($aAll);
	    $aInfo['iRowTotRow'] = $iTotalIdx;
		
		
		$aInfo['iNoCount'] =  isset($aArgs['page']) ? $iTotalIdx-$iLimit : $iTotalIdx;

		$sBranchidx = USER_ID!='1' ? " tbu.branch_idx=".USER_ID . " AND " : "";
		
		if(isset($aArgs['query'])){
			$sqlquery = $this->query('
									SELECT DISTINCT email FROM tb_user AS tbu 
									INNER JOIN tb_grade AS tbg ON tbg.grade_num = tbu.grade_idx
									LEFT JOIN tb_class AS class ON class.student_idx = tbu.idx 									
									WHERE '. $sBranchidx .' tbg.grade_num != "0" AND tbg.grade_num != "9" AND tbg.grade_num != "8" AND tbg.grade_num != "7" AND tbg.grade_num != "6" AND tbg.grade_num != "5"
										');
			if ($aArgs['query']=='all'){
				$sUserSearch = $sqlquery;
			}else if ($aArgs['query']=='option'){
				$agequery = '';
				$agehaving ='';
				$class = '';
					if(isset($aArgs['age'])){
						$range = explode('|',$aArgs['age']);
						$dateYear = date('Y-m-d');
						$getYY =  substr($dateYear,2,2);
						$agequery = ', FLOOR(DATEDIFF("'.$dateYear.'",CONCAT(CASE WHEN LEFT(ssn,2)>'.$getYY.' THEN "19" ELSE "20" END ,LEFT(ssn,2),"-",SUBSTRING(ssn,3,2),"-",SUBSTRING(ssn,5,2)))/366) AS age';
						$agehaving = ' HAVING age BETWEEN '.$range[0].' AND '.$range[1].' ';
					}
					
					if(isset($aArgs['apply']) && !isset($aArgs['class'])){
						$class = ' AND (class_status = "only_applied") ';
					}
					else if(isset($aArgs['class']) && !isset($aArgs['apply'])){
						$class = ' AND (class_status = "scheduled") ';
					}
					else if(isset($aArgs['apply']) && isset($aArgs['class'])){
						$class = ' AND (class_status = "only_applied" OR class_status = "scheduled") ';
					}
					

					
				$sUserSearch = $this->query('
						SELECT DISTINCT email'.$agequery.' FROM tb_user AS tbu 
						INNER JOIN tb_grade AS tbg ON tbg.grade_num = tbu.grade_idx
						LEFT JOIN tb_class AS class ON class.student_idx = tbu.idx 
						WHERE ('. $sBranchidx .' tbg.grade_num != "0" AND tbg.grade_num != "9" AND tbg.grade_num != "8" AND tbg.grade_num != "7" AND tbg.grade_num != "6" AND tbg.grade_num != "5")'. $class .$agehaving.'');
			}else{
				$sUserSearch = array(array('email'=>''));
			}
		
		}else{
		$sUserSearch = array(array('email'=>''));
		}
		
		$aInfo['aUserdata'] = $sUserSearch;
	    $aInfo['aData'] = $aContents;
	    $aInfo['aArgs'] = $aArgs;
		
		$aInfo['sPageTitle'] = "Email Management";

        $this->display("message/tpl/".$sAction,$aInfo);

    }
}

$oClass = new Email_mngt();
$oClass->run($aArgs);