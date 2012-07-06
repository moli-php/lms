function material_accordion(depth1){
	if($('.sub_material'+depth1).is(':visible'))
		$('.plus'+depth1).show();
	else
		$('.plus'+depth1).hide();
	$('.sub_material'+depth1).slideToggle();
	
} 
var material = {
	open:function(){
		$('.depth1').find('option:first').attr('selected', 'selected').parent('select');
		//$('.add_material').fadeIn();
		$(".add_material").dialog({
			title : "Add Material &raquo;",
			width : 300,
			height: 260,
			modal:true
		});

	},
	close:function(){
		$('.add_material').dialog("close");
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
		if($('[name=addMaterial]').validateForm()){
			$("[name=addMaterial]").ajaxSubmit({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'addUnit',ftitle:$('.material_title').val()},
				type : "GET",
				success : function(data){
					window.location.reload(true);
				}
			});
		}
	},
	modify:function(id,name){
		//$('.modify_material').fadeIn();
		$(".modify_material").dialog({
			title : "Modify Material &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
		$('.material_title_modify').val(name);
		$('.material_id_modify').val(id);
	},
	modifySave:function(){
		if($('[name=modifyTitle]').validateForm()){
			$.ajax({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'modifyUnit',funit_id:$('.material_id_modify').val(),ftitle:$('.material_title_modify').val()},
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
		$('.modify_material').dialog("close");
	},
	move:function(id){
		window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=class_mat&inner=slide&funit_id='+id+'&category_id='+1;
	},
	deleteOpenPopUp:function(id){
		$('[name=delId]').val(id);
		$(".deleteMatPopUp").dialog({
			title : "Delete Material &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
		//$('.deleteMatPopUp').fadeIn();
	},
	deleteClosePopUp:function(){
		$('.deleteMatPopUp').dialog("close");
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