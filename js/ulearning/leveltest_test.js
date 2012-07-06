function leveltest_test_accordion(depth1){
	if($('.sub_leveltest_test'+depth1).is(':visible'))
		$('.plus'+depth1).show();
	else
		$('.plus'+depth1).hide();
	$('.sub_leveltest_test'+depth1).slideToggle();
	
} 
var leveltest_test = {
	open:function(){
		$('.depth1').find('option:first').attr('selected', 'selected').parent('select');
		//$('.add_leveltest_test').fadeIn();
		$(".add_leveltest_test").dialog({
			title : "Add Level Test (Test) &raquo;",
			width : 300,
			height: 260,
			modal:true
		});

	},
	close:function(){
		$('.add_leveltest_test').dialog("close");
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
		if($('[name=addLeveltest_test]').validateForm()){
			$("[name=addLeveltest_test]").ajaxSubmit({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'addUnit',ftitle:$('.leveltest_test_title').val()},
				type : "GET",
				success : function(data){
					window.location.reload(true);
				}
			});
		}
	},
	modify:function(id,name){
		//$('.modify_leveltest_test').fadeIn();
		$(".modify_leveltest_test").dialog({
			title : "Modify Level Test (Test) &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
		$('.leveltest_test_title_modify').val(name);
		$('.leveltest_test_id_modify').val(id);
	},
	modifySave:function(){
		if($('[name=modifyTitle]').validateForm()){
			$.ajax({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'modifyUnit',funit_id:$('.leveltest_test_id_modify').val(),ftitle:$('.leveltest_test_title_modify').val()},
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
		$('.modify_leveltest_test').dialog("close");
	},
	move:function(id){
		window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=leveltest_test&inner=slide&funit_id='+id+'&category_id='+5;
	},
	deleteOpenPopUp:function(id){
		$('[name=delId]').val(id);
		//$('.deleteSlidePopUp').fadeIn();
		$(".deleteLevelTestPopUp").dialog({
			title : "Delete Level Test (Test) &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
	},
	deleteClosePopUp:function(){
		$('.deleteLevelTestPopUp').dialog("close");
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