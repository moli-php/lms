$( ".newSlidePopUp" ).draggable({handle:'span.handle',cursor:'move'});
$('.study_part').change(function(){
	if($('.study_part:checked').length == 0)
			$('.study_part').parent().attr('style',"border:solid 1px red;display:inline-block");
	else
		$('.study_part').parent().removeAttr('style');
});
var slide = {
	remove_sentence:function(){
		$('[name=sentence]').html('');
		$('[name=sentence]').removeAttr("onfocus");
	},
	movie_cat2:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'get_movie_cat_name',mov_cat_id:$('[name=cat1]').val()},
			type : "GET",
			success : function(data){
				data = $.parseJSON(data);
				var str = "";
					str += "<option></option>";
				for(var i=0; i<data.length; i++){
					str += "<option value='"+ data[i].movie_cat_name_id +"'>"+ data[i].movie_category_name +"</option>";
				}
				$('[name=cat2]').attr("onchange","slide.movie_cat3()");
				$('[name=cat2]').html(str);
				$('[name=cat3]').html('');
			}
		});
	},
	movie_cat3:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'get_movie_clip_title',mov_cat2_id:$('[name=cat2]').val()},
			type : "GET",
			success : function(data){
				data = $.parseJSON(data);
				var str = "";
					str += "<option></option>";
				for(var i=0; i<data.length; i++){
					str += "<option value='"+ data[i].movie_clip_id +"'>"+ data[i].movie_clip_title +"</option>";
				}
				$('[name=cat3]').html(str);
			}
		});
	},
	movie_cat4:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'get_movie_cat_name',mov_cat_id:$('[name=cat4]').val()},
			type : "GET",
			success : function(data){
				data = $.parseJSON(data);
				var str = "";
					str += "<option></option>";
				for(var i=0; i<data.length; i++){
					str += "<option value='"+ data[i].movie_cat_name_id +"'>"+ data[i].movie_category_name +"</option>";
				}
				$('[name=cat5]').attr("onchange","slide.movie_cat5()");
				$('[name=cat5]').html(str);
				$('[name=cat6]').html('');
			}
		});
	},
	movie_cat5:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'get_movie_clip_title',mov_cat2_id:$('[name=cat5]').val()},
			type : "GET",
			success : function(data){
				data = $.parseJSON(data);
				var str = "";
					str += "<option></option>";
				for(var i=0; i<data.length; i++){
					str += "<option value='"+ data[i].movie_clip_id +"'>"+ data[i].movie_clip_title +"</option>";
				}
				$('[name=cat6]').html(str);
			}
		});
	},
	open:function(id){
		$('.newSlidePopUp').fadeIn();
		$('[name=fexam_type_id]').val(id);
		if(id != 19 && id != 20){
			$('.commonHead').show();
			$('.nineTeenHead').hide();
			$('.twentyHead').hide();
		}
		else if(id == 19){
			$('.commonHead').hide();
			$('.nineTeenHead').show();
			$('.twentyHead').hide();
		}
		else if(id == 20){
			$('.commonHead').hide();
			$('.nineTeenHead').hide();
			$('.twentyHead').show();
		}
			
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'questionFetch',type:id},
			type : "GET",
			success : function(data){
				$('.tbody').html(data);
				$('.saveSlide').unbind('click');
				$('.saveSlide').bind('click',function(){
					slide.save(id);
				});
			}
		});
	},
	remove_sentence:function(){
		$('[name=sentence]').html('');
		$('[name=sentence]').removeAttr("onfocus");
	},
	close:function(){
		$('.newSlidePopUp').fadeOut();
	},
	fileTrigger:function(file){
			$('#'+file).trigger('click');
	},
	fileSelect:function(file,me){
			$('#'+file).val($(me).val());
	},
	character:function(me,charMax){
			var iCharLeft = charMax - $(me).val().length;
			$(me).parent().find(".character").html($(me).val().length);
	},
	save:function(id){
		if($('[name=fexam_type_id]').val() != 19 && $('[name=fexam_type_id]').val() != 20){
			if($('.study_part:checked').length == 0){
				$('.study_part').parent().attr('style',"border:solid 1px red;display:inline-block");
				$('[name=addSlideForm]').validateForm();
			}
			else
				$('.study_part').parent().removeAttr('style');
			if($('[name=addSlideForm]').validateForm()){
				$("[name=addSlideForm]").ajaxSubmit({
					url :  common.getBaseUrl()+"/admin/ulearning/process/index.php",
					//dataType : "html",
					type : "POST",
					data : {action: "addSlide",type:id},
					
					success : function(data){
						if(data == 0){
							Menu.message("warning","Invalid sound file");
							return false;
						}
						Menu.message("success","Successfully Saved");
						window.location.reload(true);
					}
				});
			}
		}
		else if($('[name=fexam_type_id]').val() == 19){
			if($('[name=addSlideNineTeenForm]').validateForm()){
				$("[name=addSlideNineTeenForm]").ajaxSubmit({
					url :  common.getBaseUrl()+"/admin/ulearning/process/index.php",
					dataType : "html",
					data : {action: "addSlide",type:id},
					type : "POST",
					success : function(data){
						if(data == 0){
							Menu.message("warning","File Error");
						}else{
							Menu.message("success","Successfully Saved");
							window.location.reload(true);
						}
					}
				});
			}
		}
		else{
			if($('[name=addSlideTwentyForm]').validateForm()){
				$("[name=addSlideTwentyForm]").ajaxSubmit({
					url :  common.getBaseUrl()+"/admin/ulearning/process/index.php",
					dataType : "html",
					data : {action: "addSlide",type:id},
					type : "POST",
					success : function(data){
						if(data == 0){
							Menu.message("warning","File Error");
						}else{
							Menu.message("success","Successfully Saved");
							window.location.reload(true);
						}
					}
				});
			}
		}
	},
	copyMoveSlidePopUp:function(action,title){
		if($('.slideCheck:checked').length > 0 ){
			//$('.copyMoveSlidePopUp').fadeIn();
			$(".copyMoveSlidePopUp").dialog({
				title : title,
				width : 400,
				height: 300,
				modal:true
			});
			$('[name=act]').val(action);
		}
		else{
			Menu.message("warning","Select slide(s) first");
			$('[name=act]').val("");
			$('.copyMoveSlidePopUp .popup_title').html("");
		}
	},
	copyMoveClosePopUp:function(){
		$('.copyMoveSlidePopUp').fadeOut();
	},
	deleteOpenPopUp:function(){
		if($('.slideCheck:checked').length > 0 ){
			//$('.deleteSlidePopUp').fadeIn();
			$(".deleteSlidePopUp").dialog({
				title : "Delete Slide &raquo;",
				width : 300,
				height: 150,
				modal:true
			});
		}
		else
			Menu.message("warning","No data to be deleted");
	},
	deleteClosePopUp:function(){
		$('.deleteSlidePopUp').dialog("close");
	},
	remove:function(){
		var slideId = new Array();
		for(var i = 0;i < $('.slideCheck:checked').length;i++)
			slideId[i] = $('.slideCheck:checked').eq(i).val();
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/index.php",
			data : {action:'removeSlide',slide_id:slideId},
			type : "GET",
			success : function(data){
				Menu.message("success","Successfully Deleted");
				window.location.reload(true);
			}
		});
	},category:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/",
			data : {action:'category',fcategory_id:$('.depth1').val()},
			type : "GET",
			success : function(data){
				var obj = $.parseJSON(data);
				$('.depth2').empty();
				$('.depth3').empty();
				$('.unit').empty();
				$('.depth2').append("<option></option>");
				$.each(obj, function(k,v){
					$('.depth2').append("<option value='"+v.fcategory_id+"'>"+v.fcategory_name+"</option>");
				});
			}
		});
	},
	depth1:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/",
			data : {action:'depth1',fcategory_id:$('.depth2').val()},
			type : "GET",
			success : function(data){
				var obj = $.parseJSON(data);
				$('.depth3').empty();
				$('.unit').empty();
				$('.depth3').append("<option></option>");
				$.each(obj, function(k,v){
					$('.depth3').append("<option value='"+v.fcategory_id+"'>"+v.fcategory_name+"</option>");
				});
			}
		});
	},
	depth2:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/",
			data : {action:'depth2',fcategory_id:$('.depth3').val()},
			type : "GET",
			success : function(data){
				var obj = $.parseJSON(data);
				$('.unit').empty();
				$('.unit').append("<option></option>");
				$.each(obj, function(k,v){
					$('.unit').append("<option value='"+v.funit_id+"'>"+v.ftitle+"</option>");
				});
			}
		});
	},
	copyMoveSave:function(){
		if($('[name=copyMoveForm]').validateForm()){
			var slideId = new Array();
			for(var i = 0;i < $('.slideCheck:checked').length;i++)
				slideId[i] = $('.slideCheck:checked').eq(i).val();
			$("[name=copyMoveForm]").ajaxSubmit({
				url : common.getBaseUrl()+"/admin/ulearning/process/",
				data : {action:'copyMoveSlide',slide_id:slideId},
				type : "GET",
				success : function(data){
					Menu.message("success","Successfully Saved");
					window.location.reload(true);
				}
			});
		}
		
	}
}
