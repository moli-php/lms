<?php if(!defined('DIRECT_ACCESS')) exit("No Direct Access!");

require_once('models/visitorModel.php');
require_once('includes/helpers.php');

class visitorStat extends Simplexi_controller
{

	private $visitorModel = NULL;
	private $iMaxVisitor = 100;
	
	public function __construct()
	{
		parent::__construct();		
		$this->visitorModel = new visitorModel();

		
	}
	
	public function run($aArgs)
	{
		$aInfo = array();		
		
		$this->library('common');		
		
		$this->importJs('statistics/admin_visitor');		
		
		$this->importCSS('statistics/admin');		
		
		$iBranchIdx = isset($aArgs['b']) ? $aArgs['b'] : "";
		
		$iUserIdx = ( USER_GRADE == 9 ) ? $iBranchIdx : USER_ID;
		
		$aInfo['start_date'] = isset($aArgs['start_date']) ? $aArgs['start_date'] : "";
		
		$aInfo['end_date'] = isset($aArgs['end_date']) ? $aArgs['end_date'] : "";
		
		$aStartDate = ymdDate($aInfo['start_date'],'array');
		
		$aEndDate = ymdDate($aInfo['end_date'],'array');	

		$sStartDate = ymdDate($aInfo['start_date']);
		
		$sEndDate = ymdDate($aInfo['end_date']);	
		
		$aInfo['aMonth'] = 	$this->_getDays($aInfo['start_date'],$aInfo['end_date'],$iUserIdx);		
		
		$aInfo['aTime'] = $this->_getTime($aInfo['start_date'],$aInfo['end_date'],$iUserIdx);
		
		$aInfo['aReferer'] = $this->visitorModel->getReferer();
		
		$aInfo['aContentsBranch'] = $this->visitorModel->getBranch();
		
		$aInfo['sStartDateLabel'] = date('M d, Y',mktime(0,0,0,$aStartDate[0],$aStartDate[1],$aStartDate[2]));
		
		$aInfo['sEndDateLabel'] = date('M d, Y',mktime(0,0,0,$aEndDate[0],$aEndDate[1],$aEndDate[2]));
		
		$aInfo['iUserIdx'] = $iUserIdx;	
		
		$aInfo['iMaxVisitor'] = $this->iMaxVisitor;
		
		$this->display("statistics/tpl/visitorStat",$aInfo);
	}
	
	private function _getDateRange($sStartDate,$sEndDate)
	{
		$aDate = array();
		$aMerge = array();
		$aMonth = array();

		$aStartDate = ymdDate( $sStartDate , 'array' );

		$aEndDate = ymdDate( $sEndDate , 'array' );	

		$iStartTime = mktime( 0 , 0, 0, $aStartDate[0], $aStartDate[1], $aStartDate[2] );

		$iEndTime = mktime( 0 , 0, 0, $aEndDate[0], $aEndDate[1], $aEndDate[2] );
		
		$aStartDateGet = getDate( $iStartTime );

		$aEndDateGet = getDate( $iEndTime );

		$iStartMonthNum = $aStartDateGet['mon'];

		$iEndMonthNum = $aEndDateGet['mon'];
		
		$iStartYear = $aStartDateGet['year'];
		
		$iEndYear = $aEndDateGet['year'];		
		
		$iStartDays =  $aStartDateGet['mday'];
		
		$iEndDays =  $aEndDateGet['mday'];
		
		$iYearRange = ( $iEndYear - $iStartYear );
		
		$iYear = 0;
		
		for( $i = $iStartYear ; $i <= $iEndYear; $i++ )
		{
			$iStartDate = ( $i < $iEndYear ) ? 12 : $iEndMonthNum;
			
			$iStartInc = ( $iYear < 1 ) ? $iStartMonthNum : 1;
			
			$iIncYear = ($iStartDate < $iEndYear) ? ( $iStartYear + $iYear ) : $iStartYear;
			
			for( $j = $iStartInc ; $j <= $iStartDate ; $j++ )
			{
				$iTotalMonth = date('t', mktime( 0, 0, 0, $j,1,$iIncYear ) );
				
				$iMonthName = date('M', mktime( 0, 0, 0, $j,1,$iIncYear ) );
				
				$iYearNum = date('Y', mktime( 0, 0, 0, $j,1,$iIncYear ) );
				
				$aDate[] = array
				(
					'month_int' => str_pad( $j , 2 , 0 , STR_PAD_LEFT ),
					'month_name' => $iMonthName,
					'start' => $iStartDays,
					'end' => $iEndDays,
					'year' => $iYearNum,
					'total_days' => $iTotalMonth				
				);
			}
			$iYear++;
		}
		
		$k = 0;
		
		foreach($aDate as $rows)
		{
			$iStartDayLoop = ($k==0) ? $rows['start'] : 1;
			
			$iEndDayLoop = ($rows['month_int'] . '-' . $rows['year'] ==  $aEndDate[0] . '-' . $aEndDate[2] ) ? $rows['end'] : $rows['total_days'];

			for( $i = $iStartDayLoop; $i <= $iEndDayLoop; $i++ )
			{
				$aMonth[] = array
				(
					'month_int' => $rows['month_int'],
					'month' => $rows['month_name'],
					'day' => str_pad($i,2,0,STR_PAD_LEFT),
					'year' => $rows['year']
				);				
				$k++;
			}
		}
		
		return $aMonth;
	}
	
