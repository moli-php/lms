<?php
include('../../../__library/controller.php');
class index extends Simplexi_Controller
{
	public function getTopicList($pager=1,$limit=2,$fcid,$search=null)
	{
		$sWhere		= 'fcid = '.$fcid;
		$total_rows	= count($this->select('tb_forum_post','',$sWhere)->execute());
		
		// Get the category for this topic
		$category	= $this->select('tb_forum_category','',$sWhere)->execute();
		
		$offset		= (($pager - 1) * $limit);
		
		$aSql		= 'SELECT 
						tb_forum_post.fpid,
						tb_forum_post.uid,
						tb_forum_post.title,
						tb_forum_post.post_date,
						
						tb_user.user_id
						
						FROM 
						tb_forum_post JOIN tb_user
						ON tb_forum_post.uid	= tb_user.idx
						WHERE tb_forum_post.fcid = '.$fcid;
		if($search !== null)
		{
			$aSql		.= ' AND tb_forum_post.title LIKE "%'.$search.'%"';
			$total_rows	= count($this->query($aSql));
		}
		$aSql			.= ' LIMIT '.$offset.','.$limit;
		$data			= $this->query($aSql);
		$sWhere_syle	= 'fcid = '.$fcid;
		$style			= $this->selectRow('tb_forum_category','',$sWhere_syle)->execute();
		
		echo json_encode(array('rows'=>$data, 'total_rows'=>$total_rows, 'style'=>$style['fsid'], 'category'=>$category, 'session'=>$_SESSION));	
		// echo json_encode(array($aSql));
	}
	
	public function deleteTopic($aData)
	{
		$fcids	= '';
		$len	= count($aData['id']) - 1;
		foreach($aData['id'] as $k=>$v)
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
		$sWhere	= 'fpid IN ('.$fcids.')';
		
		
		$aSql	= 'SELECT 
						  tb_forum_category.row
						  
						  FROM tb_forum_post JOIN tb_forum_category
						  ON tb_forum_post.fcid	= tb_forum_category.fcid
						  WHERE tb_forum_post.fpid = '.$aData['id'][0];
		$row_limit = $this->query($aSql);
		
		
		
		if(count($aData['id']) == (int)$row_limit[0]['row'])
		{
			// Go to the next previous pagination
			$bSql	= 'SELECT CEIL(COUNT(*) / 3) as pager FROM tb_forum_post WHERE fpid < '.$aData['id'][0];
			$pager	= $this->query($bSql);
		}
		else
		{
			// Stay in the same pagination
			$cSql		= 'SELECT CEIL(COUNT(*) / '.$row_limit[0]['row'].') as page FROM tb_forum_post';
			$cResult	= $this->query($cSql);
			
			$dOffset	= ($cResult[0]['page'] - 1) * (int)$row_limit[0]['row'];
			$dSql		= 'SELECT * FROM tb_forum_post LIMIT '.$dOffset.','.$row_limit[0]['row'];
			$dResult	= $this->query($dSql);
			$_fpids		= array();
			
			foreach($dResult as $k=>$v)
			{
				array_push($_fpids, $v['fpid']);
			}
			
			if(count($_fpids) == count($aData['id']))
			{
				$bSql	= 'SELECT CEIL(COUNT(*) / '.$row_limit[0]['row'].') as pager FROM tb_forum_post WHERE fpid < '.$aData['id'][0];
				$pager	= $this->query($bSql);
			}
			else
			{
				$bSql	= 'SELECT CEIL(COUNT(*) / '.$row_limit[0]['row'].') as pager FROM tb_forum_post WHERE fpid <= '.$aData['id'][0];
				$pager	= $this->query($bSql);
			}			
		}
		
		$return	= $this->deleteBy('tb_forum_post', $sWhere)->execute();
		echo json_encode(array('stat'=>$return, 'page'=>$pager[0]['pager']));
	}
	
	public function deleteAlltopics($fcid=null)
	{
		$sWhere = "fcid  = ".$fcid;
		$status	= $this->deleteBy('tb_forum_post', $sWhere)->execute();
		echo json_encode(array('stat'=>$status));
	}
	
	public	function addTopic($aData)
	{
		$aFields	= array();
		$fileFields	= array();
		
		foreach($aData as $k=>$v)
		{
			if($k == 'fcid' || $k == 'row')
			{
				$aFields[$k]	= (int)$v;
			}
			else if($k != 'crud' && $k != 'forum_section' && $k != 'id' && $k != 'ext' && $k != 'name' && $k != 'nameid')
			{
				$aFields[$k]	= $v;
			}
			else if($k == 'ext' || $k == 'name' || $k == 'nameid'){
				$fileFields[$k]	= $v;
			}
		}
		
		if($fileFields['nameid'] != null){
			$fileFields['upload_date']	= time();
			$fileResult					= $this->insert('tb_forum_uploaded_file', $fileFields)->execute();
			$lastInsertedId				= $this->lastInsertId();
		}
		else
		{
			$lastInsertedId				= null;
		}
		
		$aFields['attach_file']	= $lastInsertedId;
		$aFields['uid']			= (int)USER_ID;
		$aFields['post_date']	= time();
		
		
		$result				= $this->insert('tb_forum_post', $aFields)->execute();

		// Get the updated total rows of this post
		$sWhere_total 		= 'fcid  = '.$aData->fcid;
		$total_rows			= count($this->select('tb_forum_post','',$sWhere_total)->execute());
		
		// Get the limit row of this post's category
		$sWhere_limitRow 	= 'fcid  = '.$aData->fcid;
		$limitRow			= $this->selectRow('tb_forum_category','',$sWhere_limitRow)->execute();
		
		echo json_encode(array('stat'=>$result, 'total_rows'=>$total_rows, 'limit_row'=>$limitRow['row']));
	}
	
