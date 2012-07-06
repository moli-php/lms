<?php
include('../../../__library/controller.php');
class index extends Simplexi_Controller
{
	public function viewThread($pager=1,$limit=2,$fpid)
	{
		// Get the original post only if pager is equal to one
		$sQlOrig_post		= 'SELECT 
								tb_forum_post.fpid, 
								tb_forum_post.fcid, 
								tb_forum_post.uid, 
								tb_forum_post.title, 
								tb_forum_post.content,
								tb_forum_post.row,
								tb_forum_post.post_date,
								tb_forum_post.modified_date,
								tb_forum_post.attach_file,
								
								tb_user.user_id,
								tb_user.profile_img,
								tb_user.date_reg
								
								FROM tb_forum_post JOIN tb_user ON tb_forum_post.uid = tb_user.idx
								WHERE tb_forum_post.fpid = '.$fpid;
		$orig_post			= $this->query($sQlOrig_post);
		
		$aOrig_post			= array();
		foreach($orig_post as $k=>$v)
		{
			$aOrig_post[$k]	= $v;
		}

		// Get the comments for this thread
		if($pager == 1)
		{
			$limit	= $limit - 1;
			$offset		= (($pager - 1) * $limit);
		}
		else
		{
			// $limit	= $limit - 1;
			$offset		= (($pager - 1) * $limit) - 1;
		}
		
		if($aOrig_post)
		{
			$sQlPost_comment	= 'SELECT 
						tb_forum_post_comment.fpcid, 
						tb_forum_post_comment.fpid, 
						tb_forum_post_comment.uid,
						tb_forum_post_comment.comment,
						tb_forum_post_comment.quote,
						tb_forum_post_comment.reply_date,
						tb_forum_post_comment.modified_date,
						
						tb_user.user_id,
						tb_user.profile_img,
						tb_user.date_reg
						
						FROM tb_forum_post_comment INNER JOIN tb_user
						ON tb_forum_post_comment.uid = tb_user.idx
						
						WHERE tb_forum_post_comment.fpid = '.$fpid.' LIMIT '.$offset.', '.$limit;
			$post_comments		= $this->query($sQlPost_comment);
			$aPost_comments 	= array();
			$aCPost_comments 	= array();
			for($aCntr = 0; $aCntr <= (count($post_comments) - 1); $aCntr++)
			{
				foreach($post_comments[$aCntr] as $k=>$v)
				{
					$aPost_comments[$k]	= $v;
				}
				$aCPost_comments[$aCntr]	= $aPost_comments;
			}
			
			// Get the total rows withour limit
			$sQltotal	= 'SELECT COUNT(*) as total FROM tb_forum_post_comment INNER JOIN tb_user ON tb_forum_post_comment.uid = tb_user.idx
							WHERE tb_forum_post_comment.fpid = '.$fpid;
			$total_comments		= $this->query($sQltotal);
			
			// Get the category style
			$asQl_style = 'SELECT 
						tb_forum_category.fsid,
						tb_forum_category.image_display,
						tb_forum_category.allow_reply,
						tb_forum_category.file_attach
						
						FROM 
						tb_forum_post JOIN tb_forum_category
						ON tb_forum_post.fcid	= tb_forum_category.fcid
						WHERE tb_forum_post.fpid = '.$fpid;
			$aReult_style	= $this->query($asQl_style);
			
		}
		if($aOrig_post[0]['attach_file'] != null)
		{
			$_sWhere	= 'ufid = '.$aOrig_post[0]['attach_file'];
			$_result	= $this->selectRow('tb_forum_uploaded_file','',$_sWhere)->execute();
			$aOrig_post[0]['attach_file_detail']	= $_result;
		}
		

		
		// 'file'=>$file
		
		echo json_encode(
				array(
					'orig_post'			=>	$aOrig_post, 
					'replies'			=>	$aCPost_comments, 
					'total_rows'		=>	$total_comments, 
					'style'				=>	$aReult_style[0]['fsid'], 
					'image_display'		=>	$aReult_style[0]['image_display'], 
					'allow_reply'		=>	$aReult_style[0]['allow_reply'],
					'allow_file_attach'	=>	$aReult_style[0]['file_attach'],					
					'session'			=>	$_SESSION, 
					'attach_file'		=>	$aOrig_post[0]['attach_file']
				)
			);
	}
	
	public function addReply($aData){
		$aFields	= array();
		
		foreach($aData as $k=>$v)
		{
			$aFields[$k]	= $v;
		}
		
		$aFields['uid']			= (int)USER_ID;
		$aFields['reply_date']	= time();

		unset($aFields['crud']);
		unset($aFields['forum_section']);
		unset($aFields['id']);
		
		$result	= $this->insert('tb_forum_post_comment', $aFields)->execute();
		
		// Get the total rows withour limit
		$sQltotal	= 'SELECT COUNT(*) as total FROM tb_forum_post_comment INNER JOIN tb_user ON tb_forum_post_comment.uid = tb_user.idx
						WHERE tb_forum_post_comment.fpid = '.$aFields['fpid'];
		$total_comments		= $this->query($sQltotal);
		
		// Topic row limit 
		$sWhere = "fpid  = ".$aFields['fpid'];
		$topic_row_limit	= $this->selectRow('tb_forum_post','',$sWhere)->execute();
		
		echo json_encode(array('stat'=>$result, 'total_rows'=>$total_comments, 'topic_row_limit'=>$topic_row_limit['row']));
	}
	
