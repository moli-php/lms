$('.menu_1stdepth').click(function(){
	$('.menu_2nddepth').slideUp();
	if($(this).parent().find('.menu_2nddepth').is(':hidden'))
		$(this).parent().find('.menu_2nddepth').slideDown();
});
$('.menu_2nddepth').click(function(){
	$('.menu_3rddepth').slideUp();
	if($(this).parent().find('.menu_3rddepth').is(':hidden'))
		$(this).parent().find('.menu_3rddepth').slideToggle();
});
var category = {
	open:function(){
		$(".new_category_pop").dialog({
			title : "Add New Category &raquo;",
			width : 300,
			height: 220,
			modal:true
		});
		//$('.new_category_pop').fadeIn();
	},
	close:function(){
		$('.depth1').val(0);
		$(".new_category_pop").dialog("close");
		//$('.new_category_pop').fadeOut();
	},
	depth1:function(me){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'category',fcategory_id:$(me).val()},
			type : "GET",
			success : function(data){
				var obj = $.parseJSON(data);
				$('.depth2').html('<option value="0"></option>');
				$.each(obj, function(k,v){
					$('.depth2').append("<option value='"+v.fcategory_id+"'>"+v.fcategory_name+"</option>");
				});
			}
		});
	}, 
	save:function(){
		if($('.category_form_add').validateForm()){
			$.ajax({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'addCategory',fdepth1:$('.depth1').val(),fdepth2:$('.depth2').val(),fcategory_name:$('.category_name').val()},
				type : "GET",
				success : function(data){
					if(data == "failed")
						Menu.message("warning","Saving Failed. Check the name before saving");
					else{
						Menu.message("success","Successfully Saved");
						window.location.reload(true);
					}
				}
			});
		}
			
	},
	modifySave:function(){
		if($('[name=category_form_modify]').validateForm()){
			$.ajax({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'modifyCategoryName',fcategory_name:$('.category_name_modify').val(),fcategory_id:$('.category_id_modify').val()},
				type : "GET",
				success : function(data){
					if(data == "failed")
						Menu.message("warning","Saving Failed. Check the name before saving");
					else{
						Menu.message("success","Successfully Saved");
						window.location.reload(true);
					}
				}
			});
		}
			
	},
	modify:function(id,name){
		//$('.modify_category_pop').fadeIn();
		$(".modify_category_pop").dialog({
			title : "Modify Title &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
		$('.category_name_modify').val(name);
		$('.category_id_modify').val(id);
	},
	modifyClose:function(){
		$('.modify_category_pop').dialog("close");
	},
	deleteOpenPopUp:function(id){
		$('[name=delIdCat]').val(id);
		//$('.deleteCatPopUp').fadeIn();
		$(".deleteCatPopUp").dialog({
			title : "Delete Category &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
	},
	deleteClosePopUp:function(){
		$('.deleteCatPopUp').dialog("close");
	},
	remove:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'deleteCategory',fcategory_id:$('[name=delIdCat]').val()},
			type : "GET",
			success : function(data){
				Menu.message("success","Successfully Deleted");
				window.location.reload(true);
			}
		});
	}
}