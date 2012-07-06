<?php
require_once('models/email_model.php');

class Update extends Simplexi_controller
{
	private $TB_MSG_EMAIL = 'tb_msg_email_log';
	private $oModel;

	public function __construct()
	{
		parent::__construct();
		$this->oModel = new Email_model();
		$this->requestHandler();
	}

    /*get the value of 'req'*/
	public function requestHandler()
	{
		$this->library('common');
		$this->common->getParams();
		$sMethod  = ($this->common->getParam('req') != "" ) ? $this->common->getParam('req') : "";
		$this->$sMethod();
	}

	/*condition*/

	/* Delete Logs*/
	public function del()
	{
	    $aResult = $this->oModel->getDelete();
		echo json_encode($aResult);
	}

	/* Send Mail */
	public function sendMail()
	{
	   $aResult = $this->oModel->sendEmail();
		echo json_encode($aResult);
	}
	public function saveLog()
	{
	    $this->oModel->saveLogs();
	}
	
	public function getData()
	{
	    $aResult = $this->oModel->getDatas();
		echo json_encode($aResult);
	}
	public function delfile()
	{
	   $aResult = $this->oModel->fileDel();
	   echo json_encode($aResult);
	}
	

}

$oAjax = new Update();
