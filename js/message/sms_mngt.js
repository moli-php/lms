var currentUrl = location.href;
var url = currentUrl.split('=');

var array ="";
var row_selected = $('#rowselected').val();
var keyword = $('#keywordparam').val();

var rowparam = row_selected!='20' ? '&row='+row_selected : '';
var keywordparam = keyword != '' ? '&keyword='+keyword : '';

if($('#uploadstat').val()!=null){

	var delfile = {
			url : url[0]+'=sms_mngt&sub=update',
			type : 'post',
			dataType : 'json',
			data : {
				name : $('#uploadstat').val(),
				req : 'delfile'
			},success : function(data){
			}
		}
	$.ajax(delfile);

}

$(document).ready(function () {

    $("#all_members").change(function(){
        $(".other_options").toggle();
    }); 


    if($('#successparam').val()=="delete"){
        Menu.message('success',"Record(s) was successfully deleted");
    }else if($('#successparam').val()=="error"){
        Menu.message('warning',"Delete Error");
    }else if($('#successparam').val()=="sent"){
        Menu.message('success',"Email Sent");
    }else if($('#successparam').val()=="save"){
        Menu.message('success',"Template Saved");
    }
	
	
    $('#deltop,#delbottom').click(function () {
        
        array = new Array();
        for (var i = 1; i <= $('#chkboxcount').val(); i++) {
            if ($('.chkboxlist' + i + ':checked').val()) {
              array.push($('.chkboxlist' + i + ':checked').val());
            }
        }
        
        if(array.length==0){
            Menu.message('warning',"Please make a selection from the list");
        }else{
            
            $('#delpopup span').remove();
                var delpop = '';
                    delpop +='<span>';
                    delpop +='<p>Are you sure you want to delete '+array.length+' Sms log(s) ?</p></br>';
                    delpop +='<div class="action_btn fr">';
                    delpop +='<a href="#" class="btn_save" id="delbtn" title="Save changes" style="margin:3px">Submit</a>';
                    delpop +='<a href="javascript:cancel();"  class="btn_save"  title="Return to Users" style="margin:3px">Cancel</a>';
                    delpop +='</div>';
                    delpop +='</span>';
            $('#delpopup').append(delpop);
                
                
            $('#delpopup').dialog({
            width:348.467,
            height: 182.467,
			resizable: false
            });
            
          $('#delbtn').click(function () {
                var delLog = {
                        url : url[0]+'=sms_mngt&sub=update',
                        type : 'post',
                        dataType : 'json',
                        data : {
                            idx : array,
                            req : 'del'
                        },success : function(data){
                            $('#delpopup').dialog("close"); 
                            window.location = url[0]+'=sms_mngt&row='+row_selected+'&success='+data; 
                        }
                    }
                $.ajax(delLog);
          });
        }

    });

    $('#searchbtn').click(function () {
		window.location = url[0]+'=sms_mngt'+rowparam+'&keyword='+$('#keyword').val();
    });
    $('#show_row').change(function () {
        var row = $(this).val();
        window.location = url[0]+'=sms_mngt&row='+row+keywordparam;
    })
	var orderby = $('#orderset').val()!='desc' ? 'desc':'asc';
	$('#title').click(function () {
		window.location = url[0]+'=sms_mngt'+rowparam+keywordparam+'&field=title&order='+orderby;
    });
	$('#sent').click(function () {
		window.location = url[0]+'=sms_mngt'+rowparam+keywordparam+'&field=sent&order='+orderby;
    });
	$('#reg').click(function () {
		window.location = url[0]+'=sms_mngt'+rowparam+keywordparam+'&field=reg&order='+orderby;
    });
	
	if($('#orderset').val()=='asc'){
	$('#'+$('#fieldset').val()).attr('class','sort_down');
	}else{
	$('#'+$('#fieldset').val()).attr('class','sort_up');
	}

    /*Send SMS*/
	$('#all_members').click(function(){
		if($('#all_members:checked').val()){
			$('#agefrom').val('0');
			$('#ageto').val('0');
		}else{
			$('#agefrom').val('');
			$('#ageto').val('');	
		}
	});

	$('#csvbtn').click(function(){
	
		var result = $('form#addcsv').validateForm();
		if(result==true){
		
			var addcsv = {
					url : url[0]+'=email_mngt&sub=update',
					type : 'post',
					dataType : 'json',
					data : {
						req : 'addcsv'
					},success : function(data){
						alert(data);					
						}
				}
			$.ajax(addcsv);

		}

	});

	$('#addemail').click(function(){
	
		var result = $('form#addemailadd').validateForm();
		if(result==true){
		
			if($('#addemailfield').val().match(/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/)) {
				$('#emptylist').remove();
				$('#search_fields').prepend('<li class="lib" style="cursor:pointer">'+$('#addemailfield').val()+' '+'</li>');
				$('#addemailfield').val('');
			}else{
				Menu.message('warning',"Invalid Phone No!");
			}
		
			
		}

	});
	

		
	$('.lib').live('click', function(){
		$(this).toggleClass("selected","");				
	});
	
	$('#rmvlist').click(function(){
	
		if ($('.lib').hasClass('lib selected')==true){		
			$('[class="lib selected"]').remove();
		}else{
			Menu.message('warning',"Please make a selection from the list");
		}
	
	});
	

	if($('#query').val()=='all'){
		$('#all_members').attr('checked',true);
		$('.other_options').hide();
	}else if ($('#query').val()=='option'){
		$('#age').val()=='true' ? $('#message_age').attr('checked',true) : $('#message_age').attr('checked',false) ;
		$('#apply').val()=='true' ? $('#message_applied').attr('checked',true) : $('#message_applied').attr('checked',false) ;
		$('#opclass').val()=='true' ? $('#message_class').attr('checked',true) : $('#message_class').attr('checked',false) ;
	}
	
	if ($('#query').val()!='' && $('.lib').text()==''){
		$('#search_fields').prepend('<li id="emptylist"><font color="#ce1f1f"><center>Record(s) not found</center></font></li>');
	}

		$('#searchmailbtn').click(function () {
				var result = $('form#send').validateForm();
					if($('#all_members').is(':checked')){
						window.location = url[0]+'=sms_mngt&pageaction=send_sms&query=all';
					}else if($('#message_age').is(':checked')||$('#message_applied').is(':checked')||$('#message_class').is(':checked')){

							if($('#message_age').is(':checked') && ($('#agefrom').val()=='' ||  $('#ageto').val()=='')){
									Menu.message('warning',"Please make a selection from the list");
							}else if ($('#message_age').is(':checked') && result==false){
									Menu.message('warning',"Invalid Age");
							}else{
								if($('#agefrom').val()>$('#ageto').val()){
									Menu.message('warning',"Incorrect range of Age!");
								}else{
									$('#agefrom').attr('class','small');
									$('#ageto').attr('class','small');
									var age = $('#message_age').is(':checked') ? '&age='+$('#agefrom').val()+'|'+$('#ageto').val() :'';
									var apply = $('#message_applied').is(':checked') ? '&apply=1' :'';
									var _class = $('#message_class').is(':checked') ? '&class=2' :'';
									window.location = url[0]+'=sms_mngt&pageaction=send_sms&query=option'+age+apply+_class;
								}
							}

					}else{
						Menu.message('warning',"Please make a selection from the list");
					}
		});
		
		$('#addtpl').click(function () {
			$('#addedit_container').empty();
				$('#addedit_container').html('<a href="#" class="btn" id="save_tpl" title="Save">Save</a>');
			$('.new_tpl_dialog').dialog({
				width: 237.467,
				height: 331.467,
				resizable: false,
				title : 'Add New Template'
            });
		});
		
		$('#new_tpl').keyup(function() {
				var valLength = $(this).val().length;
				if(valLength<71){
					$('#new_template_size').html('<span class="">'+valLength+'</span>/80 bytes');
				}else{
					if(valLength<=80){
						$('#new_template_size').html('<span class="overlimit">'+valLength+'</span>/80 bytes');
					}else{
						$(this).attr('maxlength','80');
					}
				}
		});
		
		$('#save_tpl').live('click',function () {
			if($('#tpl_name').val()==""){
				$('#tpl_name').attr("style","border:1px solid #ce1f1f");
			}
			if($('#new_tpl').val()==""){
				$('#new_tpl').attr("style","border:1px solid #ce1f1f");
			}else{
				var saveTpl = {
						url : url[0]+'=sms_mngt&sub=update',
						type : 'post',
						dataType : 'json',
						data : {
							title : $('#tpl_name').val(),
							msg : $('#new_tpl').val().replace(/\n/g,"<br/>"),
							req : 'savetpl'
						},success : function(data){
							$('#addtpl').dialog("destroy"); 
							window.location = url[0]+'=sms_mngt&pageaction=send_sms&success='+data; 
						}
					}
				$.ajax(saveTpl);
			}
		});
		
		$('#deltpl').live('click',function () {
			if($('[class="radio"]:checked').val()){
				if ($('[id="radio_manual"]:checked').val()){
					Menu.message('warning',"Manual Template cannot be deleted");
				}else{
					$('#delpopup span').remove();
					var delname = $('[class="radio"]:checked').val().split('||')
						var delpop = '';
							delpop +='<span>';
							delpop +='<p>Are you sure you want to delete the "'+delname[1]+'" template ?</p></br>';
							delpop +='<div class="action_btn fr">';
							delpop +='<a href="#" class="btn_save" id="deltplbtn" title="yes" style="margin:3px">Submit</a>';
							delpop +='<a href="javascript:cancel();"  class="btn_save"  title=cancel" style="margin:3px">Cancel</a>';
							delpop +='</div>';
							delpop +='</span>';
					$('#delpopup').append(delpop);
						
						
					$('#delpopup').dialog({
					width:348.467,
					height: 182.467,
					resizable: false
					});

					 $('#deltplbtn').click(function () {
							var deltplLog = {
									url : url[0]+'=sms_mngt&sub=update',
									type : 'post',
									dataType : 'json',
									data : {
										idx : delname[0],
										req : 'deltplLog'
									},success : function(data){
										$('#delpopup').dialog("close"); 
										window.location = url[0]+'=sms_mngt&pageaction=send_sms&success='+data;
									}
								}
							$.ajax(deltplLog);
					  });
				}
			}else{
				Menu.message('warning',"Please make a selection from the list");
			}
		});
		
		$('#savetpl').live('click',function () {
			if($('[class="radio"]:checked').val()){
				if ($('[id="radio_manual"]:checked').val()){
					Menu.message('warning',"Manual Template cannot be modify");
				}else{
				var delnames = $('[class="radio"]:checked').val().split('||')
				var getdatatpl = {
						url : url[0]+'=sms_mngt&sub=update',
						type : 'post',
						dataType : 'json',
						data : {
							idx : delnames[0],
							req : 'getdatatpl'
						},success : function(data){
							$('#addedit_container').empty();
							$('#addedit_container').html('<a href="#" class="btn" id="save_edittpl" title="Save">Save</a>');
							$('#tpl_name').val(data[0].tpl_title);
							$('#new_tpl').val(data[0].tpl_message.replace(/<br\/>/g, '\n'));
							$('#tpl_size').empty();
							$('#tpl_size').html('<p class="template_size" id="new_template_size"><span class="">'+data[0].tpl_message.length+'</span>/80 bytes</p>');
								$('.new_tpl_dialog').dialog({
									width: 237.467,
									height: 331.467,
									resizable: false,
									title : 'Edit Template'
								});
						}
						
					}
				$.ajax(getdatatpl);
				
				}
			}else{
				Menu.message('warning',"Please make a selection from the list");
			}
		});
		
		$('#save_edittpl').live('click',function () {
			if($('#tpl_name').val()==""){
				$('#tpl_name').attr("style","border:1px solid #ce1f1f");
			}
			if($('#new_tpl').val()==""){
				$('#new_tpl').attr("style","border:1px solid #ce1f1f");
			}else{
			var delnames_ = $('[class="radio"]:checked').val().split('||')
				var saveTpl = {
						url : url[0]+'=sms_mngt&sub=update',
						type : 'post',
						dataType : 'json',
						data : {
							title : $('#tpl_name').val(),
							msg : $('#new_tpl').val().replace(/\n/g,"<br/>"),
							req : 'save_edittpl',
							idx : delnames_[0]
						},success : function(data){
							$('#addtpl').dialog("destroy"); 
							window.location = url[0]+'=sms_mngt&pageaction=send_sms&success='+data; 
						}
					}
				$.ajax(saveTpl);
			}
		});
		
		
		$('#tpl_name').keyup(function() {
			$('#tpl_name').attr("style","");
		});
		$('#new_tpl').keyup(function() {
			$('#new_tpl').attr("style","");
		});
		
		
		$('#blank').keyup(function() {
			$('#blank').attr("style","");
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

		
		$('#compose').live('click',function () {
		
			if($('.lib').text()==''){
				Menu.message('warning',"Search Field is Empty!");
				$('#search_fields').attr("style","border:1px solid #ce1f1f");
			}else{
				if($('#site_mobile').val()=="" || !$('#site_mobile').val().match(/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/)){
					$('#site_mobile').attr('class','fix error');
				}else{
					if ($('[name="sms"]:checked').val()){
						if(!$('#site_mobile').val().match(/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/)){
							$('#site_mobile').attr('class','fix error');
						}else if($('[id="radio_manual"]:checked').val() && $('#blank').val()==""){
							$('#blank').attr("style","border:1px solid #ce1f1f");
						}else{
						
							if($('[id="radio_manual"]:checked').val()){
								var msg_sms = $('#blank').val();
								var from_sms = $('#site_mobile').val();
								var mobile_list = $('.lib').text();
								sms.send_sms(mobile_list.split(' '),msg_sms,from_sms);
							}else{
								var id_msg = $('[name="sms"]:checked').val().split('||');
								$.ajax({
									url : url[0]+'=sms_mngt&sub=update',
									dataType: 'json',
									data: {
										idx : id_msg[0],
										req: 'getdatatpl'
									},
									success : function(data){
										var mobile_list = $('.lib').text();
										sms.send_sms(mobile_list.split(' '),data[0].tpl_message,$('#site_mobile').val());
									}
								});
								
							}

						}
					}else{
						Menu.message('warning',"Please make a selection from template list!");
					}
				}
			}

		});
		
		$('#site_mobile').keyup(function() {
			$('#site_mobile').attr('class','');
		});
		
		$('.mobile_id').click(function () {
		
			var mobile_no = new Array($(this).text());
			message.send_sms(mobile_no,false);

		});
		
});

/*show message*/

function displayMsg(idx){
		var getData = {
			url: common.getBaseUrl() + '/admin/message/?action=sms_mngt&sub=update',
			dataType: 'json',
			data: {
				id: idx,
				req: 'getData'
			},
			success: function (data) {
			
			var sms_to = data[0].sms_to.split(',');
			if (sms_to[1] == null) {
				var mobile_number = sms_to[0];
			} else {
				if (sms_to.length == 1) {
					var mobile_number = sms_to[0];
				} else if (sms_to.length == 2) {
					var mobile_number = sms_to[0] + ', and ' + sms_to[1];
				} else if (sms_to.length == 3) {
					var mobile_number = sms_to[0] + ', ' + sms_to[1] + ', and ' + sms_to[2];
				} else {
					var mobile_number = sms_to[0] + ', ' + sms_to[1] + ', and <a href="#" id="view_smsrs" style="text-decoration:underline;font-style:italic;color:#FF9900;">' + (sms_to.length - 2) + ' other Mobile No.</a>';
				}
			}
			
			var sms_msg ='';
				sms_msg +='<div class="show_message_container">';
				sms_msg +='<div id="1m_message">';
				sms_msg +='	<b class="message_label">To : <span id="m_from">'+mobile_number+'</span></b>';
				sms_msg +='	<b class="message_label">From : <span id="m_from">'+data[0].sms_from+'</span></b>';
				sms_msg +='	<p class="message_main" id="m_message"><p>';
				sms_msg +=' <li class="sms_template">';
				sms_msg +=' <ul class="templates_list">';
				sms_msg +='	<p class="template_head"></p>';
				sms_msg +='	<div class="template_bg" style="margin-left:40px"><p style="margin-left:20px">'+data[0].message+'</p></div>';
				var valLength = data[0].message.length;
				if(valLength<71){
					sms_msg +='<p align="center" class="template_size"><span class="">'+valLength+'</span>/80 bytes</p>';
				}else{
					sms_msg +='<p align="center" class="template_size"><span class="overlimit">'+valLength+'</span>/80 bytes</p>';
				}
				sms_msg +='</ul>';
				sms_msg +='</li>';
				sms_msg +='</p></div>';
				sms_msg +='</div>';
				sms_msg +='<div class="action_btn">';
				sms_msg +='	<a href="javascript:cancel()" class="btn_save" title="Close" style="float:right">Close</a>';
				sms_msg +='</div>	';
				
				$('#sms_msg').empty();
				$('#sms_msg').append(sms_msg);
			
				$('#sms_msg').dialog({
					width:288.467,
					height: 408.467,
					modal:true,
					resizable: false,
					title: 'Message'
				});
				
				    $('#view_smsrs').click(function () {
					
					
					
					var view_emailad = '';
						view_emailad+='	<div class="show_message_container">';
						view_emailad+='		<div id="1m_message">';
						view_emailad+='			<ul class="view_email">';
						view_emailad+='				<li class="search_result">';
						view_emailad+='					<ul>';
						for (var i in sms_to) {
							view_emailad += '<li>' + sms_to[i] + '</li>';
						}
						view_emailad+='					</ul>';
						view_emailad+='				</li>';
						view_emailad+='			</ul>';
						view_emailad+='		</div>';
						view_emailad+='</div>	';
						
						$('#view_sms').empty();
						$('#view_sms').append(view_emailad);
					
						$('#view_sms').dialog({
							width:274.467,
							height: 324.467,
							title: 'Recipients',
							resizable: false
						});
					});
			
			}
		}
		$.ajax(getData);

}

function CreateSms(){
    window.location = url[0]+"=sms_mngt&pageaction=send_sms";
}


function backtolist(){
    window.location = url[0]+"=sms_mngt";
}
function cancel(){

    $('#editor').dialog("close");
    $('#delpopup').dialog("close");
    $('#emailReady').dialog("close");
	$('#sms_msg').dialog("close");
}

