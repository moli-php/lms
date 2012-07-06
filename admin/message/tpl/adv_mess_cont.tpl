<div style="display:none;">
	<input type="text" id="total_contents" value="<?php echo $total_contents;?>"/>
	<div class="advise_list_dialog">
		<div class="action_btn" style='margin-bottom:5px;'>
			<a href="javascript:void(0);" class="bttn1 fr adv_receive " title="Save changes" style="margin-right:19px;margin-left:2px;">Sent Message</a>
		</div>		
		<div class="action_btn">
			<a href="javascript:void(0);" class="bttn1 fr adv_sent" title="Save changes">Receive Message</a>
		</div>
		<div class="advise_list_table_cont">
			<table class="advise_list">
				<colgroup>
					<col width="60px">
					<col width="450px">
					<col width="650px">
					<col width="220px">
					<col width="240px">
				</colgroup>
				<thead>
					<tr><th>No</th><th><a href="#" class="adv_sort" alt="adv_user_id">Id <i  class="adv_sort_up sort_icon"></i></a></th><th><a href="#" class="adv_sort" alt="adv_title">Title <i class="adv_sort_up sort_icon"></i></a></th><th><a href="#" class="adv_sort" alt="adv_read_status">Status <i  class="adv_sort_up sort_icon"></i></a></th><th><a href="#" class="adv_sort" alt="adv_date_sent">Date <i  class="adv_sort_up sort_icon"></i></a></th></tr>
				</thead>
				<tbody class="ajax_advise_message_cont">
				</tbody>
			</table>
		</div>
		<div class="page_area"></div>
	</div>
	
	<div class="message_dialog recordform_dialog" style="display:none;word">
		<div class="show_message_container">
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
			<tr><td><label>To : </label></td><td>John Adrian Tan</td></tr>
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
		<div class="show_message_container">
			<div id="1m_message">
				<b class="message_label">Title : <span id="v_title">jQuery Usage</span></b>
				<b class="message_label">Date : <span id="v_date"> 2012-04 12</span></b>
				<p class="message_main" id="v_message">	
				</p>
			</div>
		</div>
	</div>

</div>