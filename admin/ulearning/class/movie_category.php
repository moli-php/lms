<?php
class Movie_category extends Simplexi_Controller{
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		$this->importJS('ulearning/movie_category');
		
		$aData['movie_cat'] = $this->db->ulearning_model->db_select('tb_ulearning_movie_category');
		foreach($aData['movie_cat'] as $key => $val)
			$aData['movie_cat'][$key]['movie_cat_name'] = $this->db->ulearning_model->db_select('tb_ulearning_movie_category_name', null, array("movie_category_id" => $val['movie_cat_id']));
		
		$this->display("ulearning/movie_category", $aData);
	}
}
?>