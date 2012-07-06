<?php
class Test_evaluation extends Simplexi_Controller{
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		$this->importJS('ulearning/test_evaluation');
		
		$aData['iCurrentPage'] = (isset($aArgs['page'])) ? $aArgs['page'] : 1;
		$limit = (isset($aArgs['page_rows'])) ? $aArgs['page_rows'] : 20;
		$offset = $limit * ($aData['iCurrentPage']-1);
		$aData['iRowsPerPage'] = $limit;
		$search = (isset($aArgs['id'])) ? $aArgs['id'] : "";
		$course = (isset($aArgs['course'])) ? $aArgs['course'] : "";
		$status = (isset($aArgs['status'])) ? $aArgs['status'] : "";
		
		$aData['test_eval'] = $this->db->ulearning_model->db_select_distinct('tb_ulearning_test_evaluation t1 INNER JOIN tb_ulearning_assign t2 ON t2.fassign_id = t1.fassign_id
								INNER JOIN tb_ulearning_unit t7 ON t7.funit_id = t2.funit_id
								INNER JOIN tb_ulearning_category t3 ON t3.fcategory_id = t7.fcategory_id
								INNER JOIN tb_ulearning_category t4 ON t3.fdepth2 = t4.fcategory_id
								INNER JOIN tb_ulearning_category t5 ON t4.fdepth1 = t5.fcategory_id
								INNER JOIN tb_user t6 ON t6.idx = t1.user_idx
								',array('eval_id','status','current_page','sdate','edate','t2.funit_id','ftitle',
								'idx','user_id','t3.fcategory_name as category2','t4.fcategory_name as category1','t5.fcategory_name as course'),
								array("user_id LIKE" => $search, "t5.fcategory_name LIKE" => $course, "status LIKE" => $status));
		foreach($aData['test_eval'] as $key => $val){
			
			$sum = $this->db->ulearning_model->db_sum('tb_ulearning_user_grade',"fgrade",
							array('feval_id' => $val['eval_id']));
			$total = $this->db->ulearning_model->db_count('tb_ulearning_user_grade',array('feval_id' => $val['eval_id']));
			if($sum > 0)
				$aData['test_eval'][$key]['score'] = $sum/$total;
			else
				$aData['test_eval'][$key]['score'] = 0;
		}
		$aData['iTotalRows'] = count($aData['test_eval']);
		$aData['category1'] = $this->db->ulearning_model->db_select('tb_ulearning_category',array('fcategory_id','fcategory_name'),array('fdepth1' => 0,'fdepth2' => 0));
		
		
		$this->display("ulearning/test_evaluation", $aData);
	}
}
?>