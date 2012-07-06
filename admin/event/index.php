<?php
include($_SERVER['DOCUMENT_ROOT'] . '/__library/controller.php');
include($_SERVER['DOCUMENT_ROOT'] . '/admin/event/model/model.php');

class index extends oModel
{
	protected $oModel = NULL;
	
	public function __construct(){
	
		parent::__construct();
		$this->library('common');
		$this->library('tinymce'); 
		Tinymce::init();
		$this->importJS('tablesorter');
		$this->importJS('event/settings');
		$this->importCSS('event/codemirror');	
		$this->importCSS('event/event');
		$this->oModel = new oModel();
		$sAction = Common::getParam('action');
		
		/*for tiny mce
		* container = html element where you want to append to
		* style = style the textarea of tinymce
		* dialog = boolean to display inside dialog box
		* settings = tinymce settings ->you can add or remove unnecessary options
		*/
		
		// $aTinymceOptions = array(
			// "container" => ".tmce_con", 
			// "style" => "width:600px;height:400px;", 
			// "dialog" => "false", 
			// "settings" => array( 
				// "mode" => "none",
				// "theme" => "advanced",
				// "plugins" =>  "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
				// "theme_advanced_toolbar_align" => "left",
				// "theme_advanced_toolbar_location" =>"top",
				// "theme_advanced_buttons1" => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
				// "theme_advanced_buttons2" => ",search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				// "theme_advanced_buttons3" => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen"
			// )
		// );
		
		// $this->tinymce_init($aTinymceOptions); #initialize tinymce
	
	}

	public function run($aArgs)
	{	
		$sAction = Common::getParam('action');
		$sAction = $sAction != "" ? "exec" . ucwords($sAction) : "execPopup_editor";
		$this->$sAction($aArgs);
	}
	
	public function execMain_banner($aArgs)
	{
		$aArgs[] = $this->_getBannerPopupArgs('banner',$aArgs);
		$this->display("event/tpl/main_banner", $aArgs);
	}
	
	public function execAdd_banner($aArgs)
	{
		if(isset($aArgs['user_id2']) && $aArgs['user_id2']){
			$this->_transferAndDeleteImages($aArgs);
		}
		$aData['url_args'] = $this->_urlArgs($aArgs);
		$aData[] = $this->_addEditCondition('banner', $aArgs);
		$this->display("event/tpl/add_banner",$aData);
	}
	
	public function execPopup_editor($aArgs)
	{
		$aArgs[] = $this->_getBannerPopupArgs('popup',$aArgs);
		$this->display("event/tpl/popup_editor",$aArgs);
	}
	
	public function execAdd_popup($aArgs)
	{
		$aData['url_args'] = $this->_urlArgs($aArgs);
		$aData[] = $this->_addEditCondition('popup', $aArgs);
		$aData[]['show_status'] = isset($aArgs['show_status']) ? $aArgs['show_status'] : 0;
		$this->display("event/tpl/add_popup",$aData);
	}
	
	public function execDelete($aArgs)
	{
		if(isset($aArgs['sFlag']) && $aArgs['sFlag'])
		{
			switch($aArgs['sFlag'])
			{
			case "delele_banner_record" :
			$img = $this->oModel->getRecord($aArgs['idx'],"banner");
			$upload_dir =  $_SERVER['DOCUMENT_ROOT']."/uploads/event/banner/";
			unlink($upload_dir.$img[0]['banner_image']);
			echo $this->oModel->execDeleteRecords($aArgs['idx'],$aArgs['sFlag']);
			break;
			
			case "delete_popup_record" :
			echo $this->oModel->execDeleteRecords($aArgs['idx'],$aArgs['sFlag']);
			break;
			
			case "delete_banner_records" :
			$img = $this->oModel->getBannerImages($aArgs['idx']);
			$upload_dir =  $_SERVER['DOCUMENT_ROOT']."/uploads/event/banner/";
			foreach($img as $val){
			unlink($upload_dir.$val['banner_image']);
			}			
			echo $this->oModel->execDeleteRecords($aArgs['idx'],$aArgs['sFlag']);
			break;
			
			case "delete_popup_records" :
			echo $this->oModel->execDeleteRecords($aArgs['idx'],$aArgs['sFlag']);
			break;
			}
		}
	}
	
	
	/* PRIVATE */
	
	private function _urlArgs($aArgs)
	{
		$sPage = isset($aArgs['page']) ? "&page=".$aArgs['page'] : "";
		$sSearch = isset($aArgs['search']) ? "&search=".$aArgs['search'] : "";
		$sStatus = isset($aArgs['status']) ? "&status=".$aArgs['status'] : "";
		$sIdx = isset($aArgs['idx']) ? "&idx=".$aArgs['idx'] : "";
		return $sPage.$sSearch.$sStatus.$sIdx;
	}
	
