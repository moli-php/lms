<?php
class SaveComments extends Simplexi_Controller{
	public function run($aArgs){
		$this->model('ulearning_model');
		foreach($aArgs['type_id'] as $key => $val):
			$type_comment = explode("_",$val);
			if($type_comment[0] == 2 || $type_comment[0] == 3 || $type_comment[0] == 5 || $type_comment[0] == 6)
				$this->db->ulearning_model->db_update("tb_ulearning_multiple_answer",array("fcomment" => $aArgs['comment'][$key]),
											array("fmultiple_answer_id" => $type_comment[1]));
			else if($type_comment[0] == 7 || $type_comment[0] == 8 || $type_comment[0] == 9 || $type_comment[0] == 10 || $type_comment[0] == 11)
				$this->db->ulearning_model->db_update("tb_ulearning_word_answer",array("fcomment" => $aArgs['comment'][$key]),
											array("fword_answer_id" => $type_comment[1]));
			else if($type_comment[0] == 12 || $type_comment[0] == 13 || $type_comment[0] == 14 || $type_comment[0] == 16)
				$this->db->ulearning_model->db_update("tb_ulearning_sentence_answer",array("fcomment" => $aArgs['comment'][$key]),
											array("fsentence_answer_id" => $type_comment[1]));
			else if($type_comment[0] == 15 || $type_comment[0] == 18){
				$slide_id = $this->db->ulearning_model->db_max("tb_ulearning_user_grade",'fslide_id',
											array("fuser_grade_id" => $aArgs['user_grade_id']));
				$this->db->ulearning_model->db_update("tb_ulearning_slide",array("fcomment" => $aArgs['comment'][$key]),
											array("fslide_id" => $slide_id));
			}
			else if($type_comment[0] == 17)
				$this->db->ulearning_model->db_update("tb_ulearning_long_answer",array("fcomment" => $aArgs['comment'][$key]),
											array("flong_answer_id" => $type_comment[1]));
		endforeach;
	}
}
?>