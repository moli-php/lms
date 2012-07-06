var confirm_delete = 0;

var Level = {
		
	view_addlevel : function()
	{
		window.location.href = common.getClassUrl("productManageLevel");
	},
	
	backToLevelList : function()
	{
		window.location.href = common.getClassUrl("productLevel");
	},

	saveForm : function()
	{
		var result = $("[name=level_form]").validateForm();
		if(result){
			$.ajax({
				url : common.getClassUrl("productExecute"),
				dataType : "html",
				type : "POST",
				data : "exec=saveLevel&name=" + $("[name=level_name]").val() + "&description=" + $("[name=level_description]").val() + "&id=" + $("[name=editId]").val(),
				success : function(info){
					if(info){
						Menu.message("success", "Saved successfully");
						$("[name=level_form]").resetForm();
						window.location.reload();
					}
				}
			});
		}
	},
	
	deleteLevel : function()
	{
		var aDelId = new Array();
		$("input:checkbox:checked").each(function(){
			aDelId.push($(this).attr('id'));
		});
		
		if(confirm_delete == 1){
			$.ajax({
				url : common.getClassUrl("productExecute"),
				dataType : "html",
				type : "POST",
				data : "exec=deleteLevel&id=" + aDelId,
				success : function(info){
					window.location.href = common.getClassUrl("productLevel");
					$("input:checkbox:checked").each(function(){
						$(this).attr("checked", false);
					});
				}
			});
		}else if(confirm_delete == 2){
			$("#confirm_delete_box").fadeOut();
		}
		
	}
}

$("[name=level_submit]").click(function(){
	Level.saveForm();
});

$("#delete_level").click(function(){
	$("#confirm_delete_box").fadeIn();
});

$("#confirm_delete").click(function(){
	confirm_delete = 1;
	Level.deleteLevel();
});

$("#confirm_cancel").click(function(){
	confirm_delete = 2;
	Level.deleteLevel();
});
