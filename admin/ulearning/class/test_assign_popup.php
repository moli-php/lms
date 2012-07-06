<?php
class Test_assign_popup extends Simplexi_Controller{
	private $sdate;
	private $edate;
	private $branch;
	public function __construct(){
		$this->sdate =(isset($_GET['sdate']))?$_GET['sdate']:"";
		$this->edate = (isset($_GET['edate']))?$_GET['edate']:"";
		$this->branch = (isset($_GET['branch']))?$_GET['branch']:"";
	}
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		$this->importJS('ulearning/test_assign_popup');
		$fbranch_idx = $_SESSION['idx'];
		$aData['fbranch_idx'] = $fbranch_idx;
		
		$aData['branch'] = $this->db->ulearning_model->db_select('tb_user',null,array('grade_idx' => 8),array('ASC' => 1));
		$aData['course'] = array(array('fcategory_id' => 1,'fcategory_name' => 'Class Material'),
								array('fcategory_id' => 2,'fcategory_name' => 'Homework'),
								array('fcategory_id' => 4,'fcategory_name' => 'Level Test (Preview)'));
		if($fbranch_idx == 1)
			$this->db->ulearning_model->db_where(array('user_id' => (isset($aArgs['user_id']))?$aArgs['user_id']:""));
		else
			$this->db->ulearning_model->db_where(array('user_id' => (isset($aArgs['user_id']))?$aArgs['user_id']:"" ,'tb_class.branch_idx' => $fbranch_idx));
		$class = $this->db->ulearning_model->db_select('tb_class INNER JOIN tb_user ON tb_class.student_idx = tb_user.idx',array('tb_user.idx','tb_class.idx as class_id','user_id'),null,null,1);
		
		$aData['user_id'] = (!empty($class))?$class[0]['user_id']:"";
		$aData['class_id'] = (!empty($class))?$class[0]['class_id']:"";
		$aData['user_idx'] = (isset($class[0]['idx']))?$class[0]['idx']:"";
		
		if($fbranch_idx == 1)
			$this->db->ulearning_model->db_where(array('student_idx' => (isset($aData['user_idx']))?$aData['user_idx']:"",'class_status' => 'scheduled'));
		else
			$this->db->ulearning_model->db_where(array('student_idx' => (isset($aData['user_idx']))?$aData['user_idx']:"",'class_status' => 'scheduled','t1.branch_idx' => $fbranch_idx));
		$aData['class'] = $this->db->ulearning_model->db_select('tb_class t1 INNER JOIN tb_product_class t2 ON t1.p_class_idx = t2.idx',array('name','t1.idx'));
		
		$aData['sdate'] = $this->sdate;
		$aData['edate'] = $this->edate;
		
		$aData['filter'] = (isset($aArgs['filter']))?$aArgs['filter']:"";
		if($aData['filter'] == 3)
			$aData['filter'] = 2;
		else if($aData['filter'] == 5)
			$aData['filter'] = 4;
		
		$aData['iCurrentPage'] = (isset($aArgs['page'])) ? $aArgs['page']:1;
		$limit = (isset($aArgs['rows'])) ? $aArgs['rows']:10;
		$offset = $limit * ($aData['iCurrentPage']-1);
		$aData['rows'] = $limit;
		$aData['search'] = (isset($aArgs['search'])) ? $aArgs['search']:"";
		$aData['iRowsPerPage'] = $limit;
		
		$sBranchOption = "";
		if($this->branch != "")
			$sBranchOption = "t7.branch_idx = '".$this->branch."' AND ";
		$aData['fbranch_id'] = $this->branch;
		
