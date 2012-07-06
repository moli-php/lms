<?php
include('../../../__library/controller.php');
class index extends Simplexi_Controller
{
	public function getCategory($pager=1,$limit=2,$search=null)
	{
		$this->library('common');
		$total_rows	= count($this->selectAll('tb_forum_category', '')->execute());
		if($pager == 1)
		{
			$aData1	= array();
			$data	= $this->selectAll('tb_forum_category', '')->execute();
			for($acntr=0; $acntr<=(count($data) - 1); $acntr++)
			{
				// Get style name
				$sWhere		= 'fsid = '.$data[$acntr]['fsid'];
				$styleData	= $this->selectRow('tb_forum_style','',$sWhere)->execute();
				$aData1[]	= array($data[$acntr]['fcid'], $data[$acntr]['name'], $styleData['name'], $data[$acntr]['regdate'], $data[$acntr]['uid'], 'session'=>$_SESSION);
			}
			echo json_encode(array('rows'=>$aData1,'total_rows'=>$total_rows));
		}
		else
		{
			$aData1	= array();
			$offset	= (($pager - 1) * $limit); 
			$data	= $this->selectAll('tb_forum_category', '')->limit($offset,$limit)->execute();
			for($acntr=0; $acntr<=(count($data) - 1); $acntr++)
			{
				// Get style name
				$sWhere		= 'fsid = '.$data[$acntr]['fsid'];
				$styleData	= $this->selectRow('tb_forum_style','',$sWhere)->execute();
				$aData1[]	= array($data[$acntr]['fcid'], $data[$acntr]['name'], $styleData['name'], $data[$acntr]['regdate'], $data[$acntr]['uid'], 'session'=>$_SESSION);
			}			
			echo json_encode(array('rows'=>$aData1,'total_rows'=>$total_rows));
		}
	}	

	public function searchCategory($pager=1,$limit=2,$search=null)
	{
		$aOffset	= ($pager - 1) * $limit;
		$aSql		= 'SELECT 
						tb_forum_category.fcid,
						tb_forum_category.name as category_name,
						tb_forum_category.regdate,
						
						tb_forum_style.fsid,
						tb_forum_style.name as style_name
						
						FROM tb_forum_category JOIN tb_forum_style
						ON tb_forum_category.fsid = tb_forum_style.fsid
						WHERE tb_forum_category.name LIKE "%'.$search.'%"';
		$total_rows	= count($this->query($aSql));				
		$aSql		.=	'LIMIT '.$aOffset.', '.$limit.'
						';
		$aResult	= $this->query($aSql);
		echo json_encode(array('rows'=>$aResult, 'total'=>$total_rows));
	}
	
	public function viewUpdateCategory($aData)
	{
		$sWhere	= 'fcid = '.$aData['fcid'];
		return $this->selectRow('tb_forum_category','',$sWhere )->execute();
	}
	
	public function updateCategory($oData, $fcid)
	{
		$aFields	= array();
		foreach($oData as $k=>$v)
		{
			$aFields[$k]	= $v;
		}
						
		$sWhere	= 'fcid = '.$fcid;
		if($oData['file_exist'] != null)
		{
			if(file_exists('../../../uploads/forum/category/'.$oData['file_exist']) && $oData['file_exist'] != $oData['logo']) 
			{
				unlink('../../../uploads/forum/category/'.$oData['file_exist']);
			}
		}
		
		unset($aFields['file_exist']);
		echo json_encode(array($this->update('tb_forum_category',$aFields,$sWhere)->execute()));		
		// echo json_encode(array(file_exists('../../../uploads/forum/category/'.$oData['file_exist']), $oData['file_exist']));		
	}
	
	public function addCategory($oData)
	{
		$aFields	= array();
		foreach($oData as $k=>$v)
		{
			$aFields[$k]	= $v;
		}
		
		$stat		= $this->insert('tb_forum_category', $aFields)->execute();
		$total_rows	= count($this->selectAll('tb_forum_category', '')->execute());
		echo json_encode(array('stat'=>$stat, 'total_rows'=>$total_rows));
	}
	
