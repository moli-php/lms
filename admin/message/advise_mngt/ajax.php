<?php
require_once('models/advise_model.php');

class Ajax extends Simplexi_controller
{
	private $TB_MSG_ADV = 'tb_msg_adv';
	private $oModel;
	
	public function __construct()
	{
		parent::__construct();
		$this->oModel = new Advise_model();
		$this->requestHandler();
		$this->library('tinymce');
		$this->library('common');
	}
	
	public function requestHandler()
	{
		$this->library('common');
		$this->common->getParams();
		$sMethod  = ($this->common->getParam('req') != "" ) ? $this->common->getParam('req') : "";
		$this->$sMethod();
	}
	
	public function view()
	{
		$aResult = $this->oModel->getView();
		($aResult['read_status']=='N') ? $this->oModel->updateReadStatus() : "";
		echo json_encode($aResult);
	}
	
	public function delete()
	{
		$aIdx = $this->common->getParam('arr_val');		
		if($aIdx)
		{
			$sIdx = implode(',',$aIdx);
			 $this->oModel->delete($sIdx);
		}
	}
	
	public function sendreply()
	{
		$this->oModel->saveReply();
	}
	
	public function read()
	{
		$aIdx = $this->common->getParam('arr_val');	
		
		foreach($aIdx as $iIdx)
		{
			$this->oModel->markRead($iIdx );
		}
	}	
	
	public function unread()
	{
		$aIdx = $this->common->getParam('arr_val');	
		
		foreach($aIdx as $iIdx)
		{
			$this->oModel->markUnread($iIdx );
		}
	}	
	
	public function getreply()
	{
		$aResult = $this->oModel->getReply();
		
		if($aResult)
		{
			echo json_encode( $aResult);
			return;
		}
		return false;
	}
	
	public function geMessageList()
	{
		$aInfo = array();
		$aData = array();
		$aContents = $this->oModel->getContents('','','');
		
		foreach($aContents as $rows)
		{
			$aData[] = array(
				'title' => $rows['title']
			);
		}
		$aInfo['aContents'] = $aData;
		
		$this->display('message/tpl/adv_mess_list_ajax',$aInfo,false);
	}
	
	public function viewCommon()
	{
		$aResult = $this->oModel->getViewCommon();
		($aResult['read_status']=='N') ? $this->oModel->updateReadStatus() : "";
		
		echo json_encode($aResult);
		
	}
	
	public function viewReplyCommon()
	{
		$aResult = $this->oModel->getReply();
		if($aResult)
		{
			echo json_encode( $aResult);
			return;
		}
		return false;
	}
	
	public function sendReplyCommon()
	{
		$this->oModel->saveReply();
	}	
}

$oAjax = new Ajax();