	public function setModifyComment($fpcid)
	{
		$sWhere = "fpcid  = ".$fpcid;
		echo json_encode($this->selectRow('tb_forum_post_comment','',$sWhere)->execute());
	}
	
	public function updateComment($aData)
	{
		$aFields = array();
		foreach($aData as $k=>$v)
		{
			$aFields[$k]	= $v;
		}
		
		$aFields['modified_date']	= time();
		
		unset($aFields['crud']);
		unset($aFields['forum_section']);
		
		$sWhere = "fpcid  = ".$aFields['fpcid'];
		unset($aFields['fpcid']);
		$return	= $this->update('tb_forum_post_comment',$aFields,$sWhere)->execute();
		
		echo json_encode(array('stat'=>$return));
	}
	
	public function deleteComments($fpcid)
	{
		// Get the fpid to count all the total remaining rows
		$sWhere_total 	= "fpcid  = ".$fpcid;
		$fpid			= $this->selectRow('tb_forum_post_comment','',$sWhere_total)->execute();
		
		if($fpid)
		{
			// Topic row limit 
			$sWhere_limit = "fpid  = ".$fpid['fpid'];
			$topic_row_limit	= $this->selectRow('tb_forum_post','',$sWhere_limit)->execute();
			
			if($topic_row_limit)
			{
				$sWhere = "fpcid  = ".$fpcid;
				$result	= $this->deleteBy('tb_forum_post_comment',$sWhere)->execute();
				
				if($result)
				{
					// Get the total rows withour limit
					$sQltotal	= 'SELECT COUNT(*) as total FROM tb_forum_post_comment
									WHERE fpid = '.$fpid['fpid'];
					$total_comments		= $this->query($sQltotal);
				}
			}
		}
	
		echo json_encode(array('stat'=>$result,'total_rows'=>$total_comments[0]['total'],'topic_row_limit'=>$topic_row_limit['row']));
	}
	
	public function rowTopicLimit($fpid)
	{
		$getRowLimit		= 'SELECT *  FROM tb_forum_post WHERE fpid  = '.$fpid;
		return $this->query($getRowLimit);
	}
	
	public function setQuote($aData)
	{
		
		if($aData['quoteType'] == 'topic')
		{
			// If quote type is post
			$sWhere = "fpid  = ".$aData['quoteId'];
			$result	= $this->selectRow('tb_forum_post','',$sWhere)->execute();
			$result['quoteType']	= 'topic';
		}
		else
		{
			// If quote type is comment
			$sWhere = "fpcid  = ".$aData['quoteId'];
			$result	= $this->selectRow('tb_forum_post_comment','',$sWhere)->execute();
			$result['quoteType']	= 'comment';
		}
		
		echo json_encode($result);
	}
	
	public function backTopicList($fpid)
	{
		$asQl = 'SELECT 
					tb_forum_category.name,
					tb_forum_post.fcid,
					tb_forum_category.row AS category_row,
					tb_forum_category.fcid AS fcid
					
					FROM 
					tb_forum_post JOIN tb_forum_category
					ON tb_forum_post.fcid	= tb_forum_category.fcid
					WHERE tb_forum_post.fpid = '.$fpid;
		$aReult	= $this->query($asQl);
		
		$asWhere	= 'fpid <= '.$fpid.' AND fcid = '.$aReult[0]['fcid'];
		$bResult	= $this->select('tb_forum_post','',$asWhere)->execute();
		$pager		= count($bResult) / (int)$aReult[0]['category_row'];
		
		echo json_encode(array('category'=>$aReult, 'pager'=>ceil($pager)));
		// echo json_encode(array($aReult, $bResult));
	}
}

$oClass 	= new index();

$oData	= json_decode($_POST['model']);
if($oData->crud == 'r')
{
	// Topic row limit 
	$topic_row_limit	= $oClass->rowTopicLimit($oData->fpid);
	if($topic_row_limit)
	{
		$oClass->viewThread($oData->pager,$topic_row_limit[0]['row'],$oData->fpid);
	}	
}
else if($oData->crud == 'c')
{
	$oClass->addReply($oData);
}
else if($oData->crud == 'set_modify')
{
	$fpcid	= (int)$oData->fpcid;
	$oClass->setModifyComment($fpcid);
}
else if($oData->crud == 'u')
{
	$oClass->updateComment($oData);
}
else if($oData->crud == 'd')
{
	$oClass->deleteComments($oData->fpcid);
}
else if($oData->crud == 'quote_view')
{
	$aData	= array();
	$aData['quoteType']	= $oData->quoteType;
	$aData['quoteId']	= $oData->quoteId;
	$oClass->setQuote($aData);
}
else if($oData->crud == 'back_topiclist')
{
	$oClass->backTopicList($oData->fpid);
}



