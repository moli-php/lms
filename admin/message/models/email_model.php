<?php

class Email_model extends Simplexi_controller
{
	private $TB_MSG_EMAIL = 'tb_msg_email_log';

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

	public function sendEmail()
	{
			$sEmail = $this->common->getParam('email');
    	    $sSubject = $this->common->getParam('subject');
    	    $sMessage = $this->common->getParam('message');
    	    $sFrom = "admin@lms.com";
			$headers = "From:" . $sFrom;
			

		$to = implode(',',$sEmail);


		if(mail($to,$sSubject,$sMessage,$headers)){
			return 'sent';
		}else{
			return 'failed';
		}
		
	}
	
	public function saveLogs()
	{
		$aQuery = $this->query('SELECT * FROM tb_user WHERE idx = "'. USER_ID .'"');
		$cBranch = $aQuery[0]['branch_idx']!='0' ? $aQuery[0]['branch_idx'] : USER_ID;

	    $sTitle = $this->common->getParam('title');
	    $sMessage = $this->common->getParam('message');
	    $sUserEmail = $this->common->getParam('email');
	    $sUser_emails = implode(',',$sUserEmail);
	    $iSent_Count = count($sUserEmail);
	    $sDate = date("m-d-y h:m:s A");

	    $aFields[] = array('mail_title' => $sTitle,'message' => $sMessage,'emails' => $sUser_emails,'sent_count' => $iSent_Count,'reg_date' => $sDate,'branch' => $cBranch);
	    $this->insert($this->TB_MSG_EMAIL, $aFields)->execute();

	}
	
	public function getDatas()
	{
		$iIdx = $this->common->getParam('id')=='' ? "":" WHERE idx='".$this->common->getParam('id')."'";
		$aContents = $this->selectAll($this->TB_MSG_EMAIL . $iIdx )->execute();
		return $aContents;
	}
		
	public function fileDel()
	{
		unlink($_SERVER['DOCUMENT_ROOT']."/uploads/csvtmp/".$this->common->getParam('name'));
			return $_SERVER['DOCUMENT_ROOT']."/uploads/csvtmp/".$this->common->getParam('name');
	}


}