<?php
include('../__library/controller.php');
class index extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library('common');
		if(!isset($aArgs['assign_id'])){
			include(SERVER_DOCUMENT_ROOT  . '/ulearning/class/exam_list.php');
			$exam_list = new exam_list();
			$exam_list->run($aArgs);
		}else{
			include(SERVER_DOCUMENT_ROOT  . '/ulearning/class/exam_popup.php');
			$exam_popup = new exam_popup();
			$exam_popup->run($aArgs);
		}
	}
}

$oClass = new index();
$oClass->run($aArgs);
?>