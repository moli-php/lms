<?php
class Test_assign extends Simplexi_Controller{
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		$this->importJS('ulearning/test_assign');
		$aData['course'] = array(array('fcategory_id' => 1,'fcategory_name' => 'Class Material'),
								array('fcategory_id' => 2,'fcategory_name' => 'Homework'),
								array('fcategory_id' => 4,'fcategory_name' => 'Level Test (Preview)'));
		$this->display("ulearning/test_assign",$aData);
	}
}
?>