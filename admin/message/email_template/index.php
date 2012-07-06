<?php
require_once('models/email_model.php');

class Email_template extends Simplexi_Controller
{
    private $TB_MSG_EMAIL = 'tb_msg_templates';
    private $oModel;

    public function run($aArgs)
    {

        $this->oModel = new Email_model();
		
		$this->library('tinymce');
		Tinymce::init();

        $aInfo = array();
        $aData = array();

        $this->library('common');
	    $this->importJS('message/email_template');

	    /*pagination*/

	    $aInfo['iRowPerPage'] = isset($aArgs['row']) ? $aArgs['row'] : '20';
	    $aInfo['iCurPage'] = isset($aArgs['page'])?$aArgs['page']:'1';

	    $iLimit =  ($aInfo['iCurPage'] - 1) * $aInfo['iRowPerPage'];
	    $iOffset = $aInfo['iRowPerPage'];
		
		$sSearch = isset($aArgs['keyword']) ? ' AND tpl_title LIKE "%'.$aArgs['keyword'].'%"' : '';
		
		if(isset($aArgs['field']) && isset($aArgs['order'])) {
		
			if($aArgs['field']=='title'){
			$field = 'tpl_title';
			}else if($aArgs['field']=='reg'){
			$field = 'reg_date';
			}else{
			$field = 'tpl_title';
			}
			$order = (($aArgs['order']=='asc')||($aArgs['order']=='desc'))? $aArgs['order']:'asc';
			$sOrder = ' ORDER BY '.$field.' '.$order;
		}else{
			$sOrder = ' ORDER BY idx desc';
		}
		
		$sBranch = USER_ID!='1' ? " WHERE branch=".USER_ID : " WHERE branch like '%%' ";
		
	    $aContents = $this->selectAll($this->TB_MSG_EMAIL . $sBranch .$sSearch.$sOrder)->limit($iLimit, $iOffset)->execute();

	    $aAll = $this->selectAll($this->TB_MSG_EMAIL . $sBranch . $sSearch)->execute();
		$iTotalIdx = count($aAll);
	    $aInfo['iRowTotRow'] = $iTotalIdx;
		
		$aInfo['sPageTitle'] = "Email Templates";
		
		$aInfo['iNoCount'] =  isset($aArgs['page']) ? $iTotalIdx-$iLimit : $iTotalIdx;
	    $aInfo['aData'] = $aContents;
	    $aInfo['aArgs'] = $aArgs;
        $this->display("message/tpl/email_template",$aInfo);

    }
}

$oClass = new Email_template();
$oClass->run($aArgs);