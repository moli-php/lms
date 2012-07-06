$(document).ready(function(){

	$('#banner_table_list').tablesorter({
		headers: { 0:{sorter:false},1:{sorter:false},3:{sorter:false},6:{sorter:false} }
	});	
	
	$('#popup_table_list').tablesorter({
		headers: { 0:{sorter:false},1:{sorter:false},5:{sorter:false} }
	});	
	
	// init show preview if code editor selected
	var editor_selected =  $('[name=addPopupeditor]:checked').val();
	if(editor_selected != undefined){
		if(editor_selected === "code_edit")
		$('#btn_preview').click();
	}
	
	tinyMCE.init({
		mode : "specific_textareas",
		editor_selector : "html_editor",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : ",search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,|,forecolor,backcolor,|,preview,",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false
	});
	
	//title on banner or popup if add or modify
	if($('.menu_title_breadcrumb').text() == "Add popup"){
		if($('#popup_title').val().length > 0){
		$('.menu_title_breadcrumb').text("Edit popup");
		}
	}else if($('.menu_title_breadcrumb').text() == "Add banner"){
		if($('#banner_title').val().length > 0){
			$('.menu_title_breadcrumb').text("Edit banner");
		}
	}


});

// file upload css thing
$('#file').change(function(){
	if($(this).val() != ""){
		$(this).css('border','');
	}
});

$('.btn_save').click(function(){

	if($(this).attr('id') == "banner"){	// banner save btn click
		var bImage = $('#banner_image').val() == "" ? false : true;
		var bValidate = $('[name=pictureForm]').validateForm();
		var bValidate2 = $('[name=pictureForm2]').validateForm();
		
		
		if(bImage == false){
			$('#file').css('border','red solid 1px');
		}
		
		if(bImage && bValidate && bValidate2){
			document.pictureForm2.submit();
		}	
	}else if($(this).attr('id') == "popup"){ // popup save btn click
		var result = true;
		var selected_editor = $('[name=addPopupeditor]:checked').val();
		
		if(selected_editor == "html_edit"){ // Html Editor selected
		
			var textArea = 'html_editor';
			$("#"+textArea+"_ifr").contents().find(".mceContentBody").unbind("keyup");
			
			$("#"+textArea+"_ifr").contents().find(".mceContentBody").keyup(function(){
				if(tinymce.get(textArea).getContent() == ""){
					 $("#"+textArea+"_tbl").css({"border" : "1px solid #ce1f1f"});
					result = false;
				}
				else{
					$("#"+textArea+"_ifr").css({
						"border" : "1px solid #bbb",
						"border-bottom" : "none",
						"border-top" : "none"
					});
					
					result = true;
				}
			});
		
			var content = tinymce.get(textArea).getContent();
			
			if ($.trim(content) == ""){
				$("#"+textArea+"_ifr").css({"border" : "1px solid #ce1f1f"});			
				result = false;
			}
			
		}else{ // Code Editor selected
		
			if($.trim($('.CodeMirror').find('pre:last').html()) != ""){
				result = true;
			
			}else{
				result = false;
				$('.CodeMirror').css('border','1px red solid');
				$('#btn_preview').click();
			}
		
		}

		var sizeW = $('[name=popup_size_w]');
		var sizeH = $('[name=popup_size_h]');
		var posX = $('[name=popup_position_x]');
		var posY = $('[name=popup_position_y]');
		var order = $('[name=popup_order]');
		var regX = /^[1-9]{1}$|[1-9]{1}[0-9]{1,3}$/;
		var aArr = []; aArr2 = [];
		var bValid = true;
		var bValidate = $('[name=popupForm]').validateForm();
		
		$('#err_size').text('');sizeW.css('border','');sizeH.css('border','');
		
		if(sizeW.val() && sizeH.val()){
			var sW = sizeW.val().match(regX) == null ? 0 : 1;
			var sH = sizeH.val().match(regX) == null ? 0 : 1;
			aArr2.push(sW,sH);
			if(sizeW.val() > 1024 || sW == 0)
				sizeW.css('border','red solid 1px');
			else
				sizeW.css('border','');
				
			if(sizeH.val() > 768 || sH == 0)
				sizeH.css('border','red solid 1px');
			else
				sizeH.css('border','');
				
			if(sizeW.val() <= 1024 &&  sizeH.val() <= 768 && sizeW.val().match(regX) != null && sizeH.val().match(regX) != null){
				$('#err_size').text('(Max size 1024x768)').css('color','');
			}else{
				if($.inArray(0,aArr2) != -1)
				$('#err_size').text('Numeric only').css('color','red');
				else
				$('#err_size').text('(Max size 1024x768)').css('color','');
				aArr.push(0);
			}
			
			
		}
		
		if(posX.val() && posY.val()){
			if(posX.val().match(regX) == null){
				posX.css('border','red solid 1px');
			}else{
				posX.css('border','');
			}
			
			if(posY.val().match(regX) == null){
				posY.css('border','red solid 1px');
			}else{
				posY.css('border','');	
			}
			
			if(posX.val().match(regX) != null && posY.val().match(regX) != null){
				$('#err_pos').text('');
			}else{
				$('#err_pos').text('Numeric only');
				aArr.push(0);
			}
		}else{
			$('#err_pos').text('');posX.css('border','');posY.css('border','');posX.val('');posY.val('');
		}
		
		if(order.val()){
			if(order.val().match(regX) == null){
				order.css('border','red solid 1px');
				$('#err_order').text('Numeric only');
				aArr.push(0);
			}else{
				order.css('border','');
				$('#err_order').text('');
			}
		}else{
			$('#err_order').text('');order.css('border','');
		}
		
		bValid = ($.inArray(0,aArr) == -1)? true : false;
		
		if(bValid && bValidate && result){
			document.popupForm.submit();
		}
				
	}else if($(this).attr('id') == "show_status_btn"){	// this will show on this day only btn click
		var	d = Math.floor(new Date().getTime() / 1000);
			$('#show_status').val(d);
			$("#preview_popup_dialog").dialog("close");
	}
});

