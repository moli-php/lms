<?php
require_once('models/advise_model.php');
class Advise_mngt extends Simplexi_Controller
{
	private $TB_MSG_ADV = 'tb_msg_adv';
	private $oModel;
	private $_iLimit  = 20;
	
	public function run($aArgs)
	{
		$aInfo = array();
		$aData = array();
		
		$this->oModel = new Advise_model();
		$iUserIdx = isset($aArgs['m']) ? $aArgs['m'] : "";
		$this->_iLimit = (isset($aArgs['rows'])) ? $aArgs['rows'] : $this->_iLimit;	
		
		$iPage = (isset($aArgs['page'])) ? $aArgs['page'] : 1;
		$iOffset = ( $iPage - 1 ) * $this->_iLimit;
		$aInfo['field'] = (isset($aArgs['field'])) ? $aArgs['field'] : "";
		$aInfo['sort'] = (isset($aArgs['sort']) && $aArgs['sort']=='desc') ? 'asc' : "desc";
		$aInfo['rows'] = (isset($aArgs['rows'])) ? $aArgs['rows'] : $this->_iLimit;
		$aInfo['search'] = (isset($aArgs['search'])) ? $aArgs['search'] : "";
		$aInfo['search'] = (isset($aArgs['search'])) ? $aArgs['search'] : "";
		$aInfo['view'] = (isset($aArgs['view'])) ? $aArgs['view'] : "";
		$aInfo['qry_search'] = (isset($aArgs['search'])) ? '&search=' . $aArgs['search'] : "";
		$aInfo['qry_sort'] = (isset($aArgs['field']) && isset($aArgs['sort'])) ? '&field=' . $aArgs['field'] . '&sort=' . $aArgs['sort'] : "";
		$aInfo['qry_rows'] = (isset($aArgs['rows'])) ? '&rows=' . $aArgs['rows'] : "";
		$aInfo['qry_view'] = (isset($aArgs['view'])) ? '&view=' . $aArgs['view'] : "";
		$aInfo['qry_idx'] = (isset($aArgs['m'])) ? '&m=' . $iUserIdx : "";

		$sViewType = $this->_viewType($aArgs);
		$sViewMessage = isset($aArgs['view_message']) ? " AND tba.idx = {$aArgs['view_message']}" : " ";
		
		$sField = (
					(isset($aArgs['field']) && isset($aArgs['field'])) &&
					(@$aArgs['field'] =='title' || @$aArgs['field']=='read_status')
				 ) ? "tba" : "tbu";
				 
		$sAndView= "";
		$sAndView1= "";

		if(USER_GRADE==9)
		{
			$sAndView = "";
			$sAndView1 = " AND user_idx = " . $iUserIdx;		
		}
		else
		{
			$sAndView = " AND tba.branch_idx = " . USER_ID;			
			$sAndView1 = " AND user_idx = " . $iUserIdx;			
		}
		
		$sWhere = (isset($aArgs['search'])) ? " WHERE CONCAT(tba.title) LIKE '%{$aArgs['search']}%' {$sAndView1}  {$sViewType} {$sAndView} {$sViewMessage}" : " WHERE tba.user_idx = {$iUserIdx} {$sViewType} {$sAndView} {$sViewMessage}";
		$sOrderBy = (isset($aArgs['field']) && isset($aArgs['sort'])) ? " ORDER BY {$sField}.{$aArgs['field']}  {$aArgs['sort']}"  : "";
		$sLimit = (isset($aArgs['page'])) ? " LIMIT {$iOffset}, {$this->_iLimit}" : " LIMIT {$this->_iLimit}";
	    
		$this->library('tinymce'); 
		$this->importJS('message/advise_mngt');
		$this->importCSS('message/advise_mgnt');
		Tinymce::init();
	    $aContents = $this->oModel->getContentsCommon($sWhere,$sOrderBy,$sLimit);

	    $aTotalRows = $this->oModel->getCountContentsCommon($sWhere);
		$iTotalRows = $aTotalRows['total_rows'];
		
	    $aTotal = $this->oModel->getTotalCommon($iUserIdx);
	    $aTotalRead = $this->oModel->getReadCommon($sAndView1);
	    $aTotalUnread = $this->oModel->getUnreadCommon($sAndView1);
	    
		$aInfo['page'] = $iPage;
		$aInfo['limit'] = $this->_iLimit;
		$aInfo['total_rows'] = $iTotalRows;
		$aInfo['total'] = count($aTotal);
	    $aInfo['total_read'] = count($aTotalRead);
	    $aInfo['total_unread'] = count($aTotalUnread);
		$i = 0;
		
		foreach($aContents as $rows)
		{
			$aData[] = array
			(
				'row' => (($iPage==1) ? ($iTotalRows - $i) : ( $iTotalRows - $iOffset ) - $i),
				'idx' => $rows['tba_idx'],
				'user_id' =>	 $rows['user_id'],
				'title' =>	 $rows['title'],
				'message' => $rows['message'] ,
				'status' => $rows['read_status'],
				'date_reg' => $rows['date_reg']
			);
			$i++;
		}

		$aInfo['sSiteAjaxPath'] = BASE_URL . 'admin/message/?action=advise_mngt&sub=ajax';
		$aInfo['sContentsUrl'] = BASE_URL . 'admin/message/?action=advise_mngt&sub=message';
		$aInfo['aContents'] = $aData;
		$this->display("message/tpl/adv_message_popup",$aInfo,false);
	}
	
	private function _viewType($aArgs)
	{	
		$sViewType = "";
		
		switch(@$aArgs['view'])
		{
			case'read':
				$sViewType = " AND tba.read_status='Y'";
			break;
			
			case'unread':
				$sViewType = " AND tba.read_status='N'";
			break;
			
			default:
				$sViewType = "";
		}
		
		return $sViewType;
	}
}

$oClass = new Advise_mngt();
$oClass->run($aArgs);