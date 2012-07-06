<?php
include('../__library/controller.php');
class index extends Simplexi_Controller
{
	public function run()
	{
		$this->library("common");
		$this->importJS('login/login');
		
		$aData['title']	= 'Admin Login';
		$this->display('login/tpl/index', $aData, false);
	}
}

$oClass = new index();
$oClass->run($aArgs);