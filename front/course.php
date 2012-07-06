<?php
include('__library/controller.php');
class Course extends Simplexi_Controller
{
	/*add $aArgs parameter / change init to run*/
	public function run($aArgs){
	
		/*include common library*/
		$this->library("common");
		/*check if session start*/
		$this->library("checkLogin");
		
		/*tinymce*/
		$this->library('tinymce');
		Tinymce::init();
		/*send message*/
		$this->importJS('message/message');
		
		/*to import javascripts*/
		$this->importJS("tablesorter");
		
		/*for the exec functions*/
		$sAction = Common::getParam('action');
		$sAction = $sAction != "" ? "exec" . ucwords($sAction) : "_display";
		$this->$sAction($aArgs);
		
		
	}
	
	public function _display(){
		$aData['offered_class'] = $this->select("tb_product_class")->execute();
		$this->display("front/tpl/index",$aData);		
	}


	
}

$oClass = new Course();
$oClass->run($aArgs); #initialize here

