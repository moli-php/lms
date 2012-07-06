<?php
include('../../__library/controller.php');
class index extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library('common');
		
		if(isset($aArgs['page']))
		{
			$aData['iCurrentPage'] 	= $aArgs['page'];
		}
		else
		{
			$aData['iCurrentPage'] 	= 1;
		}
		
		if(isset($aArgs['rows'])){
			$aData['iRowsPerPage'] 	= $aArgs['rows'];
		}else{
			$aData['iRowsPerPage'] 	= 2;
		}
		
		$offset						= ($aData['iCurrentPage'] - 1) * $aData['iRowsPerPage'];		
		$jSql						= 'SELECT tb_user.idx, tb_user.user_id, tb_user.name, tb_branch_detail.active, tb_branch_detail.points 
										FROM tb_user LEFT JOIN tb_branch_detail ON tb_user.idx = tb_branch_detail.uid
										WHERE tb_user.grade_idx = 8
									';

		// Search
		if(isset($aArgs['search']))
		{
			$jSql					.= ' AND tb_user.user_id LIKE "%'.$aArgs['search'].'%"';
		}
		
		// Sorting
		if(isset($aArgs['sort']))
		{
			if($aArgs['sort'] == 'uid')
			{
				$jSql				.= ' ORDER BY tb_user.idx '.strtoupper($aArgs['order']);
			}
			
			if($aArgs['sort'] == 'point')
			{
				$jSql				.= ' ORDER BY tb_branch_detail.points '.strtoupper($aArgs['order']);
			}
		}	

		$jSql						.= ' LIMIT '.$offset.','.$aData['iRowsPerPage'];
		$xsql						= $this->select('tb_user','', 'grade_idx = 8')->execute();
		
		$aData['query']				= $this->query($jSql);
		$aData['cwd']				= getcwd();
		
		if(isset($aArgs['search']))
		{
			$aData['len']			= count($aData['query']);
		}
		else
		{
			$aData['len']			= count($xsql);
		}
		
		$aData['iTotalRows'] 		= $aData['len'];
		
		$this->importJS('branch/apps');
		$this->display('branch/tpl/index',$aData);				
	}	
}

$oClass = new index();
$oClass->run($aArgs);
// Common::paginate($iCurrentPage, $iRowsPerPage, $iTotalRows);