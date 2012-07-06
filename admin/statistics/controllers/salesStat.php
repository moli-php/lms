<?php
if( !defined('DIRECT_ACCESS') ) exit("No Direct Access!");

require_once('models/salesModel.php');
require_once('includes/helpers.php');

class salesStat extends Simplexi_controller
{
	private $TB_MSG_ADV = 'tb_msg_adv';
	private $oModel  = NULL;
	private $_iLimit  = 20;
	
	public function __construct()
	{
		parent::__construct();
		$this->salesModel = new salesModel();
	}
	
	public function run($aArgs)
	{
		$aData = array();
		$aProduct = array();
		$this->library('common');
		$this->library('tinymce');
		Tinymce::init();
		$this->importCSS('statistics/admin');
		$this->importJs('statistics/admin_sales');
		
		$aInfo['start_date'] = isset($aArgs['start_date']) ? $aArgs['start_date'] : "";
		$aInfo['end_date'] = isset($aArgs['end_date']) ? $aArgs['end_date'] : "";
		
		$sStartDate = ymdDate($aInfo['start_date']);
		$sEndDate = ymdDate($aInfo['end_date']);
		
		$aStartDate = ymdDate($aInfo['start_date'],'array');
		$aEndDate = ymdDate($aInfo['end_date'],'array');		
		
		$aInfo['sStartDateLabel'] = date('M d,Y',mktime(0,0,0,$aStartDate[0],$aStartDate[1],$aStartDate[2]));
		$aInfo['sEndDateLabel'] = date('M d,Y',mktime(0,0,0,$aEndDate[0],$aEndDate[1],$aEndDate[2]));
		
		$iBranchIdx = isset($aArgs['b']) ? $aArgs['b'] : "";
		$iUserIdx = (USER_GRADE == 9) ? $iBranchIdx : USER_ID;
		
		$aContentsBranch = $this->salesModel->getBranch();
		$aContentsProduct = $this->salesModel->getProduct( $sStartDate , $sEndDate , $iUserIdx );		
		$aContents = $this->salesModel->getContents($sStartDate,$sEndDate,$iUserIdx);

		$iTotalApplied = 0;
		$iTotalAmountMoney = 0;
		$iConCash = 0;
		$iConCard = 0;
		
		if(isset($aArgs['start_date']) && isset($aArgs['end_date']))
		{
			foreach($aContents as $rows)
			{
				$iTotal =($rows['payment_cash'] + $rows['payment_card'] + $rows['notconfirmed_payment']);
				
				$aData[] = array(
					'apply_count' => $rows['apply_count'],
					'datetime_purchase' => $rows['datetime_purchase'],
					'payment_cash' => number_format( $rows['payment_cash'] , 2 ),
					'payment_card' => number_format( $rows['payment_card'] , 2 ),
					'confirmed' => $rows['confirmed'],
					'not_confirmed' => $rows['not_confirmed'],
					'notconfirmed_payment' => number_format($rows['notconfirmed_payment'],2),
					'total' => number_format($iTotal,2)
				);
				
				$iTotalApplied += $rows['apply_count'];
				$iTotalAmountMoney += $iTotal;
				$iConCash += $rows['payment_cash'] ;
				$iConCard += $rows['payment_card'] ;
			}			
		}
		
		if($aContentsProduct)
		{
			foreach($aContentsProduct as $rows)
			{
				$aProduct[] = array(
					'class_name' => $rows['class_name'],
					'country' => ( ( $rows['teacher_type'] == 0 ) ? "PH" : "US" ),
					'price' => $rows['price'],
					'income' => $rows['income'],
					'total_applied' => $rows['total_applied']
				);
			}
		}
		
		$aInfo['iTotalApplied'] = $iTotalApplied;
		$aInfo['iTotalAmountMoney'] = number_format($iTotalAmountMoney,2);
		$aInfo['iTotalConfirmed'] =  number_format($iConCash + $iConCard,2);
		$aInfo['aContents'] = $aData;
		$aInfo['aContentsProduct'] = $aProduct;
		$aInfo['aContentsBranch'] = $aContentsBranch;
		$aInfo['iUserIdx'] = $iUserIdx;		
		$this->display("statistics/tpl/salesStat",$aInfo);
	}
}

