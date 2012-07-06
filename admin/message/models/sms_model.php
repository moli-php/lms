<?php

class Sms_model extends Simplexi_controller
{
	private $TB_MSG_SMS = 'tb_msg_sms_log';

	public function __construct()
	{
		parent::__construct();
		$this->library('common');
		$this->common->getParams();
	}
	public function getDelete()
	{
	     $aContents = $this->selectAll($this->TB_MSG_SMS)->execute();
	     $list_count = count($aContents);

	    $idxs = $this->common->getParam('idx');
	    foreach ($idxs as $item){
            $sWhere = "idx  = ".$item;
            $this->deleteBy($this->TB_MSG_SMS,$sWhere )->execute();
	    }

	    $aContents1 = $this->selectAll($this->TB_MSG_SMS)->execute();

	    if(count($aContents1)!=$list_count){
	        return 'delete';
	    }else{
	        return 'error';
	    }
	}
	
	
	public function getDatas()
	{
		$iIdx = $this->common->getParam('id')=='' ? "":" WHERE idx='".$this->common->getParam('id')."'";
		$aContents = $this->selectAll($this->TB_MSG_SMS . $iIdx )->execute();
		return $aContents;
	}
		
	public function fileDel()
	{
		unlink($_SERVER['DOCUMENT_ROOT']."/uploads/csvtmp/".$this->common->getParam('name'));
			return $_SERVER['DOCUMENT_ROOT']."/uploads/csvtmp/".$this->common->getParam('name');
	}
	
	public function getTemplates()
	{
		$aQuery = $this->query('SELECT * FROM tb_user WHERE idx = "'. USER_ID .'"');
		$cBranch = $aQuery[0]['branch_idx']!='0' ? $aQuery[0]['branch_idx'] : USER_ID;
		
		$sBranch = $cBranch!='1' ? " WHERE branch=". $cBranch : "";
		$aContents = $this->selectAll('tb_msg_sms_templates' . $sBranch )->execute();
		$sSiteinfo = $this->query('SELECT fphone_number FROM tb_site_configuration WHERE branch_idx = "'. $cBranch .'"');
		return array($aContents,$sSiteinfo);
		
	}
	public function saveTpls()
	{
		$aQuery = $this->query('SELECT * FROM tb_user WHERE idx = "'. USER_ID .'"');
		$cBranch = $aQuery[0]['branch_idx']!='0' ? $aQuery[0]['branch_idx'] : USER_ID;
		
	    $sTitle = $this->common->getParam('title');
	    $sMessage = $this->common->getParam('msg');

	    $aFields[] = array('tpl_title' => $sTitle,'tpl_message' => $sMessage,'branch' => $cBranch);
	    $this->insert('tb_msg_sms_templates', $aFields)->execute();
		return 'save';
		
	}
	public function deltplLogs()
	{
	     $aContents = $this->selectAll('tb_msg_sms_templates')->execute();
	     $list_count = count($aContents);

		$sWhere = "idx  = ".$this->common->getParam('idx');
		$this->deleteBy('tb_msg_sms_templates',$sWhere )->execute();

	    $aContents1 = $this->selectAll('tb_msg_sms_templates')->execute();

	    if(count($aContents1)!=$list_count){
	        return 'delete';
	    }else{
	        return 'error';
	    }
	}
	public function getdatatpls()
	{
		$iIdx = " WHERE idx='".$this->common->getParam('idx')."'";
		$aContents = $this->selectAll('tb_msg_sms_templates' . $iIdx )->execute();
		return $aContents;
	}
	public function save_edittpls()
	{
		$sTableName = "tb_msg_sms_templates";
	    $sTitle = $this->common->getParam('title');
	    $sMessage = $this->common->getParam('msg');

	    $aFields = array('tpl_title' => $sTitle,'tpl_message' => $sMessage);
		$sWhere = 'idx ='.$this->common->getParam('idx');
	    $this->update($sTableName,$aFields,$sWhere )->execute();
		return 'save';
	}

}