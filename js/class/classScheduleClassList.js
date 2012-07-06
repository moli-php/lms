var classtabs = {
	levelTestInfo : function(idx){
        $.ajax({
            url : common.getClassUrl("classExecute"),
            dataType : "json",
            data : 	{
		                exec : "getLevelTestData",
		                userIdx : idx
            		},
            success : function(aData){
                if (aData > 0)
                    location.href = common.getClassUrl("classLevelTestInfo") + "&idx=" + idx;
                else
                    common.reportError("No level test inquiry found.");
            }
        });
    },
    classCalendar : function(user_id, class_id){
    	location.href = common.getClassUrl("classScheduleCalendar") + "&uid=" + user_id + "&class_id=" + class_id;
    },
    classList : function(user_id, class_id){
    	location.href = common.getClassUrl("classScheduleClassList") + "&uid=" + user_id + "&class_id=" + class_id;
    },
    classChangeSchedule : function(user_id, class_id){
    	location.href = common.getClassUrl("classScheduleChange") + "&uid=" + user_id + "&class_id=" + class_id;
    }
    
}

var manageSchedule = {
	editSingleScheduleStatus : function(date, student, classId){
		var pDate = Date.parse(date);
		var cDate = Date.parse(new Date("2012-06-21"));
		var diff = Math.round((cDate - pDate) / 86400000);
		
		if($("select[name=choose_class] option:selected").attr("status") == "scheduled" || $("select[name=choose_class] option:selected").attr("status") == "cancelled"){
			if(diff <= 0){
				$.ajax({
					url : common.getClassUrl("classScheduleClassList"),
					dataType : "json",
					type : "POST",
					data : 	{
								exec : "editSingleScheduleStatus",
								date : date,
								student : student,
								classId : classId
							},
					success : function(info){
						$("#change_popup").dialog({
							title : "Edit Schedule Status",
							width : 450,
							height : 350,
							modal:true
						});
						var sHtml = "";
						sHtml = info[0].teacher_name + " (" + info[0].daystart + " " + info[0].time_start + " ~ " + info[0].time_end + ") : " + $("select[name=choose_class] option:selected").html();
						$("#editSchedStatTitle").html(sHtml);
						$('[name=scheduleStatus]:radio[value="'+info[0].sched_status+'"]').attr('checked', 'checked');
						$('[name=datestart]').val(info[0].daystart);
						$('[name=teacherid]').val(info[0].teacher_idx);
					}
				});
			}else{
				$("#error_popup p").html("This is an elapsed schedule date. No permission to change.");
				$("#error_popup").dialog({
					title : "Error",
					width : 450,
					height : 150,
					modal:true
				});
			}
		}else if($("select[name=choose_class] option:selected").attr("status") == "deleted"){
			$("#error_popup p").html("This schedule is deleted.");
			$("#error_popup").dialog({
				title : "Error",
				width : 450,
				height : 150,
				modal:true
			});
		}else{
			$("#error_popup p").html("This schedule is already finished.");
			$("#error_popup").dialog({
				title : "Error",
				width : 450,
				height : 150,
				modal:true
			});
		}
	},
	saveScheduleStatus : function(){
		$("[name=editSchedStatus]").ajaxSubmit({
			url : common.getClassUrl("classScheduleClassList"),
			dataType : "html",
			data : 	{
						exec : "updateSingleSchedule",
						classId : $('[name=classId]').val(),
						date : $('[name=datestart]').val(),
						teacher : $('[name=teacherid]').val()
						
					},
			success : function(info){
				if(info==1){
					$("#change_popup").dialog('close');
					window.location.reload();
				}
			}
		});
	}
}

$("[name=saveSchedStatus]").click(function(){
	manageSchedule.saveScheduleStatus();
});

$("[name=uneditedSchedStatus]").click(function(){
	$("#error_popup").dialog('close');
});