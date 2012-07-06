
var currentUrl = location.href;
var url = currentUrl.split('=');

var array ="";
var row_selected = $('#rowselected').val();
var keyword = $('#keywordparam').val();

var rowparam = row_selected!='20' ? '&row='+row_selected : '';
var keywordparam = keyword != '' ? '&keyword='+keyword : '';

if($('#uploadstat').val()!=null){

	var delLog = {
			url : url[0]+'=email_mngt&sub=update',
			type : 'post',
			dataType : 'json',
			data : {
				name : $('#uploadstat').val(),
				req : 'delfile'
			},success : function(data){
			}
		}
	$.ajax(delLog);

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
                    delpop +='<p>Are you sure you want to delete '+array.length+' Email log(s) ?</p></br>';
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
                        url : url[0]+'=email_mngt&sub=update',
                        type : 'post',
                        dataType : 'json',
                        data : {
                            idx : array,
                            req : 'del'
                        },success : function(data){
                            $('#delpopup').dialog("close"); 
                            window.location = url[0]+'=email_mngt&row='+row_selected+'&success='+data; 
                        }
                    }
                $.ajax(delLog);
          });
        }

    });

    $('#searchbtn').click(function () {
		window.location = url[0]+'=email_mngt'+rowparam+'&keyword='+$('#keyword').val();
    });
    $('#show_row').change(function () {
        var row = $(this).val();
        window.location = url[0]+'=email_mngt&row='+row+keywordparam;
    })
	var orderby = $('#orderset').val()!='desc' ? 'desc':'asc';
	$('#title').click(function () {
		window.location = url[0]+'=email_mngt'+rowparam+keywordparam+'&field=title&order='+orderby;
    });
	$('#sent').click(function () {
		window.location = url[0]+'=email_mngt'+rowparam+keywordparam+'&field=sent&order='+orderby;
    });
	$('#reg').click(function () {
		window.location = url[0]+'=email_mngt'+rowparam+keywordparam+'&field=reg&order='+orderby;
    });
	
	if($('#orderset').val()=='asc'){
	$('#'+$('#fieldset').val()).attr('class','sort_down');
	}else{
	$('#'+$('#fieldset').val()).attr('class','sort_up');
	}

    /*Send EMAIL*/
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
			$('#emptylist').remove();
			$('#search_fields').prepend('<li class="lib" style="cursor:pointer">'+$('#addemailfield').val()+' '+'</li>');
			$('#addemailfield').val('');			
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
						window.location = url[0]+'=email_mngt&pageaction=send_email&query=all';
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
									window.location = url[0]+'=email_mngt&pageaction=send_email&query=option'+age+apply+_class;
								}
							}
					}else{
						Menu.message('warning',"Please make a selection from the list");
					}
		});
		
		$('#compose').live('click',function () {
		
			if($('.lib').text()==''){
				Menu.message('warning',"Search Field is Empty!");
				$('#search_fields').attr("style","border:1px solid #ce1f1f");
			}else{

				var email_list = $('.lib').text();
				message.send_mail(email_list.split(' '),true);
		
			}

		});
		
		$('#testlink').click(function () {
		
			var mobile_no = new Array($(this).text());
			message.send_mail(mobile_no,false);

		});

    
/*show message*/
    
        
});


function displayMsg(idx){
		var getData = {
			url: common.getBaseUrl() + '/admin/message/?action=email_mngt&sub=update',
			dataType: 'json',
			data: {
				id: idx,
				req: 'getData'
			},
			success: function (data) {
			
			var emails = data[0].emails.split(',');
			if (emails[1] == null) {
				var email_add = emails[0];
			} else {
				if (emails.length == 1) {
					var email_add = emails[0];
				} else if (emails.length == 2) {
					var email_add = emails[0] + ', and ' + emails[1];
				} else if (emails.length == 3) {
					var email_add = emails[0] + ', ' + emails[1] + ', and ' + emails[2];
				} else {
					var email_add = emails[0] + ', ' + emails[1] + ', and <a href="#none" id="view_emailaddrs" style="text-decoration:underline;font-style:italic;color:#FF9900;">' + (emails.length - 2) + ' other members</a>';
				}
			}
			
			var email_msg ='';
				email_msg +='<div class="show_message_container">';
				email_msg +='<div id="1m_message">';
				email_msg +='	<b class="message_label">Title : <span id="m_title">'+data[0].mail_title+'</span></b>';
				email_msg +='	<b class="message_label">To : <span id="m_from">'+email_add+'</span></b>';
				email_msg +='	<b class="message_label">Date : <span>'+data[0].reg_date+'</span></b>';
				email_msg +='	<p class="message_main" id="m_message">'+data[0].message+'</p>';
				email_msg +='</div>';
				email_msg +='</div>';
				email_msg +='<div class="action_btn">';
				email_msg +='	<a href="javascript:cancel()" class="btn_save" title="Close" style="float:right">Close</a>';
				email_msg +='</div>	';
				
				$('#email_msg').empty();
				$('#email_msg').append(email_msg);
			
				$('#email_msg').dialog({
					width: 'auto',
					height: 'auto',
					modal:true,
					title: 'Message',
					resizable: true
				});
				
				    $('#view_emailaddrs').click(function () {
					
					
					
					var view_emailad = '';
						view_emailad+='	<div class="show_message_container">';
						view_emailad+='		<div id="1m_message">';
						view_emailad+='			<ul class="view_email">';
						view_emailad+='				<li class="search_result">';
						view_emailad+='					<ul>';
						for (var i in emails) {
							view_emailad += '<li>' + emails[i] + '</li>';
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
							resizable: false
						});
					});
			
			}
		}
		$.ajax(getData);

}

function CreateEmail(){
    window.location = url[0]+"=email_mngt&pageaction=send_email";
}


function backtolist(){
    window.location = url[0]+"=email_mngt";
}
function cancel(){

    $('#editor').dialog("close");
    $('#delpopup').dialog("close");
    $('#emailReady').dialog("close");
	$('#email_msg').dialog("close");
}

