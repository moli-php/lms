$(function(){ 
	//$('#redactor_content').redactor({ imageUpload: '?action=redactor' });
	
	
	/*on load func*/
	User.change_by_grade();
	
	/*table sorter*/
	$('.post_table').tablesorter({
		headers: { 0:{sorter:false},1:{sorter:false},3:{sorter:false},5:{sorter:false},6:{sorter:false},7:{sorter:false},9:{sorter:false} }
	});	
	
	/*triggers*/
	$("#grade").change(function(){
		User.change_by_grade();
	});
	$("#toggle_additional").click(function(){
		$("#area_additional").slideToggle();
	});
	$("#btn_save_all").click(function(){
		User.save_adduser();
	});

	$("#check_duplicate_id").click(function(){
		User.check_duplicate_id();
	});
	
	/*file upload*/
	$("#upload_btn").click(function(){
		$("#file_upload").trigger("click");
	});
	$("#file_upload").change(function(){
		var imagepath = $(this).val().replace("C:\\fakepath\\","");
	
		if($.browser.msie == true || $.browser.msie != undefined){
			$('#filepath').html(imagepath);
		}else{
			$('#filepath').html(imagepath);
			
			 if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#prof_img_con').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
		}
	});
	
	/*for add address*/
	$("#find_add_btn").click(function(){
		User.find_address();
	});
	$("#find_address_submit").click(function(){
		User.choose_address();
	});
	$("#choose_address_submit").click(function(){
		User.rest_address();
	});
	$("#rest_address_submit").click(function(){
		User.final_address();
	});
	$("#sc_address_list a").live("click", function(){
		$(".error_msg").html("");
		var sAddress = $(this).html();
		var aAddress = sAddress.split(" - ");
		sCity = aAddress[0];
		sArea = aAddress[1];
	});
	
	/*email*/
	$('.send_email').click(function(){
	  email = $(this).text();
	   var emailparam =new Array(email);
	   message.send_mail(emailparam);
	});
	
	/*send message*/
	$('.mobile_id').click(function () {
		var mobile_no = new Array($(this).text());
		message.send_sms(mobile_no);
	});

});

