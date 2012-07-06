<?php

class membersModel extends Simplexi_controller
{
	private $TB_USER = 'tb_user';
	
	private $TB_SALES_PRODUCT = 'tb_sales_product';
	
	public function __construct()
	{
		parent::__construct();
		$this->TB_USER = 'tb_user';
	}
	
	public function getContents()
	{
		return $this->select($this->TB_USER,'','')->execute();
	}
	
	public function getApplied($sStartDate,$sEndDate,$iUserIdx)
	{
		return $this->query("SELECT COUNT(*) as total_applied FROM {$this->TB_SALES_PRODUCT} WHERE DATE_FORMAT(FROM_UNIXTIME(datetime_purchase),'%Y-%m-%d') BETWEEN '{$sStartDate}' AND '{$sEndDate}' AND branch_idx = {$iUserIdx}",'row');
	}
	
	public function getTotalUsers($iUserIdx)
	{
		return $this->selectRow($this->TB_USER,'COUNT(*) as total_user',"branch_idx = {$iUserIdx}")->execute();
	}
	
	public function getAge($sStartDate,$sEndDate,$iUserIdx)
	{
		return $this->select($this->TB_USER,'',"grade_idx != 9 AND DATE_FORMAT(FROM_UNIXTIME(date_reg),'%Y-%m-%d') BETWEEN '{$sStartDate}' AND '{$sEndDate}' AND branch_idx = {$iUserIdx}")->execute();
	}
	
	public function getBranch()
	{
		return $this->select($this->TB_USER,'','grade_idx = 8')->execute();
	}	
	
	public function getQuit($sStartDate,$sEndDate,$sWhereQuit,$iUserIdx)
	{
		return $this->query("SELECT COUNT(*) as total_quit FROM {$this->TB_USER} WHERE quit_flag = 1 AND  DATE_FORMAT(FROM_UNIXTIME(date_reg),'%Y-%m-%d') BETWEEN '{$sStartDate}' AND '{$sEndDate}' {$sWhereQuit}" ,'row');
	}
	
	public function getMemberJoined($sStartDate,$sEndDate,$iUserIdx)
	{
		return $this->query("SELECT COUNT(*) as total_joined_period FROM {$this->TB_USER} WHERE DATE_FORMAT(FROM_UNIXTIME(date_reg),'%Y-%m-%d') BETWEEN '{$sStartDate}' AND '{$sEndDate}' AND branch_idx = {$iUserIdx}" ,'row');		
	}
}