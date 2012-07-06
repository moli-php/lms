<?php if( !defined('DIRECT_ACCESS') ) exit("No Direct Access!");

class visitorModel extends Simplexi_controller
{
	private $TB_STAT_VISITOR_LOG = 'tb_stat_visitor_log';
	private $TB_STAT_REFERER_LOG = 'tb_stat_referer_log';
	private $USER = 'tb_user';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getContents($sDate,$iUserIdx)
	{
		return $this->selectRow($this->TB_STAT_VISITOR_LOG,'COUNT(*) as total_rows',"
		DATE_FORMAT(FROM_UNIXTIME(date_visit),'%Y-%m-%d') = '{$sDate}' AND
		branch_idx = {$iUserIdx}
		")->execute();
	}
	
	public function getTime( $sStartTime , $sEndTime , $sDate,$iUserIdx )
	{
		return $this->selectRow($this->TB_STAT_VISITOR_LOG,'COUNT(*) as total_rows',"
		DATE_FORMAT(FROM_UNIXTIME(date_visit),'%H:%i') BETWEEN '{$sStartTime}' AND '{$sEndTime}' AND
		DATE_FORMAT(FROM_UNIXTIME(date_visit),'%Y-%m-%d') = '{$sDate}' AND
		branch_idx = {$iUserIdx}
		")->execute();
	}	
	
	public function getBranch()
	{
		return $this->select($this->USER,'','grade_idx = 8')->execute();
	}	
	
	public function getReferer()
	{
		return $this->query("SELECT DISTINCT(referer),COUNT(referer) as total_referer FROM {$this->TB_STAT_REFERER_LOG} GROUP BY referer");
		// return $this->select($this->TB_STAT_REFERER_LOG,'')->execute();
	}
}