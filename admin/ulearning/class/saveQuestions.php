<?php
class SaveQuestions extends Simplexi_Controller{
	public function run($aArgs){
		$this->library('common');
		$this->model('ulearning_model');
		if($aArgs['type'] == 2){
			$question = array();
			$answer = array();
			for($i=1;$i<=6;$i++){
				$question[$i-1] = $aArgs['question_'.$i];
				$answer[$i-1] = $aArgs['answer_'.$i];
			}
			$choice = array();
			for($i=1,$j=1,$x=1;$x<=30;$x++,$j++){
				if($j>5){
					$j-=5;
					$i++;
				}
				$choice[$x-1] = $aArgs['choice_'.$i.$j];
			}
			$choice_count = 0;
			foreach($question as $i => $v){
				if($question[$i] != ""){
					$this->db->ulearning_model->db_insert("tb_ulearning_multiple",array("fslide_id" => $aArgs['slide_id'],
														"fquestion" => $question[$i], "fanswer" => $answer[$i]));
					$question_id = $this->db->ulearning_model->db_max("tb_ulearning_multiple","fquestion_id");
					for($idx=0;$idx<5;$idx++){
						if($choice[$choice_count] == ""){
							$choice_count = ($i+1)*5;break;}
						$this->db->ulearning_model->db_insert("tb_ulearning_multiple_choice",array("fquestion_id" => $question_id,
						"fchoice" => $choice[$choice_count]));
						$choice_count++;
					}
				}
			}
		}else if($aArgs['type'] == 3){
			$question = array();
			$answer = array();
			for($i=1;$i<=5;$i++){
				$question[$i-1] = $aArgs['question_'.$i];
				$answer[$i-1] = $aArgs['answer_'.$i];
			}
			$choice = array();
			for($i=1,$j=1,$x=1;$x<=25;$x++,$j++){
				if($j>5){
					$j-=5;
					$i++;
				}
				$choice[$x-1] = $aArgs['choice_'.$i.$j];
			}
			$choice_count = 0;
			foreach($question as $i => $v){
				if($question[$i] != ""){
					$this->db->ulearning_model->db_insert("tb_ulearning_multiple",array("fslide_id" => $aArgs['slide_id'],
														"fquestion" => $question[$i], "fanswer" => $answer[$i]));
					$question_id = $this->db->ulearning_model->db_max("tb_ulearning_multiple","fquestion_id");
					for($idx=0;$idx<5;$idx++){
						if($choice[$choice_count] == ""){
							$choice_count = ($i+1)*5;break;}
						$this->db->ulearning_model->db_insert("tb_ulearning_multiple_choice",array("fquestion_id" => $question_id,
						"fchoice" => $choice[$choice_count]));
						$choice_count++;
					}
				}
			}
		}else if($aArgs['type'] == 5){
			$question = array();
			$answer = array();
			$image = array();
			for($i=1;$i<=4;$i++){
				$question[$i-1] = $aArgs['question_'.$i];
				$answer[$i-1] = $aArgs['answer_'.$i];
				if($aArgs['image_'.$i] != "")
					$image[$i-1] = $_FILES['image_'.$i]['name'];
			}
			$choice = array();
			for($i=1,$j=1,$x=1;$x<=20;$x++,$j++){
				if($j>5){
					$j-=5;
					$i++;
				}
				$choice[$x-1] = $aArgs['choice_'.$i.$j];
			}
			$choice_count = 0;
			foreach($question as $i => $v){
				if($question[$i] != ""){
					$this->db->ulearning_model->db_insert("tb_ulearning_multiple",array("fslide_id" => $aArgs['slide_id'],
														"fquestion" => $question[$i], "fanswer" => $answer[$i]));
					$question_id = $this->db->ulearning_model->db_max("tb_ulearning_multiple","fquestion_id");
					if($aArgs['image_'.($i+1)] != ""){
						$ext = explode(".",$_FILES['image_'.($i+1)]['name']);
						move_uploaded_file($_FILES['image_'.($i+1)]['tmp_name'],"../../../uploads/ulearning/question_upload/t5_".$aArgs['slide_id']."_".$question_id.".".end($ext));
						$this->db->ulearning_model->db_update("tb_ulearning_multiple",array("fimage" => "t5_".$aArgs['slide_id']."_".$question_id.".".end($ext)),array("fquestion_id" => $question_id));
					}
					for($idx=0;$idx<5;$idx++){
						if($choice[$choice_count] == ""){
							$choice_count = ($i+1)*5;break;}
						$this->db->ulearning_model->db_insert("tb_ulearning_multiple_choice",array("fquestion_id" => $question_id,
						"fchoice" => $choice[$choice_count]));
						$choice_count++;
					}
				}
			}
		}else if($aArgs['type'] == 6){
			$this->db->ulearning_model->db_insert("tb_ulearning_multiple",array("fslide_id" => $aArgs['slide_id'],"fanswer" => $aArgs['answer']));
			$question_id = $this->db->ulearning_model->db_max("tb_ulearning_multiple","fquestion_id");
			for($idx=1;$idx<=5;$idx++){
				if($aArgs['choice_'.$idx] == "")
					break;
				$this->db->ulearning_model->db_insert("tb_ulearning_multiple_choice",array("fquestion_id" => $question_id,
				"fchoice" => $aArgs['choice_'.$idx]));
			}
		}else if($aArgs['type'] == 7){
			for($i=1;$i<=6;$i++){
				if($aArgs['word_'.$i] == "")
					break;
				$this->db->ulearning_model->db_insert("tb_ulearning_word",array("fslide_id" => $aArgs['slide_id'],"fword" => $aArgs['word_'.$i]));
			}
		}else if($aArgs['type'] == 8){
			for($i=1;$i<=12;$i++){
				if($aArgs['word_'.$i] == ""){ break; }
				$this->db->ulearning_model->db_insert("tb_ulearning_word",array("fslide_id" => $aArgs['slide_id'],"fword" => $aArgs['word_'.$i]));
			}
		}else if($aArgs['type'] == 9){
			for($i=1;$i<=4;$i++){
				if($aArgs['word_'.$i] == ""){ break; }
				$type = explode("/",$_FILES['image_'.$i]['type']);
				if($type[0] != "image"){ break; }
				$this->db->ulearning_model->db_insert("tb_ulearning_word",array("fslide_id" => $aArgs['slide_id'],"fword" => $aArgs['word_'.$i]));
				$id = $this->db->ulearning_model->db_max("tb_ulearning_word","fword_id");
				$ext = explode(".",$_FILES['image_'.$i]['name']);
				move_uploaded_file($_FILES['image_'.$i]['tmp_name'],"../../../uploads/ulearning/question_upload/t9_".$id."_".$i.".".end($ext));
				$this->db->ulearning_model->db_update("tb_ulearning_word",array("fimage" => "t9_".$id."_".$i.".".end($ext)),array("fword_id" => $id));
			}
		}else if($aArgs['type'] == 10){
			for($i=1;$i<=6;$i++){
				if($aArgs['sentence_'.$i] == ""){ break; }
				$this->db->ulearning_model->db_insert("tb_ulearning_sentence",array("fslide_id" => $aArgs['slide_id'],"fsentence" => $aArgs['sentence_'.$i]));
			}
			if($i>1){
				for($i=1;$i<=12;$i++){
					if($aArgs['word_'.$i] == ""){ break; }
					$this->db->ulearning_model->db_insert("tb_ulearning_word",array("fslide_id" => $aArgs['slide_id'],"fword" => $aArgs['word_'.$i]));
				}
			}
		}else if($aArgs['type'] == 11){
			if($aArgs['sentence'] != ""){
				$this->db->ulearning_model->db_insert("tb_ulearning_sentence",array("fslide_id" => $aArgs['slide_id'],"fsentence" => $aArgs['sentence']));
				for($i=1;$i<=12;$i++){
					if($aArgs['word_'.$i] == ""){ break; }
					$this->db->ulearning_model->db_insert("tb_ulearning_word",array("fslide_id" => $aArgs['slide_id'],"fword" => $aArgs['word_'.$i]));
				}
			}
		}else if($aArgs['type'] == 12){
			for($i=1;$i<=4;$i++){
				if($aArgs['question_'.$i] != ""){ 
					$this->db->ulearning_model->db_insert("tb_ulearning_sentence",array("fslide_id" => $aArgs['slide_id'],"fsentence" => $aArgs['question_'.$i],"fvoice" => $aArgs['radio_'.$i]));
				}else{
					break;
				}
			}
		}else if($aArgs['type'] == 13){
			for($i=1;$i<=4;$i++){
				if($aArgs['image_'.$i] == ""){ break; }
				$type = explode("/",$_FILES['image_'.$i]['type']);
				if($type[0] != "image"){ break; }
					$this->db->ulearning_model->db_insert("tb_ulearning_sentence",array("fslide_id" => $aArgs['slide_id'],"fvoice" => $aArgs['radio_'.$i]));
					$id = $this->db->ulearning_model->db_max("tb_ulearning_sentence","fsentence_id");
					$ext = explode(".",$_FILES['image_'.$i]['name']);
					move_uploaded_file($_FILES['image_'.$i]['tmp_name'],"../../../uploads/ulearning/question_upload/t13_".$id."_".$i.".".end($ext));
					$this->db->ulearning_model->db_update("tb_ulearning_sentence",array("fimage" => "t13_".$id."_".$i.".".end($ext)),array("fsentence_id" => $id));
			}
		}else if($aArgs['type'] == 14){
			for($i=1;$i<=3;$i++){
				if($aArgs['image_'.$i] == "" || $aArgs['question_'.$i] == ""){ break; }
				$type = explode("/",$_FILES['image_'.$i]['type']);
				if($type[0] != "image"){ break; }
					$this->db->ulearning_model->db_insert("tb_ulearning_sentence",array("fslide_id" => $aArgs['slide_id'],"fsentence" => $aArgs['question_'.$i],"fvoice" => $aArgs['radio_'.$i]));
					$id = $this->db->ulearning_model->db_max("tb_ulearning_sentence","fsentence_id");
					$ext = explode(".",$_FILES['image_'.$i]['name']);
					move_uploaded_file($_FILES['image_'.$i]['tmp_name'],"../../../uploads/ulearning/question_upload/t14_".$id."_".$i.".".end($ext));
					$this->db->ulearning_model->db_update("tb_ulearning_sentence",array("fimage" => "t14_".$id."_".$i.".".end($ext)),array("fsentence_id" => $id));
			}
		}else if($aArgs['type'] == 16){
			for($i=1;$i<=6;$i++){
				if($aArgs['word_'.$i] == "")
					break;
				$this->db->ulearning_model->db_insert("tb_ulearning_sentence",array("fslide_id" => $aArgs['slide_id'],"fsentence" => $aArgs['sentence_'.$i]));
			}
		}
		else if($aArgs['type'] == 17){
			$this->db->ulearning_model->db_update("tb_ulearning_slide",array("flong" => $aArgs['long']),array("fslide_id" => $aArgs['slide_id']));
		}
		else if($aArgs['type'] == 19){
			if(isset($_FILES['doc']['name']) && $_FILES['doc']['name'] != ""){
			$name = explode(".",$_FILES['doc']['name']);
				if(end($name) == "doc" || end($name) == "docx"){
					$this->db->ulearning_model->db_insert("tb_ulearning_movie_question",array("fslide_id" => $aArgs['slide_id'],"fmovie_clip_id" => $aArgs['cat3']));
					$id = $this->db->ulearning_model->db_max("tb_ulearning_movie_question","fmovie_question_id");
					move_uploaded_file($_FILES['doc']['tmp_name'],"../../../uploads/ulearning/question_upload/t19_".$id.".".end($name));
					$this->db->ulearning_model->db_update("tb_ulearning_movie_question",array("fword_script" => "t19_".$id.".".end($name)),array("fmovie_question_id" => $id));
					echo 1;
				}else
					echo 0;
			}else{
				$this->db->ulearning_model->db_insert("tb_ulearning_movie_question",array("fslide_id" => $aArgs['slide_id'],"fmovie_clip_id" => $aArgs['cat3']));
				echo 1;
			}
		}
		else if($aArgs['type'] == 20){
			if(isset($_FILES['doc_20']['name']) && $_FILES['doc_20']['name'] != ""){
			$name = explode(".",$_FILES['doc_20']['name']);
				if(end($name) == "doc" || end($name) == "docx"){
					$this->db->ulearning_model->db_insert("tb_ulearning_movie_question",array("fslide_id" => $aArgs['slide_id'],"fmovie_clip_id" => $aArgs['cat6'],"ftodays_object" => $aArgs['todays_object'],
														"frelated_article" => $aArgs['related_article']));
					$id = $this->db->ulearning_model->db_max("tb_ulearning_movie_question","fmovie_question_id");
					move_uploaded_file($_FILES['doc_20']['tmp_name'],"../../../uploads/ulearning/question_upload/t20_".$id.".".end($name));
					$this->db->ulearning_model->db_update("tb_ulearning_movie_question",array("fword_script" => "t20_".$id.".".end($name)),array("fmovie_question_id" => $id));
					for($i=1;$i<=6;$i++){
						if($aArgs['warm_up_q_'.$i] == ""){ break; }
						$this->db->ulearning_model->db_insert("tb_ulearning_warmup_question",array("fmovie_question_id" => $id,"fwarmup_question" => $aArgs['warm_up_q_'.$i]));
					}
					for($i=1;$i<=10;$i++){
						if($aArgs['disque_q_'.$i] == ""){ break; }
						$this->db->ulearning_model->db_insert("tb_ulearning_disquession_question",array("fmovie_question_id" => $id,"fdisquession_question" => $aArgs['disque_q_'.$i]));
					}
					for($i=1;$i<=5;$i++){
						if($aArgs['debate_'.$i] == ""){ break; }
						$this->db->ulearning_model->db_insert("tb_ulearning_lets_debate",array("fmovie_question_id" => $id,"flets_debate" => $aArgs['debate_'.$i]));
					}
					echo 1;
				}else{
					echo 0;
				}
			}else{
				$this->db->ulearning_model->db_insert("tb_ulearning_movie_question",array("fslide_id" => $aArgs['slide_id'],"fmovie_clip_id" => $aArgs['cat6'],"ftodays_object" => $aArgs['todays_object'],
													"frelated_article" => $aArgs['related_article']));
				$id = $this->db->ulearning_model->db_max("tb_ulearning_movie_question","fmovie_question_id");
				for($i=1;$i<=6;$i++){
					if($aArgs['warm_up_q_'.$i] == ""){ break; }
					$this->db->ulearning_model->db_insert("tb_ulearning_warmup_question",array("fmovie_question_id" => $id,"fwarmup_question" => $aArgs['warm_up_q_'.$i]));
				}
				for($i=1;$i<=10;$i++){
					if($aArgs['disque_q_'.$i] == ""){ break; }
					$this->db->ulearning_model->db_insert("tb_ulearning_disquession_question",array("fmovie_question_id" => $id,"fdisquession_question" => $aArgs['disque_q_'.$i]));
				}
				for($i=1;$i<=5;$i++){
					if($aArgs['debate_'.$i] == ""){ break; }
					$this->db->ulearning_model->db_insert("tb_ulearning_lets_debate",array("fmovie_question_id" => $id,"flets_debate" => $aArgs['debate_'.$i]));
				}
				echo 1;
			}
		}
	}
}
?>