$('[name=addPopupeditor]').click(function(){
	if($(this).val() == 'html_edit'){
		$(".code_editor_holder").css('display','none');
		$(".code_preview").css('display','none');
		$(".html_editor_holder").css('display','table-row');
	}else{
		$(".html_editor_holder").css('display','none');
		$(".code_editor_holder").css('display','table-row');
		$(".code_preview").css('display','table-row');
		
	}
});

$('[name=banner_title]').keyup(function(){
	$('#banner_title2').val($(this).val());
});

$('.delete_record').click(function(){
	var id = $(this).attr('id').split("|");
	var thisObj = $(this);
	var sPage = "", sFlag = "";

	if(id[1] == 'banner'){
		sPage = "main_banner";
		sFlag = "delele_banner_record";
	}else if(id[1] == 'popup'){
		sPage = "popup_editor";
		sFlag = "delete_popup_record";
	}
	
	$('#del_dialog')
		.dialog({
			modal : true,
			resizable : false,
			buttons: { 
				"Delete": function() {
					$.ajax({
						url : settings.sBASEURL+"/admin/event/?action="+sPage,
						type : "POST",
						data : {action:'delete',sFlag:sFlag,idx:id[0]},
						success : function(data){
							if(data == 1){
								Menu.message("success","Deleted successfully");
								thisObj.parents('tr').remove();
							}else{
								Menu.message("warning","Failed");
							}
						}
					});
					$('#del_dialog').dialog("close");
				},
				"Cancel": function() { $(this).dialog("close"); }
			}
		});
	

});

$('.btn_apply').click(function(){
	var type = $(this).attr('id');
	var sSearch = $(this).prev().val();
	var rel = $(this).attr('rel');
	
	switch(type)
	{			
		case 'delete_records' :
		var page = "", sFlag = "";
			if(rel == "banner"){
				page = "main_banner";
				sFlag = "delete_banner_records";
			}else if(rel == "popup"){
				page = "popup_editor";
				sFlag = "delete_popup_records";
			}

			var aArr = [], sStr = "";
			
			var chklen = $('table tbody tr input:checked').length;
			if(chklen <= 0){
				$('#del_no_selected').dialog({
						modal : true,
						resizable : false,
						buttons : { "Ok" : function() {$(this).dialog("close");} }
				});
			}else{
				$('#dels_dialog')
					.dialog({
						modal : true,
						resizable : false,
						buttons: { 
							"Delete": function() {
								$('table tbody tr input').each(function(k,v){
								if(v.checked){
									aArr.push(v.id);
									$(this).parent().parent().hide();
								}
								});
								sIdx = aArr.toString();
								$.ajax({
									url : settings.sBASEURL+"/admin/event/?action="+page,
									type : "POST",
									data : {action:'delete',sFlag:sFlag,idx:sIdx},
									success : function(data){
										if(data > 0){
											Menu.message("success","Deleted successfully");
										}else{
											Menu.message("warning","Failed");
										}
									}
								});
								$('#dels_dialog').dialog("close");
							},
							"Cancel": function() { $(this).dialog("close"); }
						}
					});
			}
		break;

	}
		
});


// popup preview button
$('#preview_popup').click(function(){
	console.log(typeof $('[name=popup_size_w]').val());
	var sizeW = ($('[name=popup_size_w]').val().length > 0 || typeof $('[name=popup_size_w]').val() == "number") ? parseInt($('[name=popup_size_w]').val())+6 : 300;
	var sizeH = ($('[name=popup_size_h]').val().length > 0) ? parseInt($('[name=popup_size_h]').val())+6 : 200;
	var editor_selected = $('[name=addPopupeditor]:checked').val();

	
	if(editor_selected == "html_edit"){
		$('#preview_popup_content').html(tinymce.get('html_editor').getContent()).css({width:sizeW+"px",height:sizeH+"px"});
	}else{
		$('#preview_popup_content').html(editor.getValue());
	}
	$('#preview_popup_dialog').dialog({
		modal : true,
		width: sizeW+50,
		height: sizeH+90,
		resizable : false
		
	});
	

});


var settings = {
		
		sBASEURL : common.getBaseUrl(),
		
		addBannerUrl : function(){
			window.location.href = settings.sBASEURL+"/admin/event/?action=add_banner";
		},
		
		addPopupUrl : function(){
			window.location.href = settings.sBASEURL+"/admin/event/?action=add_popup";
		},
		
		popup_editor_list : function(){
			window.location.href = settings.sBASEURL+"/admin/event/?action=popup_editor";
		},
		
		banner_list : function(){
			window.location.href = settings.sBASEURL+"/admin/event/?action=main_banner";
		}
		
}
