<?php
class Preview_slide extends Simplexi_Controller{
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		
		$str = '';
		$aData['date'] = date("Y.m.d");
		$aData['preview'] = $this->db->ulearning_model->db_select('tb_ulearning_slide', null, array("fslide_id" => $aArgs['slide_id']));
		
			$aData['hours'] = floor($aData['preview'][0]['ftime_limit'] / (60 * 60));
			$divisor_for_minutes = $aData['preview'][0]['ftime_limit'] % (60 * 60);
			$aData['minutes'] = floor($divisor_for_minutes / 60);
			$divisor_for_seconds = $divisor_for_minutes % 60;
			$aData['seconds'] = ceil($divisor_for_seconds);
		if($aData['preview'][0]['fexam_type_id'] == 1){
		
		}else if($aData['preview'][0]['fexam_type_id'] == 2 || $aData['preview'][0]['fexam_type_id'] == 3 || $aData['preview'][0]['fexam_type_id'] == 5 || $aData['preview'][0]['fexam_type_id'] == 6){
			$aQuestions = $this->db->ulearning_model->db_select('tb_ulearning_multiple', null, array("fslide_id" => $aData['preview'][0]['fslide_id']), array("ASC" => 1));
			foreach($aQuestions as $key => $val){ 
				$str .= '<div class="row_container"><div class="h_box_exp count validated_'.$key.'">';
				if($val['fimage']){
					$str .= '<img style="float:left; margin:7px 7px 20px 15px" src="' . BASE_URL . 'image.php?w=250&path=ulearning/question_upload/'. $val['fimage'] .'" />';
				}
				$str .= '<p class="text">'.$val['fquestion'].'</p>';
				$aChoices = $this->db->ulearning_model->db_select('tb_ulearning_multiple_choice', null, array("fquestion_id" => $val['fquestion_id']));
				foreach($aChoices as $k => $v){
					$str .= '<div class="multiple_choice_w">';
					$str .= '<input type="radio" name="choice_'. $key .'" value="'.($k+1).'" />';
					$str .= '<p class="m_choice">'. ($k+1) .'.'. $v['fchoice'] .'</p>';
					$str .= '</div>';
				}
				$str .= '</div></div>';
			}
			$aData['contents'] = $str;
		}else if($aData['preview'][0]['fexam_type_id'] == 4){
		
		}else if($aData['preview'][0]['fexam_type_id'] == 7){
			$str .= '<div class="row_container"><div class="h_box_exp">';
			$aWords = $this->db->ulearning_model->db_select('tb_ulearning_word', null, array("fslide_id" => $aData['preview'][0]['fslide_id']));
			foreach($aWords as $key => $val){
				if((($key)%3) == 0){
					$str .= '<div class="row_container" style="margin-top:5px">';
				}
				$str .= '<div class="answer">';
				$str .= '<p>'. ($key+1) .'.</p>';
				$str .= '<div class="answer_box count validated_'.$key.'"><input type="text" name="answer_'. $key .'" /></div></div>';
				if((($key)%3) == 2){
					$str .= '</div>';
				}
			}
			if((($key)%3) != 2){
				$str .= '</div>';
			}
			$str .= '</div></div>';
			$aData['contents'] = $str;
		}else if($aData['preview'][0]['fexam_type_id'] == 8){
			$str .= '<div class="row_container"><div class="h_box_exp">';
			$str .= '<div class="row_container" style="margin-top:5px">';
			$str .= '<p class="choices_2">';
			$aWords = $this->db->ulearning_model->db_select('tb_ulearning_word', null, array("fslide_id" => $aData['preview'][0]['fslide_id']));
			shuffle($aWords);
			foreach($aWords as $key => $val){
				$str .= '<span class="answer_2">'. $val['fword'] .'</span>';
				if(($key+1) != count($aWords)){
					$str .= ' / ';
				}
			}
			$str .= '</p></div>';
			foreach($aWords as $key => $val){
				if((($key)%5) == 0){
					$str .= '<div class="row_container" style="width:100%;margin-top:5px;text-align:center;display:inline-block">';
					$str .= '<div style="width:auto;display:inline-block">';
				}
				$str .= '<div class="answer_box_2 count validated_'.$key.'"><input type="text" name="answer_'. $key .'" /></div>';
				if((($key)%5) == 4){
					$str .= '</div></div>';
				}
			}
			if((($key)%5) != 4){
				$str .= '</div></div>';
			}
			$str .= '</div></div>';
			$aData['contents'] = $str;
		}else if($aData['preview'][0]['fexam_type_id'] == 9){
			$str .= '<div class="row_container"><div class="h_box_exp">';
			$aWords = $this->db->ulearning_model->db_select('tb_ulearning_word', null, array("fslide_id" => $aData['preview'][0]['fslide_id']));
			foreach($aWords as $key => $val){
				$str .= '<div class="row_container" style="width:100%;padding-bottom:10px;text-align:center;border-bottom:1px solid #989898;margin-bottom:10px">';
				$str .= '<div style="width:auto;display:inline-block;">';
				$str .= '<p style="margin-top:10px"><img src="' . BASE_URL . 'image.php?w=300&path=ulearning/question_upload/'. $val['fimage'] .'" /></p>';
				$str .= '<div class="answer_box_2 count validated_'.$key.'" style="width:auto;"><input type="text" style="width:292px;" name="answer_'. $key .'" /></div></div></div>';
			}
			$str .= '</div></div>';
			$aData['contents'] = $str;
		}else if($aData['preview'][0]['fexam_type_id'] == 10 || $aData['preview'][0]['fexam_type_id'] == 11){
			$str .= '<div class="row_container"><div class="h_box_exp"><div class="exam_box">';
			$aSentence = $this->db->ulearning_model->db_select('tb_ulearning_sentence', null, array("fslide_id" => $aData['preview'][0]['fslide_id']));
			foreach($aSentence as $key => $val){
				if($aData['preview'][0]['fexam_type_id'] == 10)
					$str .= '<p class="exam count" style="margin-top:10px;">'.($key+1) .'. ';
				else
					$str .= '<p class="exam count" style="margin-top:10px;">';
				$temp = $val['fsentence'];
				for($i=0,$n=0;$i<12;$i++){
					if(strpos($temp, '[[blank#'.($i+1).']]', 0) > -1){
						$temp = str_replace("[[blank#". ($i+1) ."]]", "<span class='answer_box_3 validated_".$key."_".$i."_".$n."' ><input type='text' name='answer_".$key."_".$i."_".$n."' /></span>", $temp);
						$i--;$n++;
					}else{
						$n=0;
					}
					
				}
				$str .= $temp;
				$str .= '</p>';
			}
			$str .= '</div></div></div>';
			$aData['contents'] = $str;
		}else if($aData['preview'][0]['fexam_type_id'] == 12){
			$str .= '<div class="row_container"><div class="h_box_exp"><div class="exam_box">';
			$aSentence = $this->db->ulearning_model->db_select('tb_ulearning_sentence', null, array("fslide_id" => $aData['preview'][0]['fslide_id']));
			foreach($aSentence as $key => $val){
				$str .= '<div class="exam">';
				$str .= '<strong class="question_number">'. ($key+1) .'.</strong>';
				$str .= '<p class="question_a">'. $val['fsentence'] .'</p>';
				if($val['fvoice'] == 1){
					$str .= '<div class="timer_column">';
					$str .= '<p class="timer_title">Time</p>';
					$str .= '<p class="play_timer"><span class="time_remaining">00:00:00</span></p>	';	
					$str .= '</div>';
					$str .= '<ul class="exam_control">';
					$str .= '<li><input type="button" class="control_rec" /></li>';
					$str .= '<li><input type="button" class="control_play" /></li>';
					$str .= '</ul>';
				}
				$str .= '</div>';
			}
			$str .= '</div></div></div>';
			$aData['contents'] = $str;
		}else if($aData['preview'][0]['fexam_type_id'] == 13){
			$aSentence = $this->db->ulearning_model->db_select('tb_ulearning_sentence', null, array("fslide_id" => $aData['preview'][0]['fslide_id']));
			foreach($aSentence as $key => $val){
				if((($key)%2) == 0){
					$str .= '<div class="row_container">';
				}
				$str .= '<div class="m_vid_box_fix ">';
				$str .= '<div class="m_video_box"><img src="' . BASE_URL . 'image.php?h=244&cr=16:9.49&path=ulearning/question_upload/'. $val['fimage'] .'"  /></div>';
				if($val['fvoice'] == 1){
					$str .= '<div class="m_control_box_2">';
					$str .= '<ul class="video_control">';
					$str .= '<li class="vid_timer_column"><p class="timer_title">Time</p><p class="play_timer"><span class="time_remaining">00:00:00</span></p></li>';
					$str .= '<li><input type="button" class="control_rec" /></li>';
					$str .= '<li><input type="button" class="control_play" /></li>';
					$str .= '</ul>';
					$str .= '</div>';
				}
				$str .= '</div>';
				if((($key)%2) == 1){
					$str .= '</div>';
				}
			}
			if((($key)%2) != 1){
				$str .= '</div>';
			}
			$aData['contents'] = $str;
		}else if($aData['preview'][0]['fexam_type_id'] == 14){
			$str .= '<div class="row_container"><div class="h_box_exp">';
			$aSentence = $this->db->ulearning_model->db_select('tb_ulearning_sentence', null, array("fslide_id" => $aData['preview'][0]['fslide_id']));
			foreach($aSentence as $key => $val){
				$str .= '<div class="row_container  test14">';
				$str .= '<div class="row_container box_question_14"><p>'. ($key+1) .'. '. $val['fsentence'] .'</p></div>';
				$str .= '<div class="m_vid_box_fix">';
				$str .= '<div class="m_video_box"><img src="' . BASE_URL . 'image.php?h=244&cr=16:9.49&path=ulearning/question_upload/'. $val['fimage'] .'" /></div>';
				if($val['fvoice'] == 1){
					$str .= '<div class="m_control_box_2">';
					$str .= '<ul class="video_control">';
					$str .= '<li class="vid_timer_column"><p class="timer_title">Time</p><p class="play_timer"><span class="time_remaining">00:00:00</span></p></li>';
					$str .= '<li><input type="button" class="control_rec" /></li>';
					$str .= '<li><input type="button" class="control_play" /></li>';
					$str .= '</ul>';
					$str .= '</div>';
				}
				$str .= '</div></div>';
			}
			$str .= '</div></div>';
			$aData['contents'] = $str;
		}else if($aData['preview'][0]['fexam_type_id'] == 15){
		
		}else if($aData['preview'][0]['fexam_type_id'] == 16){
			$str .= '<div class="row_container"><div class="h_box_exp"><div class="exam_box">';
			$aSentence = $this->db->ulearning_model->db_select('tb_ulearning_sentence', null, array("fslide_id" => $aData['preview'][0]['fslide_id']));
			foreach($aSentence as $key => $val){
				$str .= '<div class="exam">';
				$str .= '<strong class="question_number">'. ($key+1) .'.</strong>';
				$str .= '<p class="question_a">'. $val['fsentence'] .'</p>';
				$str .= '<div class="row_container"><div class="answer_box_2 count validated_'.$key.'" style="width:auto;"><input type="text" style="width:500px;" name="answer_'. $key .'" /></div></div>';
				$str .= '</div>';
			}
			$str .= '</div></div></div>';
			$aData['contents'] = $str;
		}else if($aData['preview'][0]['fexam_type_id'] == 17){
			$str .= '<div class="row_container">';
			for($i=0;$i< $aData['preview'][0]['flong'];$i++){
				$str .= '<textarea class="answer_area count validated_'.$i.'" name="answer_'.$i.'" style="margin:10px 0 5px 0;"></textarea>';
			}
			$str .= '</div>';
			$aData['contents'] = $str;
		}else if($aData['preview'][0]['fexam_type_id'] == 18){
		
		}else if($aData['preview'][0]['fexam_type_id'] == 19){
			$aClip = $this->db->ulearning_model->db_select('tb_ulearning_movie_question t1 INNER JOIN tb_ulearning_movie_clip t2 ON t1.fmovie_clip_id = t2.movie_clip_id', null, array("fslide_id" => $aData['preview'][0]['fslide_id']),null,1);
			$aData['video'] = $aClip[0]['movie_clip_url'];
			$aClip = $this->db->ulearning_model->db_select('tb_ulearning_movie_clip t1 INNER JOIN tb_ulearning_movie_category_name t2 ON t1.movie_clip_cat_name_id = t2.movie_cat_name_id
															INNER JOIN tb_ulearning_movie_category t3 ON t2.movie_category_id = t3.movie_cat_id',array('movie_category','movie_category_name','movie_clip_title','movie_clip_description','movie_clip_url','movie_clip_image'),null,array('ASC' => 1));
			foreach($aClip as $key => $val):
				$str .= '<li>
					<p class="video_gallery"><strong>'.$val['movie_category'].' > '.$val['movie_category_name'].'</strong></p>
					<a href="'.$val['movie_clip_url'].'" target="video_content"><img src="' . BASE_URL . 'image.php?w=136&cr=8.5:4&path=ulearning/upload/'.$val['movie_clip_image'].'" alt="thumbnail image d2" style="margin-bottom:5px;" /></a>
					<div class="video_info">
						<strong class="video_title">'.$val['movie_clip_title'].'</strong>
						<p class="video_description">'.$val['movie_clip_description'].'</p>
						<p class="video_views"></p>
					</div>
				</li>';
			endforeach;
			$aData['contents'] = $str;

		}else if($aData['preview'][0]['fexam_type_id'] == 20){
			$aClip = $this->db->ulearning_model->db_select('tb_ulearning_movie_question t1 INNER JOIN tb_ulearning_movie_clip t2 ON t1.fmovie_clip_id = t2.movie_clip_id', null, array("fslide_id" => $aData['preview'][0]['fslide_id']),null,1);
			$aData['video'] = $aClip[0]['movie_clip_url'];
			$aWarmUp = $this->db->ulearning_model->db_select('tb_ulearning_warmup_question', null, array("fmovie_question_id" => $aClip[0]['fmovie_question_id']));
			$aDiscussion = $this->db->ulearning_model->db_select('tb_ulearning_disquession_question', null, array("fmovie_question_id" => $aClip[0]['fmovie_question_id']));
			$aDebate = $this->db->ulearning_model->db_select('tb_ulearning_lets_debate', null, array("fmovie_question_id" => $aClip[0]['fmovie_question_id']));
			$str .= '<ul>
				<li>
					<p class="video_gallery"><strong>Today\'s Objective</strong></p>
					'.$aClip[0]['ftodays_object'].'
				</li>
				<li>
					<ul class="video_thumbs_summary_outer">
						<ul class="question_thumbs">
							<li>
								<div class="question_info">
									<strong class="question_title">I. WARM-UP : Answer the following questions</strong>';
									foreach($aWarmUp as $key => $val){
										$str .= '<p class="question_description">'.($key+1).'.'.$val['fwarmup_question'].'</p>';
									}
								$str .='</div>
							</li>
						</ul>
						<ul class="question_thumbs">
							<li>
								<div class="question_info">
									<strong class="question_title">Related Article</strong>
									<div class="question_summary">'.$aClip[0]['frelated_article'].'</div>
								</div>
							</li>
						</ul>
						<ul class="question_thumbs">
							<li>
								<div class="question_info">
									<strong class="question_title">II. Discussion Questions</strong>';
									foreach($aDiscussion as $key => $val){
										$str .= '<p class="question_description">'.($key+1).'.'.$val['fdisquession_question'].'</p>';
									}
								$str .='</div>
							</li>
						</ul>
						<ul class="question_thumbs">
							<li>
								<div class="question_info">
									<strong class="question_title">III. Let\'s Debate! </strong>';
									foreach($aDebate as $key => $val){
										$str .= '<p class="question_description">'.($key+1).'.'.$val['flets_debate'].'</p>';
									}
								$str .='</div>
							</li>
						</ul>
					</ul>
				</li>
			</ul>';
			$aData['contents'] = $str;
		}
		$this->display("ulearning/preview_slide",$aData,false);
	}
}
?>