var User = {
	/*warning message*/
	warning: function(message){
		$('.warning').remove();
		$('body').append('<div class="warning" >'+message+'</div>');
		$(".warning").dialog({
			title:'<p class="popup_title">Warning &raquo;</p>',
			resizable:false,width:300,height:150,modal: true,
			buttons: {
				Close: function() {
					$( this ).dialog( "close" );
					return false;
				}
			}
		});
	
	},
	/*add grade viewer popup*/
	view_addgrade: function(){
	
		var user_type_count = parseInt($("#user_type_count").val());
		var user_type_limit = 9;
	
		if(user_type_count < user_type_limit){
		$('.popup_window').dialog('close');
			$('#add_grade_popup').dialog({resizable:false,width:230,height:190,title:'<p class="popup_title">Add Grade &raquo;</p>'});
		}else{
			Menu.message("warning","Grade type alredy complete");
		}
	},
	
	/*add grade viewer popup*/
	view_modgrade: function(idx){
		$.ajax({  
			url: document.URL,
			dataType: 'json',
			data: {
			action: 'grade_details',
			get_grade_id: idx
			},
			success: function(data){
				$("#mod_grade_idx").val(data.idx);
				$("#mod_grade_datereg").val(data.date_reg);
				$("input[name='mod_grade_name']").val(data.grade_name);
				
				if(data.fix_flag == 1){
					$(".mod_grade_num").hide();
					$(".mod_grade_num_con").remove();
					$(".mod_grade_num_wrap").append('<span class="mod_grade_num_con">'+data.grade_num+'<input type="hidden" name="mod_grade_num" readonly value="'+data.grade_num+'" /></span>');
				}else{
					$(".mod_grade_num").show();
					$(".db_grade_num,.mod_grade_num_con").remove();
					$(".mod_grade_num").prepend('<option class="db_grade_num" selected>'+data.grade_num+'</option>');
				}
			}
		});
		
		$('#mod_grade_popup').dialog({resizable:false,width:230,height:190,title:'<p class="popup_title">Modify Grade &raquo;</p>'});
	},
	
	/*save/ add grade*/
	submit_addgrade: function(formname){
		var bValidate = $("#"+formname).validateForm();
		
			if(bValidate === true){
				$("#"+formname).submit(function(){
					this.submit();
				});
			}
		
	},
	
	/*save data via submit*/
	save_adduser: function(){
		var bValidate = $("#userAddForm").validateForm();
		
		/*validate for spaces*/
		var userid = $('#username').val();
		if (userid.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+]/) != -1) {
			Menu.message("warning","Invalid character(spaces is restricted)");
			bValidate = false;
		}
		
		/*validate password*/
		var chk_password = User.checkStr($('#password').val());
		if (chk_password != "true") {
			Menu.message("warning","Password " + chk_password);
			bValidate = false;
		}
		
		if(bValidate === true){
			$("#userAddForm").submit(function(){
				this.submit();
			});
		}
		
	},
	
	checkStr: function(str) {
		if (str.length < 6) {
			return("too short (mininum of 6 char)");
		} else if (str.length > 15) {
			return("too long (maximum of 15 char)");
		} else if (str.search(/\d/) == -1) {
			return("has no number (at least 1 number is required)");
		} else if (str.search(/[a-zA-Z]/) == -1) {
			return("has no letter (at least 1 letter is required)");
		} else if (str.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+]/) != -1) {
			return("invalid character (spaces is restricted)");
		}
		return ("true");
	},
	
	/*username ajax checker*/
	check_duplicate_id: function(){
		var username = $.trim($("#username").val());
		if(username.length >= 6){
			$.ajax({  
				url: document.URL,
				dataType: 'json',
				data: {
				action: 'check_duplicate_id',
				get_user_id: username,
				get_user_idx: ($("#user_idx").val()) ? $("#user_idx").val() : ""
				},
				success: function(data){
					$('.message_dialog').html(data);
					$(".message_dialog").dialog({modal:true});
				}
			});
		}else{
			Menu.message("warning","Please enter valid user id");
		}
	},
	/*prepare to delete*/
	prep_delete: function(from){
		
		$("#dialog-confirm").dialog({
			title:'<p class="popup_title">Warning &raquo;</p>',
			resizable:false,width:350,height:180,modal: true,
			buttons: {
				"Ok": function() {
					$( this ).dialog( "close" );
					User.delete_list(from);
				},
				Cancel: function() {
					$( this ).dialog( "close" );
					return false;
				}
			}
		});
	},
	/*delete rows in list*/
	delete_list: function(from){
	
			var strid = '';
			$.each($("input:[name='checkbox[]']:checked"), function(){
				var idx =$(this).val();
				 strid += ","+idx;	
			});
			
			if(strid.length == 0){
				Menu.message("warning","Please choose row(s) to delete");
				 $("html, body").animate({ scrollTop: 0 }, "fast");
				return;
			}
			
			$.ajax({  
				url: document.URL,
				dataType: 'json',
				data: {
				action: 'delete_list',
				get_idx: strid.substr(1),
				get_from: from
				},
				success: function(data){
					if(data > 0){
						Menu.message("success","Deleted successfully");
						 setTimeout('location.reload()', 2000);
					}else{
						Menu.message("warning","Error Deleting");
						$("html, body").animate({ scrollTop: 0 }, "fast");
					}
				}
			});
		
	},
	
	/*dropdown options displayer*/
	change_by_grade: function(){
		var grade = $("#grade").val();
		var user = $("#sess_grade_idx").val();
		var user_idx = $("#sess_idx").val();
		
		var add_query = (user_idx == 1)? '' : 'AND branch_idx = '+user_idx;
		var sData = '';
		$(".branch_type, .teacher_type, .head_teacher").remove();
		
		if(grade != "8"){
			switch(grade){	
			case "6":
				if(user == "9"){
					sData += '<tr class="branch_type" ><th><label >Branch</label><span class="neccesary">*</span></th><td>';
					sData += '<select id="branch" name="branch" class="branches">';
					sData += '</select>';
					sData += '</td></tr>';
				}
				
				sData += '<tr class="teacher_type" ><th><label >Teacher type</label><span class="neccesary">*</span></th><td>';
				sData += '<select id="teacher_type" name="teacher_type">';
				sData += '</select></td></tr>';
				
				sData += '<tr class="head_teacher" ><th><label >Head Teacher</label><span class="neccesary">*</span></th><td>';
				sData += '<select id="head_teacher" name="head_teacher">';
				//sData += '<option value="none">-select-</option>';
				sData += '</select></td></tr>';
				break;
			
			default:
				if(user == "9"){
					sData += '<tr class="branch_type" ><th><label >Branch</label><span class="neccesary">*</span></th><td>';
					sData += '<select id="branch" name="branch" class="branches">';
					sData += '</select>';
					sData += '</td></tr>';
				}
				break;
			}
			
			/*get branch by ajax*/
			$.ajax({  
				url: document.URL,
				dataType: 'json',
				data: {
					action: 'get_dbdata_rows',
					get_tb: 'tb_user',
					get_field: '',
					get_where: ' grade_idx = 8'
				},
				success: function(data){
					var sData = '';
					sData += '<option value="0">-select-</option>';
						$.each(data, function(key, val){ 
							selected = (val.idx == $("#branch_idx").val())?  'selected' : '';
						  sData += '<option '+selected+' value="'+val.idx+'">'+val.user_id+'</option>';
						});
					
					$(".branches").html(sData);
				}
			});	
			
			/*get teacher type by ajax*/
			$.ajax({ 			
				url: document.URL,
				dataType: 'json',
				data: {
					action: 'get_dbdata_rows',
					get_tb: 'tb_teacher_management',
					get_field: '',
					get_where: add_query.replace('AND', '')
				},
				success: function(data){
					var sData = '';
					sData += '<option value="0">-select-</option>';

						$.each(data, function(key, val){ 
						  sData += '<option value="'+val.idx+'">'+val.grade_name+'</option>';
						});

					$("#teacher_type").html(sData);
				}
			});	
			
			/*get branch by ajax*/
			$.ajax({  
				url: document.URL,
				dataType: 'json',
				data: {
					action: 'get_dbdata_rows',
					get_tb: 'tb_user',
					get_field: '',
					get_where: ' grade_idx = 7 '+add_query
				},
				success: function(data){
					var sData = '';
					sData += '<option value="0">-select-</option>';
						$.each(data, function(key, val){ 
							//selected = (val.idx == $("#branch_idx").val())?  'selected' : '';
						  sData += '<option  value="'+val.idx+'">'+val.user_id+'</option>';
						});
					
					$("#head_teacher").html(sData);
				}
			});	
			
			
			
			
		}
		$(".table_user").append(sData);
	},
	
	/*add address popup*/
	view_adduser: function(){
		window.location.href = '?action=user_list&sub=add_user';
	},
	find_address : function(){
		$("#find_address").dialog({
		title:'<p class="popup_title">Find Address &raquo;</p>',
		resizable:false,width:230,height:190,modal: true
		});
	},
	choose_address : function(){
		
		if($("#find_address_input").val() == ""){
			$("#find_address_input").css("border", "1px solid #FF0000");
		}else{
			var sKeyword = $("#find_address_input").val();
			var sHtml = "";
			$("#find_address_input").css("border", "1px solid #CCCCCC");
			$.ajax({
				url: document.URL,
				dataType: 'json',
				data: {
				action: 'find_address',
				keyword: sKeyword
				},
				success : function(info){
					if(info == ""){
						$(".error_msg").html("No results found.");
						$("#find_address_input").val("");
					}else{
						$(".error_msg").html("");
						$.each(info, function(key, val){
							sHtml += "<a id = '" + val.idx + "' style = 'width:190px' onclick='User.highlight(this)'  >" + val.fcity + " - " + val.farea + "</a>";
						});
						
						$("#sc_address_list").empty().append(sHtml);
						$("#find_address").dialog("close");
						$("#choose_address").dialog({
							title:'<p class="popup_title">Choose Your Address &raquo;</p>',
							resizable:false,width:280,height:200,modal: true
						});
					}
				}
			});
		}
	},
	rest_address : function(){
		if(sCity == "" && sArea == ""){
			$(".error_msg").html("Please choose an address.");
		}else{
			$("#choose_address").dialog("close");
			$("#rest_address").dialog({
				title:'<p class="popup_title">Input Rest of your Address &raquo;</p>',
				resizable:false,width:320,height:160,modal: true
			});
		}
	},
	final_address : function(){
		if($("#rest_address_input").val() == ""){
			$("#rest_address_input").css("border", "1px solid #FF0000");
		}else{
			$("#rest_address_input").css("border", "1px solid #CCCCCC");
			$("[name=faddress]").val($("#rest_address_input").val() + " " + sArea + ", " + sCity);
			$("#rest_address").dialog("close");
		}
	},
	highlight: function(selector){
		$('.dropdown_list a').css('background','#ffffff');
		$(selector).css('background','#3399FF');
	}
	
}