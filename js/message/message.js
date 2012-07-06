$(document).ready(function(){
	
});

var message = {
	
	send_mail:function(email,param){
	
		tinyMCE.init({
			mode: "none",
			theme: "advanced",
			theme_advanced_toolbar_align: "left",
			theme_advanced_toolbar_location: "top",
			theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
			theme_advanced_buttons2: "bullist,numlist,separator,outdent,indent,separator,undo,redo,separator",
			theme_advanced_buttons3: ""
		});
		var disabled = '';
		if(param==true){
			email.pop();
			var disabled = '';
		}else if (param==false){
			var disabled = 'disabled="disabled"';
		}
		var _email = email.toString();
		var emails = _email.split(',');
		if (emails[1] == null) {
			var email_add = emails[0];
		} else {
			if (email.length == 1) {
				var email_add = emails[0];
			} else if (email.length == 2) {
				var email_add = emails[0] + ', and ' + emails[1];
			} else if (email.length == 3) {
				var email_add = emails[0] + ', ' + emails[1] + ', and ' + emails[2];
			} else {
				var email_add = emails[0] + ', ' + emails[1] + ', and <a href="#" id="view_emailaddrs" style="text-decoration:underline;font-style:italic;color:#FF9900;">' + (email.length - 2) + ' other members</a>';
			}
		}
			$('#sendto').html(email_add);
			
		var getData = {
			url: common.getBaseUrl() + '/admin/message/?action=email_template&sub=update',
			dataType: 'json',
			data: {
				req: 'getData'
			},
			success: function (data) {
			if(data==""){
				Menu.message('warning','Template not set yet!');
			}else{
			$('div#parent').remove();
				var dialog_email = '<div id="parent">';
				dialog_email += '<div class="popup_window message_content" id="editor" style="padding:20px;display:none">';
				dialog_email += '<p style="float:left"><label>Send To: </label><span id="sendto">' + email_add + '</span></p><br><br>';
				dialog_email += '<p style="float:left"><label>Templates: </label><select id="emailTpl" onChange = "message.showTemplate()">';
				dialog_email += '<option selected value="none" id="blank_option">blank</option>';

				for (var i in data) {
					var titlesubs = data[i].tpl_title.substring(0,20);
					var template_title = data[i].tpl_title.length<=20 ? data[i].tpl_title : titlesubs+'...';
					dialog_email += '<option value="' + data[i].idx +'">' + template_title +'</option>';
				}
				dialog_email += '</select></p><br><br>';
				dialog_email += '<p style="float:left"><label>Title:</label><input type="text" id="email_title" '+disabled+'/></p>';
				dialog_email += '	<div class="text_editor" style="float:left">';
				dialog_email += '		<textarea class="my_textarea" id="my_textarea"></textarea>';
				dialog_email += '	</div>';
				dialog_email += '	<div class="action_btn">';
				dialog_email += '		<a href="#" class="btn_save" id="sendEmail" title="Save changes" style="float: left;">Send E-mail</a>';
				dialog_email += '		<a href="#" id="cancel" class="btn_return fr"  title="Return to Users">Cancel</a>';
				dialog_email += '	</div>';
				dialog_email += '</div>';
				dialog_email += '<div class="popup_window message_content" id="emailReady" style="display:none">';
				dialog_email += '	<p>E-mail will be sent to chosen list, are you sure?</p>';
				dialog_email += '	<div class="action_btn fr">';
				dialog_email += '		<a href="#" class="btn_save" id="sendEmailbtn" title="Save changes">Submit</a>';
				dialog_email += '		<a href="javascript:message.close();"  class="btn_return"  title="Return to Users" style="float:left">Cancel</a>';
				dialog_email += '	</div>';
				dialog_email += '</div>';
				dialog_email += '<div class="message_dialog recordform_dialog" id="view_emailadd" style="display:none;word"></div></div>';
				$('body').append(dialog_email);
																
				$('#editor').dialog({
					width: 706.467,
					height: 420.467,
					resizable: false,
					title: 'Send Email',
					modal: true,
					open: function () {
						tinyMCE.execCommand('mceAddControl', true, 'my_textarea');
					},
					close: function () {
						if (tinyMCE.getInstanceById('my_textarea')) {
							tinyMCE.execCommand('mceFocus', false, 'my_textarea');
						}
						tinyMCE.get('my_textarea').setContent('');
						$('#email_title').val('');
						$('#emailTpl').val('');
					}
				});
				

				if(disabled!=""){
					$('#blank_option').remove();
					setTimeout(function(){
						$.ajax({
							url : common.getBaseUrl() + '/admin/message/?action=email_template&sub=update',
							type : 'post',
							dataType: 'json',
							data: {
								id: $("#emailTpl").val(),
								req: 'getData'
							},
							success : function(data){
								$("#email_title").val(data[0].tpl_title);
								tinyMCE.get('my_textarea').setContent(data[0].message);
								tinyMCE.get('my_textarea').getBody().setAttribute('contenteditable', 'false');
							}
						});
						},50);
				}
				}
				
				$('#cancel').click(function () {
				
					$('#editor').dialog('close');
					tinyMCE.get('my_textarea').setContent('');
					$('#email_title').val('');
					$('#emailTpl').val('');
				
				});
				
				$('#view_emailaddrs').click(function () {
					var view_emailad = '';
						view_emailad+='	<div class="show_message_container">';
						view_emailad+='		<div id="1m_message">';
						view_emailad+='			<ul class="view_email">';
						view_emailad+='				<li class="search_result">';
						view_emailad+='					<ul>';
						for (var x in emails) {
							view_emailad += '<li>' + emails[x] + '</li>';
						}
						view_emailad+='					</ul>';
						view_emailad+='				</li>';
						view_emailad+='			</ul>';
						view_emailad+='		</div>';
						view_emailad+='</div>	';
						
						$('#view_emailadd').empty();
						$('#view_emailadd').append(view_emailad);
					
						$('#view_emailadd').dialog({
							width:274.467,
							height: 324.467,
							title: 'Recipients',
							resizable: false,
							show : {effect:'clip'}
						});
				});
				
				$('#sendEmail').click(function () {
					tinyMCE.triggerSave();
					$('#editor').dialog("destroy");
					var emailtitle = $('#email_title').val();
					var emailmsg = $('#my_textarea').val();
					$('#emailReady').dialog({
						width: 322.467,
						height: 150,
						modal: true,
						resizable: false,
						show : {effect:'clip'}
					});
					$('#sendEmailbtn').click(function () {
						$('#emailReady').dialog("close");

					var mess = '<div id="message_con" class="ui-widget" style="margin-bottom:20px;"><div class="ui-state-highlight ui-corner-all" style="padding: 7px;text-align:center; "> <p><img src="../../images/loader3.gif" style="vertical-align: middle;height:25px;width:25px;" />&nbsp;&nbsp; Message Sending please wait... </p></div></div>';
					$('#message_wrap_con').html(mess);
					
						var users_email = email;
						var sendMail = {
							url: common.getBaseUrl() + '/admin/message/?action=email_mngt&sub=update',
							type: 'post',
							dataType: 'json',
							data: {
								email: users_email,
								title: emailtitle,
								message: emailmsg,
								req: 'sendMail'
							},
							success: function (data) {
								$('#message_wrap_con').empty();

								
								if(data=='sent'){
									var save_log = {
										url: common.getBaseUrl() + '/admin/message/?action=email_mngt&sub=update',
										type: 'post',
										dataType: 'json',
										data: {
											email: users_email,
											title: emailtitle,
											message: emailmsg,
											req: 'saveLog'
										},
										success: function (data) {
											Menu.message('success','Message Sent');
										},
										error: function(){
											Menu.message('warning','Creating Message-Log Failed!');
										}
									}
									$.ajax(save_log);
								}else{
									Menu.message('warning','Message Sending Failed');
								}
																
							},
							error: function(){
								Menu.message('warning','Message Sending Failed');
							}
						}
						$.ajax(sendMail);
					});
				});
								
			}
		}
		$.ajax(getData);
		
	},
	close : function(){
		window.location.reload();
	},
	showTemplate: function(){
	
		if($("#emailTpl").val()=='none'){
					$("#email_title").val('');
					tinyMCE.get('my_textarea').setContent('');

		}else{
				$.ajax({
				url : common.getBaseUrl() + '/admin/message/?action=email_template&sub=update',
				type : 'post',
				dataType: 'json',
				data: {
					id: $("#emailTpl").val(),
					req: 'getData'
				},
				success : function(data){
					$("#email_title").val(data[0].tpl_title);
					tinyMCE.get('my_textarea').setContent(data[0].message);
				}
			});
		}
	},
	
	send_sms:function(mobile,flag){
	
		
		if (flag==false){
			var disabled = 'disabled="disabled"';
		}else{
			var disabled = '';
		}
		var _mobile = mobile.toString();
		var mobiles = _mobile.split(',');
		if (mobiles[1] == null) {
			var mobile_no = mobiles[0];
		} else {
			if (mobile.length == 1) {
				var mobile_no = mobiles[0];
			} else if (mobile.length == 2) {
				var mobile_no = mobiles[0] + ', and ' + mobiles[1];
			} else if (mobile.length == 3) {
				var mobile_no = mobiles[0] + ', ' + mobiles[1] + ', and ' + mobiles[2];
			} else {
				var mobile_no = mobiles[0] + ', ' + mobiles[1] + ', and <a href="#" id="view_mobiles" style="text-decoration:underline;font-style:italic;color:#FF9900;">' + (mobile.length - 2) + ' other members</a>';
			}
		}
		var getSmstpl= {
		
			url: common.getBaseUrl() + '/admin/message/?action=sms_mngt&sub=update',
			dataType: 'json',
			data: {
				req: 'getTpl'
			},
			success: function (data) {
					var dialog_sms = '<div id="sms_container"><div class="message_dialog recordform_dialog" id="view_smstpl" style="display:none;word"></div></div>';
					$('body').append(dialog_sms);	
				if(data[1]==''){
					Menu.message('warning','Site phone number not yet configured!');
				}else if(data[0]==''){
					Menu.message('warning','Template not set yet!');
				}else{
					var view_smstpl = '';
						view_smstpl+='	<div class="show_message_container">';
						view_smstpl+='		<div id="1m_message">';
						view_smstpl+='			<b class="message_label">';
						view_smstpl+='				To : <span id="m_title">'+mobile_no+'</span>';
						view_smstpl+='			</b>';
						view_smstpl+='			<b class="message_label">';
						view_smstpl+='				From : <span id="m_title"><input type="text" id="from_id" '+disabled+' value="'+data[1][0].fphone_number+'"></span>';
						view_smstpl+='			</b>';
						view_smstpl+='			<p id="m_message" class="message_main"><div id="warningtpl"></div></p>';
						view_smstpl+='		<li class="sms_template">';
						view_smstpl+='			<ul class="templates_list">';
						view_smstpl+='				<li id="manual_li">';
						view_smstpl+='					<p class="template_head"><input id="radio_manual_common" type="radio" class="radio" name="sms_common" /><label>Manual Template</label></p>';
						view_smstpl+='						<div class="template_bg">';
						view_smstpl+='							<textarea id="blank_common" class="textfield"></textarea>';
						view_smstpl+='						</div>';
						view_smstpl+='					<p class="template_size" id="manual_common"><span class="">0</span>/80 bytes</p>';
						view_smstpl+='				</li>';
						for (var i in data[0]) {
						view_smstpl+='				<li>';
						view_smstpl+='					<p class="template_head"><input type="radio" class="radio" name="sms_common" value="'+data[0][i].idx+'" /><label>'+data[0][i].tpl_title+'</label></p>';
						view_smstpl+='						<div class="template_bg"><p>'+data[0][i].tpl_message+'</p></div>';
						
							var valLength = data[0][i].tpl_message.length;
								if(valLength<71){
									view_smstpl+='					<p class="template_size"><span class="">'+valLength+'</span>/80 bytes</p>';
								}else{
									view_smstpl+='					<p class="template_size"><span class="overlimit">'+valLength+'</span>/80 bytes</p>';
								}
						view_smstpl+='				</li>';
						}		
						view_smstpl+='			</ul>';
						view_smstpl+='		</li>';
						view_smstpl+='		</div>';
						view_smstpl+='</div>	';
						view_smstpl+='<div align="center"><input type="button" id="sendsmsbtn" class="btn" value="Send SMS" style="cursor:pointer" /></div>';
						
						$('#view_smstpl').empty();
						$('#view_smstpl').append(view_smstpl);
					
						$('#view_smstpl').dialog({
							title: 'SMS Template',
							resizable: true,
							minHeight: 412.467,
							minWidth: 713.467,
							show : {effect:'clip'}
						});
						
						}
						$('.textfield').keyup(function() {
								var valLength = $(this).val().length;
								if(valLength<71){
                                    $('#manual').html('<span class="">'+valLength+'</span>/80 bytes');
								}else{
									if(valLength<=80){
										$('#manual').html('<span class="overlimit">'+valLength+'</span>/80 bytes');
									}else{
										$(this).attr('maxlength','80');
									}
								}
						});
						$('#sendsmsbtn').click(function(){
						
							if($('#from_id').val()=="" || !$('#from_id').val().match(/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/)){
								$('#from_id').attr('class','fix error');
							}
							if($('[name="sms_common"]:checked').val()){
								if(!$('#from_id').val().match(/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/)){
									$('#from_id').attr('class','fix error');
								}else if($('[id="radio_manual_common"]:checked').val() && $('#blank_common').val()==""){
									$('#blank_common').attr("style","border:1px solid #ce1f1f");
								}else{
								
									if($('[id="radio_manual_common"]:checked').val()){
										var msg_sms = $('#blank_common').val();
										var from_sms = $('#from_id').val();
										sms.send_sms(mobiles,msg_sms,from_sms);
									}else{
										var id_msg = $('[name="sms_common"]:checked').val();
										$.ajax({
											url : common.getBaseUrl()+'/admin/message/?action=sms_mngt&sub=update',
											dataType: 'json',
											data: {
												idx : id_msg,
												req: 'getdatatpl'
											},
											success : function(data){
												sms.send_sms(mobiles,data[0].tpl_message,$('#from_id').val());
											}
										});
										
									}
								}
							}else{
								$('#warningtpl').empty();
								$('#warningtpl').html('<div style="padding: 7px;text-align:center;" class="ui-state-error ui-corner-all">  <p style="display:inline-block;"><span style="float: left;margin-right:5px;" class="ui-icon ui-icon-alert"></span>Please Make a selection from the list</p></div>');
							}
							$('.radio').live('click',function(){
								$('#warningtpl').fadeOut(2000);
							});
						});
						
						$('#blank_common').keyup(function() {
							$('#blank_common').attr("style","");
								var valLength = $(this).val().length;
								if(valLength<71){
									$('#manual_common').html('<span class="">'+valLength+'</span>/80 bytes');
								}else{
									if(valLength<=80){
										$('#manual_common').html('<span class="overlimit">'+valLength+'</span>/80 bytes');
									}else{
										$(this).attr('maxlength','80');
									}
								}
						});
						
						$('#from_id').keyup(function() {
							$('#from_id').attr('class','');
						});
						
						if (disabled !=""){
							$('#manual_li').remove();
						}

			
			}
			
		}
		$.ajax(getSmstpl);

	}
};