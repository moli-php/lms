<?php

class Email_tpl_model extends Simplexi_controller
{
	private $TB_MSG_EMAIL = 'tb_msg_templates';

	public function __construct()
	{
		parent::__construct();
		$this->library('common');
		$this->common->getParams();
	}
	public function getDelete()
	{
	     $aContents = $this->selectAll($this->TB_MSG_EMAIL)->execute();
	     $list_count = count($aContents);

	    $idxs = $this->common->getParam('idx');
	    foreach ($idxs as $item){
            $sWhere = "idx  = ".$item;
            $this->deleteBy($this->TB_MSG_EMAIL,$sWhere )->execute();
	    }

	    $aContents1 = $this->selectAll($this->TB_MSG_EMAIL)->execute();

	    if(count($aContents1)!=$list_count){
	        return 'delete';
	    }else{
	        return 'error';
	    }
	}

	
	public function getDatas()
	{
		$aQuery = $this->query('SELECT * FROM tb_user WHERE idx = "'. USER_ID .'"');
		$cBranch = $aQuery[0]['branch_idx']!='0' ? $aQuery[0]['branch_idx'] : USER_ID;	

		$iIdx = $this->common->getParam('id')=='' ? "":" AND idx='".$this->common->getParam('id')."'";
		$sBranch = $cBranch!='1' ? " WHERE branch=".$cBranch : " WHERE branch like '%%' ";
		$aContents = $this->selectAll($this->TB_MSG_EMAIL . $sBranch . $iIdx )->execute();
		return $aContents;
	}
	
	public function createTemp()
	{
		$aQuery = $this->query('SELECT * FROM tb_user WHERE idx = "'. USER_ID .'"');
		$cBranch = $aQuery[0]['branch_idx']!='0' ? $aQuery[0]['branch_idx'] : USER_ID;
		
		$sTableName = "tb_msg_templates";
	    $sTitle = $this->common->getParam('title');
	    $sMessage = $this->common->getParam('message');
	    $sDate = date("m-d-y h:m:s A");

	    $aFields[] = array('tpl_title' => $sTitle,'message' => $sMessage,'reg_date' => $sDate,'branch' => $cBranch);
	    $this->insert($sTableName, $aFields)->execute();
	
	}
	public function editTemp()
	{
		$sTableName = "tb_msg_templates";
	    $sTitle = $this->common->getParam('title');
	    $sMessage = $this->common->getParam('message');
	    $sDate = date("m-d-y h:m:s A");

	    $aFields = array('tpl_title' => $sTitle,'message' => $sMessage,'reg_date' => $sDate);
		$sWhere = 'idx ='.$this->common->getParam('idedit');
	    $this->update($sTableName,$aFields,$sWhere )->execute();

	}


}