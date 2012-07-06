<?php
class Cat_mngt extends Simplexi_Controller{
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		$this->importJS('ulearning/cat_mngt');
		$fbranch_idx = $_SESSION['idx'];
		$aData['depth1'] = $this->db->ulearning_model->db_select('tb_ulearning_category',null,array('fdepth1' => 0),array('ASC' => 1));
		
		$aData['category'] = $this->db->ulearning_model->db_select('tb_ulearning_category',null,array('fdepth1' => 0),array('ASC' => 1));
		foreach($aData['category'] as $key => $val):
			if($val['fcategory_id'] == 1){
				if($fbranch_idx == 1)
					$this->db->ulearning_model->db_where(array('fdepth1' => 1,'fdepth2' => 0));
				else
					$this->db->ulearning_model->db_where(array('fdepth1' => 1,'fdepth2' => 0,'fbranch_idx' => $fbranch_idx));
			}else if($val['fcategory_id'] == 2 || $val['fcategory_id'] == 3){
				if($fbranch_idx == 1)
					$this->db->ulearning_model->db_where(array('fdepth1' => 2,'fdepth2' => 0));
				else
					$this->db->ulearning_model->db_where(array('fdepth1' => 2,'fdepth2' => 0,'fbranch_idx' => $fbranch_idx));
			}else if($val['fcategory_id'] == 4 || $val['fcategory_id'] == 5){
				if($fbranch_idx == 1)
					$this->db->ulearning_model->db_where(array('fdepth1' => 4,'fdepth2' => 0));
				else
					$this->db->ulearning_model->db_where(array('fdepth1' => 4,'fdepth2' => 0,'fbranch_idx' => $fbranch_idx));
				
			}
			$aData['category'][$key]['depth1'] = $this->db->ulearning_model->db_select('tb_ulearning_category',null,null,array('ASC' => 1));
			foreach($aData['category'][$key]['depth1'] as $k => $v):
				if($val['fcategory_id'] == 1){
					if($fbranch_idx == 1)
						$this->db->ulearning_model->db_where(array('fdepth1' => 1,'fdepth2' => $v['fcategory_id']));
					else
						$this->db->ulearning_model->db_where(array('fdepth1' => 1,'fdepth2' => $v['fcategory_id'],'fbranch_idx' => $fbranch_idx));
				}else if($val['fcategory_id'] == 2 || $val['fcategory_id'] == 3){
					if($fbranch_idx == 1)
						$this->db->ulearning_model->db_where(array('fdepth1' => 2,'fdepth2' => $v['fcategory_id']));
					else
						$this->db->ulearning_model->db_where(array('fdepth1' => 2,'fdepth2' => $v['fcategory_id'],'fbranch_idx' => $fbranch_idx));
				}else if($val['fcategory_id'] == 4 || $val['fcategory_id'] == 5){
					if($fbranch_idx == 1)
						$this->db->ulearning_model->db_where(array('fdepth1' => 4,'fdepth2' => $v['fcategory_id']));
					else
						$this->db->ulearning_model->db_where(array('fdepth1' => 4,'fdepth2' => $v['fcategory_id'],'fbranch_idx' => $fbranch_idx));
					
				}
				$aData['category'][$key]['depth1'][$k]['depth2'] = $this->db->ulearning_model->db_select('tb_ulearning_category',null,null,array('ASC' => 1));
			endforeach;
		endforeach;
		$this->display("ulearning/cat_mngt",$aData);
	}
}
?>