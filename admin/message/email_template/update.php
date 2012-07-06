<?php
require_once('models/email_tpl_model.php');

class Update extends Simplexi_controller
{
	private $TB_MSG_EMAIL = 'tb_msg_templates';
	private $oModel;

	public function __construct()
	{
		parent::__construct();
		$this->oModel = new Email_tpl_model();
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

	public function del()
	{
	    $aResult = $this->oModel->getDelete();
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
	
	public function createTpl()
	{
	    $this->oModel->createTemp();
	}
	
	public function editTpl()
	{
	    $this->oModel->editTemp();
	}

}

$oAjax = new Update();
