<?php
include('../../__library/controller.php');
class index extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library('common');
		$this->library('checkLogin');
		
		$this->importCSS('forum');
		$this->importJS('forum/require');
		$this->importJS('forum/require_setup');
		
		$this->library('tinymce'); 
		Tinymce::init();
		
		// $aTinymceOptions = array(
			// 'container' => '.dialog_wrapper', 
			// 'style' => 'width:800px;height:1000px;', 
			// 'dialog" => "true", 
			// "id" => "html_editor",
			// "name" => "html_editor",
			// "setting" => array(
				// mode : "specific_textareas",
				// editor_selector : "html_editor",
				// theme : "advanced",
				// plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

				// theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
				// theme_advanced_buttons2 : ",search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				// theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				
				// theme_advanced_toolbar_location : "top",
				// theme_advanced_toolbar_align : "left",
				// theme_advanced_statusbar_location : "bottom",
				// theme_advanced_resizing : true
			// )
		// );
		
		// $this->tinymce_init(); #initialize tinymce

		$aData['hello']		= 'Hello World';
		// $aData['baseURL']	= BASE_URL;

		$this->display('forum/tpl/index',$aData);
	}	
}

$oClass = new index();
$oClass->run($aArgs);