	public function setUpdateTopic($fpid)
	{
		$sWhere 	= 'fpid  = '.$fpid;
		$result		= $this->selectRow('tb_forum_post','',$sWhere)->execute();		
		
		if($result['attach_file'] != null){
			$_sWhere					= 'ufid = '.$result['attach_file'];
			$_result					= $this->selectRow('tb_forum_uploaded_file','',$_sWhere)->execute();
			$_result['attach_nameid']	= $_result['nameid'];
			$_result['attach_name']		= $_result['name'];
			$_result['attach_ext']		= $_result['ext'];
			$attached					= array($_result['attach_nameid'], $_result['attach_name'],$_result['attach_ext'],$_result['ufid']);
			$result['attached']			= $attached;
		}		
		echo json_encode(array($result));
	}
	
	public function updateTopic($aData)
	{
		$aFields	= array();
		$fileFields	= array();
		
		foreach($aData as $k=>$v)
		{
			if($k == 'fcid' || $k == 'row')
			{
				$aFields[$k]	= (int)$v;
			}
			else if($k != 'crud' && $k != 'forum_section' && $k != 'id' && $k != 'ext' && $k != 'name' && $k != 'nameid' && $k != 'ufid')
			{
				$aFields[$k]	= $v;
			}	
			else if($k == 'ext' || $k == 'name' || $k == 'nameid' || $k == 'ufid'){
				$fileFields[$k]	= $v;
			}			
		}
		
		if($fileFields['nameid'] != null){
			$fileFields['modified_date']	= time();
			$ufid							= $fileFields['ufid'];
			unset($fileFields['ufid']);
			
			$fileResult						= $this->update('tb_forum_uploaded_file', $fileFields, 'ufid = '.$ufid)->execute();
		}
		
		$aFields['modified_date']	= time();
		unset($aFields['fpid']);
		$sWhere 					= 'fpid  = '.$aData->fpid;
		
		echo json_encode(array($this->update('tb_forum_post',$aFields,$sWhere)->execute()));
	}
	
	public function getTopicRow($fcid)
	{
		$sWhere	= 'fcid	= '.$fcid;
		$result	= $this->selectRow('tb_forum_category','',$sWhere)->execute();
		echo json_encode(array('row'=>$result['row']));
	}
	
	public function categoryRowLimit($fcid)
	{
		// Get the limit row of this post's category
		$sWhere_limitRow 	= 'fcid  = '.$fcid;
		$limitRow			= $this->selectRow('tb_forum_category','',$sWhere_limitRow)->execute();
		return	$limitRow['row'];
	}
	
	public function backToCategoryList($aData)
	{
		$aSql		= 'SELECT  CEIL(COUNT(*)/'.$aData['row'].') as page FROM tb_forum_category WHERE fcid <= '.$aData['fcid'];
		$aResult	= $this->query($aSql);
		echo json_encode(array('page'=>$aResult[0]['page']));
	}
}

$oClass 	= new index();
$uri 		= $_SERVER['REQUEST_URI'];
$segment 	= explode('/', $uri);

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	$data	= explode('_', $segment[5]);
	$pager	= str_replace('pager', '', $data[0]);
	$row	= str_replace('row', '', $data[1]);
	$fcid	= str_replace('fcid', '', $data[2]);
	
	$oClass->getTopicList($pager,$row,$fcid);
}
else
{
	$oData	= json_decode($_POST['model']);
	if($oData->crud == 'd')
	{
		$aFields['id']	= $oData->id;
		$oClass->deleteTopic($aFields);
	}
	else if($oData->crud == 'c')
	{
		$oClass->addTopic($oData);
	}
	else if($oData->crud == 'v')
	{
		$oClass->setUpdateTopic($oData->id);
	}
	else if($oData->crud == 'u')
	{
		$oClass->updateTopic($oData);
	}
	else if($oData->crud == 'topic_row')
	{
		$oClass->getTopicRow($oData->fcid);
	}	
	else if($oData->crud == 'search')
	{
		$row	= $oClass->categoryRowLimit($oData->fcid);
		if(isset($oData->page))
		{
			$page	= $oData->page;
		}
		else
		{
			$page	= 1;
		}
		$oClass->getTopicList($page,$row,$oData->fcid,$oData->title);
	}
	else if($oData->crud == 'delete_alltopic')
	{
		$oClass->deleteAlltopics($oData->fcid);
	}
	else if($oData->crud == 'back_to_category')
	{
		$aData	= array();
		$aData['fcid']	= $oData->fcid;
		$aData['row']	= $oData->row;
		$oClass->backToCategoryList($aData);
		
		// echo json_encode(array('fcid'=>$oData->fcid, 'row'=>$oData->row));
	}
}








