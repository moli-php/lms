<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link type="text/css" rel="stylesheet" href="../../css/style.css" media="all" />
	<link rel="stylesheet" type="text/css" href="../../css/custom-theme/jquery-ui-1.8.20.custom.css" />
	<script type="text/javascript">
	window.onresize = function() 
	{
		window.resizeTo(1200,800);
	};
	</script>
	<style type="text/css">
		.wrap {width:98% !important;padding:10px !important;margin-right:10px;}
	</style>
</head>
<body>
	<a href="#">Test</a>
	<div id="container">
		<div class="container_wrap2">
			<div class="wrap">				
				<div class="top">
					<h3 class="title">Advise Management</h3>
				</div>
				<div id="message_wrap_con"></div>
				<ul class="sort_view">
					<li <?php echo ($view=="") ? 'class="active all"' : ""; ?>><a href="<?php echo $sContentsUrl;?><?php echo $qry_idx; ?>">All (<?php echo $total;?>)</a></li>
					<li <?php echo ($view=="read") ? 'class="active all"' : ""; ?>><a href="<?php echo $sContentsUrl;?>&view=read<?php echo $qry_idx; ?>">Read (<?php echo $total_read;?>)</a></li>
					<li <?php echo ($view=="unread") ? 'class="active all"' : ""; ?>><a href="<?php echo $sContentsUrl;?>&view=unread<?php echo $qry_idx; ?>">Unread (<?php echo $total_unread;?>)</a></li>
					<li style="float:right;background:none"><input type="text" id="search_box" value="<?php echo $search;?>"/><input type="submit" value="search" class="btn_apply search_btn" alt="<?php echo $qry_view . $qry_idx;?>"/></li>
				</ul>
				<div class="top_2">
					<div class="show_rows">
						Show Rows
						<select class="row" alt="<?php echo $qry_idx . $qry_view . $qry_search . $qry_sort;?>">
							<option value="10" <?php echo ($rows==10) ? "selected='selected'" : "";?>>10</option>
							<option value="20" <?php echo ($rows==20) ? "selected='selected'" : "";?>>20</option>
							<option value="30" <?php echo ($rows==30) ? "selected='selected'" : "";?>>30</option>
							<option value="50" <?php echo ($rows==50) ? "selected='selected'" : "";?>>50</option>
						</select>
					</div>
				</div>
				<table cellspacing="0" class="post_table banner">
					<colgroup>
						<col width="40px" />
						<col width="40px" />
						<col width="100px" />
						<col  />	
						<col width="80px" />		
						<col width="170px" />
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" class="check_all"/></th>
							<th>No.</th>
							<th><a href="<?php echo $sContentsUrl;?>&field=user_id&sort=<?php echo ($field=='user_id') ? $sort : "desc";?><?php echo $qry_idx . $qry_search . $qry_rows . $qry_view;?>" class="<?php echo ($field=='user_id') ? (($sort=='desc') ? 'sort_down' : 'sort_up') : "sort_down";?>">User</a></th>
							<th><a href="<?php echo $sContentsUrl;?>&field=title&sort=<?php echo ($field=='title') ? $sort : "desc";?><?php echo $qry_idx . $qry_search . $qry_rows . $qry_view;?>" class="<?php echo ($field=='title') ? (($sort=='desc') ? 'sort_down' : 'sort_up') : "sort_down";?>">Title</a></th>
							<th ><a href="<?php echo $sContentsUrl;?>&field=read_status&sort=<?php echo ($field=='read_status') ? $sort : "desc";?><?php echo $qry_idx . $qry_search . $qry_rows . $qry_view;?>" class="<?php echo ($field=='read_status') ? (($sort=='desc') ? 'sort_down' : 'sort_up') : "sort_down";?>">Status</a></th>
							<th><a href="<?php echo $sContentsUrl;?>&field=date_reg&sort=<?php echo ($field=='date_reg') ? $sort : "desc";?><?php echo $qry_idx . $qry_search . $qry_rows . $qry_view;?>" class="<?php echo ($field=='date_reg') ? (($sort=='desc') ? 'sort_down' : 'sort_up') : "sort_down";?>">Registered Date</a></th>
						</tr>
					</thead>
					<tbody >						
						<?php if($aContents){?>
							<?php foreach($aContents as $rows){?>
							<tr>
								<td><input type="checkbox" name="checkbox[]" value="<?php echo $rows['idx'];?>"/></td>
								<td><?php echo $rows['row'];?></td>
								<td><span class="username_disp<?php echo $rows['idx'];?>"><?php echo $rows['user_id'];?></span></td>
								<td><a href="javascript:void(0);" class="show_message" <?php echo ($rows['status']=='N') ? 'style="font-weight:bold;"' : "";?>alt="<?php echo $rows['idx'];?>"><?php echo $rows['title'];?></a></td>
								<td><?php echo $rows['status'];?></td>
								<td><?php echo date('Y-m-d',$rows['date_reg']);?></td>
							</tr>
							<?php }?>
						<?php }else{?>
							<tr><td colspan="6">No record(s)</td></tr>
						<?php }?>
					</tbody>
				</table>		
				<div class="bottom">
					<div class="apply_action">
						<a href="#" class="btn_apply delete_btn">Delete</a>
					</div>
				</div>
				<?php echo Common::paginate($page, $limit, $total_rows); ?>
			</div>
		</div>	
	</div>
	
