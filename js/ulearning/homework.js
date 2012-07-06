function homework_accordion(depth1){
	if($('.sub_homework'+depth1).is(':visible'))
		$('.plus'+depth1).show();
	else
		$('.plus'+depth1).hide();
	$('.sub_homework'+depth1).slideToggle();
	
} 
var homework = {
	open:function(){
		$('.depth1').find('option:first').attr('selected', 'selected').parent('select');
		//$('.add_homework').fadeIn();
		$(".add_homework").dialog({
			title : "Add Homework &raquo;",
			width : 300,
			height: 260,
			modal:true
		});
	},
	close:function(){
		$('.add_homework').dialog("close");
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
		if($('[name=addHomework]').validateForm()){
			$("[name=addHomework]").ajaxSubmit({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'addUnit',ftitle:$('.homework_title').val()},
				type : "GET",
				success : function(data){
					window.location.reload(true);
				}
			});
		}
	},
	modify:function(id,name){
		//$('.modify_homework').fadeIn();
		$(".modify_homework").dialog({
			title : "Modify Homeowork &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
		$('.homework_title_modify').val(name);
		$('.homework_id_modify').val(id);
	},
	modifySave:function(){
		if($('[name=modifyTitle]').validateForm()){
			$.ajax({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'modifyUnit',funit_id:$('.homework_id_modify').val(),ftitle:$('.homework_title_modify').val()},
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
		$('.modify_homework').dialog("close");
	},
	move:function(id){
		window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=homework&inner=slide&funit_id='+id+'&category_id='+2;
	},
	deleteOpenPopUp:function(id){
		$('[name=delId]').val(id);
		//$('.deleteSlidePopUp').fadeIn();
		$(".deleteHomeworkPopUp").dialog({
			title : "Delete Homework &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
	},
	deleteClosePopUp:function(){
		$('.deleteHomeworkPopUp').dialog("close");
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