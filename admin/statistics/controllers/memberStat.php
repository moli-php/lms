<?php if( !defined('DIRECT_ACCESS') ) exit("No Direct Access!");

require_once("models/membersModel.php");

class memberStat extends Simplexi_controller
{
	private $oModel;

	public function __construct()
	{
		parent::__construct();
		$this->membersModel = new membersModel();
	}

	public function run($aArgs)
	{
		$this->library('common');
		$this->importCSS('statistics/admin');
		$this->importJs('statistics/admin_member');

		$aInfo['start_date'] = isset($aArgs['start_date']) ? $aArgs['start_date'] : "";
		$aInfo['end_date'] = isset($aArgs['end_date']) ? $aArgs['end_date'] : "";

		$iBranchIdx = isset($aArgs['b']) ? $aArgs['b'] : "";
		$iUserIdx = (USER_GRADE == 9) ? $iBranchIdx : USER_ID;
		
		$sWhereQuit = (USER_GRADE == 9) ? " AND branch_idx = {$iBranchIdx}" : "AND branch_idx=" . USER_ID;

		$sStartDate = ymdDate($aInfo['start_date']);
		$sEndDate = ymdDate($aInfo['end_date']);
		$aResult = $this->membersModel->getContents();
		$aUserCount = $this->membersModel->getTotalUsers($iUserIdx);
		$aApplied = $this->membersModel->getApplied($sStartDate,$sEndDate,$iUserIdx);
		$aQuit = $this->membersModel->getQuit($sStartDate,$sEndDate,$sWhereQuit,$iUserIdx);
		$aJoined = $this->membersModel->getMemberJoined($sStartDate,$sEndDate,$iUserIdx);		
		
		$aInfo['total_user'] = $aUserCount['total_user'];
		$aInfo['total_applied'] = $aApplied['total_applied'];
		$aInfo['total_quit'] = $aQuit['total_quit'];
		$aInfo['total_joined'] = $aJoined['total_joined_period'];

		$aInfo['aContentsBranch'] = $this->membersModel->getBranch();
		$aInfo['aContents'] = $aResult;
		$aInfo['iUserIdx'] = $iUserIdx;
		
		$iCurrentYear = date('Y',time());	
			
		$aAgeRange = array( 0, 10 , 11 , 20 , 21 , 30 , 31 , 40 , 41 , 100 );

		$iAgeCount = count( $aAgeRange );

		$aAgeInfo = array();
		
		$aUser = $this->membersModel->getAge( $sStartDate , $sEndDate , $iUserIdx );
		
		$i1 = 1;
		$i2 = 1;
		$i3 = 1;
		$i4 = 1;
		$i5 = 1;

		$aAgeInfo['0-10'] = 0;
		$aAgeInfo['11-20'] = 0;
		$aAgeInfo['21-30'] = 0;
		$aAgeInfo['31-40'] = 0;
		$aAgeInfo['41-100'] = 0;

		$aAgeInfo['total_male'] = 0;
		$aAgeInfo['total_female'] = 0;
		if($aUser)
		{		
			foreach($aUser as $rows)
			{
				$aSsnInfo = splitSsnInfo( $rows['ssn'] );
				$iAge = ( $iCurrentYear - $aSsnInfo['year'] );
				
				$aAgeInfo['total_male'] += ( $aSsnInfo['gender'] == 1 ) ? 1 : 0;
				
				$aAgeInfo['total_female'] += ( $aSsnInfo['gender'] == 2 ) ? 1 : 0;
				
				if( $aAgeRange[0] <= $iAge && $iAge <= $aAgeRange[1] )
				{
					$aAgeInfo['0-10'] = ( $i1++ ) ;
				}
				
				if( $aAgeRange[2] <= $iAge && $iAge <= $aAgeRange[3] )
				{
					$aAgeInfo['11-20'] =($i2++) ;
				}
				
				if( $aAgeRange[4] <= $iAge && $iAge <= $aAgeRange[5] )
				{
					$aAgeInfo['21-30'] = $i3++ ;
				}	

				if( $aAgeRange[6] <= $iAge && $iAge <= $aAgeRange[7] )
				{
				
					$aAgeInfo['31-40'] = $i4++ ;
				}

				if( $aAgeRange[8] <= $iAge && $iAge <= $aAgeRange[9] )
				{
					$aAgeInfo['41-100'] = $i5++ ;
				}			
			}
		}
		
		$aInfo['total_male'] = $aAgeInfo['total_male'];
		$aInfo['total_female'] = $aAgeInfo['total_female'];
		$aInfo['age_info'] = $aAgeInfo;		
		
		$this->display("statistics/tpl/memberStat",$aInfo);
	}
}