		$this->db->ulearning_model->db_where($sBranchOption."fuser_idx = '".$aData['user_idx']."' AND t5.fcategory_id LIKE '".$aData['filter']."%' ".
								((!empty($aData['sdate']) && !empty($aData['edate']) ) ? "AND t1.fdate BETWEEN '".strtotime($aData['sdate'])."' AND '".strtotime($aData['edate'])."'" : ""));
		$aData['iTotalRows'] = $this->db->ulearning_model->db_count('tb_ulearning_assign t1 INNER JOIN tb_ulearning_unit t2 ON t2.funit_id = t1.funit_id
									INNER JOIN tb_ulearning_category t3 ON t2.fcategory_id = t3.fcategory_id
									INNER JOIN tb_ulearning_category t4 ON t3.fdepth2 = t4.fcategory_id
									INNER JOIN tb_ulearning_category t5 ON t4.fdepth1 = t5.fcategory_id
									INNER JOIN tb_class t6 ON t6.idx = t1.fclass_id
									INNER JOIN tb_product_class t7 ON t7.idx = t6.p_class_idx');
									
		$this->db->ulearning_model->db_where($sBranchOption."fuser_idx = '".$aData['user_idx']."' AND t5.fcategory_id LIKE '".$aData['filter']."%' ".
								((!empty($aData['sdate']) && !empty($aData['edate']) ) ? "AND t1.fdate BETWEEN '".strtotime($aData['sdate'])."' AND '".strtotime($aData['edate'])."'" : ""));
		$aData['assignment'] = $this->db->ulearning_model->db_select('tb_ulearning_assign t1
									INNER JOIN tb_ulearning_unit t2 ON t2.funit_id = t1.funit_id
									INNER JOIN tb_ulearning_category t3 ON t2.fcategory_id = t3.fcategory_id
									INNER JOIN tb_ulearning_category t4 ON t3.fdepth2 = t4.fcategory_id
									INNER JOIN tb_ulearning_category t5 ON t4.fdepth1 = t5.fcategory_id
									INNER JOIN tb_class t6 ON t6.idx = t1.fclass_id
									INNER JOIN tb_product_class t7 ON t7.idx = t6.p_class_idx',array('fassign_id','t1.fdate','ftitle','t4.fcategory_name as category2','t3.fcategory_name as category3','t5.fcategory_name as category1','t5.fcategory_id as category_id1','name'),null,null,$limit,$offset);
									
		$aData['allCount'] = $this->countAssignCategoryFunc(null,$aData['user_idx']); 
		$aData['classMaterialCount'] = $this->countAssignCategoryFunc(1,$aData['user_idx']);
		$aData['previewCount'] = $this->countAssignCategoryFunc(2,$aData['user_idx']);
		$aData['levelTestPreviewCount'] = $this->countAssignCategoryFunc(4,$aData['user_idx']);
		$this->display("ulearning/test_assign_popup",$aData,false);
		
	}
	private function countAssignCategoryFunc($base,$idx){
		$sBranchOption = "";
		if($this->branch != "")
			$sBranchOption = "t7.branch_idx = '".$this->branch."' AND ";
		$this->db->ulearning_model->db_where($sBranchOption."fuser_idx = '".$idx."' AND t5.fcategory_id LIKE '".$base."%' ".
								((!empty($this->sdate) && !empty($this->edate) ) ? "AND t1.fdate BETWEEN '".strtotime($this->sdate)."' AND '".strtotime($this->edate)."'" : ""));
		return $this->db->ulearning_model->db_count('tb_ulearning_assign t1 
									INNER JOIN tb_ulearning_unit t2 ON t2.funit_id = t1.funit_id
									INNER JOIN tb_ulearning_category t3 ON t2.fcategory_id = t3.fcategory_id
									INNER JOIN tb_ulearning_category t4 ON t3.fdepth2 = t4.fcategory_id
									INNER JOIN tb_ulearning_category t5 ON t4.fdepth1 = t5.fcategory_id
									INNER JOIN tb_class t6 ON t6.idx = t1.fclass_id
									INNER JOIN tb_product_class t7 ON t7.idx = t6.p_class_idx');
	}
}
?>