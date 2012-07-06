 $('.menu_1stdepth').click(function(){
	$('.menu_2nddepth').slideUp();
	if($(this).parent().find('.menu_2nddepth').is(':hidden'))
		$(this).parent().find('.menu_2nddepth').slideToggle();
});
  
var movie_category = {
	open:function(){
		//$('.add_movie_cat').fadeIn();
		$('.modify_movie_cat').fadeOut();
		$('.delete_movie_cat').fadeOut();
		$(".add_movie_cat").dialog({
			title : "Add New Category &raquo;",
			width : 300,
			height: 200,
			modal:true
		});
	},
	close:function(){
		$('.popup_window').dialog("close");
		// $('.modify_movie_cat').dialog("close");
		// $('.delete_movie_cat').dialog("close");
	},
	add_submit:function(){
		if($("[name=add_category]").validateForm()){
			$.ajax({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'add_movie_category', mov_cat_id:$('.depth').val(), mov_cat_name:$('#category_name').val()},
				type : "GET",
				success : function(data){
					if(data==1){
						window.location.reload(true);
						Menu.message("success","Saved!");
					}else{
						Menu.message("warning","Failed! Name already exist.");
					}
				}
			});
		}
	},
	modify:function(cid,id,name){
		$('#modify_cat_name').val(name);
		$('#mod_id').val(id);
		$('#mod_cat_id').val(cid);
		//$('.modify_movie_cat').fadeIn();
		$('.add_movie_cat').fadeOut();
		$('.delete_movie_cat').fadeOut();
		$(".modify_movie_cat").dialog({
			title : "Modify Title &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
	},
	modify_submit:function(){
		if($("[name=modify_category]").validateForm()){
			$.ajax({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'modify_movie_category', mov_cat_id:$('#mod_cat_id').val(), mov_cat_name_id:$('#mod_id').val(), mov_cat_name:$('#modify_cat_name').val()},
				type : "GET",
				success : function(data){
					if(data==1){
						window.location.reload(true);
						Menu.message("success","Saved!");
					}else{
						Menu.message("warning","Failed! Name already exist.");
					}
				}
			});
		}
	},
	delete_confirm:function(id){
		$('#del_id').val(id);
		$('.modify_movie_cat').fadeOut();
		$('.add_movie_cat').fadeOut();
		//$('.delete_movie_cat').fadeIn();
		$(".delete_movie_cat").dialog({
			title : "Delete Category &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
	},	
	delete_category:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'delete_movie_category', mov_cat_name_id: $('#del_id').val()},
			type : "GET",
			success : function(data){
				Menu.message("success","Successfully Deleted!");
				window.location.reload(true);
			}
		});
	}
}