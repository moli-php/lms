<?php
include('../../../__library/controller.php');
class branch_model extends Simplexi_Controller
{
	// Performs CU | C(create) and U(update)
	public function cu($aArgs)
	{
		$this->library('common');
		
		$sWhere	= 'uid = '.$aArgs['uid'];
		$rowLen	= count($this->select('tb_branch_detail','',$sWhere)->execute());
		
		if($rowLen == 0)
		{
			// Insert new branch informations
			$aFields	= array(
							'uid'		=> (int)$aArgs['uid'],
							'active'	=> (int)$aArgs['active'],
							'points'	=> (int)$aArgs['point'],
							'referrer'	=> $aArgs['referrer'],
							'description'	=> $aArgs['description']
						);
			return $this->insert('tb_branch_detail', $aFields)->execute();
		}
		else
		{
			// Update current branch
			$aFields	= array(
							'active'	=> (int)$aArgs['active'],
							'points'	=> (int)$aArgs['point'],
							'referrer'	=> $aArgs['referrer'],
							'description'	=> $aArgs['description']
						);
			return $this->update('tb_branch_detail',$aFields,$sWhere)->execute();
		}
	}	
	
	// Display data to be edited
	public function displayRow($aArgs)
	{	
		$sWhere	= 'uid = '.$aArgs['uid'];
		return $this->select('tb_branch_detail','',$sWhere)->execute();
	}
	
	// Search username
	public function search($aArgs)
	{
		$aData	= array();
		$sWhere	= 'user_id LIKE "%'.$aArgs['user_id'].'%"';
		$row	= $this->select('tb_user','',$sWhere)->execute();
		$len	= count($this->select('tb_user','',$sWhere)->execute()) - 1;
		
		for($cntr=0; $cntr<=$len; $cntr++)
		{
			$sWhere2	= 'uid = '.$row[$cntr]['idx'];
			$row2		= $this->selectRow('tb_branch_detail','',$sWhere2)->execute();
			if($row2['active'] == 1){
				$stat	= 'Active';
			}else{
				$stat	= 'Deactivated';
			}
			$aData[]	= array('idx'=>$row[$cntr]['idx'], 'user_id'=>$row[$cntr]['user_id'], 'points'=>$row2['points'], 'stat'=>$stat);
		}
		return $aData;
	}
	
	// Get point and active
	public function pointActive($aArgs)
	{
		// $sWhere	= 'uid LIKE "%'.$aArgs['user_id'].'%"';
		// return $this->select('tb_branch','',$sWhere)->execute();
	}
}

$oClass = new branch_model();

// Performs CU | C(create) and U(update)
if(isset($aArgs['cu']) == true AND $aArgs['cu'] == 'cu')
{
	echo $oClass->cu($aArgs);
}

// Display data to be edited
if(isset($aArgs['display']) == true AND $aArgs['display'] == 'display')
{
	echo json_encode($oClass->displayRow($aArgs));
}

// Search
if(isset($aArgs['search']) == true AND $aArgs['search'] == 'username')
{
	echo json_encode($oClass->search($aArgs));
}
// echo '<pre>';
// print_r($oClass->search($aArgs));
// $oClass->search($aArgs);






