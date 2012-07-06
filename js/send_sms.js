var sms = {

	send_sms : function(mobile,msg,from){
		if(mobile.length==1){
			var mobile_len = '';
		}else{
			mobile.pop();
			var mobile_len = '('+mobile.length+')';
		}
			$('div#parent').remove();
			var dialog_email = '<div id="parent">';
				dialog_email += '<div class="popup_window message_content" id="smsReady" style="display:none">';
				dialog_email += '	<p>SMS will be sent to chosen list '+mobile_len+'. Are you sure?</p>';
				dialog_email += '	<div class="action_btn fr">';
				dialog_email += '		<a href="#" class="btn_save" id="sendSmsbtn" title="Save changes">Submit</a>';
				dialog_email += '		<a href="javascript:message.close();"  class="btn_return"  title="Return to Users" style="float:left">Cancel</a>';
				dialog_email += '	</div>';
				dialog_email += '</div>';
				dialog_email += '</div>';
				$('body').append(dialog_email);	
				
				$('#smsReady').dialog({
					width: 350.467,
					height: 150,
					modal: true,
					resizable: false,
					show : {effect:'clip'}
				});
				
		$('#sendSmsbtn').click(function(){
			$('#smsReady').dialog('close');
			$('#view_smstpl').dialog('close');

		var mess = '<div id="message_con" class="ui-widget" style="margin-bottom:20px;"><div class="ui-state-highlight ui-corner-all" style="padding: 7px;text-align:center; "> <p><img src="../../images/loader3.gif" style="vertical-align: middle;height:25px;width:25px;" />&nbsp;&nbsp; Message Sending please wait... </p></div></div>';
					$('#message_wrap_con').html(mess);	
					
			$.ajax({
				url : common.getBaseUrl() + '/admin/message/?action=sms_mngt&sub=update',
				type : 'post',
				dataType: 'json',
				data: {
					to : mobile,
					mesg : msg,
					resc : from,
					req: 'sendSms'
				},
				success : function(data){
					if (data=='sucess'){
						Menu.message('success','Message Sent');
					}else if(data=='failed'){
						Menu.message('warning','Sending Message Failed');
					}else if(data=='authenfailed'){
						Menu.message('warning','Sending Error : Aunthentication Failed!');
					}
				}
			});
		
		});

	}
	
};