<?php
include('../../__library/controller.php');
class index extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library('common');
		$aData['page_title'] = "SAMPLE TITLE";
		$aData['text'] = "SAMPLE TEXT";
		$aData['test'] = "TEST";
		
		$aData['iCurrentPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
		$aData['iRowsPerPage'] = 10;
		$aData['iTotalRows'] = 100;
		
		$this->importJS('common');
		$this->message('success', 'wew');
		if(isset($aArgs['page']) && $aArgs['page'] == 1)
			$this->message('success', 'WARNING MESSAGE');

		$this->display("sample/index", $aData);
	}
}

$oClass = new index();
$oClass->run($aArgs);
?>