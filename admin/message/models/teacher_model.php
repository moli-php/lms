<?php

class Teacher_model extends Simplexi_controller
{
	private $TB_MSG_ADV_TEACHER = 'tb_msg_adv_teacher';
	private $TB_USER = 'tb_user';
	
	public function __construct()
	{
		parent::__construct();
		$this->library('common');
		$this->common->getParams();
	}
	
	public function getContents($sWhere,$sLimit,$sOrderBy)
	{
		return $this->query("SELECT 
			tba.idx as tba_idx,
			tbu.user_id as user_id,
			tba.user_idx as user_idx,
			tba.title as title,
			tba.message as message,
			tba.read_status as read_status,			
			tba.date_sent as date_sent		
		FROM {$this->TB_MSG_ADV_TEACHER} as tba LEFT JOIN {$this->TB_USER} as tbu ON tbu.idx = tba.user_idx {$sWhere} {$sOrderBy} {$sLimit}");
	}
	
	public function getCount($sWhere)
	{
		return $this->query("SELECT * FROM {$this->TB_MSG_ADV_TEACHER} $sWhere");
	}
	
	public function updateReadStatus()
	{
		$aData = array(
			'read_status' => "Y"
		);	
		$this->update($this->TB_MSG_ADV_TEACHER,$aData,"idx = {$this->common->getParam('idx')}")->execute();
	}	
	
	public function getView()
	{
		return $this->selectRow($this->TB_MSG_ADV_TEACHER,'', "idx = {$this->common->getParam('idx')}")->execute();
	}
	
	public function getReply()
	{
		return $this->selectRow($this->TB_MSG_ADV_TEACHER,'*, DATE_FORMAT( FROM_UNIXTIME( date_sent ), "%Y-%m-%d" ) as date_sent',"parent_idx = {$this->common->getParam('parent')}")->execute();	
	}
	
	public function saveReply()
	{
		$aData = array(
			'parent_idx' => $this->common->getParam('parent'),
			'title' => $this->common->getParam('reply_title'),
			'message' => $this->common->getParam('reply_message'),
			'read_status' => 'N',
			'date_sent' => time(),
		);
		
		$this->insert($this->TB_MSG_ADV_TEACHER,$aData)->execute();
	}	
}