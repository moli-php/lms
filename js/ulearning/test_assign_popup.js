 var assign = {
	class_schedule:function(id,class_id){
		if(class_id != "")
			common.class_schedule(id+"&class="+class_id);
		else
			Menu.message("warning","Cannot go to uLearning Course. Please Select User ID and Class first");
	},
	category:function(){
		if($('.course').val() ==1){
			$('.unit').attr("disabled","disabled");
			$('.unit_required').hide();
		}
		else{
			$('.unit').removeAttr("disabled");
			$('.unit_required').show();
		}
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/",
			data : {action:'category',fcategory_id:$('.course').val()},
			type : "GET",
			success : function(data){
				var obj = $.parseJSON(data);
				$('.depth1').empty();
				$('.depth2').empty();
				$('.unit').empty();
				$('.depth1').append("<option></option>");
				$.each(obj, function(k,v){
					$('.depth1').append("<option value='"+v.fcategory_id+"'>"+v.fcategory_name+"</option>");
				});
			}
		});
	},
	depth1:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/",
			data : {action:'depth1',fcategory_id:$('.depth1').val()},
			type : "GET",
			success : function(data){
				var obj = $.parseJSON(data);
				$('.depth2').empty();
				$('.unit').empty();
				$('.depth2').append("<option></option>");
				$.each(obj, function(k,v){
					$('.depth2').append("<option value='"+v.fcategory_id+"'>"+v.fcategory_name+"</option>");
				});
			}
		});
	},
	depth2:function(){
		$.ajax({
			url : common.getBaseUrl()+"/admin/ulearning/process/",
			data : {action:'depth2',fcategory_id:$('.depth2').val()},
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
	date:function(){
		$( ".date" ).datepicker("show");
	},
	edate:function(){
		$( ".edate" ).datepicker("show");
	},
	sdate:function(){
		$( ".sdate" ).datepicker("show");
	},
	search:function(){
		if(!$('.branch').length)
			window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=test_assign&inner=popup&user_id="+$('[name=username]').val()+"&sdate="+$('.sdate').val()+"&edate="+$('.edate').val();
		else
			window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=test_assign&inner=popup&user_id="+$('[name=username]').val()+"&sdate="+$('.sdate').val()+"&edate="+$('.edate').val()+"&branch="+$('.branch').val();
	},
	total:function(){
		window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=test_assign&inner=popup&user_id="+$('[name=username]').val();
	},
	addAssignment:function(){
		if($('[name=userAddForm]').validateForm()){
			$.ajax({
				url : common.getBaseUrl()+"/admin/ulearning/process/",
				data : {action:'assign',
					fcategory_id:$('.course').val(),
					fdepth1:$('.depth1').val(),
					fdepth2:$('.depth2').val(),
					funit_id:$('.unit').val(),
					class_id:$('.class').val(),
					user_id:$('.user_id').val(),
					fdate:$('.date').val()
				},
				type : "GET",
				success : function(data){
					if(data == 1){
						Menu.message("success","Successfully Assigned");
						//window.location.reload(true);
						
					}
					else{
						Menu.message("warning","Saving Failed. Duplicate Data");
					}
				}
			});
		}else
			Menu.message("warning","Please fill the required fields");
	},
	remove:function(){
		var fassign_id = new Array();
		for(var i=0;i<$('.assign_check').length;i++){
			if($('.assign_check:checked').eq(i).val()){
				fassign_id.push($('.assign_check:checked').eq(i).val());
			}
		}
		if(fassign_id.length > 0){
			$.ajax({
				type:"GET",
				url: common.getBaseUrl()+"/admin/ulearning/process/",
				data:{action:"deleteAssigned",fassign_id:fassign_id},
				success:function(data){
					Menu.message("success","Successfully Deleted");
					window.location.reload(true);
				}
			});
		}else
			Menu.message("warning","Nothing to be removed");
	}

}
