$(document).ready(function(){
	if($('#datepicker').length > 0)
		$('#datepicker').datepicker({
			inline: true
		});	
});



var common = {
	dialogResizable : false,
	dialogModal : true,
	dialogDraggable : true,
	dialogCloseOnEscape : true,
	
	getBaseUrl : function(){
		var sUrl = location.href;
		return sUrl.match(/^(http:\/\/)?([^\/]+)/g);
	},
	
	getClassUrl : function(sClass){
		var sUrl = location.href;
		sUrl = sUrl.replace(/\?(.*)/g, "");
		
		return sClass ? (sUrl + "?action=" + sClass) : sUrl;
	},
	
	getUrlParameter : function(param){
		return this.getUrlParameters()[param];
	},
	
	getUrlParameters : function(){
		var params = {};
		
		window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str,key,value) {
			params[key] = value;
		});

		return params;
	},
		
	reportError : function(content, oFunction){
		$("#errorDialogBox").remove();
		$("body").append('<div id="errorDialogBox" style="display:none;"></div>');
		$("#errorDialogBox").append('<p class="dialogContent"><span class="ui-icon ui-icon-alert" style="float:left; margin:0px 7px 20px 0;"></span>' + content + '</p>');
		$("#errorDialogBox").dialog({
			modal: common.dialogModal,
			resizable: common.dialogResizable,
			draggable: common.dialogDraggable,
			closeOnEscape: common.dialogCloseOnEscape,
			title: "Error",
			buttons: {
				Close : function(){
					$(this).dialog("close");
				}
			},
			close: function(){
				if (oFunction != undefined && typeof oFunction == "function") oFunction.call();
			}
		});
	},
	
	createDialog : function(dialogName, content){
		$("#" + dialogName).remove();
		$("body").append('<div id="' + dialogName + '" style="display:none;"></div>');
		$("#" + dialogName).html(content);
	},
	
	/*message*/
	message: function(data, label, reload){
		if(data == 'success')	
			var mess = '<div id="message_con" class="ui-widget" style="margin-bottom:20px;"><div class="ui-state-highlight ui-corner-all" style="padding: 7px;text-align:center;"> <p style="display:inline-block;"><span class="ui-icon ui-icon-info" style="float: left;margin-right:5px;"></span>'+label+'.</p></div></div>';
		if(data == 'warning')	
			var mess = '<div id="message_con" class="ui-widget" style="margin-bottom:20px;"><div class="ui-state-error ui-corner-all" style="padding: 7px;text-align:center;">  <p style="display:inline-block;"><span class="ui-icon ui-icon-alert" style="float: left;margin-right:5px;"></span>'+label+'</p></div></div>';
		$('#message_wrap_con').html(mess);
		
		if($('#message_wrap_con').html() != ''){
			if (reload)
				setTimeout('window.location.href = ' + common.getClassUrl(reload), 4000);
			else
				$("#message_con").fadeOut(5000);
				$("html, body").animate({ scrollTop: 0 }, 500)
		}
	},
	
	ulearning_assign:function(id){
		if(id != ""){
			$.ajax({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'checkStudentSchedule',user_idx:id},
				type : "GET",
				success : function(data){
					if(data == 1)
						window.open(common.getBaseUrl()+"/admin/ulearning/?action=test_assign&inner=popup&user_id="+id,"mywindow","width=1000,height=700,resizable=no,scrollbars=yes");
					else if(data == 0)
						Menu.message("warning","Student has no schedule of class yet");
					else if(data == -1)
						Menu.message("warning","User is not a student");
				}
			});
		}else
			window.open(common.getBaseUrl()+"/admin/ulearning/?action=test_assign&inner=popup&user_id="+id,"mywindow","width=1000,height=700,resizable=no,scrollbars=yes");
	},
	ulearning_preview_slide:function(id){
		window.open(common.getBaseUrl()+"/admin/ulearning/?action=preview_slide&slide_id="+id,"mywindow","width=1000,height=700,resizable=no,scrollbars=no");
	},
	ulearning_menu_hide:function(){
		$('.side_menu').find('.cat_mngt').hide();
		$('.side_menu').find('.movie_cat').hide();
	},
	class_schedule:function(id){
		window.open(common.getBaseUrl() + '/admin/class/?action=classScheduleManage&inner=popup&uid='+id, 'classSchedWindow','width=1000,height=700,resizable=no,scrollbars=yes');
	},
	
	adviseMessage : function(targetElement){
		/** Element append **/
		var self_ajax_path = common.getBaseUrl() + '/admin/message/';		
		function _setContainer()
		{			
			var options = {
				url : self_ajax_path,
				dataType :'html',
				type : 'get',
				data : {
					action : 'advise_mngt',
					sub : 'ajax_teacher',
					req : 'setContainer'
				},success : function(server_response){
					var css_src = '<link rel="stylesheet" type="text/css"  href="' + common.getBaseUrl() + '/css/message/advise_mngt.css"/>';		
					$("head").append(css_src);
					$('body').append(server_response)
				}
			}		
			$.ajax(options);		
		}
		
		function _getTeacherMessage()
		{
			var options = {
				url : self_ajax_path,
				dataType :'html',
				type : 'get',
				data : {
					action : 'advise_mngt',
					sub : 'ajax_teacher',
					req : 'getTeacherMessageList'
				},success : function(server_response){
					$('.ajax_advise_message_cont').html(server_response);
					$(".advise_list_dialog").dialog({
						title : "Student Message »",
						width:600
					});					
				}
			}		
			$.ajax(options);		
		}
		
		_setContainer();
		/** ====== Event Handler ======= **/		
		targetElement.click(function(){
			_getTeacherMessage();
		});

	}, advise_option : function(idx){
	
		window.open(common.getBaseUrl()+"/admin/message/?action=advise_mngt&sub=message&m=" + idx,"mywindow","width=1000,height=700,resizable=no,scrollbars=yes");
	
	},adviseMessage : function(targetElement){
	
		/** Element append auto to body when loaded. **/
		var self_ajax_path = common.getBaseUrl() + '/admin/message/';		
		var global_sort = "";
		var global_field = "";
		var global_page = 1;
		var global_view_type = 0;
		var global_idx = null;
		
		function _setContainer()
		{			
			var options = {
				url : self_ajax_path,
				dataType :'html',
				type : 'get',
				data : {
					action : 'advise_mngt',
					sub : 'ajax_teacher',
					req : 'setContainer'
				},success : function(server_response){
					var css_src = '<link rel="stylesheet" type="text/css"  href="' + common.getBaseUrl() + '/css/message/styles.css"/>';		
					var css_src = '<link rel="stylesheet" type="text/css"  href="' + common.getBaseUrl() + '/css/message/advise_mngt.css"/>';		
					$("head").append(css_src);
					$('body').append(server_response);
				}
			}		
			$.ajax(options);		
		}
		
		function _getTeacherMessage(page,status,field,sort)
		{
			var status = ( status=='' ) ? 0 : 1;
			var field_type = (field=='') ? 'date_sent' : field;
			var sort_order = (sort=='') ? "desc" : sort;
			var total_contents = $("#total_contents").val();
			var as = (field_type=='user_id') ? 'tbu' : 'tba';
			$('.reply_dialog').dialog('close');
			$('.viewreply_dialog').dialog('close');
			$('.message_dialog').dialog('close');
			var options = {
				url : self_ajax_path,
				dataType :'html',
				type : 'get',
				data : {
					action : 'advise_mngt',
					sub : 'ajax_teacher',
					req : 'getTeacherMessageList',
					field : field_type,
					as : as,
					sort : sort_order,
					page : page,
					status : status
				},success : function(server_response){				
					$('.ajax_advise_message_cont').html(server_response);
					var n = $('.adv_list_count1').val();
					
					if( n > 0 )
					{					
						var paging = pagination(page,n,10,2);	
						$(".page_area").html(paging);
					}
					
					$(".page_area").html(paging);
					$(".advise_list_dialog").dialog({
						title : "Student Message »",
						width:790
					});
				}
			}		
			
			$.ajax(options);		
		}
		
		function _getReply()
		{
			var options = {
				url : self_ajax_path,
				dataType :'json',
				type : 'get',
				data : {
					action : 'advise_mngt',
					sub : 'ajax_teacher',
					req : 'getReplyMessage',
					parent : global_idx
					
				},success : function(server_response){				
					if(server_response)
					{
						$("#v_title").html(server_response.title)
						$("#v_date").html(server_response.date_sent)
						$("#v_message").html(server_response.message);
						$(".viewreply_dialog").dialog({
							title : "Reply Message &raquo;",
							width:500
						});
						return true;
					}
							
					$('.reply_dialog').dialog({
						title : "Reply »",
						width:500,
						open : function(){
							tinyMCE.execCommand('mceAddControl', true, 'reply_message');
							$(".send_btn").show();
							$('#reply_title').val('');
							// tinyMCE.get('reply_message').setContent('');
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
					url : self_ajax_path,
					type : 'post',
					dataType : 'html',
					data : {
						action : 'advise_mngt',
						sub : 'ajax_teacher',
						parent : global_idx,
						req : 'sendreply',
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
		
		function pagination(iPage,iTotalItem,iItemsPerPage)
		{
			var iInterval = 2;
			var iOptionlength = Math.ceil(iTotalItem / iItemsPerPage);  
			var sNavigation = '<div class="bottom_2">';
			sNavigation += '<div class="pagination">';
			sNavigation += '<ul>';
			
			if (iOptionlength == 0) iOptionlength = 1;
			
			if (iPage > iOptionlength){
				iPage = iOptionlength;
			}
			if(iPage == 1){
				sNavigation += '<li class="first"><span>prev</span></li>';
			}else{
				sNavigation += '<li class="first"><a href="javascript:void(0);" class="pager" alt="' + ( iPage-1) + '">prev</a></li>';
			}
			for (iLink = 1; iLink <= iOptionlength; iLink++){
				if (iLink == 2 && iPage >= (iInterval + 3)){
					sNavigation += '<li><a href="javascript:void(0);" class="pager num">1</a></li><li>&hellip;</li>';
				}
				else if(iLink == 1 && iPage == (iInterval + 2)){
					sNavigation += '<li><a href="javascript:void(0);" class="pager num"  alt="' + iLink + '">1</a></li>';
				}
				if (iLink == iPage){
					sNavigation += '<li><a class="current">' + iPage + '</a></li>';
				}
				else if (iLink >= (iPage - iInterval)){
					if (iLink == 1){
						sNavigation += '<li><a href="javascript:void(0);"  class="pager num" alt="' + iLink + '">' + iLink + '</a></li>';
					}
					else {
						sNavigation += '<li><a href="javascript:void(0);"   class="pager num"  alt="' + iLink + '">' + iLink + '</a></li>';
					}	
				}
				if (iLink >= (iPage + iInterval) && (iOptionlength - (iInterval + 2)) >= iPage){
					sNavigation += '<li>&hellip;</li><li><a href="javascript:void(0)"  class="pager num"  alt="' + iOptionlength + '">' + iOptionlength + '</a></li>';
					break;
				}	
			}
			
			if(iPage == iOptionlength){
				sNavigation += '<li class="first"><span>next</span></li>';
			}else{
				sNavigation += '<li class="first"><a href="javascript:void(0);" class="pager" alt="' + ( iPage + 1 ) + '">next</a></li>';
			}
			sNavigation += '</div></div>';
			return sNavigation;
		}		
		
		_setContainer();
		
		/** Initialize dialog for list**/
		targetElement.click(function(){
			global_page = 1;
			_getTeacherMessage(global_page,'','');
		});
		
		/** Pager functions**/
		$('.pager').live('click',function(){
			global_page = parseInt($.trim($(this).attr('alt')));
			_getTeacherMessage(global_page,global_view_type,global_field,global_sort);
		});
		
		/** Sort Button**/
		$(".adv_sort").live('click',function(){			
			var clicked_element = $(this).attr('alt');
			var change_element = $(this);

			$('.adv_sort').each(function(){

				if($(this).attr('alt') == clicked_element)
				{
					var sort = $(this).children().attr('class').split(/\s+/)[0];
					var sort_order = sort.replace('adv_sort_',"");
					var field_order = clicked_element.replace('adv_',"");
					var sort_order = (sort_order=='down') ? 'asc' : 'desc';
					global_field = field_order;
					global_sort = sort_order;
					
					_getTeacherMessage(global_page,global_view_type,field_order,sort_order);
					if(sort=='adv_sort_up')
					{
						change_element.children().removeClass('adv_sort_up sort_icon');
						change_element.children().addClass('adv_sort_down sort_icon');	
					}
					else
					{
						change_element.children().removeClass('adv_sort_down sort_icon');
						change_element.children().addClass('adv_sort_up sort_icon');
					}					
				}
				else
				{
					$(this).children().removeClass('adv_sort_down sort_icon');
					$(this).children().addClass('adv_sort_up sort_icon');
				}
			});
		});
		
		$('.adv_view_id').live('click',function(){
			$(this).attr('style','font-weight:normal;');
			var id = $(this).attr('alt');
			global_idx = id;
			var options  = {
				url : self_ajax_path,
				dataType : 'json',
				type : 'post',
				data : {
					action : 'advise_mngt',
					sub : 'ajax_teacher',
					req : 'getView',
					idx : id
				},success : function(server_response){
					$('.message_dialog').dialog({
						title : "Message &raquo;",
						width : 500,
						close : function(){

						},open : function(){
							
						}
					});
					$("#m_title").html(server_response.title);
					$("#m_message").html(server_response.message);
				}
			}
			
			$.ajax(options);
		});
		
		$('.adv_sent').live('click',function(){
			global_page = 1;
			global_view_type = 0;
			$('.adv_sort').children().removeClass('adv_sort_down sort_icon').addClass('adv_sort_up sort_icon');
			_getTeacherMessage(1,global_view_type,'','');
		});
		
		$('.adv_receive').live('click',function(){
			global_page = 1;
			global_view_type = 1;
			$('.adv_sort').children().removeClass('adv_sort_down sort_icon').addClass('adv_sort_up sort_icon');
			_getTeacherMessage(1,global_view_type,'','');
		});
		
		$('.show_reply_link').live('click',function(){
			$('#message_success').hide();
			$('#sending_message').hide();
			$('.reply_dialog').dialog('close');
			$('.viewreply_dialog').dialog('close');
			_getReply();
		});
		
		$('.send_btn').live('click',function(){
			_sendReply();
		});
		
		tinyMCE.init({
			mode : "none",
			theme : "advanced",
			theme_advanced_toolbar_align : "left",
			theme_advanced_toolbar_location : "top",
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "bullist,numlist,separator,outdent,indent,separator,undo,redo,separator",
			theme_advanced_buttons3 : ""
		});

	}
	
	
	// },
	
	// tinymce_init: function(aOptions){
		//console.log(aOptions);
		// /*give default if tinymce setting is not define*/
		//var aOptions = new Array();
		// if(typeof aOptions.settings != 'undefined'){
			//if(aOptions.settings == null || aOptions.settings == undefined){
				// var settings = {
					// mode: "none",
					// plugins:  "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
					// theme_advanced_toolbar_align: "left",
					// theme_advanced_toolbar_location:"top",
					// theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
					// theme_advanced_buttons2: ",search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
					// theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen"
				// }
			//}
		// }
		 // aOptions.settings = settings;

		// var sData = '';
		// sData += '<textarea  name="'+aOptions.name+'" id="'+aOptions.id+'" style="'+aOptions.style+'" ></textarea>';
	
		// /*write javascript*/
		
		// $(aOptions.container).html(sData);
		
			// if(aOptions.dialog == true){
				// tinyMCE.init(aOptions.settings);
			// }else{
			 // $("textarea#"+aOptions.id).tinymce(aOptions.settings);
			// }
	
	// }
	
};