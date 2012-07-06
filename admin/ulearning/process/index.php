<?php
include('../../../__library/controller.php');
class Index extends Simplexi_Controller
{
	public function run($aArgs)
	{
	    $this->library('common');
		$this->model('ulearning_model');
		$fbranch_idx = $_SESSION['idx'];
		
		if($aArgs['action'] == "depth1")///////////////////////////////////////////DEPTH1
			echo json_encode($this->db->ulearning_model->db_select('tb_ulearning_category',null,array('fdepth2' => $aArgs['fcategory_id']),array('ASC' => 1)));
			
			
		if($aArgs['action'] == "depth2")///////////////////////////////////////////DEPTH2
			echo json_encode($this->db->ulearning_model->db_select('tb_ulearning_unit',null,array('fcategory_id' => $aArgs['fcategory_id']),array('ASC' => 1)));
			
			
		else if($aArgs['action'] == "category"){///////////////////////////////////////////CATEGORY
			if($aArgs['fcategory_id'] == 1){
				if($fbranch_idx == 1)
					$this->db->ulearning_model->db_where(array('fdepth1' => 1,'fdepth2' => 0));
				else
					$this->db->ulearning_model->db_where(array('fdepth1' => 1,'fdepth2' => 0,'fbranch_idx' => $fbranch_idx));
			}else if($aArgs['fcategory_id'] == 2 || $aArgs['fcategory_id'] == 3){
				if($fbranch_idx == 1)
					$this->db->ulearning_model->db_where(array('fdepth1' => 2,'fdepth2' => 0));
				else
					$this->db->ulearning_model->db_where(array('fdepth1' => 2,'fdepth2' => 0,'fbranch_idx' => $fbranch_idx));
			}else if($aArgs['fcategory_id'] == 4 || $aArgs['fcategory_id'] == 5){
				if($fbranch_idx == 1)
					$this->db->ulearning_model->db_where(array('fdepth1' => 4,'fdepth2' => 0));
				else
					$this->db->ulearning_model->db_where(array('fdepth1' => 4,'fdepth2' => 0,'fbranch_idx' => $fbranch_idx));
			}
			echo json_encode($this->db->ulearning_model->db_select('tb_ulearning_category',null,null,array('ASC' => 1)));
		}
		
		
		else if($aArgs['action'] == "addCategory"){///////////////////////////////////////////ADDCATEGORY
			if($this->checkCategoryName($aArgs['fdepth1'],$aArgs['fdepth2'],$aArgs['fcategory_name']) == 0)
				if($aArgs['fdepth1'] == 1)
					$this->db->ulearning_model->db_insert('tb_ulearning_category',array('fdepth1' => 1,'fdepth2' => $aArgs['fdepth2'], 'fcategory_name' => $aArgs['fcategory_name'],'fbranch_idx' => $fbranch_idx));
				else if($aArgs['fdepth1'] == 2 || $aArgs['fdepth1'] == 3)
					$this->db->ulearning_model->db_insert('tb_ulearning_category',array('fdepth1' => 2,'fdepth2' => $aArgs['fdepth2'], 'fcategory_name' => $aArgs['fcategory_name'],'fbranch_idx' => $fbranch_idx));
				else if($aArgs['fdepth1'] == 4 || $aArgs['fdepth1'] == 5)
					$this->db->ulearning_model->db_insert('tb_ulearning_category',array('fdepth1' => 4,'fdepth2' => $aArgs['fdepth2'], 'fcategory_name' => $aArgs['fcategory_name'],'fbranch_idx' => $fbranch_idx));
			else
				echo "failed";
		}
		
		
		else if($aArgs['action'] == "deleteCategory"){///////////////////////////////////////////DELETECATEGORY
			$this->db->ulearning_model->db_delete('tb_ulearning_category',array('fdepth2' => $aArgs['fcategory_id']));
			$this->db->ulearning_model->db_delete('tb_ulearning_category',array('fcategory_id' => $aArgs['fcategory_id']));
		}	
			
			
		else if($aArgs['action'] == "modifyCategoryName"){///////////////////////////////////////////MODIFYCATEGORYNAME
			$aData = $this->db->ulearning_model->db_select('tb_ulearning_category',null,array('fcategory_id' => $aArgs['fcategory_id']),array('ASC' => 1));
			if($this->checkCategoryName($aData[0]['fdepth1'],$aData[0]['fdepth2'],$aArgs['fcategory_name']) == 0)
				$this->db->ulearning_model->db_update('tb_ulearning_category',array('fcategory_name' => $aArgs['fcategory_name']),array('fcategory_id' => $aArgs['fcategory_id']));
			else
				echo "failed";
		}
		
		
		else if($aArgs['action'] == "modifyUnit"){///////////////////////////////////////////MODIFYUNIT
			$aData = $this->db->ulearning_model->db_select('tb_ulearning_unit',null,array('funit_id' => $aArgs['funit_id']),null,1);
			if($this->db->ulearning_model->db_count('tb_ulearning_unit',array('funit_id !' => $aArgs['funit_id'],'ftitle' => $aArgs['ftitle'],'fcategory_id' => $aData[0]['fcategory_id'])) == 0)
				$this->db->ulearning_model->db_update('tb_ulearning_unit',array('ftitle' => $aArgs['ftitle']),array('funit_id' => $aArgs['funit_id']));
			else
				echo "failed";
		}
		
		
		else if($aArgs['action'] == "addUnit"){///////////////////////////////////////////ADDUNIT
			if(isset($aArgs['branch']) && $aArgs['branch'] != 1)
				$fbranch_idx = $aArgs['branch'];
			$this->db->ulearning_model->db_insert('tb_ulearning_unit',array('fcategory_id' => $aArgs['depth2'],'ftitle' => $aArgs['title'], 'fdate' => time(),'fbranch_idx' => $fbranch_idx));
		}
		
		
		else if($aArgs['action'] == "assign"){///////////////////////////////////////////ASSIGN
			$aData = $this->db->ulearning_model->db_select('tb_user',null,array('user_id' => $aArgs['user_id']),null,1);
			if($aArgs['fcategory_id'] != 1){
				if($this->db->ulearning_model->db_count('tb_ulearning_assign',array('fuser_idx' => $aData[0]['idx'],'fclass_id' => $aArgs['class_id'],'funit_id' => $aArgs['funit_id'],
														'fdate' =>strtotime($aArgs['fdate']))) == 0){
					
					$this->db->ulearning_model->db_insert('tb_ulearning_assign',array('fuser_idx' => $aData[0]['idx'],'fclass_id' => $aArgs['class_id'],'funit_id' => $aArgs['funit_id'],
														'fdate' =>strtotime($aArgs['fdate'])));
					echo 1;
				}
				else
					echo 0;
			}else{
				$unit = $this->db->ulearning_model->db_select('tb_ulearning_unit',null,array('fcategory_id' => $aArgs['fdepth2']));
				//var_dump($unit);
				foreach($unit as $key => $val):
					if($this->db->ulearning_model->db_count('tb_ulearning_assign',array('fuser_idx' => $aData[0]['idx'],'fclass_id' => $aArgs['class_id'],'funit_id' => $val['funit_id'],
														'fdate' =>strtotime($aArgs['fdate']))) == 0){
						$this->db->ulearning_model->db_insert('tb_ulearning_assign',array('fuser_idx' => $aData[0]['idx'],'fclass_id' => $aArgs['class_id'],'funit_id' => $val['funit_id'],
														'fdate' =>strtotime($aArgs['fdate'])));
					}
				endforeach;
				echo 1;
			}
		}
		 
		
		else if($aArgs['action'] == "deleteAssigned"){///////////////////////////////////////////DELETEASSIGNED
			foreach($aArgs['fassign_id'] as $key => $val):
				$this->db->ulearning_model->db_delete('tb_ulearning_assign',array('fassign_id' => $aArgs['fassign_id'][$key]));
			endforeach;
		}
		
		
		else if($aArgs['action'] == "deleteUnit"){///////////////////////////////////////////DELETEAUNIT
				$this->db->ulearning_model->db_delete('tb_ulearning_unit',array('funit_id' => $aArgs['funit_id']));
		}
		
		
		else if($aArgs['action'] == "questionFetch"){///////////////////////////////////////////QUESTIONFETCH
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/questions.php');
			$questions = new questions();
			$questions->run($aArgs);
		}
		
		
		else if($aArgs['action'] == "addSlide"){///////////////////////////////////////////ADDSLIDE
			if($aArgs['type'] != 19 && $aArgs['type'] != 20){
				$study_part = (isset($aArgs['study_part']))? implode(",",$aArgs['study_part']):"";
				$ext = (isset($_FILES['sound_file']['name'])) ? explode(".",$_FILES['sound_file']['name']) : array();
				$sound_file = (isset($_FILES['sound_file']['name'])) ? $_FILES['sound_file']['name'] : "";
				if(end($ext) == "wav" || end($ext) == "mp3" || count($ext) == 0){
					$this->db->ulearning_model->db_insert("tb_ulearning_slide",array("funit_id" => $aArgs['funit_id'], "fexam_type_id" => $aArgs['fexam_type_id'],"sequence" => $aArgs['sequence'],
												"fslide_name" => $aArgs['slide_name'],"ftime_limit" => $aArgs['time'],"fbackground_css" => $aArgs['background_css'], "fstudy_part" => $study_part,
												"fstudy_summary" => $aArgs['study_summary'],"fsound_file" => $sound_file,"frecorded" => $aArgs['recorded']));
					//$ext = explode(".",$_FILES['sound_file']['name']);
					$fslide = $this->db->ulearning_model->db_max("tb_ulearning_slide",'fslide_id');
					if($sound_file != "")
						move_uploaded_file($_FILES['sound_file']['tmp_name'],"../../../uploads/ulearning/slide_upload/".$fslide.".".end($ext));
					echo 1;
				}else{
					echo 0;
					exit(0);
				}
				
			}else if($aArgs['type'] == 19){
				if(isset($_FILES['doc']['name']) && $_FILES['doc']['name'] != ""){
					$name = explode(".",$_FILES['doc']['name']);
					if(end($name) == "doc" || end($name) == "docx"){
						$this->db->ulearning_model->db_insert("tb_ulearning_slide",array("funit_id" => $aArgs['funit_id'], "fexam_type_id" => $aArgs['fexam_type_id'],"sequence" => $aArgs['sequence'],
														"fslide_name" => $aArgs['slide_name']));
					}	
				}else{
					$this->db->ulearning_model->db_insert("tb_ulearning_slide",array("funit_id" => $aArgs['funit_id'], "fexam_type_id" => $aArgs['fexam_type_id'],"sequence" => $aArgs['sequence'],
														"fslide_name" => $aArgs['slide_name']));
				}
			}else{
				if(isset($_FILES['doc_20']['name']) && $_FILES['doc_20']['name'] != ""){
					$name = explode(".",$_FILES['doc_20']['name']);
					if(end($name) == "doc" || end($name) == "docx"){
						$this->db->ulearning_model->db_insert("tb_ulearning_slide",array("funit_id" => $aArgs['funit_id'], "fexam_type_id" => $aArgs['fexam_type_id'],"sequence" => $aArgs['sequence'],"fslide_name" => $aArgs['slide_name']));
					}	
				}else{
					$this->db->ulearning_model->db_insert("tb_ulearning_slide",array("funit_id" => $aArgs['funit_id'], "fexam_type_id" => $aArgs['fexam_type_id'],"sequence" => $aArgs['sequence'],"fslide_name" => $aArgs['slide_name']));
				}
			}$fslide = $this->db->ulearning_model->db_max("tb_ulearning_slide",'fslide_id');
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/saveQuestions.php');
			$aArgs['slide_id'] = $fslide;
			$saveQuestions = new saveQuestions();
			$saveQuestions->run($aArgs);
		}
		
		
		else if($aArgs['action'] == "removeSlide"){///////////////////////////////////////////REMOVESLIDE
			foreach($aArgs['slide_id'] as $k => $v){
				$movie_question_id = $this->db->ulearning_model->db_max("tb_ulearning_movie_question",'fmovie_question_id',array('fslide_id' =>$aArgs['slide_id'][$k]));
				$this->db->ulearning_model->db_delete("tb_ulearning_warmup_question",array('fmovie_question_id' =>$movie_question_id));
				$this->db->ulearning_model->db_delete("tb_ulearning_disquession_question",array('fmovie_question_id' =>$movie_question_id));
				$this->db->ulearning_model->db_delete("tb_ulearning_lets_debate",array('fmovie_question_id' =>$movie_question_id));
				$this->db->ulearning_model->db_delete("tb_ulearning_movie_question",array('fslide_id' =>$aArgs['slide_id'][$k]));
				
				$question_id = $this->db->ulearning_model->db_max("tb_ulearning_multiple",'fquestion_id',array('fslide_id' =>$aArgs['slide_id'][$k]));
				$this->db->ulearning_model->db_delete("tb_ulearning_multiple_choice",array('fquestion_id' =>$question_id));
				$this->db->ulearning_model->db_delete("tb_ulearning_multiple",array('fslide_id' =>$aArgs['slide_id'][$k]));
				
				$this->db->ulearning_model->db_delete("tb_ulearning_sentence",array('fslide_id' =>$aArgs['slide_id'][$k]));
				$this->db->ulearning_model->db_delete("tb_ulearning_word",array('fslide_id' =>$aArgs['slide_id'][$k]));
				$this->db->ulearning_model->db_delete("tb_ulearning_slide",array('fslide_id' =>$aArgs['slide_id'][$k]));
			}
		}
		
		
		else if($aArgs['action'] == "copyMoveSlide"){///////////////////////////////////////////COPYMOVESLIDE
			if($aArgs['act'] == "copy"){
				//for($k)
				$aArgs['slide_id'] = array_reverse($aArgs['slide_id']);
				foreach($aArgs['slide_id'] as $k => $v){
					//////////////////////////////////////tb_ulearning_slide
					$this->query("INSERT INTO tb_ulearning_slide (fexam_type_id,funit_id,sequence,fslide_name,ftime_limit,
									fbackground_css,fstudy_part,fstudy_summary,fsound_file,frecorded,flong)
									SELECT fexam_type_id,'".$aArgs['unit']."',sequence,fslide_name,ftime_limit,
									fbackground_css,fstudy_part,fstudy_summary,fsound_file,frecorded,flong
									FROM tb_ulearning_slide WHERE fslide_id = '".$aArgs['slide_id'][$k]."'");
					$slide_id = $this->db->ulearning_model->db_max("tb_ulearning_slide",'fslide_id');
					//////////////////////////////////////tb_ulearning_sentence
					$this->query("INSERT INTO tb_ulearning_sentence (fslide_id,fsentence,fvoice,fimage) SELECT $slide_id,fsentence,fvoice,fimage
								FROM tb_ulearning_sentence WHERE fslide_id = '".$aArgs['slide_id'][$k]."'");
					//////////////////////////////////////tb_ulearning_word
					$this->query("INSERT INTO tb_ulearning_word (fslide_id,fword,fimage) SELECT $slide_id,fword,fimage
								FROM tb_ulearning_word WHERE fslide_id = '".$aArgs['slide_id'][$k]."'");
					//////////////////////////////////////tb_ulearning_multiple tb_ulearning_multiple_choice
					$this->query("INSERT INTO tb_ulearning_multiple (fslide_id,fquestion,fanswer,fimage) SELECT $slide_id,fquestion,fanswer,fimage
								FROM tb_ulearning_multiple WHERE fslide_id = '".$aArgs['slide_id'][$k]."'");
					$multiple = $this->db->ulearning_model->db_select("tb_ulearning_multiple",array('fquestion_id'),array('fslide_id' =>$slide_id));
					$multiple2 = $this->db->ulearning_model->db_select("tb_ulearning_multiple",array('fquestion_id'),array('fslide_id' =>$aArgs['slide_id'][$k]));
					foreach($multiple as $key => $val):
						$this->query("INSERT INTO tb_ulearning_multiple_choice (fquestion_id,fchoice) SELECT '".$val['fquestion_id']."',fchoice
								FROM tb_ulearning_multiple_choice
								WHERE fquestion_id = '".$multiple2[$key]['fquestion_id']."'");
					endforeach;
					//////////////////////////////////////tb_ulearning_warmup_question tb_ulearning_disquession_question tb_ulearning_lets_debate tb_ulearning_movie_question
					$this->query("INSERT INTO tb_ulearning_movie_question (fslide_id,fmovie_clip_id,fword_script,ftodays_object,frelated_article) 
								SELECT $slide_id,fmovie_clip_id,fword_script,ftodays_object,frelated_article
								FROM tb_ulearning_movie_question WHERE fslide_id = '".$aArgs['slide_id'][$k]."'");
					$movie_question = $this->db->ulearning_model->db_select("tb_ulearning_movie_question",array('fmovie_question_id'),array('fslide_id' =>$slide_id));
					$movie_question2 = $this->db->ulearning_model->db_select("tb_ulearning_movie_question",array('fmovie_question_id'),array('fslide_id' =>$aArgs['slide_id'][$k]));
					foreach($movie_question as $key => $val):
						$this->query("INSERT INTO tb_ulearning_warmup_question (fmovie_question_id,fwarmup_question) SELECT '".$val['fmovie_question_id']."',fwarmup_question
								FROM tb_ulearning_warmup_question
								WHERE fmovie_question_id = '".$movie_question2[$key]['fmovie_question_id']."'");
								
						$this->query("INSERT INTO tb_ulearning_disquession_question (fmovie_question_id,fdisquession_question) SELECT '".$val['fmovie_question_id']."',fdisquession_question
								FROM tb_ulearning_disquession_question
								WHERE fmovie_question_id = '".$movie_question2[$key]['fmovie_question_id']."'");
								
						$this->query("INSERT INTO tb_ulearning_lets_debate (fmovie_question_id,flets_debate) SELECT '".$val['fmovie_question_id']."',flets_debate
								FROM tb_ulearning_lets_debate
								WHERE fmovie_question_id = '".$movie_question2[$key]['fmovie_question_id']."'");
								
						//$this->query("INSERT INTO tb_ulearning_movie_question (fslide_id,fmovie_clip_id,fword_script,ftodays_object,frelated_article) SELECT '".$slide_id."',flets_debate
								//FROM tb_ulearning_lets_debate
								//WHERE fmovie_question_id = '".$movie_question2[$key]['fmovie_question_id']."'");
					endforeach;
					
				}
			}else if($aArgs['act'] == "move"){
				foreach($aArgs['slide_id'] as $k => $v)
					$this->db->ulearning_model->db_update("tb_ulearning_slide",array('funit_id' => $aArgs['unit']),array('fslide_id' =>$aArgs['slide_id'][$k]));
			}
		}
		
		
		else if($aArgs['action'] == "updateSlideGrade"){///////////////////////////////////////////UPDATESLIDEGRADE
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/saveComments.php');
			$saveComments = new saveComments();
			$saveComments->run($aArgs);
			echo $this->db->ulearning_model->db_update('tb_ulearning_user_grade',array('fgrade' => $aArgs['user_slide_grade']),array('fuser_grade_id' => $aArgs['user_grade_id']));
		}
		
		
		else if($aArgs['action'] == "checkStudentSchedule"){///////////////////////////////////////////CHECKSTUDENTSCHEDULE
			$iSchedule = $this->db->ulearning_model->db_count("tb_class t1 INNER JOIN tb_user t2 ON t1.student_idx = t2.idx AND user_id =  '".$aArgs['user_idx']."' AND class_status='scheduled'");
			$iIsStudent = $this->db->ulearning_model->db_count("tb_user",array("user_id" =>  $aArgs['user_idx'],"grade_idx" => 1));
			if($iIsStudent==0){
				echo -1;
			}else{
				if($iSchedule > 0)
					echo 1;
				else
					echo 0;
			}
			
		}
		
		
		else if($aArgs['action'] == "evaluate"){///////////////////////////////////////////EVALUATE
			echo $this->db->ulearning_model->db_update('tb_ulearning_test_evaluation',array('status' => "Evaluated"),array('eval_id' => $aArgs['eval_id']));
		}
		
		
		else if($aArgs['action'] == "add_movie_category"){
			$iName_exist = $this->db->ulearning_model->db_count('tb_ulearning_movie_category_name',array('movie_category_id' => $aArgs['mov_cat_id'],'movie_category_name' => $aArgs['mov_cat_name']));
			if($iName_exist == 0){
				$this->db->ulearning_model->db_insert('tb_ulearning_movie_category_name',array('movie_category_id' => $aArgs['mov_cat_id'],'movie_category_name' => $aArgs['mov_cat_name']));
				echo 1;
			}else{
				echo 0;
			}
		}
		else if($aArgs['action'] == "modify_movie_category"){
			$iName_exist = $this->db->ulearning_model->db_count('tb_ulearning_movie_category_name',array('movie_category_id' => $aArgs['mov_cat_id'],'movie_category_name' => $aArgs['mov_cat_name']));
			if($iName_exist == 0){
				$this->db->ulearning_model->db_update('tb_ulearning_movie_category_name',array('movie_category_name' => $aArgs['mov_cat_name']),array('movie_cat_name_id' => $aArgs['mov_cat_name_id']));
				echo 1;
			}else{
				echo 0;
			}
		}
		else if($aArgs['action'] == "delete_movie_category"){
			$aData = $this->db->ulearning_model->db_select('tb_ulearning_movie_clip',null,array('movie_clip_cat_name_id' => $aArgs['mov_cat_name_id']));
			foreach($aData as $key => $val){
				unlink('../../../uploads/ulearning/upload/'.$val['movie_clip_image']);
			}
			$this->db->ulearning_model->db_delete('tb_ulearning_movie_clip',array('movie_clip_cat_name_id' => $aArgs['mov_cat_name_id']));
			$this->db->ulearning_model->db_delete('tb_ulearning_movie_category_name',array('movie_cat_name_id' => $aArgs['mov_cat_name_id']));
		}
		else if($aArgs['action'] == "get_movie_cat_name")
			echo json_encode($this->db->ulearning_model->db_select('tb_ulearning_movie_category_name',null,array('movie_category_id' => $aArgs['mov_cat_id'])));
		else if($aArgs['action'] == "delete_movie_clip"){
			foreach($aArgs['mov_clip_id'] as $key => $val){
				$image = $this->db->ulearning_model->db_select('tb_ulearning_movie_clip',array('movie_clip_image'),array('movie_clip_id' => $val));
				if($image[0]['movie_clip_image'] != ""){
					unlink('../../../uploads/ulearning/upload/'.$image[0]['movie_clip_image']);
				}
				$this->db->ulearning_model->db_delete('tb_ulearning_movie_clip',array('movie_clip_id' => $val));
				echo $image[0]['movie_clip_image'];
			}
		}
		else if($aArgs['action'] == "upload_movie_image"){
			if(file_exists('../../../uploads/ulearning/upload/'.$aArgs['mov_image']) && !empty($aArgs['mov_image'])){
				unlink('../../../uploads/ulearning/upload/'.$aArgs['mov_image']);
			}
			$type=$_FILES['file']['type'];
			$name=$_FILES['file']['name'];
			$size=$_FILES['file']['size'];
			$type=explode("/",$type);
			$name=explode(".",$name);
			$temp=time();
			if($type[0] == "image"){
				if($size > 1024){
					move_uploaded_file($_FILES['file']['tmp_name'], '../../../uploads/ulearning/upload/'. $temp .'.'.end($name));
					echo $temp .'.'.end($name);
				}else{
				echo "error";
				}
			}else{
				echo "error";
			}
		}
		else if($aArgs['action'] == "delete_preview"){
			unlink('../../../uploads/ulearning/upload/'.$aArgs['mov_image']);
		}
		else if($aArgs['action'] == "add_movie_clip"){
			if($aArgs['mov_image'] != ""){
				unlink('../../../uploads/ulearning/upload/'.$aArgs['mov_image']);
				$name=$_FILES['file']['name'];
				$name=explode(".",$name);
			
				$this->db->ulearning_model->db_insert('tb_ulearning_movie_clip',array('movie_clip_cat_name_id' => $aArgs['select_cat_name'],'movie_clip_title' => $aArgs['title'],'movie_clip_description' => $aArgs['description'],
													'movie_clip_url' => $aArgs['url']));
				$id = $this->db->ulearning_model->db_max('tb_ulearning_movie_clip','movie_clip_id');
				
				move_uploaded_file($_FILES['file']['tmp_name'], '../../../uploads/ulearning/upload/'. $id .'.'. end($name));
				
				$this->db->ulearning_model->db_update('tb_ulearning_movie_clip',array('movie_clip_image' => $id .'.'. end($name)),array('movie_clip_id' => $id));
			}else{
				$this->db->ulearning_model->db_insert('tb_ulearning_movie_clip',array('movie_clip_cat_name_id' => $aArgs['select_cat_name'],'movie_clip_title' => $aArgs['title'],'movie_clip_description' => $aArgs['description'],
													'movie_clip_url' => $aArgs['url']));
			}
		}
		else if($aArgs['action'] == "modify_movie_clip"){
			if($aArgs['mov_image'] != ""){
				unlink('../../../uploads/ulearning/upload/'.$aArgs['mov_image']);
				$name=$_FILES['file']['name'];
				$name=explode(".",$name);
				move_uploaded_file($_FILES['file']['tmp_name'], '../../../uploads/ulearning/upload/'. $aArgs['mov_clip_id'] .'.'. end($name));
				
				$this->db->ulearning_model->db_update('tb_ulearning_movie_clip',array('movie_clip_cat_name_id' => $aArgs['select_cat_name'],'movie_clip_title' => $aArgs['title'],'movie_clip_description' => $aArgs['description'],
													'movie_clip_url' => $aArgs['url'],'movie_clip_image' => $aArgs['mov_clip_id'] .'.'. end($name)),array('movie_clip_id' => $aArgs['mov_clip_id']));
			}else{
				$this->db->ulearning_model->db_update('tb_ulearning_movie_clip',array('movie_clip_cat_name_id' => $aArgs['select_cat_name'],'movie_clip_title' => $aArgs['title'],'movie_clip_description' => $aArgs['description'],
													'movie_clip_url' => $aArgs['url'],'movie_clip_image' => null),array('movie_clip_id' => $aArgs['mov_clip_id']));
			}
		}
		else if($aArgs['action'] == "get_movie_clip_title")
			echo json_encode($this->db->ulearning_model->db_select('tb_ulearning_movie_clip',array('movie_clip_id','movie_clip_title'),array('movie_clip_cat_name_id' => $aArgs['mov_cat2_id'])));
	}
	
	private function checkCategoryName($id,$id2,$name){
		$bool = 0;
		if($id == 1){
			if($fbranch_idx == 1)
				$this->db->ulearning_model->db_where(array('fdepth1' => 1,'fdepth2' => $id2, 'fcategory_name' => $name));
			else
				$this->db->ulearning_model->db_where(array('fdepth1' => 1,'fdepth2' => $id2, 'fcategory_name' => $name,'fbranch_idx' => $fbranch_idx));
		}
		else if($id == 2 || $id == 3){
			if($fbranch_idx == 1)
				$this->db->ulearning_model->db_where(array('fdepth1' => 2,'fdepth2' => $id2, 'fcategory_name' => $name));
			else
				$this->db->ulearning_model->db_where(array('fdepth1' => 2,'fdepth2' => $id2, 'fcategory_name' => $name,'fbranch_idx' => $fbranch_idx));
		}
		else if($id == 4 || $id == 5){
			if($fbranch_idx == 1)
				$this->db->ulearning_model->db_where(array('fdepth1' => 4,'fdepth2' => $id2, 'fcategory_name' => $name));
			else
				$this->db->ulearning_model->db_where(array('fdepth1' => 4,'fdepth2' => $id2, 'fcategory_name' => $name,'fbranch_idx' => $fbranch_idx));
		}
		$bool = $this->db->ulearning_model->db_count('tb_ulearning_category',array('fdepth1' => 4,'fdepth2' => $id2, 'fcategory_name' => $name));
		return $bool;
	}
}
$oClass = new index();
$oClass->run($aArgs);
?> 