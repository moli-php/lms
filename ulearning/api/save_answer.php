<?php
include('../../__library/controller.php');
class Save_answer extends Simplexi_Controller
{
	private $user = 29;
	public function __construct(){
		$this->model('ulearning_model');
	}
	
	public function run($aArgs){
		$correct = 0;$id = array();
		if($aArgs['exam_type_id'] == 2 || $aArgs['exam_type_id'] == 3 || $aArgs['exam_type_id'] == 5 || $aArgs['exam_type_id'] == 6){
			$aQuestions = $this->db->ulearning_model->db_select('tb_ulearning_multiple', null, array("fslide_id" => $aArgs['slide_id']),array("ASC" => 1));
			foreach($aQuestions as $key => $val){ 
				if($aArgs['choice_'.$key] == $val['fanswer']){
					$correct++;
				}
				$this->db->ulearning_model->db_insert('tb_ulearning_multiple_answer',array("fquestion_id" => $val['fquestion_id'],"fanswer" => $aArgs['choice_'.$key]));
				$id[$key] = $this->db->ulearning_model->db_max('tb_ulearning_multiple_answer','fmultiple_answer_id');
			}
			$this->insert_user_grade($aArgs['assign_id'],$aArgs['slide_id'],$aArgs['eval_id'],(($correct*100)/($key+1)),$id,'tb_ulearning_multiple_answer','fmultiple_answer_id');
		}
		else if($aArgs['exam_type_id'] == 7 || $aArgs['exam_type_id'] == 8 || $aArgs['exam_type_id'] == 9){
			$aWords = $this->db->ulearning_model->db_select('tb_ulearning_word', null, array("fslide_id" => $aArgs['slide_id']),array("ASC" => 1));
			foreach($aWords as $key => $val){ 
				if(strtolower($aArgs['answer_'.$key]) == strtolower($val['fword'])){
					$correct++;
				}
				$this->db->ulearning_model->db_insert('tb_ulearning_word_answer',array("fword_id" => $val['fword_id'],"fword_answer" => $aArgs['answer_'.$key]));
				$id[$key] = $this->db->ulearning_model->db_max('tb_ulearning_word_answer','fword_answer_id');
			}
			$this->insert_user_grade($aArgs['assign_id'],$aArgs['slide_id'],$aArgs['eval_id'],(($correct*100)/($key+1)),$id,'tb_ulearning_word_answer','fword_answer_id');
		}
		else if($aArgs['exam_type_id'] == 10 || $aArgs['exam_type_id'] == 11){
			$aWords = $this->db->ulearning_model->db_select('tb_ulearning_word', null, array("fslide_id" => $aArgs['slide_id']),array("ASC" => 1));
			$aSentence = $this->db->ulearning_model->db_select('tb_ulearning_sentence', null, array("fslide_id" => $aArgs['slide_id']),array("ASC" => 1));
			$items = 0;
			foreach($aSentence as $key => $val){ 
				$temp = $val['fsentence'];
				for($i=0,$n=0;$i<12;$i++){
					if(strpos($temp, '[[blank#'.($i+1).']]', 0) > -1){
						$temp = str_replace("[[blank#". ($i+1) ."]]", "<replaced_".($i+1).">", $temp);
						if(strtolower($aArgs["answer_".$key."_".$i."_".$n]) == strtolower($aWords[$i]['fword'])){
							$correct++;
						}
						$this->db->ulearning_model->db_insert('tb_ulearning_word_answer',array("fword_id" => $aWords[$i]['fword_id'],"fword_answer" => stripslashes($aArgs["answer_".$key."_".$i."_".$n])));
						$id[$items] = $this->db->ulearning_model->db_max('tb_ulearning_word_answer','fword_answer_id');
						$i--;$items++;
					}else{
						$n=0;
					}
				}
			}
			$this->insert_user_grade($aArgs['assign_id'],$aArgs['slide_id'],$aArgs['eval_id'],(($correct*100)/$items),$id,'tb_ulearning_word_answer','fword_answer_id');
		}
		else if($aArgs['exam_type_id'] == 12 || $aArgs['exam_type_id'] == 13 || $aArgs['exam_type_id'] == 14){
			$aSentence = $this->db->ulearning_model->db_select('tb_ulearning_sentence', null, array("fslide_id" => $aArgs['slide_id']),array("ASC" => 1));
			foreach($aSentence as $key => $val){ 
				if($val['fvoice'] == 1){
					$this->db->ulearning_model->db_insert('tb_ulearning_sentence_answer',array("fsentence_id" => $val['fsentence_id'],"fvoice_answer" => null));
					$id[$key] = $this->db->ulearning_model->db_max('tb_ulearning_sentence_answer','fsentence_answer_id');
				}
			}
			$this->insert_user_grade($aArgs['assign_id'],$aArgs['slide_id'],$aArgs['eval_id'],0,$id,'tb_ulearning_sentence_answer','fsentence_answer_id');
		}
		else if($aArgs['exam_type_id'] == 15 || $aArgs['exam_type_id'] == 18){
			$this->db->ulearning_model->db_update('tb_ulearning_slide',array("fslide_id" => $aArgs['slide_id']),array("frecorded" => "recorded"));
			$this->db->ulearning_model->db_insert('tb_ulearning_user_grade',array("feval_id" => $aArgs['eval_id'],"fslide_id" => $aArgs['slide_id'],"fgrade" => 0));
		}
		else if($aArgs['exam_type_id'] == 16){
			$aSentence = $this->db->ulearning_model->db_select('tb_ulearning_sentence', null, array("fslide_id" => $aArgs['slide_id']),array("ASC" => 1));
			foreach($aSentence as $key => $val){ 
				$this->db->ulearning_model->db_insert('tb_ulearning_sentence_answer',array("fsentence_id" => $val['fsentence_id'],"fsentence_answer" => $aArgs["answer_".$key]));
				$id[$key] = $this->db->ulearning_model->db_max('tb_ulearning_sentence_answer','fsentence_answer_id');
			}
			$this->insert_user_grade($aArgs['assign_id'],$aArgs['slide_id'],$aArgs['eval_id'],0,$id,'tb_ulearning_sentence_answer','fsentence_answer_id');
		}
		else if($aArgs['exam_type_id'] == 17){
			$aLong = $this->db->ulearning_model->db_select('tb_ulearning_slide', array("flong"), array("fslide_id" => $aArgs['slide_id']));
			for($i=0;$i<$aLong[0]['flong'];$i++){
				$this->db->ulearning_model->db_insert('tb_ulearning_long_answer',array("flong_answer" => $aArgs["answer_".$i]));
				$id[$i] = $this->db->ulearning_model->db_max('tb_ulearning_long_answer','flong_answer_id');
			}
			$this->insert_user_grade($aArgs['assign_id'],$aArgs['slide_id'],$aArgs['eval_id'],0,$id,'tb_ulearning_long_answer','flong_answer_id');
		}
	}
	
	private function insert_user_grade($assign_id,$slide_id,$eval_id,$grade,$id,$table,$field){
		$this->db->ulearning_model->db_update('tb_ulearning_test_evaluation',array("edate" => strtotime(date("Y-m-d"))),array("user_idx" => $this->user,"assign_id" => $assign_id));
		$this->db->ulearning_model->db_insert('tb_ulearning_user_grade',array("feval_id" => $eval_id,"fslide_id" => $slide_id,"fgrade" => $grade));
		$ug_id = $this->db->ulearning_model->db_max('tb_ulearning_user_grade','fuser_grade_id');
		foreach($id as $key => $val)
		$this->db->ulearning_model->db_update($table,array("fuser_grade_id" => $ug_id),array($field => $val));
	}
}

$oClass = new Save_answer();
$oClass->run($aArgs);
?>