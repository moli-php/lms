<?php
include('../../../__library/controller.php');
class index extends Simplexi_Controller
{
	public function inserts($aArgs)
	{
		$this->library('common');
		
		$aFields	= array(
					'username'	=> $aArgs->username,
					'password'	=> $aArgs->password
				);

		echo json_encode(array($this->insert('test', $aFields)->execute()));
	}	
}

$aArgs	= json_decode($_POST['model']);
$oClass = new index();

if(isset($aArgs->method) AND $aArgs->method == 'insert')
{
	$oClass->inserts($aArgs);
}
else
{
	echo json_encode(array('error'));
}




