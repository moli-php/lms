<?php
require_once('models/sms_model.php');

class Sms_mngt extends Simplexi_Controller
{
    private $TB_MSG_SMS = 'tb_msg_sms_log';
    private $oModel;

    public function run($aArgs)
    {
	
		

        $this->oModel = new Sms_model();
		
		$this->library('tinymce');
		Tinymce::init();

        $aInfo = array();
        $aData = array();

        $this->library('common');
		$this->library("checkLogin");
	    $this->importJS('message/sms_mngt');
		$this->importJS('message/message');
		$this->importJS('send_sms');
	    if(isset($aArgs['pageaction'])){

	        $sAction = $aArgs['pageaction'] == 'send_sms' ? 'send_sms' : 'error';

	    }else{
	        $sAction = 'sms_mngt';
	    }
		

	    /*pagination*/

	    $aInfo['iRowPerPage'] = isset($aArgs['row']) ? $aArgs['row'] : '20';
	    $aInfo['iCurPage'] = isset($aArgs['page'])?$aArgs['page']:'1';


	    $iLimit =  ($aInfo['iCurPage'] - 1) * $aInfo['iRowPerPage'];
	    $iOffset = $aInfo['iRowPerPage'];
		
		$sSearch = isset($aArgs['keyword']) ? ' AND message LIKE "%'.$aArgs['keyword'].'%"' : '';
		
		if(isset($aArgs['field']) && isset($aArgs['order'])) {
		
			if($aArgs['field']=='message'){
			$field = 'message';
			}else if($aArgs['field']=='sent'){
			$field = 'sent_count';
			}else if($aArgs['field']=='reg'){
			$field = 'reg_date';
			}else{
			$field = 'message';
			}
			
			$order = (($aArgs['order']=='asc')||($aArgs['order']=='desc'))? $aArgs['order']:'asc';

			$sOrder = ' ORDER BY '.$field.' '.$order;
		}else{
			$sOrder = ' ORDER BY idx desc';
		}
		
		$sBranch = USER_ID!='1' ? " WHERE branch=".USER_ID : " WHERE branch like '%%' ";
		
	    $aContents = $this->selectAll($this->TB_MSG_SMS .$sBranch .$sSearch.$sOrder)->limit($iLimit, $iOffset)->execute();

	    $aAll = $this->selectAll($this->TB_MSG_SMS . $sBranch . $sSearch)->execute();
		$iTotalIdx = count($aAll);
	    $aInfo['iRowTotRow'] = $iTotalIdx;
		
		$aSmsTemplate = $this->selectAll('tb_msg_sms_templates' .$sBranch)->execute();
		$sSiteinfo = $this->query('SELECT fphone_number FROM tb_site_configuration WHERE branch_idx = "'.USER_ID.'"');
		
		$aInfo['iNoCount'] =  isset($aArgs['page']) ? $iTotalIdx-$iLimit : $iTotalIdx;

		$sBranchidx = USER_ID!='1' ? " tbu.branch_idx=".USER_ID . " AND " : "";
		
		if(isset($aArgs['query'])){
			$sqlquery = $this->query('
									SELECT DISTINCT phone_mob FROM tb_user AS tbu 
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
						SELECT DISTINCT phone_mob'.$agequery.' FROM tb_user AS tbu 
						INNER JOIN tb_grade AS tbg ON tbg.grade_num = tbu.grade_idx
						LEFT JOIN tb_class AS class ON class.student_idx = tbu.idx 
						WHERE ('. $sBranchidx .' tbg.grade_num != "0" AND tbg.grade_num != "9" AND tbg.grade_num != "8" AND tbg.grade_num != "7" AND tbg.grade_num != "6" AND tbg.grade_num != "5")'. $class .$agehaving.'');
			}else{
				$sUserSearch = array(array('phone_mob'=>''));
			}
		
		}else{
		$sUserSearch = array(array('phone_mob'=>''));
		}
		
		$aInfo['aUserdata'] = $sUserSearch;
	    $aInfo['aData'] = $aContents;
		$aInfo['aSmsTemplate'] = $aSmsTemplate;
		$sSiteinfo_ = $sSiteinfo ==null ? "" : $sSiteinfo[0]['fphone_number'];
		$aInfo['sSiteinfo'] = $sSiteinfo_;
	    $aInfo['aArgs'] = $aArgs;
		
		$aInfo['sPageTitle'] = "SMS Management";

        $this->display("message/tpl/".$sAction,$aInfo);

    }
}

$oClass = new Sms_mngt();
$oClass->run($aArgs);