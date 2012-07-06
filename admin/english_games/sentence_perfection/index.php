<?php
require_once('models/sentence_perfection_model.php');

class Sentence_perfection extends Simplexi_Controller
{
    private $TB_GAME = 'tb_game_sentence';
    private $oModel;

    public function run($aArgs)
    {
	
		

        $this->oModel = new Sentence_perfection_model();
        $aInfo = array();
        $aData = array();

        $this->library('common');
		$this->library("checkLogin");
		$this->importJS('english_games/sentence_perfection');
		

		/*pagination*/

	    $aInfo['iRowPerPage'] = isset($aArgs['row']) ? $aArgs['row'] : '20';
	    $aInfo['iCurPage'] = isset($aArgs['page'])?$aArgs['page']:'1';


	    $iLimit =  ($aInfo['iCurPage'] - 1) * $aInfo['iRowPerPage'];
	    $iOffset = $aInfo['iRowPerPage'];
		
		$sSearch = isset($aArgs['keyword']) ? ' AND question LIKE "%'.$aArgs['keyword'].'%"' : '';
		
		if(isset($aArgs['field']) && isset($aArgs['order'])) {
		
			if($aArgs['field']=='question'){
			$field = 'question';
			}else if($aArgs['field']=='answer'){
			$field = 'answer';
			}else if($aArgs['field']=='level'){
			$field = 'level';
			}else if($aArgs['field']=='point'){
			$field = 'point';
			}else if($aArgs['field']=='status'){
			$field = 'status';
			}else{
			$field = 'mail_title';
			}
			
			$order = (($aArgs['order']=='asc')||($aArgs['order']=='desc'))? $aArgs['order']:'asc';

			$sOrder = ' ORDER BY '.$field.' '.$order;
		}else{
			$sOrder = ' ORDER BY idx desc';
		}

		if(isset($aArgs['status'])){
			if($aArgs['status']=='Published' || $aArgs['status']=='Unpublished'){
				$sStatus = ' AND status = "'.$aArgs['status'].'"';
			}else{
				$sStatus = '';
			}
		
		}else{
			$sStatus = '';
		}
		
		$sBranch = USER_ID!='1' ? " WHERE branch=".USER_ID . $sStatus: " WHERE branch like '%%' " . $sStatus;
		
		$aContents = $this->selectAll($this->TB_GAME .$sBranch .$sSearch.$sOrder)->limit($iLimit, $iOffset)->execute();
	    $aAll = $this->selectAll($this->TB_GAME . $sBranch . $sSearch)->execute();
		$iTotalIdx = count($aAll);
	    $aInfo['iRowTotRow'] = $iTotalIdx;
		
		$sBranch_stat = USER_ID == 1 ? "like '%%'" : "=". USER_ID;
		
		$aPublish = $this->selectAll($this->TB_GAME . " WHERE branch ".$sBranch_stat." AND status='Published'")->execute();
		$aInfo['aPublish'] = count($aPublish);
		$aUnpublish = $this->selectAll($this->TB_GAME . " WHERE branch ".$sBranch_stat." AND status='Unpublished'")->execute();
		$aInfo['aUnpublish'] = count($aUnpublish);

		$aInfo['iNoCount'] =  isset($aArgs['page']) ? $iTotalIdx-$iLimit : $iTotalIdx;
		
	    $aInfo['aArgs'] = $aArgs;
		$aInfo['aData'] = $aContents;
		$aAction = isset($aArgs['action']) ? $aArgs['action'] : "sentence_perfection";
        $this->display("english_games/tpl/".$aAction,$aInfo);

    }
}

$oClass = new Sentence_perfection();
$oClass->run($aArgs);