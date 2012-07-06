<?php
include('../../__library/controller.php');
class Index extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library("checkLogin");
	    $this->library('common');
		if(!isset($aArgs['action']) || $aArgs['action'] == "cat_mngt"){
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/cat_mngt.php');
			$cat_mngt = new cat_mngt();
			$cat_mngt->run($aArgs);
		}
		else if($aArgs['action'] == "class_mat"){
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/class_mat.php');
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/slide.php');
			if(!isset($aArgs['inner'])){
				$class_mat = new class_mat();
				$class_mat->run($aArgs);
			}
			else if($aArgs['inner'] == "slide"){
				$slide = new slide();
				$slide->run($aArgs);
			}
		}
		else if($aArgs['action'] == "preview"){
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/preview.php');
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/slide.php');
			if(!isset($aArgs['inner'])){
				$preview = new preview();
				$preview->run($aArgs);
			}
			else if($aArgs['inner'] == "slide"){
				$slide = new slide();
				$slide->run($aArgs);
			}
			
		}
		else if($aArgs['action'] == "homework"){
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/homework.php');
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/slide.php');
			if(!isset($aArgs['inner'])){
				$homework = new homework();
				$homework->run($aArgs);
			}
			else if($aArgs['inner'] == "slide"){
				$slide = new slide();
				$slide->run($aArgs);
			}
		}
		else if($aArgs['action'] == "leveltest_preview"){
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/leveltest_preview.php');
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/slide.php');
			if(!isset($aArgs['inner'])){
				$leveltest_preview = new leveltest_preview();
				$leveltest_preview->run($aArgs);
			}
			else if($aArgs['inner'] == "slide"){
				$slide = new slide();
				$slide->run($aArgs);
			}
		}
		else if($aArgs['action'] == "leveltest_test"){
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/leveltest_test.php');
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/slide.php');
			if(!isset($aArgs['inner'])){
				$leveltest_test = new leveltest_test();
				$leveltest_test->run($aArgs);
			}
			else if($aArgs['inner'] == "slide"){
				$slide = new slide();
				$slide->run($aArgs);
			}
		} 
		else if($aArgs['action'] == "test_assign"){
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/test_assign.php');
			include(SERVER_DOCUMENT_ROOT  . '/admin/ulearning/class/test_assign_popup.php');
			if(!isset($aArgs['inner'])){
				$test_assign = new test_assign();
				$test_assign->run($aArgs);
				
			}
			else if($aArgs['inner'] == "popup"){
				$test_assign_popup = new test_assign_popup();
				$test_assign_popup->run($aArgs);
			}
		}
		else if($aArgs['action'] == "test_eval"){
			if(!isset($aArgs['inner'])){
				include(SERVER_DOCUMENT_ROOT . '/admin/ulearning/class/test_evaluation.php');
				$test_evaluation = new test_evaluation();
				$test_evaluation->run($aArgs);
			}else if($aArgs['inner'] == "eval_manage"){
				include(SERVER_DOCUMENT_ROOT . '/admin/ulearning/class/test_evaluation_manage.php');
				$test_evaluation_manage = new test_evaluation_manage();
				$test_evaluation_manage->run($aArgs);
			}
		}
		else if($aArgs['action'] == "movie_cat"){
			include(SERVER_DOCUMENT_ROOT . '/admin/ulearning/class/movie_category.php');
			$movie_category = new movie_category();
			$movie_category->run($aArgs);
		}
		else if($aArgs['action'] == "movie_clip"){
			if(!isset($aArgs['add_new'])){
				include(SERVER_DOCUMENT_ROOT . '/admin/ulearning/class/movie_clip.php');
				$movie_clip = new movie_clip();
				$movie_clip->run($aArgs);
			}else{
				include(SERVER_DOCUMENT_ROOT . '/admin/ulearning/class/add_movie_clip.php');
				$add_movie_clip = new add_movie_clip();
				$add_movie_clip->run($aArgs);
			}
		}
		else if($aArgs['action'] == "preview_slide"){
			include(SERVER_DOCUMENT_ROOT . '/admin/ulearning/class/preview_slide.php');
			$preview_slide = new preview_slide();
			$preview_slide->run($aArgs);
		}
		else if($aArgs['action'] == "preview_total_slides"){
			include(SERVER_DOCUMENT_ROOT . '/admin/ulearning/class/preview_total_slides.php');
			$preview_total_slides = new preview_total_slides();
			$preview_total_slides->run($aArgs);
		}
		else
			echo "None";
		if($_SESSION['idx'] != 1)
			echo '<script type="text/javascript">common.ulearning_menu_hide();</script>';
	}
}
$oClass = new index();
$oClass->run($aArgs);
?>