	private function _getBannerPopupArgs($sTable, $aArgs)
	{
		$aArgs['url_args'] = $this->_urlArgs($aArgs);
		$aArgs['iCurrentPage'] = $aArgs['page'] = (isset($aArgs['page'])) ? $aArgs['page'] : 1;
		$aArgs['iRowsPerPage'] = isset($aArgs['rows']) ? $aArgs['rows'] : 10;
		$aArgs['offset'] = $aArgs['iRowsPerPage'] * ($aArgs['iCurrentPage'] - 1);
		$aArgs['iTotalRows'] = $this->_getTotalRecords($sTable,$aArgs);
		$aArgs['aData']['getData'] = $this->oModel->getRecords($aArgs,$sTable);
		$aArgs['aData']['showRows'] = array(10,20,30,40,50);
		$aArgs['iCount'] = array(
							'all'=>$this->oModel->getCount($sTable),
							'active'=>$this->oModel->getCount($sTable,'Active'),
							'inactive'=>$this->oModel->getCount($sTable,'Inactive')
							);
		$i = 0;
		foreach($aArgs['aData']['getData'] as $key => $val){
			$aArgs['aData']['getData'][$key]['iNum'] = $aArgs['iTotalRows'] - $aArgs['offset'] - $i;
			$i++;
		}
		return $aArgs;
	}
	
	private function _addEditCondition($sTable,$aArgs)
	{
		$sPage = isset($aArgs['page']) ? "&page=".$aArgs['page'] : "";
		$sSearch = isset($aArgs['search']) ? "&search=".$aArgs['search'] : "";
		$sStatus = isset($aArgs['status']) ? "&status=".$aArgs['status'] : "";

		$sExecTable = ($sTable == "popup") ? "execPopup" : "execBanner";
		$sUrlPath = ($sTable == "popup") ? "popup_editor" : "main_banner";
		$sTitle = ($sTable == "popup") ? (isset($aArgs['popup_title']) ? $aArgs['popup_title'] : "") : (isset($aArgs['banner_title2']) ? $aArgs['banner_title2'] : "");
		
		$aData['aData'] = (isset($aArgs['idx']) && $aArgs['idx']) ? $this->oModel->getRecord($aArgs['idx'],$sTable) : "";
		$aData['aActive'] = array('Active','Inactive');
		$aData['aPosition_mode'] = array('Left','Center','Right');
		$aData['aEditor_mode'] = array('html_edit','code_edit');
		$aData['aWindow'] = array('Current Window','New Window');
		
		if(isset($aArgs['idx'],$sTitle) && $aArgs['idx'] && $sTitle){
			$aArgs['tableExec'] = "edit";
			if($this->oModel->$sExecTable($aArgs) !== false){
				echo "<script>window.location.href='".BASE_URL."admin/event/?action=".$sUrlPath.$sStatus.$sSearch.$sPage."';</script>";
			}else $this->message('warning');
		}elseif(isset($sTitle) && $sTitle){
			$aArgs['tableExec'] = 'insert';
			if($this->oModel->$sExecTable($aArgs) !== false){
				echo "<script>window.location.href='".BASE_URL."admin/event/?action=".$sUrlPath."';</script>";
			}else $this->message('warning');
		}
			
		return $aData;
	}
	
	private function _transferAndDeleteImages($aArgs)
	{
		// transfer image on temp 
		$img = $aArgs['banner_image'];
		$sSource = $_SERVER['DOCUMENT_ROOT']."/uploads/event/temp/".$img;
		$sDestination = $_SERVER['DOCUMENT_ROOT']."/uploads/event/banner/".$img;
		if(file_exists($sSource)){
			if(copy($sSource,$sDestination)){
				$aFiles = glob($_SERVER['DOCUMENT_ROOT']."/uploads/event/temp/".$aArgs['user_id2']."_*.*");
				foreach($aFiles as $val){
				if(file_exists($val)) unlink($val);
				}
			}
		}
		// delete old file
		if(isset($aArgs['old_banner_image'],$aArgs['banner_image']) && $aArgs['old_banner_image'] && $aArgs['banner_image']){
			if($aArgs['banner_image'] != $aArgs['old_banner_image']){
			if(file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/event/banner/".$aArgs['old_banner_image']))
			unlink($_SERVER['DOCUMENT_ROOT']."/uploads/event/banner/".$aArgs['old_banner_image']);
			}
		}
	}
	
	private function _getTotalRecords($table,$aArgs)
	{
		if(isset($aArgs['search'],$aArgs['status'])){
			$iTotal = $this->oModel->getCountSearch($aArgs['search'],$table,$aArgs['status']);
		}elseif(isset($aArgs['search'])){
			$iTotal = $this->oModel->getCountSearch($aArgs['search'],$table,"");
		}elseif(isset($aArgs['status'])){
			$iTotal = $this->oModel->getCountSearch("",$table,$aArgs['status']);
		}else{
			$iTotal = $this->oModel->getCount($table);
		}
		return $iTotal;
	}

}

$oClass = new index();
$oClass->run($aArgs);
?>