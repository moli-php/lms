<?php
class Class_mat_slide extends Simplexi_Controller{
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		$this->importJS('ulearning/class_mat_slide');
		$aData['aSlide'] = $this->db->ulearning_model->db_select("tb_ulearning_slide",null,null,array("ASC" => 1));
        foreach($aData['aSlide'] as $k => $v)
        	$aData['aSlide'][$iCount]['num'] = $k + 1;
			
		$aData['exam_type'] = $this->db->ulearning_model->db_select("tb_ulearning_exam_type",null,null,array("ASC" => 1));
        foreach($aData['exam_type'] as $k => $v)
        	$aData['exam_type'][$k]['num'] = $k + 1;
		$this->display("ulearning/class_mat_slide",$aData);
	}
}
?>