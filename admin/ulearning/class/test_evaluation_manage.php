<?php
class Test_evaluation_manage extends Simplexi_Controller{
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		$this->importJS('ulearning/test_evaluation_manage');
		
		$aData['eval_id'] = $aArgs['eval_id'];
		$aEval = $this->db->ulearning_model->db_select_distinct("tb_ulearning_test_evaluation t1 INNER JOIN tb_ulearning_assign t2 ON t2.fassign_id = t1.fassign_id
									INNER JOIN tb_ulearning_unit t7 ON t7.funit_id = t2.funit_id
									INNER JOIN tb_ulearning_category t3 ON t7.fcategory_id = t3.fcategory_id
									INNER JOIN tb_ulearning_category t4 ON t3.fdepth2 = t4.fcategory_id
									INNER JOIN tb_ulearning_category t5 ON t4.fdepth1 = t5.fcategory_id
									INNER JOIN tb_user t6 ON t6.idx = t1.user_idx",array("status","t2.funit_id","name","user_id","t5.fcategory_name as cat1","t4.fcategory_name as cat2","t3.fcategory_name as cat3","ftitle"),
									array("eval_id" => $aArgs['eval_id']),null,1);
		$aData['totalSlide'] = $this->db->ulearning_model->db_count('tb_ulearning_user_grade',array('feval_id' => $aArgs['eval_id']));
		$aData['user'] = $aEval[0]['user_id'];
		$aData['name'] = $aEval[0]['name'];
		$aData['cat1'] = $aEval[0]['cat1'];
		$aData['cat2'] = $aEval[0]['cat2'];
		$aData['cat3'] = $aEval[0]['cat3'];
		$aData['status'] = $aEval[0]['status'];
		$aData['unit_title'] = $aEval[0]['ftitle'];
		$aSlide = $this->db->ulearning_model->db_select('tb_ulearning_slide',null,array('funit_id' => $aEval[0]['funit_id']),array("ASC" => 4,"DESC" => 1));
		//$aData['slideCount'] = count($aSlide);
		foreach($aSlide as $k => $v):
			$user_grade = $this->db->ulearning_model->db_select('tb_ulearning_user_grade',array("fgrade","fuser_grade_id"),
							array('fslide_id' => $v['fslide_id'],'feval_id' => $aArgs['eval_id']),null,1);
			$aSlide[$k]['fgrade_id'] = (isset($user_grade[0]))?$user_grade[0]['fuser_grade_id']:"";
			$aSlide[$k]['fgrade'] = (isset($user_grade[0]))?number_format($user_grade[0]['fgrade'], 2, '.', ''):"0.00";
			if($v['fexam_type_id'] == 2 || $v['fexam_type_id'] == 3 || $v['fexam_type_id'] == 5 || $v['fexam_type_id'] == 6){
				$aSlide[$k]['questions'] = $this->db->ulearning_model->db_select('tb_ulearning_multiple',array('fquestion','fanswer','fquestion_id'),array('fslide_id' => $v['fslide_id']),array('ASC' => 1));
				
				if($v['fexam_type_id'] == 6)
					$aSlide[$k]['questions'][0]['fquestion'] = "listen and answer correctly";
				if($aSlide[$k]['questions'])
	    			foreach($aSlide[$k]['questions'] as $key => $val):
						if($aSlide[$k]['fgrade_id'] !="")
						$aAnswer = $this->db->ulearning_model->db_select('tb_ulearning_multiple_answer',null,array('fquestion_id' => $val['fquestion_id'],'fuser_grade_id' => $user_grade[0]['fuser_grade_id']),array('ASC' => 1),1);
	    				$choice = $this->db->ulearning_model->db_select('tb_ulearning_multiple_choice',null,array('fquestion_id' => $val['fquestion_id']),array('ASC' => 1));
	    				foreach($choice as $idx => $value){
	    					if($val['fanswer'] == $idx+1)
	    						$aSlide[$k]['questions'][$key]['correct_answer'] = $value['fchoice'];
							if($aSlide[$k]['fgrade_id'] !=""){
								if($aAnswer && $aAnswer[0]['fanswer'] == $idx+1){
									$aSlide[$k]['questions'][$key]['user_answer'] = $value['fchoice'];
									$aSlide[$k]['questions'][$key]['fcomment'] = $aAnswer[0]['fcomment'];
									$aSlide[$k]['questions'][$key]['answer_id'] = $aAnswer[0]['fmultiple_answer_id'];
								}
							}else{
								$aSlide[$k]['questions'][$key]['user_answer'] = false;
								$aSlide[$k]['questions'][$key]['fcomment'] = false;
								$aSlide[$k]['questions'][$key]['answer_id'] = 0;
							}
	    				}
	    			endforeach;
			}
			else if($v['fexam_type_id'] == 7 || $v['fexam_type_id'] == 8 || $v['fexam_type_id'] == 9){
				$word = $this->db->ulearning_model->db_select('tb_ulearning_word',null,array('fslide_id' => $v['fslide_id']),array('ASC' => 1));
    			if($word){
					foreach($word as $key => $val){
						$word2 = $this->db->ulearning_model->db_select('tb_ulearning_word_answer',null,array('fword_id' => $val['fword_id'],'fuser_grade_id' => $aSlide[$k]['fgrade_id']),array('ASC' => 1),1);
						if($v['fexam_type_id'] == 7)
							$aSlide[$k]['questions'][$key]['fquestion'] = "Fill Up the words";
						else if($v['fexam_type_id'] == 8)
							$aSlide[$k]['questions'][$key]['fquestion'] = "Sentence Arrangements";
						else if($v['fexam_type_id'] == 9)
							$aSlide[$k]['questions'][$key]['fquestion'] = "Image & Listen<br />Write word";
							
						$aSlide[$k]['questions'][$key]['correct_answer'] = $val['fword'];
						if($aSlide[$k]['fgrade_id'] !=""){
							$aSlide[$k]['questions'][$key]['user_answer'] = $word2[0]['fword_answer'];
							$aSlide[$k]['questions'][$key]['fcomment'] = $word2[0]['fcomment'];
							$aSlide[$k]['questions'][$key]['answer_id'] = $word2[0]['fword_answer_id'];
						}else{
							$aSlide[$k]['questions'][$key]['user_answer'] = false;
							$aSlide[$k]['questions'][$key]['fcomment'] = false;
							$aSlide[$k]['questions'][$key]['answer_id'] = 0;
						}
    				}
    			}
			}
			else if($v['fexam_type_id'] == 10 || $v['fexam_type_id'] == 11){
				$sentence = $this->db->ulearning_model->db_select('tb_ulearning_sentence',null,array('fslide_id' => $v['fslide_id']),array('ASC' => 1));
				if($sentence){
					$d = 0;
					$word = $this->db->ulearning_model->db_select('tb_ulearning_word',null,array('fslide_id' => $v['fslide_id']),array('ASC' => 1));
					$word2 = $this->db->ulearning_model->db_select('tb_ulearning_word_answer',null,array('fuser_grade_id' => $aSlide[$k]['fgrade_id']),array('ASC' => 1));
					foreach($sentence as $key => $val){
						$aSlide[$k]['questions'][$key]['fquestion'] = $val['fsentence'];
						$temp2 = $temp = $val['fsentence'];
						// var_dump($word2[5]);
						for($i=0,$j=0;$i<count($word);$i++){
							if(strpos($temp, "[[blank#". ($i+1) ."]]") > -1){
								$temp = str_replace("[[blank#". ($i+1) ."]]", $word[$i]['fword'], $temp);
								if($aSlide[$k]['fgrade_id'] !=""){
									$temp2 = str_replace("[[blank#". ($i+1) ."]]", $word2[$d++]['fword_answer'], $temp2);
									if($j==0){
										$aSlide[$k]['questions'][$key]['fcomment'] = $word2[$d-1]['fcomment'];
										$aSlide[$k]['questions'][$key]['answer_id'] = $word2[$d-1]['fword_answer_id'];
										$j++;
									}
								}else{
									
									$aSlide[$k]['questions'][$key]['fcomment'] = false;
									$aSlide[$k]['questions'][$key]['answer_id'] = 0;
								}
							}
							
						}
						$aSlide[$k]['questions'][$key]['correct_answer'] = $temp;
						if($aSlide[$k]['fgrade_id'] !="")
							$aSlide[$k]['questions'][$key]['user_answer'] = $temp2;
						else
							$aSlide[$k]['questions'][$key]['user_answer'] = false;
					}
				}
			}
			else if($v['fexam_type_id'] == 12 || $v['fexam_type_id'] == 13 || $v['fexam_type_id'] == 14 || $v['fexam_type_id'] == 16){
				$sentence = $this->db->ulearning_model->db_select('tb_ulearning_sentence',null,array('fslide_id' => $v['fslide_id']),array('ASC' => 1));
				if($sentence){
					foreach($sentence as $key => $val){
						$sentence_answer = $this->db->ulearning_model->db_select('tb_ulearning_sentence_answer',null,array('fsentence_id' => $val['fsentence_id'],'fuser_grade_id' => $aSlide[$k]['fgrade_id']),array('ASC' => 1),1);
						if($v['fexam_type_id'] == 12){
							$aSlide[$k]['questions'][$key]['fquestion'] = "Image or Voice Q.<br />Text n S. Voice";
							$aSlide[$k]['questions'][$key]['correct_answer'] = $val['fsentence'];
							if($aSlide[$k]['fgrade_id'] !=""){
								$aSlide[$k]['questions'][$key]['user_answer'] = ($val['fvoice'] == 1)?$sentence_answer[0]['fvoice_answer']:0;//'a1.mp3';
								$aSlide[$k]['questions'][$key]['fcomment'] = ($val['fvoice'] == 1)?$sentence_answer[0]['fcomment']:0;
								$aSlide[$k]['questions'][$key]['answer_id'] = ($val['fvoice'] == 1)?$sentence_answer[0]['fsentence_answer_id']:0;
							}else{
								$aSlide[$k]['questions'][$key]['user_answer'] = false;
								$aSlide[$k]['questions'][$key]['fcomment'] = false;
								$aSlide[$k]['questions'][$key]['answer_id'] = 0;
							}
						}else if($v['fexam_type_id'] == 13){
							$aSlide[$k]['questions'][$key]['fquestion'] = "Image and Listen<br />Voice Answer";
							$aSlide[$k]['questions'][$key]['correct_answer'] = "<img src='" . BASE_URL . "image.php?h=50&cr=4:4&path=ulearning/question_upload/".$val['fimage']."' height='50' width='50' />";
							if($aSlide[$k]['fgrade_id'] !=""){
								$aSlide[$k]['questions'][$key]['user_answer'] = ($val['fvoice'] == 1)?$sentence_answer[0]['fvoice_answer']:0;//'a1.mp3';
								$aSlide[$k]['questions'][$key]['fcomment'] = ($val['fvoice'] == 1)?$sentence_answer[0]['fcomment']:0;
								$aSlide[$k]['questions'][$key]['answer_id'] = ($val['fvoice'] == 1)?$sentence_answer[0]['fsentence_answer_id']:0;
							}else{
								$aSlide[$k]['questions'][$key]['user_answer'] = false;
								$aSlide[$k]['questions'][$key]['fcomment'] = false;
								$aSlide[$k]['questions'][$key]['answer_id'] = 0;
							}
						}else if($v['fexam_type_id'] == 14){
							$aSlide[$k]['questions'][$key]['fquestion'] = "Image and Listen<br />Voice Answer";
							$aSlide[$k]['questions'][$key]['correct_answer'] = "<img src='" . BASE_URL . "image.php?h=50&cr=4:4&path=ulearning/question_upload/".$val['fimage']."' height='50' width='50' /><br />".$val['fsentence'];
							if($aSlide[$k]['fgrade_id'] !=""){
								$aSlide[$k]['questions'][$key]['user_answer'] = ($val['fvoice'] == 1)?$sentence_answer[0]['fvoice_answer']:0;//'a1.mp3';
								$aSlide[$k]['questions'][$key]['fcomment'] = ($val['fvoice'] == 1)?$sentence_answer[0]['fcomment']:0;
								$aSlide[$k]['questions'][$key]['answer_id'] = ($val['fvoice'] == 1)?$sentence_answer[0]['fsentence_answer_id']:0;
							}else{
								$aSlide[$k]['questions'][$key]['user_answer'] = false;
								$aSlide[$k]['questions'][$key]['fcomment'] = false;
								$aSlide[$k]['questions'][$key]['answer_id'] = 0;
							}
						}
						else if($v['fexam_type_id'] == 16){
							$aSlide[$k]['questions'][$key]['fquestion'] = "Sentence Making";
							$aSlide[$k]['questions'][$key]['correct_answer'] = $val['fsentence'];
							if($aSlide[$k]['fgrade_id'] !=""){
								$aSlide[$k]['questions'][$key]['user_answer'] = $sentence_answer[0]['fsentence_answer'];
								$aSlide[$k]['questions'][$key]['fcomment'] = $sentence_answer[0]['fcomment'];
								$aSlide[$k]['questions'][$key]['answer_id'] = $sentence_answer[0]['fsentence_answer_id'];
							}else{
								$aSlide[$k]['questions'][$key]['user_answer'] = false;
								$aSlide[$k]['questions'][$key]['fcomment'] = false;
								$aSlide[$k]['questions'][$key]['answer_id'] = 0;
							}
						}
    				}
    			}
			}
			else if($v['fexam_type_id'] == 15 || $v['fexam_type_id'] == 18){
				$aSlide[$k]['questions'][0]['fquestion'] = "Answer with your voice";
				$aSlide[$k]['questions'][0]['correct_answer'] = "No Specific Correct Answer";
				if($aSlide[$k]['fgrade_id'] !=""){
					$aSlide[$k]['questions'][0]['user_answer'] = $v['frecorded'];//'a1.mp3';
					$aSlide[$k]['questions'][0]['fcomment'] = $v['fcomment'];//'a1.mp3';
					$aSlide[$k]['questions'][0]['answer_id'] = $v['fslide_id'];
				}else{
					$aSlide[$k]['questions'][0]['user_answer'] = false;
					$aSlide[$k]['questions'][0]['fcomment'] = false;
					$aSlide[$k]['questions'][0]['answer_id'] = 0;
				}
			}
			else if($v['fexam_type_id'] == 17){
				$long_answer = $this->db->ulearning_model->db_select('tb_ulearning_long_answer',null,array('fuser_grade_id' => $aSlide[$k]['fgrade_id']),array('ASC' => 1));
				for($i = 0;$i < (int)($aSlide[$k]['flong']);$i++){
					$aSlide[$k]['questions'][$i]['fquestion'] = "Long Writing by<br />Topic";
					$aSlide[$k]['questions'][$i]['correct_answer'] = "No Specific Correct Answer";
					if($aSlide[$k]['fgrade_id'] !=""){
						$aSlide[$k]['questions'][$i]['user_answer'] = $long_answer[$i]['flong_answer'];
						$aSlide[$k]['questions'][$i]['fcomment'] = $long_answer[$i]['fcomment'];
						$aSlide[$k]['questions'][$i]['answer_id'] = $long_answer[$i]['flong_answer_id'];
					}else{
						$aSlide[$k]['questions'][$i]['user_answer'] = false;
						$aSlide[$k]['questions'][$i]['fcomment'] = false;
						$aSlide[$k]['questions'][$i]['answer_id'] = 0;
					}
				}
			}
		endforeach;
		$aData['slide'] = $aSlide;
		$this->display("ulearning/test_evaluation_manage",$aData);
	}
}
?>