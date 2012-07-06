var test_eval_manage = {
	total:function(){
		var total = 0;
		for(var i=0;i<$('.slides').length;i++){
			if($('#slideGradeField-'+i).val() =="")
				$('#slideGradeField-'+i).val(0);
			if(test_eval_manage.isNumeric($('#slideGradeField-'+i).val()) == false){
				$('#slideGradeField-'+i).addClass("error");
				$('.total_value_class').addClass("error");
			}
			else{
				$('#slideGradeField-'+i).removeClass("error");
				$('.total_value_class').removeClass("error");
				total += parseFloat($('#slideGradeField-'+i).val());
			}
		}
		$('.total_value_class').val(parseFloat(total/$('.slides').length).toFixed(2));
	},
	isNumeric:function(sText){
		var ValidChars = "0123456789.";
		var IsNumber=true;
		var Char;
		for (i = 0; i < sText.length && IsNumber == true; i++){ 
			Char = sText.charAt(i); 
			if (ValidChars.indexOf(Char) == -1)
				IsNumber = false;
		}
		return IsNumber;
	},
	slideSubmit:function(user_grade_id,type,slideCount){
		var type_id = new Array();
		if(user_grade_id == ""){
			Menu.message("warning","Student haven't visited the slide yet");
			return false;
		}
		if(test_eval_manage.isNumeric($('#slideGradeField-'+slideCount).val()) === false){
			Menu.message("warning","Score is not numeric");
			return false;
		}
		var comment_type_id = new Array();
		for(var i=0;i<$('.type_'+type).length;i++){
			type_id.push($('.type_'+type).eq(i).val());
			comment_type_id.push($('.comment_type_'+type).eq(i).val());
		}
		$.ajax({
			type: "POST",
			url: common.getBaseUrl()+"/admin/ulearning/process/",
			data: {user_grade_id:user_grade_id,user_slide_grade:$('#slideGradeField-'+slideCount).val(),type_id:type_id,comment:comment_type_id,action:"updateSlideGrade"},
			success:function(data){
				Menu.message("success","Successfully Saved");
			}
		});
	},
	evaluate:function(){
		if($('.status').val() == "Assigned"){
			Menu.message("warning","This exam cannot be evaluated because the student isn't finished with the exam");
			return false;
		}else{
			$.ajax({
				type: "POST",
				url: common.getBaseUrl()+"/admin/ulearning/process/",
				data: {eval_id:$('.eval_id').val(),action:"evaluate"},
				success:function(data){
					Menu.message("success","Successfully Evaluated");
				}
			});
		}
	}
}