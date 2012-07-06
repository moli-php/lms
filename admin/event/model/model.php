<?php

class oModel extends Simplexi_Controller
{
	protected $sTableBanner = NULL;
	protected $sTablePopup = NULL;
	
	public function __construct(){
		parent::__construct();
		$this->sTableBanner = "tb_event_add_banner";
		$this->sTablePopup = "tb_event_add_popup";
	}
	
	public function execBanner($aArgs)
	{
		$aFields = array(
				'user_id' => USER_ID,
				'title' => strip_tags($aArgs['banner_title2']),
				'banner_image' => strip_tags($aArgs['banner_image']),
				'url' => strip_tags($aArgs['banner_url']),
				'window' => strip_tags($aArgs['window_type']),
				'status' => strip_tags($aArgs['status_type']),
				'date_created' => time()			
				);
		
		if($aArgs['tableExec'] == "edit"){
			unset($aFields['date_created']);
			$sWhere = "idx = $aArgs[idx]";
			if(USER_GRADE == 9)unset($aFields['user_id']);
			$this->update($this->sTableBanner,$aFields,$sWhere)->execute();
		}elseif($aArgs['tableExec'] == "insert"){
			$this->insert($this->sTableBanner,$aFields)->execute();
		}
	}
	
	public function execPopup($aArgs){
	
		$content = ($aArgs['addPopupeditor'] == "html_edit") ? $aArgs['html_editor'] : $aArgs['code'];
		$aFields = array(
					'user_id' => USER_ID,
					'title' => strip_tags($aArgs['popup_title']),
					'editor_mode' => strip_tags($aArgs['addPopupeditor']),
					'content' => $content,
					'size' => strip_tags($aArgs['popup_size_w']."|".$aArgs['popup_size_h']),
					'position' => strip_tags($aArgs['popup_position_x']."|".$aArgs['popup_position_y']."|".$aArgs['position']),
					'status' => strip_tags($aArgs['status_type']),
					'`order`' => strip_tags($aArgs['popup_order']),
					'show_status' => $aArgs['show_status'],
					'date_created' => time()
					);

		if($aArgs['tableExec'] == "edit"){
			unset($aFields['date_created']);
			if(USER_GRADE == 9)unset($aFields['user_id']);
			$sWhere = "idx = ".$aArgs['idx'];
			return $this->update($this->sTablePopup,$aFields,$sWhere)->execute();
		}elseif($aArgs['tableExec'] == 'insert'){
			return $this->insert($this->sTablePopup,$aFields)->execute();
		}
	}
	
	public function getRecords($aData,$sFlag)
	{	
		$sTable = ($sFlag == "banner") ? $this->sTableBanner : $this->sTablePopup;
		$iOffset = ($aData['iCurrentPage']-1) * $aData['iRowsPerPage'];
		$sWhere = USER_GRADE != 9 ? "AND user_id = ".USER_ID : "";
		if(isset($aData['search'],$aData['status'])){
		return  $this->select($sTable,"",'title LIKE "%'.$aData['search'].'%" AND status = "'.$aData['status'].'" '.$sWhere)->orderBy('date_created','DESC')->limit($iOffset,$aData['iRowsPerPage'])->execute();
		}elseif(isset($aData['search'])){
		return  $this->select($sTable,"",'title LIKE "%'.$aData['search'].'%" '.$sWhere)->orderBy('date_created','DESC')->limit($iOffset,$aData['iRowsPerPage'])->execute();
		}elseif(isset($aData['status'])){
		return  $this->select($sTable,"",'status = "'.$aData['status'].'" '.$sWhere)->orderBy('date_created','DESC')->limit($iOffset,$aData['iRowsPerPage'])->execute();
		}else{
		$sWhere = (USER_GRADE != 9) ? "user_id = ".USER_ID : "";
		return  $this->select($sTable,"",$sWhere)->orderBy('date_created','DESC')->limit($iOffset,$aData['iRowsPerPage'])->execute();
		}
	}
	
	public function getRecord($idx,$sFlag){
		$sTable = ($sFlag == "banner") ? $this->sTableBanner : $this->sTablePopup;
		$sWhere = "idx = ".$idx;
		return $this->select($sTable,'',$sWhere)->execute();
	}
	
	public function getCountSearch($sSearch=null,$sFlag,$sStatus=null)
	{
		$sTable = ($sFlag == "banner") ? $this->sTableBanner : $this->sTablePopup;
		$sWhere = USER_GRADE != 9 ? " AND user_id = ".USER_ID : "";
		$sStatus = (isset($sStatus) && $sStatus)? "status = '".$sStatus."'" : "";
		$sSearch = (isset($sSearch) && $sSearch)? "title LIKE '%".$sSearch."%'" : "";
		if(isset($sStatus,$sSearch) && $sStatus && $sSearch){
		return count($this->select($sTable,"",$sSearch.' AND '.$sStatus."".$sWhere)->execute());
		}elseif(isset($sStatus) && $sStatus){
		return count($this->select($sTable,"",$sStatus."".$sWhere)->execute());
		}elseif(isset($sSearch) && $sSearch){
		return count($this->select($sTable,"",$sSearch."".$sWhere)->execute());
		}
		
		return count($this->select($sTable,"",$sSearch.''.$sStatus."".$sWhere)->execute());
	}
	
	public function getCount($sFlag,$sField=null)
	{
		$sWhere = (USER_GRADE != 9) ? "user_id = ".USER_ID : "";
		$sWhere2 = (USER_GRADE != 9) ? "AND user_id = ".USER_ID : "";
		$sTable = ($sFlag == "banner") ? $this->sTableBanner : $this->sTablePopup;
		
			switch($sField)
			{
				case 'Active' :
				return count($this->select($sTable,"","status = 'Active' ".$sWhere2)->execute());
				break;
				
				case 'Inactive' :
				return count($this->select($sTable,"","status = 'Inactive' ".$sWhere2)->execute());
				break;
				
				default :
				return count($this->select($sTable,"",$sWhere)->execute());
			}
	}
	
	public function getBannerImages($idx){
		$sIn = "idx IN($idx)";
		$aFields = array('banner_image');
		return $this->select($this->sTableBanner,$aFields,$sIn)->execute();
	}
	
	public function execDeleteRecords($idx,$sFlag)
	{	
		$sWhere1 = (USER_GRADE !=9) ? "idx = ".$idx." AND user_id = ".USER_ID : "idx = ".$idx."";
		$sWhere2 = (USER_GRADE !=9) ? "WHERE idx IN({$idx}) AND user_id = ".USER_ID : "WHERE idx IN({$idx})";
		if($sFlag == "delele_banner_record"){
			return $this->deleteBy($this->sTableBanner,$sWhere1)->execute();
		}elseif($sFlag == "delete_popup_record"){
			return $this->deleteBy($this->sTablePopup,$sWhere1)->execute();
		}elseif($sFlag == "delete_banner_records"){
			return $this->query("DELETE FROM {$this->sTableBanner} ".$sWhere2);
		}elseif($sFlag == "delete_popup_records"){
			return $this->query("DELETE FROM {$this->sTablePopup} ".$sWhere2);
		}
	}
	

}