var currentUrl = location.href;
var url = currentUrl.split('=');

var array ="";
var row_selected = $('#rowselected').val();
var keyword = $('#keywordparam').val();

var rowparam = row_selected!='20' ? '&row='+row_selected : '';
var keywordparam = keyword != '' ? '&keyword='+keyword : '';


$(document).ready(function () {


    
    if($('#successparam').val()=="delete"){
        Menu.message('success',"Record(s) was successfully deleted");
    }else if($('#successparam').val()=="error"){
        Menu.message('warning',"Delete Error");
    }else if($('#successparam').val()=="save"){
        Menu.message('success',"Message save");
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
                    delpop +='<p>Are you sure you want to delete '+array.length+' Template(s) ?</p></br>';
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
                        url : url[0]+'=email_template&sub=update',
                        type : 'post',
                        dataType : 'json',
                        data : {
                            idx : array,
                            req : 'del'
                        },success : function(data){
                            $('#delpopup').dialog("close"); 
                            window.location = url[0]+'=email_template&row='+row_selected+'&success='+data; 
                        }
                    }
                $.ajax(delLog);
          });
        }

    });

    $('#searchbtn').click(function () {
		window.location = url[0]+'=email_template'+rowparam+'&keyword='+$('#keyword').val();
    });
    $('#show_row').change(function () {
        var row = $(this).val();
        window.location = url[0]+'=email_template&row='+row+keywordparam;
    })
	var orderby = $('#orderset').val()!='desc' ? 'desc':'asc';
	$('#title').click(function () {
		window.location = url[0]+'=email_template'+rowparam+keywordparam+'&field=title&order='+orderby;
    });
	$('#reg').click(function () {
		window.location = url[0]+'=email_template'+rowparam+keywordparam+'&field=reg&order='+orderby;
    });
	
	if($('#orderset').val()=='asc'){
	$('#'+$('#fieldset').val()).attr('class','sort_down');
	}else{
	$('#'+$('#fieldset').val()).attr('class','sort_up');
	}
  
});

function EmailTpl(flag,idx){

		var getData = {
			url: common.getBaseUrl() + '/admin/message/?action=email_template&sub=update',
			dataType: 'json',
			data: {
				id: idx,
				req: 'getData'
			},
			success: function (data) {
			
				if(flag=='modify'){
					var dialog_title = 'Edit Template';
					var request = 'editTpl';
					var _id = idx;
					var _title = data[0].tpl_title;
					var _msg = data[0].message;
				}else{
					var dialog_title = 'Create New Template';
					var request = 'createTpl';
					var _id = '';
					var _title = '';
					var _msg = '';
				}
			

				var dialog_email = '';
				dialog_email += '<div class="popup_window message_content" id="editor" style="padding:20px;display:none">';
				dialog_email += '<p style="float:left"><label>Title:</label><input type="text" id="email_title" value="'+_title+'" /></p>';
				dialog_email += '	<div class="text_editor">';
				dialog_email += '		<textarea class="my_textarea" id="my_textarea">'+_msg+'</textarea>';
				dialog_email += '	</div>';
				dialog_email += '	<div class="action_btn">';
				dialog_email += '		<a href="#" class="btn_save" id="save" title="Save changes" style="float: left;">Save</a>';
				dialog_email += '		<a href="javascript:cancel();" class="btn_return fr"  title="Return to Users">Cancel</a>';
				dialog_email += '	</div>';
				dialog_email += '</div>';
				$('body').append(dialog_email);
				tinyMCE.init({
					mode: "none",
					theme: "advanced",
					theme_advanced_toolbar_align: "left",
					theme_advanced_toolbar_location: "top",
					theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
					theme_advanced_buttons2: "bullist,numlist,separator,outdent,indent,separator,undo,redo,separator",
					theme_advanced_buttons3: ""
				});
				


				
				$('#editor').dialog({
					width: 706.467,
					height: 380.467,
					resizable: false,
					title: dialog_title,
					modal: true,
					open: function () {
						tinyMCE.execCommand('mceAddControl', true, 'my_textarea');
					},
					close: function () {
						if (tinyMCE.getInstanceById('my_textarea')) {
							tinyMCE.execCommand('mceFocus', false, 'my_textarea');
							tinyMCE.execCommand('mceRemoveControl', false, 'my_textarea');
						}
						$('#editor').remove();
						$('#tiny').empty();
					}
				});
				
				$('#save').live('click',function () {

				if($('#email_title').val()==""){
					$('#email_title').attr('class','fix error');
				}else if(tinyMCE.get('my_textarea').getContent()==''){
					$('.mceIframeContainer').attr('style','border: 1px solid #ce1f1f;');	
				}else{
					tinyMCE.triggerSave();
					var emailtitle = $('#email_title').val();
					var emailmsg = $('#my_textarea').val();
					
						var save_log = {
							url: common.getBaseUrl() + '/admin/message/?action=email_template&sub=update',
							type: 'post',
							dataType: 'json',
							data: {
								idedit: _id,
								title: emailtitle,
								message: emailmsg,
								req: request
							},
							success: function (data) {
								window.location = common.getBaseUrl()+'/admin/message/?action=email_template&success=save'; 
								// alert(emailmsg);
							}
						}
						$.ajax(save_log);
				}
				
					$('#email_title').keyup(function() {
						$('#email_title').attr('class','');
					});
				
				});
				
			}
		}
		$.ajax(getData);


}

function cancel(){

	if (tinyMCE.getInstanceById('my_textarea')) {
		tinyMCE.execCommand('mceFocus', false, 'my_textarea');
		tinyMCE.execCommand('mceRemoveControl', false, 'my_textarea');
	}
	$('#editor').remove();
	$('#tiny').empty();
	$('#delpopup').dialog("close");

}