	public function deleteCategory($aData)
	{
		$fcids	= '';
		$len	= count($aData['fcid']) - 1;
		foreach($aData['fcid'] as $k=>$v)
		{
			if($k < $len)
			{
				$fcids	.= $v.',';
			}
			else
			{
				$fcids	.= $v;
			}
		}
		$sWhere	= 'fcid IN ('.$fcids.')';
		
		if(count($aData['fcid']) == $aData['row_limit'])
		{
			// Delete all the rows for current page
			// Check if there's still a record where ids are greater than the deleted records
			$tmpId	= (int)$aData['fcid'][count($aData['fcid']) - 1];
			$bSql	= 'SELECT COUNT(*) as remaining FROM tb_forum_category WHERE fcid > '.$tmpId;
			$bResult	= $this->query($bSql);
			
			// If there's still a record where ids are greater than the deleted records
			if($bResult[0]['remaining'] != 0)
			{
				// Get the next previous pagination page and add 1
				$cSql		= 'SELECT CEIL(COUNT(*) / '.$aData['row_limit'].') as pager FROM tb_forum_category WHERE fcid < '.$aData['fcid'][0];
				$cResult	= $this->query($cSql);
				$pager		= $cResult[0]['pager'] + 1;
			}
			else
			{
				// If there's non
				// Go to the next previous pagination
				$dSql		= 'SELECT CEIL(COUNT(*) / '.$aData['row_limit'].') as pager FROM tb_forum_category WHERE fcid < '.$aData['fcid'][0];
				$dResult	= $this->query($dSql);
				$pager		= $dResult[0]['pager'];
			}			
		}
		else
		{
			$eSql		= 'SELECT CEIL(COUNT(*) / '.$aData['row_limit'].') as page FROM tb_forum_category';
			$eResult	= $this->query($eSql);
			
			$fOffset	= ($eResult[0]['page'] - 1) * $aData['row_limit'];
			$fSql		= 'SELECT * FROM tb_forum_category LIMIT '.$fOffset.','.$aData['row_limit'];
			$gResult	= $this->query($fSql);
			$_fcids		= array();
			
			foreach($gResult as $k=>$v)
			{
				array_push($_fcids, $v['fcid']);
			}
			
			if(count($_fcids) == count($aData['fcid']))
			{
				$hSql		= 'SELECT CEIL(COUNT(*) / '.$aData['row_limit'].') as pager FROM tb_forum_category WHERE fcid < '.$aData['fcid'][0];
				$hResult	= $this->query($hSql);
				$pager		= $hResult[0]['pager'];
			}
			else
			{
				$hSql		= 'SELECT CEIL(COUNT(*) / '.$aData['row_limit'].') as pager FROM tb_forum_category WHERE fcid <= '.$aData['fcid'][0];
				$hResult	= $this->query($hSql);
				$pager		= $hResult[0]['pager'];
			}	
		}
		

		$status	= $this->deleteBy('tb_forum_category', $sWhere)->execute();
		// $status	= 'status';
		echo json_encode(array('status'=>$status,'page'=>$pager));
	}
	
	public function getAllStyles()
	{
		return $this->selectAll('tb_forum_style', '')->execute();
	}
	
	public function getAllGrades()
	{
		return $this->selectAll('tb_grade', '')->execute();
	}
}

$oClass 	= new index();
$uri 		= $_SERVER['REQUEST_URI'];
$segment 	= explode("/", $uri);

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$pager 		= explode("_", $segment[5]);
	$catPage	= str_replace('categorypager', '', $pager[0]);
	$catRow		= str_replace('row', '', $pager[1]);
	if($pager[0] == 'categorypager'.$catPage)
	{
		$oClass->getCategory($catPage,$catRow);
	}	
}
else
{
	$oData	= json_decode($_POST['model']);
	if($oData->forum_section == 'category')
	{
		$aField	= array();
		
		if($oData->crud == 'r')
		{
			$aData['fcid']	= $oData->id;
			echo json_encode(array('category_form'=>$oClass->viewUpdateCategory($aData), 'style_list'=>$oClass->getAllStyles(), 'grade_list'=>$oClass->getAllGrades()));
		}
		else if($oData->crud == 'u')
		{
			$aField['uid']				= USER_ID;
			$aField['fsid']				= (int)$oData->forum_style;
			$aField['read_auth']		= (int)$oData->read_auth;
			$aField['write_auth']		= (int)$oData->write_auth;
			$aField['name']				= str_replace('+', ' ', urldecode($oData->category_title));
			$aField['logo']				= $oData->filename;
			$aField['row']				= (int)$oData->this_category_row;
			$aField['file_attach']		= (int)$oData->attachment;
			$aField['image_display']	= (int)$oData->img_display;
			$aField['allow_reply']		= (int)$oData->allow_reply;
			$aField['modified_date']	= time();
		
			$aField['file_exist']		= $oData->file_exist;
			$fcid						= $oData->fcid;
			$oClass->updateCategory($aField, $fcid);
		}
		else if($oData->crud == 'view_category_style_grade')
		{
			echo json_encode(array('style_list'=>$oClass->getAllStyles(), 'grade_list'=>$oClass->getAllGrades()));
		}
		else if($oData->crud == 'c')
		{
			$aField['uid']				= USER_ID;
			$aField['fsid']				= (int)$oData->forum_style;
			$aField['read_auth']		= (int)$oData->read_auth;
			$aField['write_auth']		= (int)$oData->write_auth;
			$aField['name']				= str_replace('+', ' ', urldecode($oData->category_title));
			$aField['logo']				= $oData->filename;
			$aField['row']				= (int)$oData->this_category_row;
			$aField['file_attach']		= (int)$oData->attachment;
			$aField['image_display']	= (int)$oData->img_display;
			$aField['allow_reply']		= (int)$oData->allow_reply;
			$aField['regdate']			= time();
			
			$oClass->addCategory($aField);
		}
		else if($oData->crud == 'd')
		{
			$aFields['fcid']		= $oData->id;
			$aFields['row_limit']	= $oData->row_limit;
			$oClass->deleteCategory($aFields);
		}
		else if($oData->crud == 'search')
		{
			$oClass->searchCategory($oData->page,$oData->row_limit, $oData->title);
			// echo json_encode($oData);
		}
	}
}
// $aData['fcid']	= 58;
// echo '<pre>';
// $oClass->getCategory(2);
// print_r(array('category_form'=>$oClass->viewUpdateCategory($aData), 'style_list'=>$oClass->getAllStyles(), 'grade_list'=>$oClass->getAllGrades()));




