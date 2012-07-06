<?php

class Advise_model extends Simplexi_controller
{
	private $TB_MSG_ADV = 'tb_msg_adv';
	private $TB_USER = 'tb_user';
	
	public function __construct()
	{
		parent::__construct();
		$this->library('common');
		$this->common->getParams();
	}
	
	public function getContents($sWhere,$sOrderBy,$sLimit)
	{
		return $this->query("
			SELECT 
			tba.idx as tba_idx,
			tbu.user_id as user_id,
			tba.title as title,
			tba.message as message,
			tba.read_status as read_status,			
			tba.date_reg as date_reg		
			FROM {$this->TB_MSG_ADV} as tba LEFT join 
			{$this->TB_USER} as tbu ON tbu.idx = tba.user_idx
			{$sWhere} {$sOrderBy} {$sLimit}"
		);
	}
	
	public function getCountContents($sWhere)
	{
	
		return $this->query("
			SELECT 
			 COUNT(*) as total_rows FROM {$this->TB_MSG_ADV} as tba LEFT join 
			{$this->TB_USER} as tbu ON tbu.idx = tba.user_idx
			{$sWhere}"
		,'row');	
	}
	
	public function getView()
	{
		return $this->selectRow($this->TB_MSG_ADV,'*, DATE_FORMAT(FROM_UNIXTIME(date_reg),"%Y-%m-%d") as date_registered',' idx = ' . $this->common->getParam('idx'))->execute();
	}	
	
	public function updateReadStatus()
	{
		$aData = array(
			'read_status' => "Y"
		);
		
		$this->update($this->TB_MSG_ADV,$aData,"idx = {$this->common->getParam('idx')}")->execute();
	}
	
	public function getTotal($sAndView)
	{
		return $this->select($this->TB_MSG_ADV,'','parent_idx = 0 ' . $sAndView )->execute();
	}
	
	public function getRead($sAndView)
	{
		return $this->select($this->TB_MSG_ADV,'',"parent_idx = 0 AND read_status = 'Y' " . $sAndView )->execute();
	}		
	
	public function getUnread($sAndView)
	{
		return $this->select($this->TB_MSG_ADV,'',"parent_idx = 0 AND read_status = 'N' " . $sAndView )->execute();
	}	
	
	public function delete($sIdx)
	{
		$this->query("DELETE FROM {$this->TB_MSG_ADV} WHERE idx in({$sIdx})");
	}
	
	public function markRead($iIdx)
	{
		$aData = array(
			'read_status' => 'Y'
		);
		$this->update($this->TB_MSG_ADV,$aData,"idx = $iIdx")->execute();
	}	
	
	public function markUnread($iIdx)
	{
		$aData = array(
			'read_status' => 'N'
		);
		$this->update($this->TB_MSG_ADV,$aData,"idx = $iIdx")->execute();
	}
	
	public function saveReply()
	{
		$aData = array(
			'parent_idx' => $this->common->getParam('parent'),
			'title' => $this->common->getParam('reply_title'),
			'message' => $this->common->getParam('reply_message'),
			'read_status' => 'N',
			'date_reg' => time(),
		);
		
		$this->insert($this->TB_MSG_ADV,$aData)->execute();
	}
	
	public function getReply()
	{
		return $this->selectRow($this->TB_MSG_ADV,'*, DATE_FORMAT(FROM_UNIXTIME(date_reg),"%Y-%m-%d") as date_registered',"parent_idx = {$this->common->getParam('parent')}")->execute();
	}
	
	public function getContentsCommon($sWhere,$sOrderBy,$sLimit)
	{
		return $this->query("
			SELECT 
			tba.idx as tba_idx,
			tbu.user_id as user_id,
			tba.title as title,
			tba.message as message,
			tba.read_status as read_status,			
			tba.date_reg as date_reg		
			FROM {$this->TB_MSG_ADV} as tba LEFT join 
			{$this->TB_USER} as tbu ON tbu.idx = tba.user_idx
			{$sWhere} {$sOrderBy} {$sLimit}
			"
		);
	}
	
	
	public function getCountContentsCommon($sWhere)
	{
		return $this->query("
			SELECT 
			 COUNT(*) as total_rows FROM {$this->TB_MSG_ADV} as tba LEFT join 
			{$this->TB_USER} as tbu ON tbu.idx = tba.user_idx
			{$sWhere}"
		,'row');
	}	
	
	public function getTotalCommon($iUserIdx)
	{
		return $this->select($this->TB_MSG_ADV,'',"user_idx = {$iUserIdx}")->execute();
	}
	
	public function getUnreadCommon($sAndView)
	{
		return $this->select($this->TB_MSG_ADV,'','read_status = "N" ' . $sAndView )->execute();
	}	

	public function getReadCommon($sAndView)
	{
		return $this->select($this->TB_MSG_ADV,'','read_status = "Y" ' . $sAndView )->execute();
	}	
	
	public function getViewCommon()
	{
		return $this->selectRow($this->TB_MSG_ADV,'*, DATE_FORMAT(FROM_UNIXTIME(date_reg),"%Y-%m-%d") as date_registered',' idx = ' . $this->common->getParam('idx'))->execute();

	}
}