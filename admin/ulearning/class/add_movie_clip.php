<?php
class Add_movie_clip extends Simplexi_Controller{
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		$this->importJS('ulearning/movie_clip');
		
			$aData['modify'] = $this->db->ulearning_model->db_select('tb_ulearning_movie_category INNER JOIN tb_ulearning_movie_category_name ON tb_ulearning_movie_category.movie_cat_id = tb_ulearning_movie_category_name.movie_category_id
																INNER JOIN tb_ulearning_movie_clip ON tb_ulearning_movie_category_name.movie_cat_name_id = tb_ulearning_movie_clip.movie_clip_cat_name_id',
																array('movie_cat_id','movie_category','movie_cat_name_id','movie_category_name','movie_clip_id','movie_clip_title','movie_clip_description','movie_clip_url','movie_clip_image'), array('movie_clip_id' => $aArgs['add_new']));

			$aData['movie_cat'] = $this->db->ulearning_model->db_select('tb_ulearning_movie_category');

		$this->display("ulearning/add_movie_clip", $aData);
	}
}
?>