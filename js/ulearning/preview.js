function preview_accordion(depth1){
	if($('.sub_preview'+depth1).is(':visible'))
		$('.plus'+depth1).show();
	else
		$('.plus'+depth1).hide();
	$('.sub_preview'+depth1).slideToggle();
	
} 
var preview = {
	open:function(){
		$('.depth1').find('option:first').attr('selected', 'selected').parent('select');
		//$('.add_preview').fadeIn();
		$(".add_preview").dialog({
			title : "Add Preview &raquo;",
			width : 300,
			height: 260,
			modal:true
		});
	},
	close:function(){
		$('.add_preview').dialog("close");
	},
	depth1:function(me){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'depth1',fcategory_id:$(me).val()},
			type : "GET",
			success : function(data){
				var obj = $.parseJSON(data);
				$('.depth2').empty();
				$.each(obj, function(k,v){
					$('.depth2').append("<option value='"+v.fcategory_id+"'>"+v.fcategory_name+"</option>");
				});
			}
		});
	},
	save:function(){
		if($('[name=addPreview]').validateForm()){
			$("[name=addPreview]").ajaxSubmit({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'addUnit',ftitle:$('.preview_title').val()},
				type : "GET",
				success : function(data){
					window.location.reload(true);
				}
			});
		}
	},
	modify:function(id,name){
		//$('.modify_preview').fadeIn();
		$(".modify_preview").dialog({
			title : "Modify Preview &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
		$('.preview_title_modify').val(name);
		$('.preview_id_modify').val(id);
	},
	modifySave:function(){
		if($('[name=modifyTitle]').validateForm()){
			$.ajax({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'modifyUnit',funit_id:$('.preview_id_modify').val(),ftitle:$('.preview_title_modify').val()},
				type : "GET",
				success : function(data){
					if(data == "failed")
						Menu.message("warning","Saving Failed. Check the title before saving");
					else{
						Menu.message("success","Successfully Saved");
						window.location.reload(true);
					}
				}
			});
		}
	},
	modifyClose:function(){
		$('.modify_preview').dialog("close");
	},
	move:function(id){
		window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=preview&inner=slide&funit_id='+id+'&category_id='+3;
	},
	deleteOpenPopUp:function(id){
		$('[name=delId]').val(id);
		//$('.deletePreviewPopUp').fadeIn();
		$(".deletePreviewPopUp").dialog({
			title : "Delete Preview &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
	},
	deleteClosePopUp:function(){
		$('.deletePreviewPopUp').dialog("close");
	},
	remove:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'deleteUnit',funit_id:$('[name=delId]').val()},
			type : "GET",
			success : function(data){
				Menu.message("success","Successfully Deleted");
				window.location.reload(true);
			}
		});
	}
}