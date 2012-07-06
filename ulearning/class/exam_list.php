<?php
class Exam_list extends Simplexi_Controller
{
	public function run($aArgs){
		$user = 29;
		$this->model('ulearning_model');
		$this->importJS('ulearning/front/exam_list');
		
		$aData['unit'] = $this->db->ulearning_model->db_select('tb_ulearning_assign t1 INNER JOIN tb_ulearning_unit t2 ON t1.funit_id=t2.funit_id LEFT OUTER JOIN tb_ulearning_test_evaluation t3 
																ON t1.fassign_id=t3.fassign_id ',array("t1.fassign_id","t2.ftitle","t3.status"),array("t1.fuser_idx" => $user));

		$this->display("ulearning/tpl/exam_list", $aData);
	}
}
?>