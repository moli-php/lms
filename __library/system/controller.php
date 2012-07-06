<?php

class Simplexi_Controller extends Model
{	
	public $oNewInstance;
	public $db;
	
	public function display($aFile, $aData = null, $sHeaderFooter = true)
	{
		$GLOBALS['aData'] = $aData;
		if ($aData !== null) 
			extract($aData);

		ob_start();
		
		if (is_array($aFile)){
			foreach ($aFile as $sFile) { 
				$sFile = str_replace("/", "\\", $sFile);
				$sPath = (checkContainerAdmin() === true) ? ADMIN_PATH : FRONT_PATH;
			
				if (!file_exists($sPath . $sFile . TPL)) 
				{
					exit("<br />File does not exists : " . $sPath . $aFile . TPL . "<br /> ");
					continue;
				} else 
					include_once ($sPath . $sFile . TPL);	
			}
		} else {
			$sFile = str_replace("/", "\\", $aFile);
			$sPath = (checkContainerAdmin() === true) ? ADMIN_PATH : FRONT_PATH;
			
			if (!file_exists($sPath . $aFile . TPL))
				exit("<br />File does not exists : " . $sPath . $aFile . TPL . "<br /> ");
			else	
				include_once ($sPath . $aFile . TPL);
		}

		$sContent = ob_get_contents();
		ob_end_clean();
		
		if ($sHeaderFooter === true)
			__include('header');
			
		echo $sContent;
		
		if ($sHeaderFooter === true)
			__include('footer');
	}
	
	public function view($aFile, $aData = null)
	{
		$sFullUrl = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$sChunk = parse_url($sFullUrl);
		
		$sUrl = substr(preg_replace("/admin\//", "", $sChunk['path']), 1);

		if (is_array($aFile)){
			foreach ($aFile as $iKey => $sValue)
				$aFile[$iKey] = $sUrl . "tpl/" . $sValue;
		} else {
			$aFile = $sUrl . "tpl/" . $aFile;
		}
		
		$this->display($aFile, $aData);
	}
	
	public function importCSS($sCSS)
	{
		if(isset($GLOBALS["iCSS"]) && !in_array($sCSS, $GLOBALS["iCSS"]))
			$GLOBALS["iCSS"][] = $sCSS;
	}
	
	public function externalCSS($sCSS)
	{
		if(isset($GLOBALS["eCSS"]) && !in_array($sCSS, $GLOBALS["eCSS"]))
			$GLOBALS["eCSS"][] = $sCSS;
	}
	
	public function importJS($sJS)
	{
		if(isset($GLOBALS["iJS"]) && !in_array($sJS, $GLOBALS["iJS"]))
			$GLOBALS["iJS"][] = $sJS;
	}
	
	public function externalJS($sJS)
	{
		if(isset($GLOBALS["eJS"]) && !in_array($sJS, $GLOBALS["eJS"]))
			$GLOBALS["eJS"][] = $sJS;
	}
	
	public function writeJS($sJS)
	{
		if(isset($GLOBALS["wJS"]) && !in_array($sJS, $GLOBALS["wJS"]))
			$GLOBALS["wJS"][] = $sJS;
	}
	
	public function library($aFile)
	{
		if (is_array($aFile)){
			foreach ($aFile as $sFile){
				include_once (LIBRARY_PATH . $sFile . EXT);
				$oNewInstance =& $this;
				$oNewInstance->$sFile = new $sFile;
			}
		}
		else {
			include_once (LIBRARY_PATH . $aFile . EXT);
			$oNewInstance =& $this;
			$oNewInstance->$aFile = new $aFile;
		}
	}
	
	public function model($aFile)
	{
		if (is_array($aFile)){
			foreach ($aFile as $sFile){
				$sFile = str_replace("/", "\\", $sFile);
				include_once (MODEL_PATH . $sFile . EXT);
				$oNewInstance =& $this;
				$oNewInstance->db->$sFile = new $sFile;
			}
		}
		else {
			$aFile = str_replace("/", "\\", $aFile);
			include_once (MODEL_PATH . $aFile . EXT);
			$oNewInstance =& $this;
			$oNewInstance->db->$aFile = new $aFile;
		}
	}
	
	public function message($sType, $sMessage = '')
	{
		$_SESSION['sMessageType'] = strtolower($sType) == 'success' ? 'success' : 'warning';
		$_SESSION['sMessage'] = $sMessage != '' ? $sMessage : (strtolower($sType) == 'success' ? 'Success' : 'Error');
	}
	
	/*initialize tiny mce*/
	public function tinymce_init($aOptions = null){
	
		/*import javascript*/
		self::importJS("tinymce/jscripts/tiny_mce/jquery.tinymce");
		self::importJS("tinymce/jscripts/tiny_mce/tiny_mce");
		
		/*give default if tinymce setting is not define*/
		if(!isset($aOptions['settings']) OR $aOptions['settings'] == null){
			
			$aOptions['settings'] = array( 
				"mode" => "none",
				"theme" => "advanced",
				"plugins" =>  "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
				"theme_advanced_toolbar_align" => "left",
				"theme_advanced_toolbar_location" =>"top",
				"theme_advanced_buttons1" => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
				"theme_advanced_buttons2" => ",search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				"theme_advanced_buttons3" => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen"
			);
		}
	
		/*write javascript*/
		self::writeJS('$(function(){ 
		$("'.$aOptions['container'].'").html("<textarea  name='.$aOptions['name'].' id='.$aOptions['id'].'  style='.$aOptions['style'].' ></textarea>");
		
			if('.$aOptions['dialog'].' === true){
				tinyMCE.init('.json_encode($aOptions['settings']).');
			}else{
			 $("textarea#'.$aOptions['id'].'").tinymce('.json_encode($aOptions['settings']).');
			}
	
		});');
	
	}
	
	public function tinymce_return($sData){
		/*write javascript*/
		self::writeJS('$(function(){ 
			$("#html_editor").html("'.addslashes($sData).'");
		});');
	}
	
	 public function redactor_init($sPath){
		
		if(isset($_FILES[ 'file' ])){
			$_FILES [ 'file' ] [ 'type' ]  = strtolower ( $_FILES [ 'file' ] [ 'type' ]);
			$file = $sPath . md5 ( Date ( 'YmdHis' )). '_'.$_FILES["file"]["name"] ;
			$tmp_name = $_FILES["file"]["tmp_name"];
			$name = $_FILES["file"]["name"];
			move_uploaded_file($tmp_name, $file);
			echo '<img src = "'.$file.'"/>';
		}
	
	 }
}

?>