<!--hidden-->
<div class="message_dialog recordform_dialog" style="display:none;word">
	<div class="show_message_container" style="height:75%;">
		<div id="1m_message">
			<b class="message_label">Title : <span id="m_title">jQuery Usage</span></b>
			<b class="message_label">From : <span id="m_from">johntan</span></b>
			<b class="message_label">Date : <span id="m_date"></span></b>
			<p class="message_main" id="m_message">	
			</p>
		</div>
	</div>
	<div class="action_btn">
		<a href="javascript:void(0);" class="btn_save fr show_reply_link" title="Save changes">Reply</a>
	</div>	
</div>		
<div class="recordform_dialog reply_dialog" style="display:none;">
	<form class="reply_form">
	<table class="recordform_table">
		<col width="80px" />
		<tr><td><label>Title : </label></td><td><input type="text" validate="required|minlength[6]|maxlength[100]" class="fix" name="reply_title" id="reply_title" style="width:100%;" /></td></tr>
		<tr><td><label>To : </label></td><td><span class="r_from">John Adrian Tan</span></td></tr>
		<tr><td colspan="2">
			<textarea class="reply_message" name="reply_message" id="reply_message" cols="10" style="width:450px;height:250px;"></textarea>
			<label id="reply_message_error" style="display: none;">Please provide your message</label>
		</td></tr>
	</table>
	<div id="sending_message" class="ui-widget" style="margin-bottom:20px;display:none;"><div class="ui-state-highlight ui-corner-all" style="padding: 7px;text-align:center;"> <p style="display:inline-block;"><span class="ui-icon ui-icon-info" style="float: left;margin-right:5px;"></span>Sending Message..</p></div></div>
	<div id="message_success" class="ui-widget" style="margin-bottom:20px;display:none;"><div class="ui-state-highlight ui-corner-all" style="padding: 7px;text-align:center;"> <p style="display:inline-block;"><span class="ui-icon ui-icon-info" style="float: left;margin-right:5px;"></span>Message has been sent succesfully!</p></div></div>
	<div class="action_btn">
		<a href="javascript:void(0);" class="btn_save fr send_btn" title="Save changes">Send</a>
	</div>
	</form>
</div>

<div class="viewreply_dialog recordform_dialog" style="display:none;word">
	<div class="show_message_container" style="height:79%;">
		<div id="1m_message">
			<b class="message_label">Title : <span id="v_title">jQuery Usage</span></b>
			<b class="message_label">Date : <span id="v_date"> 2012-04 12</span></b>
			<p class="message_main" id="v_message">	
			</p>
		</div>
	</div>
</div>

<div class="delete_dialog" style="display:none;" title="Delete Message">
	<span class="alert_mess">Are you sure you want to delete this message?</span>
	<a href="#" class="dynbtn delete_confirm_btn">Delete </a>
	<a href="#" class="dynbtn" onclick="adv_pop.closeDialog($('.delete_dialog'))"> Cancel </a>
</div>

<input type="hidden" id="contents_url" value="<?php echo $sContentsUrl;?>"/>
<input type="hidden" id="site_ajax" value="<?php echo $sSiteAjaxPath;?>"/>
<script type="text/javascript">
var defaults = {
	current_url : "<?php echo CURRENT_URL;?>"
}
</script>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.20.custom.min.js"></script>
<script type="text/javascript" src="../../js/menu/jquery.cookie.js"></script>
<script type="text/javascript" src="../../js/menu/menu.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.js"></script>
<script type="text/javascript" src="../../js/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="../../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../../js/message/adv_mngt_popup.js"></script>
</body>
</html>	