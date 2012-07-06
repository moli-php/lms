<?php

require_once('models/teacher_model.php');

class Ajax_teacher extends Simplexi_controller
{
	private $oModel;
	
	public function __construct()
	{
		parent::__construct();
		$this->oModel = new Teacher_model();
		$this->requestHandler();
	}
	
	public function requestHandler()
	{
		$this->library('common');
		$this->common->getParams();	
		$sMethod  = ($this->common->getParam('req') != "" ) ? $this->common->getParam('req') : "";
		$this->$sMethod();
	}
	
	public function setContainer()
	{
		$aInfo = array();
		$sWhere = "WHERE teacher_idx = " . USER_ID;
		$aTotalContents = $this->oModel->getCount($sWhere);
		$aInfo['total_contents'] = count($aTotalContents);
		$this->display('message/tpl/adv_mess_cont',$aInfo,false);
	}
	
	public function getTeacherMessageList()
	{
		$aInfo = array();
		$aData = array();
		$iPage = $this->common->getParam('page');
		$iOffset = ($iPage - 1) *  10;
		$sLimit = "LIMIT {$iOffset}, 10";
		$sOrderBy = "ORDER BY {$this->common->getParam('as')}.{$this->common->getParam('field')} {$this->common->getParam('sort')}";
		$sWhere = "";
		
		$sWhere = " WHERE tba.parent_idx != 0 AND tba.teacher_idx = " . USER_ID;	
		$sWhere1 = " WHERE parent_idx != 0 AND teacher_idx = " . USER_ID;	
		
		if($this->common->getParam('status')==0)
		{
			$sWhere = " WHERE tba.parent_idx = 0 AND tba.teacher_idx = " . USER_ID;	
			$sWhere1 = " WHERE parent_idx = 0 AND teacher_idx = " . USER_ID;	
		}		
		
		$aContents = $this->oModel->getContents($sWhere,$sLimit,$sOrderBy);
		$aCount = $this->oModel->getCount($sWhere1);
		
		foreach($aContents as $rows)
		{
			$aData[] = array(
				'idx' => $rows['tba_idx'],
				'user_id' => $rows['user_id'],
				'title' => $rows['title'],
				'status' => $rows['read_status'],
				'date_sent' => $rows['date_sent']
			);
		}		
		$aInfo['aContents'] = $aData;
		$aInfo['aCount'] = $aCount;
		$this->display('message/tpl/adv_mess_list_ajax',$aInfo,false);
	}
	
	public function getView()
	{
		$aResult = $this->oModel->getView();
		($aResult['read_status']=='N') ? $this->oModel->updateReadStatus() : "";
		echo json_encode($aResult);
	}
	
	public function getReplyMessage()
	{
		$aResult = $this->oModel->getReply();
		echo json_encode($aResult);
	}
	
	public function sendreply()
	{
		$this->oModel->saveReply();
	}
}

$oAjaxTeacher = new Ajax_teacher();