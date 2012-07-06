<?php
class Class_mat extends Simplexi_Controller{
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		$this->importJS('ulearning/class_mat');
		$this->importJS('ulearning/preview_total_slides');
		$fbranch_idx = $_SESSION['idx'];
		$aData['fbranch_idx'] = $fbranch_idx;
		/////////////////////////////////////////////////////////////////
		if($fbranch_idx == 1)
			$this->db->ulearning_model->db_where(array('fdepth1' => 1));
		else
			$this->db->ulearning_model->db_where(array('fdepth1' => 1,'fbranch_idx' => $fbranch_idx));
		$aData['depth1'] = $this->db->ulearning_model->db_select('tb_ulearning_category',null,null,array('ASC' => 1));
		$aData['branch'] = $this->db->ulearning_model->db_select('tb_user',null,array('grade_idx' => 8),array('ASC' => 1));
		foreach($aData['depth1'] as $key => $val):
			if($fbranch_idx == 1)
				$this->db->ulearning_model->db_where(array('fdepth2' => $val['fcategory_id']));
			else
				$this->db->ulearning_model->db_where(array('fdepth2' => $val['fcategory_id'],'fbranch_idx' => $fbranch_idx));
			$aData['depth1'][$key]['count'] = $this->db->ulearning_model->db_count('tb_ulearning_category');
			if($fbranch_idx == 1)
				$this->db->ulearning_model->db_where(array('fcategory_id' => $val['fcategory_id']));
			else
				$this->db->ulearning_model->db_where(array('fcategory_id' => $val['fcategory_id'],'fbranch_idx' => $fbranch_idx));
			$aData['depth1'][$key]['count2'] = $this->db->ulearning_model->db_count('tb_ulearning_unit');
		endforeach;
		/////////////////////////////////////////////////////////////////
		
		/////////////////////////////////////////////////////////////////
		$aData['iCurrentPage'] = (isset($aArgs['page'])) ? $aArgs['page']:1;
		$search = (isset($aArgs['ftitle'])) ? $aArgs['ftitle']:"";
		$limit = 10;
		$offset = $limit * ($aData['iCurrentPage']-1);
		$aData['search'] = (isset($aArgs['search'])) ? $aArgs['search']:"";
		$aData['iRowsPerPage'] = $limit;
		
		if($fbranch_idx == 1)
			$this->db->ulearning_model->db_where(array('ftitle LIKE' => $aData['search'],'fdepth1' => 1));
		else
			$this->db->ulearning_model->db_where(array('ftitle LIKE' => $aData['search'],'fdepth1' => 1,'tb_ulearning_unit.fbranch_idx' => $fbranch_idx));
		$aData['iTotalRows'] = $this->db->ulearning_model->db_count('tb_ulearning_unit INNER JOIN tb_ulearning_category ON tb_ulearning_unit.fcategory_id = tb_ulearning_category.fcategory_id');
		
		if($fbranch_idx == 1)
			$this->db->ulearning_model->db_where(array('ftitle LIKE' => $aData['search'],'fdepth1' => 1));
		else
			$this->db->ulearning_model->db_where(array('ftitle LIKE' => $aData['search'],'fdepth1' => 1,'tb_ulearning_unit.fbranch_idx' => $fbranch_idx));
		$aData['material'] = $this->db->ulearning_model->db_select('tb_ulearning_unit INNER JOIN tb_ulearning_category ON tb_ulearning_unit.fcategory_id = tb_ulearning_category.fcategory_id',array('funit_id','fcategory_name as course','ftitle','fdate','fdepth2'),null,array('ASC' => 1),$limit,$offset);
		if($aData['material']){
			foreach($aData['material'] as $key => $val):
				$aData['material'][$key]['num'] = $key+1;
				$category2 = $this->db->ulearning_model->db_select('tb_ulearning_category',array('fcategory_name'),array('fcategory_id' => $val['fdepth2']));
				$aData['material'][$key]['slideCount'] = $this->db->ulearning_model->db_count('tb_ulearning_slide',array('funit_id' => $val['funit_id']));
				$aData['material'][$key]['category'] = $category2[0]['fcategory_name'];
			endforeach;
		}
		/////////////////////////////////////////////////////////////////
		
		$this->display("ulearning/class_mat",$aData);
	}
}
?>