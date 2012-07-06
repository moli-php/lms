var adv_pop = function()
{
	var contents_url = $("#contents_url").val();
	var ajax_path = $("#site_ajax").val();
	var idx_global = 0;
	var aidx_global = [];
	
	function _row(element)
	{
		window.location = contents_url + '&rows=' + $(element).val() + $(element).attr('alt');
	}
		
	function _search(element)
	{
		var search_box = $("#search_box");
		window.location = contents_url + '&search=' + search_box.val() + $(element).attr('alt');
	}

	function _view(idx)
	{
		var options = {
			url : ajax_path,
			dataType : 'json',
			type : 'post',
			data : {
				req : 'viewCommon',
				idx : idx
			},success : function(server_response){
				$("#m_from").html($(".username_disp"+idx).html());
				$("#m_title").html(server_response.title);
				$("#m_date").html(server_response.date_registered);
				$("#m_message").html(server_response.message);
				$('.message_dialog').dialog({
					title : "Message &#187;",
					width:500,
					height:350,
					modal : true,
					close : function(){
						
						$(".viewreply_dialog").dialog('close');
						$(".reply_dialog").dialog('close');
					}
				});				
			}			
		}
		
		$.ajax(options);
	}
	
	function _showReply()
	{		
		$(".viewreply_dialog").dialog('close');
		$(".reply_dialog").dialog('close');
		$('#message_success').hide();
		$('#sending_message').hide();
		var options = {
			url : ajax_path,
			dataType : 'json',
			type : 'post',
			data : {
				req : 'viewReplyCommon',
				parent : idx_global
			},success : function(server_response){
				if(!server_response)
				{
					$(".send_btn").show();
					$('.reply_dialog').dialog({
						title : "Reply &raquo;",
						width:500,
						open : function(){
							tinyMCE.execCommand('mceAddControl', true, 'reply_message');
							$('#reply_title').val('');
							tinyMCE.get('reply_message').setContent('');
						},close : function(){
							if (tinyMCE.getInstanceById('reply_message'))
							{
								tinyMCE.execCommand('mceFocus', false, 'reply_message');                    
								tinyMCE.execCommand('mceRemoveControl', false, 'reply_message');
							}					
												
							$(this).dialog('destroy');
						}
					});			
			
					$(".r_from").html($(".username_disp"+idx_global).html());					
				}
				else
				{					
					$(".viewreply_dialog").dialog({
						title : "View Reply &raquo;",
						width:500,
						height:350,
					});
					$('#v_title').html(server_response.title);
					$('#v_date').html(server_response.date_registered);
					$('#v_message').html(server_response.message);
				}
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
	
	function loadEvents()
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
	
		$('.row').change(function(){
			_row(this);
		});
		
		$(".search_btn").click(function(){
			_search(this);
		});	
		
		$('.show_message').click(function(){
			var idx = $(this).attr('alt');
			idx_global = idx;
			$(this).removeAttr('style');
			_view(idx);
		});
		
		$('.show_reply_link').click(function(){
			_showReply();
		});
		
		$('.send_btn').click(function(){
			_sendReply();
		});		
		
		$('.check_all').click(function(){
			var checkbox = $('input[name="checkbox[]"]');
			var total_checked = checkbox.filter(':checked').length;
			if(total_checked==0)
			{
				$('.delete_dialog').dialog('close');
			}
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
		
				
		$('.delete_confirm_btn').click(function(){
			deleteConfirm();
		});
	}
	function closeDialog(element)
	{
		element.dialog('destroy');
	}
	return{
		loadEvents : loadEvents,
		closeDialog : closeDialog
	}
}();

jQuery(document).ready(function(){
	adv_pop.loadEvents();
});

