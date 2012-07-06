<?php
include($_SERVER['DOCUMENT_ROOT'] . '/__library/controller.php');
class index extends Simplexi_Controller
{
	public function init()
	{
		$aData['page_title'] = "SAMPLE TITLE";
		$aData['text'] = "SAMPLE TEXT";
		$aData['test'] = "TEST";

		$this->importCSS('common');
		$this->importJS('script');

		$this->display("sample/index", $aData);
	}
}

$oClass = new index();
?>