$(document).ready(function(){
	var temp = $('.time_remain').html();
	global_assign_id = $('#assign_id').val();
	
	if(temp != null){
		var array = temp.split(":");
		if(array[0] != 0 || array[1] != 0 || array[2] != 0){
			exam_popup.time_remain(array[0],array[1],array[2]);
		}
	}
});

$(window).unload(function(){
	exam_popup.save_answer();
	window.opener.location.reload(true);
});

var exam_popup = {
	next_slide:function(id){
		if(exam_popup.validate() == true){
			exam_popup.redirect(id);
		}
	},
	validate:function(){
		var validated = true;
		if($('#exam_type_id').val() == 2 || $('#exam_type_id').val() == 3 || $('#exam_type_id').val() == 5 || $('#exam_type_id').val() == 6){
			for(var i=0;i<$('.count').length;i++){
				$('.validated_'+i).removeAttr('style');
				if($('[name=choice_'+i+']:checked').length == 0){
					$('.validated_'+i).attr('style','border:solid 2px red');
					validated = false;
				}
			}
		}else if($('#exam_type_id').val() == 7 || $('#exam_type_id').val() == 8 || $('#exam_type_id').val() == 9){
			for(var i=0;i<$('.count').length;i++){
				$('.validated_'+i).removeAttr('style');
				if($('#exam_type_id').val() == 9)
					$('.validated_'+i).attr('style','width:auto;');
				if($('[name=answer_'+i+']').val() == ""){
					if($('#exam_type_id').val() == 9)
					$('.validated_'+i).attr('style','border:solid 3px red;width:auto;');
					else
					$('.validated_'+i).attr('style','border:solid 2px red');
					validated = false;
				}
			}
		}else if($('#exam_type_id').val() == 10 || $('#exam_type_id').val() == 11){
			for(var i=0;i<$('.count').length;i++){
				for(var j=0;j<12;j++){
					for(var k=0;k<12;k++){
						$('.validated_'+i+'_'+j+'_'+k).removeAttr('style');
						if($('[name=answer_'+i+'_'+j+'_'+k+']').val() == ""){
							$('.validated_'+i+'_'+j+'_'+k).attr('style','border:solid 2px red');
							validated = false;
						}else if($('[name=answer_'+i+'_'+j+'_'+k+']').length == 0){ break; }
					}
				}
			}
		}else if($('#exam_type_id').val() == 16){
			for(var i=0;i<$('.count').length;i++){
				$('.validated_'+i).removeAttr('style');
				$('.validated_'+i).attr('style','width:auto;');
				if($('[name=answer_'+i+']').val() == ""){
					$('.validated_'+i).attr('style','border:solid 3px red;width:auto;');
					validated = false;
				}
			}
		}else if($('#exam_type_id').val() == 17){
			for(var i=0;i<$('.count').length;i++){
				$('.validated_'+i).removeAttr('style');
				$('.validated_'+i).attr('style','margin:10px 0 5px 0;');
				if($('[name=answer_'+i+']').val() == ""){
					$('.validated_'+i).attr('style','border:solid 2px red;margin:10px 0 5px 0;');
					validated = false;
				}
			}
		}
		
		return validated;
	},
	time_remain:function(hr,min,sec){
		setTimeout(function(){
			if(sec == 0){
				if(min == 0){
					if(hr > 0){
						hr = hr-1;
						min = 59;
						sec = 59;
					}
				}else{
					min = min-1;
					sec = 59;
				}
			}else{
				sec = sec-1;
			}
			if(hr==0 && min==0 && sec==0){
				exam_popup.redirect(global_assign_id);
			}else{
			exam_popup.time_remain(hr,min,sec);
			}
			$('.time_remain').html(hr+":"+min+":"+sec);
		},1000);
	},
	save_answer:function(){
		$("#exam_popup").ajaxSubmit({
			url: common.getBaseUrl()+"/ulearning/api/save_answer.php",
			type: "GET",
			dataType:"html"
		});
	},
	redirect:function(id){
		window.location.href = common.getBaseUrl()+"/ulearning/?assign_id="+id;
	}
}

