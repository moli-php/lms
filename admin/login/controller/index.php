<?php
include('../../../__library/controller.php');
class index extends Simplexi_Controller
{
	public function login($aData)
	{
		$this->library('common');
		
		$aFields = array(
					'idx',
					'user_id',
					'grade_idx'	,
					'profile_img'						
					);
		
		$sWhere	= 'user_id = "'.$aData['username'].'" AND password = "'.$aData['password'].'" AND grade_idx IN(9,8,7,6)';
		$return	= $this->selectRow('tb_user',$aFields,$sWhere)->execute();
		
		if($return == false){
			$result	= $return;
		}else{
			$result	= $return;
			$_SESSION['idx']		= $result['idx'];
			$_SESSION['user_id']	= $result['user_id'];
			$_SESSION['grade_idx']	= $result['grade_idx'];
			$_SESSION['profile_img']	= $result['profile_img'];
		}
		
		echo json_encode(array($return));
	}	
}

$oClass 	= new index();

if(isset($_POST['action']) && $_POST['action'] == 'login')
{
	$aData['username']	= $_POST['username'];
	$aData['password']	= $_POST['password'];
	
	$oClass->login($aData);
}