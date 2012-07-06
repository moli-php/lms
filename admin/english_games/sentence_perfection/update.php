<?php
require_once('models/sentence_perfection_model.php');

class Update extends Simplexi_controller
{
	private $TB_MSG_EMAIL = 'tb_msg_email_log';
	private $oModel;

	public function __construct()
	{
		parent::__construct();
		$this->oModel = new Sentence_perfection_model();
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

	public function saveData()
	{
	    $aResult = $this->oModel->saveDatas();
		echo json_encode($aResult);
	}
	public function del()
	{
	    $aResult = $this->oModel->dels();
		echo json_encode($aResult);
	}
	public function updatestat()
	{
	    $aResult = $this->oModel->updatestats();
		echo json_encode($aResult);
	}
	public function getData()
	{
	    $aResult = $this->oModel->getDatas();
		echo json_encode($aResult);
	}

	

}

$oAjax = new Update();
