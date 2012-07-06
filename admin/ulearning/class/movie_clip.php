<?php
class Movie_clip extends Simplexi_Controller{
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		$this->importJS('ulearning/movie_clip');
		
		$mov_title = (isset($aArgs['movie_title'])) ? $aArgs['movie_title'] : "";
		$mov_cat_id = (isset($aArgs['mov_cat_id'])) ? $aArgs['mov_cat_id'] : "";
		$mov_cat_name_id = (isset($aArgs['mov_cat_name_id'])) ? $aArgs['mov_cat_name_id'] : "";
		$aData['iCurrentPage'] = (isset($aArgs['page'])) ? $aArgs['page'] : 1;
		$limit = (isset($aArgs['page_rows'])) ? $aArgs['page_rows'] : 20;
		$offset = $limit * ($aData['iCurrentPage']-1);
		$aData['iRowsPerPage'] = $limit;
		
		if($mov_cat_id == "" && $mov_cat_name_id == ""){
		$aData['movie'] = $this->db->ulearning_model->db_select('tb_ulearning_movie_category INNER JOIN tb_ulearning_movie_category_name ON tb_ulearning_movie_category.movie_cat_id = tb_ulearning_movie_category_name.movie_category_id
																INNER JOIN tb_ulearning_movie_clip ON tb_ulearning_movie_category_name.movie_cat_name_id = tb_ulearning_movie_clip.movie_clip_cat_name_id',
																array('movie_category','movie_category_name','movie_clip_id','movie_clip_title','movie_clip_url','movie_clip_image'), array('movie_clip_title LIKE' => $mov_title));
		$aData['iTotalRows'] = count($aData['movie']);
		}else if($mov_cat_id != "" && $mov_cat_name_id == ""){
		$aData['movie'] = $this->db->ulearning_model->db_select('tb_ulearning_movie_category INNER JOIN tb_ulearning_movie_category_name ON tb_ulearning_movie_category.movie_cat_id = tb_ulearning_movie_category_name.movie_category_id
																INNER JOIN tb_ulearning_movie_clip ON tb_ulearning_movie_category_name.movie_cat_name_id = tb_ulearning_movie_clip.movie_clip_cat_name_id',
																array('movie_category','movie_category_name','movie_clip_id','movie_clip_title','movie_clip_url','movie_clip_image'), 
																array('movie_clip_title LIKE' => $mov_title, 'movie_category_id' => $mov_cat_id));
		$aData['iTotalRows'] = count($aData['movie']);
		}else if($mov_cat_id != "" && $mov_cat_name_id != ""){
		$aData['movie'] = $this->db->ulearning_model->db_select('tb_ulearning_movie_category INNER JOIN tb_ulearning_movie_category_name ON tb_ulearning_movie_category.movie_cat_id = tb_ulearning_movie_category_name.movie_category_id
																INNER JOIN tb_ulearning_movie_clip ON tb_ulearning_movie_category_name.movie_cat_name_id = tb_ulearning_movie_clip.movie_clip_cat_name_id',
																array('movie_category','movie_category_name','movie_clip_id','movie_clip_title','movie_clip_url','movie_clip_image'), 
																array('movie_clip_title LIKE' => $mov_title, 'movie_category_id' => $mov_cat_id, 'movie_clip_cat_name_id' => $mov_cat_name_id));
		$aData['iTotalRows'] = count($aData['movie']);
		}
		
		$aData['movie_cat'] = $this->db->ulearning_model->db_select('tb_ulearning_movie_category');
		
		$this->display("ulearning/movie_clip", $aData);
	}
}
?>