var advise_mgt = function()
{
	var ajax_path = $("#site_ajax").val();
	var contents_url = $("#contents_url").val();
	var idx_global = 0;
	var aidx_global = [];
	
	function _getReply()
	{
		$(".viewreply_dialog").dialog('close');
		$(".reply_dialog").dialog('close');
		$('#message_success').hide();
		$('#sending_message').hide();
		var options = {
			url : ajax_path,
			type : 'post',
			dataType : 'json',
			data : {
				req : 'getreply',
				parent : idx_global
			},success : function(server_response){
				if(server_response)
				{
					$("#v_title").html(server_response.title);
					$("#v_message").html(server_response.message);
					$("#v_date").html(server_response.date_registered);
					$('.viewreply_dialog').dialog({
						title : "Reply &raquo;",
						width:500				
					});					
					return true;
				}
				$('.reply_dialog').dialog({
				
					title : "Reply &raquo;",
					width:500,
					open : function(){
						tinyMCE.execCommand('mceAddControl', true, 'reply_message');
						$(".send_btn").show();
						$('#reply_title').val('');
						$('.rep_to').html($("#m_from").html());
						if (tinyMCE.getInstanceById('reply_message'))
						{
							tinyMCE.get('reply_message').setContent('');
						}
					},close : function(){

						if (tinyMCE.getInstanceById('reply_message'))
						{
							tinyMCE.execCommand('mceFocus', false, 'reply_message');                    
							tinyMCE.execCommand('mceRemoveControl', false, 'reply_message');
						}					
											
						$(this).dialog('destroy');
					}
				});
			}
		}
		$.ajax(options);
	}
	
	function _sendReply()
	{
		var error = 0;
		tinyMCE.triggerSave();
		var bvalidate = $(".reply_form").validateForm();
		var reply_message = $('#reply_message').val();
		$('#reply_message_error').hide();
		$('#message_success').hide();
		
		if(reply_message=="")
		{
			error += 1;
			 $('#reply_message_error').show();
		}
		
		if(bvalidate==true && error==0)
		{
			var reply_title = $("#reply_title");
			var reply_message = $("#reply_message");
			$('#sending_message').show();
			var options = {
				url : ajax_path,
				type : 'post',
				dataType : 'html',
				data : {
					req : 'sendreply',
					parent : idx_global,
					reply_title : reply_title.val(),
					reply_message : reply_message.val()
				},success : function(server_response){
					$('#message_success').show();
					$('#sending_message').hide();
					$(".send_btn").hide();
				}
			}
			$.ajax(options);						
		}

	}
	
	function _row(element)
	{
		window.location = contents_url + '&rows=' + $(element).val() + $(element).attr('alt');
	}
	
	function _read(arr_val)
	{
		var options = {
			url : ajax_path,
			type : 'post',
			dataType : 'html',
			data : {
				req : 'read',
				arr_val : arr_val
			},success : function(server_response){
				alert(server_response);
			}
		}
		$.ajax(options);
	}
	
	function _unRead(arr_val)
	{
		var options = {
			url : ajax_path,
			type : 'post',
			dataType : 'html',
			data : {
				req : 'unread',
				arr_val : arr_val
			},success : function(server_response){

			}
		}
		$.ajax(options);
	}
	
	function _delete(arr_val)
	{
		$('.delete_dialog').dialog({
			title : "Delete Message",
			width : 350
		});
	}
	
	function deleteConfirm()
	{
		var options = {
			url : ajax_path,
			type : 'post',
			dataType : 'html',
			data : {
				req : 'delete',
				arr_val : aidx_global
			},success : function(server_response){
				Menu.message('success',"Message has been deleted!");
				window.location = defaults.current_url;
			}
		}
		$.ajax(options);			
	}

	function _view(idx)
	{
		$("#m_from").html('');
		$("#m_title").html('');
		$("#m_message").html('');
		idx_global = idx;
		var options = {
			url : ajax_path,
			type : 'post',
			dataType : 'json',
			data : {
				idx : idx,
				req : 'view'
			},success : function(server_response){
				if(server_response)
				{
					$("#m_from").html($(".user_disp"+idx).html());
					$("#m_title").html(server_response.title);
					$("#m_message").html(server_response.message);
					$("#m_date").html(server_response.date_registered);
				}
			}
		}
		$.ajax(options);
	}
	
	function _search(element)
	{
		var search_box = $("#search_box");
		window.location = contents_url + '&search=' + search_box.val() + $(element).attr('alt');
	}
	
	function send(){
			var shtml = "";
			$('.div_area').remove()
			$('.tarea').remove()
			shtml += "<div class='div_area'><div class='tarea'><textarea id='t'></textarea></div></div>";
			
			$("body").append(shtml);
			
			$('.tarea').dialog({
					title : "Reply &raquo;",
					width:500,
					open : function(){
						tinyMCE.execCommand('mceAddControl', true, 't');
					},close : function(){

						if (tinyMCE.getInstanceById('t'))
						{
							tinyMCE.execCommand('mceFocus', false, 't');                    
							tinyMCE.execCommand('mceRemoveControl', false, 't');
						}					
											
						$(this).dialog('destroy');
					}
			});	
	}
	
	function load_events()
	{	
		tinyMCE.init({
			mode : "none",
			theme : "advanced",
			theme_advanced_toolbar_align : "left",
			theme_advanced_toolbar_location : "top",
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "bullist,numlist,separator,outdent,indent,separator,undo,redo,separator",
			theme_advanced_buttons3 : ""
		});

		
		$('.check_all').click(function(){
			var checkbox = $('input[name="checkbox[]"]');
			var total_checked = checkbox.filter(':checked').length;
			if(total_checked==0)
			{
				$('.delete_dialog').dialog('close');
			}
		})
		
		$(".show_message_link").click(function(){
			var idx = $(this).attr('alt');			
			$(this).attr('style','font-weight:normal');
			_view(idx);
			$('.reply_dialog').dialog("close");
			$('.delete_dialog').dialog("close");
			$('.message_dialog').dialog({
				title : "Message &raquo;",
				width:500,
				modal : true,
				close : function(){					
					$(".viewreply_dialog").dialog('close');
					$(".reply_dialog").dialog('close');
				}
			});
		});

		$(".show_reply_link").click(function(e){
			var idx = $(this).attr('alt');
			_getReply();
			
		});		
				
		
		$('.delete_btn').click(function(){
			var action_options = $(".action_options");	
			var checkbox = $('input[name="checkbox[]"]');
			var total_checked = checkbox.filter(':checked').length;
			var arr_val = [];
			
			if(action_options.val()=='')
			{
				Menu.message('warning',"Select action you want to perform.");
				return false;
			}
			
			if(total_checked==0)
			{
				Menu.message('warning',"No records selected!");
				return false;
			}
			
			checkbox.each(function(index,value){
				var idx = $(this).val();
				
				if($(this).is(":checked")==true)
				{
					arr_val.push(idx);	
				}
				aidx_global = arr_val;
			});			
			$('.delete_dialog').dialog({
				width:350,
				title : "Delete Message"
			});

		});
		
		$(".search_btn").click(function(){
			_search(this);
		});	
		
		$(".row").change(function(){
			_row(this);
		});
		
		$('.test').click(function(e){
			send()
		});
		
		$('.send_btn').click(function(){
			_sendReply();
		});
		
		$('.delete_confirm_btn').click(function(){
			deleteConfirm();
		});
		
		$('input[name="checkbox[]"]').click(function(){
			closeDialog($('.delete_dialog'));
		});
		
		$('input[name="checkbox[]"]').shiftcheckbox();
	}
	
	function closeDialog(element)
	{
		element.dialog('destroy');
	}
	
	return{
		load_events : load_events,
		closeDialog : closeDialog
	}
}();

jQuery(document).ready(function(){
	advise_mgt.load_events();
});
