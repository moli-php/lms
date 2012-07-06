<?php
include('../../__library/controller.php');
class index extends Simplexi_Controller
{
	var $sDefaultClass = "productClass";

	public function run($aArgs)
	{
		$this->library(array("checkLogin", "common"));

		$sFileName = !isset($aArgs['action']) ? $this->sDefaultClass : $aArgs['action'];
		$sFile = dirname(__FILE__) . "/controller/" . $sFileName . EXT;
		
		if (file_exists($sFile)){
			include_once $sFile;
			$sFileName = new $sFileName();
			$sFileName->run($aArgs);
		} else
			echo "File does not exist : " . $sFileName;
	}
}

$oClass = new index();
$oClass->run($aArgs);