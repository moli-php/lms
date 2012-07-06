<?php
include('../../__library/controller.php');
class Assorted_ajax extends Simplexi_Controller
{
	private $user = 29;
	public function __construct(){
		$this->model('ulearning_model');
	}
	
	public function run($aArgs){
		if($aArgs['action'] == "get_cur_page"){
			$aData = $this->db->ulearning_model->db_select('tb_ulearning_test_evaluation',array('current_page'),array('funit_id' => $aArgs['unit_id'],'user_idx' => $this->user));
			$offset = $aData[0]['current_page'] ? $aData[0]['current_page'] : 0;
			echo $offset;
		}
	}
}

$oClass = new Assorted_ajax();
$oClass->run($aArgs);
?>