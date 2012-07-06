<?php
require_once('models/sms_model.php');
require_once('models/send_sms.php');

class Update extends Simplexi_controller
{
	private $TB_MSG_EMAIL = 'tb_msg_sms_log';
	private $oModel;
	private $oModelSms;

	public function __construct()
	{
		parent::__construct();
		$this->oModel = new Sms_model();
		$this->oModelSms = new Send_sms();
		$this->requestHandler();
	}
	
	public function del()
	{
	    $aResult = $this->oModel->getDelete();
		echo json_encode($aResult);
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
	public function getTpl()
	{
	   $aResult = $this->oModel->getTemplates();
	   echo json_encode($aResult);
	}
	public function savetpl()
	{
	    $aResult = $this->oModel->saveTpls();
		echo json_encode($aResult);
	}	
	public function deltplLog()
	{
	    $aResult = $this->oModel->deltplLogs();
		echo json_encode($aResult);
	}
	public function getdatatpl()
	{
	    $aResult = $this->oModel->getdatatpls();
		echo json_encode($aResult);
	}
	public function save_edittpl()
	{
	    $aResult = $this->oModel->save_edittpls();
		echo json_encode($aResult);
	}
	public function sendSms()
	{
	    $aResult = $this->oModelSms->sendsms();
		echo json_encode($aResult);
	}

}

$oAjax = new Update();
