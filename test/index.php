<?php
include($_SERVER['DOCUMENT_ROOT'] . '/__library/controller.php');
class index extends Simplexi_Controller
{
	public function run()
	{
		$aData['test'] = "test123456";
		
		$this->importCSS('common');
		$this->importCSS('common');
		$this->importCSS('common');
		$this->importCSS('common');
		$this->importCSS('common');
		$this->importJS('script');
		
		$this->display("test/test", $aData);
	}
}

$oClass = new index();
$oClass->run();
?>