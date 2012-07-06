$('#select_category_name').val("");
$('#select_category').val("");
$('#movie_title').val("");

$('.check_all').click(function(){
	if($('.check_all').attr("checked"))
		$('.check').attr("checked","checked");
});
	
$('.page_rows').change(function(){
	window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=movie_clip&page_rows="+$('.page_rows').val();
});

$('#select_category').change(function(){
	$('#select_category_name').html("");
	if($('#select_category').val()!= ""){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'get_movie_cat_name', mov_cat_id:$('#select_category').val()},
			type : "GET",
			success : function(data){
				data = $.parseJSON(data);
				var str = "";
					str += "<option></option>";
				for(var i=0; i<data.length; i++){
					str += "<option value='"+ data[i].movie_cat_name_id +"'>"+ data[i].movie_category_name +"</option>";
				}
				$('#select_category_name').html(str);
			}
		});
	}
});

$('#image_file').live('change', function(){
	$(".image_preview").html('');
	$("[name=userAddForm]").ajaxSubmit({
		url :  common.getBaseUrl()+"/admin/ulearning/process/index.php",
		dataType : "html",
		data : {action: "upload_movie_image", mov_image:$('.image_name').html()},
		type : "POST",
		success : function(data){
			if(data == "error"){
				Menu.message("warning","Image File Error.");
			}else{
				$(".image_preview").html('<img src="../../uploads/ulearning/upload/'+ data +'" width="200" alt="Image Preview" /><a href="javascript:movie_clip.delete_preview(\''+ data +'\')" class="image_preview_close" title="Delete Image" >[X]</a>');
				$('.image_name').html(data);
			}
		}
	});

});

var movie_clip = {
	add_movie_clip:function(){
		window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=movie_clip&add_new";
	},
	search:function(){
			window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=movie_clip&movie_title="+$('#movie_title').val()+"&mov_cat_id="+$('#select_category').val()+"&mov_cat_name_id="+$('#select_category_name').val();
	},
	close:function(){
		$('.popup_window').dialog("close");
	},
	delete_confirm:function(){
		//$('.delete_movie_clip').fadeIn();
		$(".delete_movie_clip").dialog({
			title : "Delete Movie Clip &raquo;",
			width : 300,
			height: 150,
			modal:true
		});
	},	
	delete_movie_clip:function(){
		var count = $(".check").length;
		var checked_box = new Array();
		for(var i=0; i<count; i++){
			if($(".check:checked").eq(i).val()){
				checked_box.push($(".check:checked").eq(i).val());
			}
		}
		if(checked_box.length > 0){
			$.ajax({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'delete_movie_clip', mov_clip_id: checked_box},
				type : "GET",
				success : function(data){
					Menu.message("success","Successfully Deleted!");
					window.location.reload(true);
				}
			});
		}
	},
	submit_movie_clip:function(){
		if($("[name=userAddForm]").validateForm()){
			$("[name=userAddForm]").ajaxSubmit({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'add_movie_clip', mov_image:$('.image_name').html()},
				type : "POST",
				success : function(data){
					Menu.message("success","Movie Clip Saved!");
					window.location.reload(true);
				}
			});
		}
	},
	delete_preview:function(name){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'delete_preview', mov_image: name},
			type : "GET",
			success : function(data){
				$('#image_file').val('');
				$('.image_preview').html('');
				$('.image_name').html('');
			}
		});
	},
	modify_clip:function(id){
		window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=movie_clip&add_new="+id;
	},
	modify_movie_clip:function(id){
		if($("[name=userAddForm]").validateForm()){
			$("[name=userAddForm]").ajaxSubmit({
				url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
				data : {action:'modify_movie_clip', mov_clip_id: id, mov_image:$('.image_name').html()},
				type : "POST",
				success : function(data){
						Menu.message("success","Movie Clip Updated!");
						window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=movie_clip";
				}
			});
		}
	}
} 