	public function _getDays($sStartDate,$sEndDate,$iUserIdx)
	{
		$aMonth = array();
		$aDate = $this->_getDateRange($sStartDate,$sEndDate);
		$i = 0;
		
		foreach($aDate as $rows)
		{
			$aDateInfo = $this->visitorModel->getContents($rows['year'] . '-' . $rows['month_int'] . '-' . str_pad($rows['day'],2,0,STR_PAD_LEFT),$iUserIdx);	
			$aMonth[] = array
			(
				'month' => $rows['month'],
				'day' => str_pad($rows['day'],2,0,STR_PAD_LEFT),
				'year' => $rows['year'],
				'total_visitor' => $aDateInfo['total_rows'],
				'percent' => ( ( $aDateInfo['total_rows'] * $this->iMaxVisitor ) / 50 )
			);
		}
		
		return $aMonth;
	}
	
	private function _getTime($sStartDate,$sEndDate,$iUserIdx)
	{
		$iS = 0;
		$iE = 0;
		
		$aStartTime = array();
		$aEndTime = array();
		
		for($i = 0; $i <=23 ; $i++)
		{
			$aStartTime[] = str_pad($i,2,0,STR_PAD_LEFT) . ":00";
			$aEndTime[] = str_pad($i,2,0,STR_PAD_LEFT) . ":59";	
		}		
		
		$aTime = array();
		$aGetTime = array();
		$aDate = $this->_getDateRange($sStartDate,$sEndDate);
		
		for($i = 0 ; $i <=23 ; $i++)
		{
			$iTotalRows = 0;
			$sStartTime =  str_pad($i,2,0,STR_PAD_LEFT) . ":00";
			$sEndTime =  str_pad($i,2,0,STR_PAD_LEFT) . ":59";
			
			foreach($aDate as $rows)
			{
				$sDate = $rows['year'] . '-' . $rows['month_int'] . '-' . $rows['day'];
				$aGetTime = $this->visitorModel->getTime( $sStartTime , $sEndTime , $sDate,$iUserIdx );
				$iTotalRows += $aGetTime['total_rows'];
			}					
			
			$aTime[] = array(
				'start_time' => $sStartTime,
				'end_time' => $sEndTime,
				'total_visitor' => $iTotalRows,
				'percent' => ( ( $iTotalRows * $this->iMaxVisitor ) / 100 )
			);	
		}
		return $aTime;
	}
}