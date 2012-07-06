var curMonth = $("[name=month]").val();
var curYear = $("[name=year]").val();

$(document).ready(function(){
	cal.calendar(curMonth,curYear,0);
	studentSched.getAllSchedule(curMonth,curYear);
});

var cal = {
	prev: function(val,month,year){
		var month = Number(month);
		var year = Number(year);
		var sMonth = "";
		
		if (val) {
			month = (month == 12) ? 1 : month + 1;	
		}
		else {
			month = (month == 1) ? 12 : month - 1;
			if(month == 12){
				year = year - 1;
			}
		}
		
		if(month<10){
			sMonth = "0" + month;
		}else{
			sMonth = month;
		}
		
		$("[name=month]").val(sMonth);
		cal.calendar(sMonth,year);
	},
	next: function(val,month,year){
		var month = Number(month);
		var year = Number(year);
		
		if (val) {
			month = (month == 12) ? 1 : month + 1;
			if(month == 1){
				year = year + 1;
			}
		}
		else {
			month = (month == 1 || month == undefined) ? 12 : month - 1;
		}
		
		if(month<10){
			sMonth = "0" + month;
		}else{
			sMonth = month;
		}
		
		$("[name=month]").val(sMonth);
		$("[name=year]").val(year);
		cal.calendar(sMonth,year);
	},	
	calendar: function(month,year){
		var htmlContent ="";
		var FebNumberOfDays ="";
		var counter = 1;	
		var nextMonth = Number(month); //+1; //Used to match up the current month with the correct start date.
		var prevMonth = Number(month) -1;

		//Determing if February (28,or 29)  
		if (parseInt(month) == 2){
			if ( (parseInt(year)%100!=0) && (parseInt(year)%4==0) || (parseInt(year)%400==0)){
				FebNumberOfDays = 29;
			}else{
				FebNumberOfDays = 28;
			}
		}
	
		// names of months and week days.
		var monthNames = ["January","February","March","April","May","June","July","August","September","October","November", "December"];
		var dayNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday", "Saturday"];
		var dayPerMonth = ["31", ""+FebNumberOfDays+"","31","30","31","30","31","31","30","31","30","31"]
		
		// days in previous month and next one , and day of week.
		var nextDate = new Date((monthNames[nextMonth - 1]) +" " + 22 + " , "+ year);
		var weekdays= nextDate.getDay();
		var addDay = weekdays;
		var weekdays2 = weekdays;
		var numOfDays = dayPerMonth[parseInt(month - 1)];
		
		// this leave a white space for days of pervious month.
		while (weekdays>0){
			htmlContent += "<td class='null'></td>";
			// used in next loop.
			weekdays--;
		}
		
		for(var ctr=counter;ctr<=numOfDays;ctr++){
			var sCtr = "";
			if (weekdays2 > 6){
				weekdays2 = 0;
				htmlContent += "</tr><tr>";			
			}
			if(ctr<10){
				sCtr = "0" + ctr;
			}else{
				sCtr = ctr;
			}
			
			htmlContent +="<td id="+year+"-"+month+"-"+sCtr+"><div class='date_content'><span>"+ctr+"</span></div></td>";
			weekdays2++;

		} 
		
		var totalDays;
		if(addDay >= 6){
			totalDays = 42 - (parseInt(numOfDays) + parseInt(addDay));
		}else{
			totalDays = 35 - (parseInt(numOfDays) + parseInt(addDay));
		}
		 if(totalDays <= 6 ){
			if(totalDays < 0){
					totalDays = 6;
			}
			 for(var endDay = 0; endDay <= totalDays - 1;endDay++){
				
				htmlContent += "<td class=null></td>";
			}
		}else{
			var aDate = [7,8,9,10,11,12,13];
		
			$.each(aDate,function(key,val){
				if(val == totalDays){
					totalDays = key;
				}
			});
			
			for(var endDay = 0; endDay <= totalDays - 1;endDay++){
				htmlContent += "<td class=null></td>";
			}
		}


		var calendarBody = "<tr>";
		calendarBody += htmlContent;
		calendarBody += "</tr>";

		$(".days").html(calendarBody);

		var calendarBody = "<tr>";
		calendarBody += htmlContent;
		calendarBody += "</tr>";

		$(".days").html(calendarBody);
		studentSched.getAllSchedule(month,year);
		
	}
}

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

var studentSched = {
	getAllSchedule : function(curMonth,curYear){
		$.ajax({
			url : common.getClassUrl("classScheduleCalendar"),
			dataType : "json",
			data : 	{
						exec : "getAllSchedule",
						year : curYear,
						month : curMonth,
						classId : $("[name=choose_class]").val()
					},
			success : function(info){
				$.each(info['schedule'], function(key, val){
					var sHtml = "";
					sHtml += "<div class='content-inside'>";
						sHtml += "<ul class='schedule_data'>";
							sHtml += "<li class='class_time'>"+val.time_start+"~"+val.time_end+"</li>";
							sHtml += "<li class='student_name'>"+val.teacher_name+"</li>";
							sHtml += "<li class='class_status'><a href='javascript:studentSched.editSchedStatus(\""+val.daystart+"\","+$("[name=choose_class]").val()+")' class='"+val.sched_status+"'>"+val.sched_status+"</a></li>";
						sHtml += "</ul>";
					sHtml += "</div>"; 
					$("#"+val.daystart + " .date_content").append(sHtml);
				});
				
				$.each(info['holiday'], function(key,val){
					var sHtml = "";
					sHtml += "<div class='content-inside'>";
						sHtml += "<p class='marker'>"+val.reason+"</p>";
					sHtml += "</div>"; 
					$("#"+val.ass_holiday).css({
						"background-color" : "#FDFF91",
						"color" : "#A8AFB7"
					});
					$("#"+val.ass_holiday + " .date_content").append(sHtml);
				});
			}
		});
	},
	editSchedStatus : function(date,classId){
		
		if($("select[name=choose_class] option:selected").attr("status") == "scheduled" || $("select[name=choose_class] option:selected").attr("status") == "cancelled"){
			var pDate = Date.parse(date);
			var cDate = Date.parse(new Date("2012-06-21"));
			var diff = Math.round((cDate - pDate) / 86400000);
			
			if(diff <= 0){
				$("[name=datestart]").val(date);
				$.ajax({
					url : common.getClassUrl("classScheduleCalendar"),
					dataType : "json",
					data : 	{
								exec : "getSingleSchedule",
								date : date,
								classId : classId
							},
					success : function(info){
						$("#change_popup").dialog({
							title : "Edit Schedule Status",
							width : 450,
							height : 350,
							modal:true
						});
						$("[name=teacherid]").val(info[0]['teacher_idx']);
						$("#editSchedStatTitle").html(info[0].teacher_name + " (" + info[0].daystart + " "+ info[0].time_start +"~"+info[0].time_end +") : " + $("select[name=choose_class] option:selected").html());
						$('[name=scheduleStatus]:radio[value="'+info[0].sched_status+'"]').attr('checked', 'checked');
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
	saveSchedStatus : function(){
		var newSchedStatus = $("[name=scheduleStatus]:checked").val();
		$("[name=editSchedStatus]").ajaxSubmit({
			url : common.getClassUrl("classScheduleCalendar"),
			dataType : "html",
			data : 	{
						exec : "updateSingleSchedule",
						date : $("[name=datestart]").val(),
						classId : $("[name=classId]").val(),
						teacher : $("[name=teacherid]").val()
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

var schedStatusTabs = {
		
		waiting : function(curMonth, curYear){
			$(".content-inside").empty();
			$.ajax({
				url : common.getClassUrl("classScheduleCalendar"),
				dataType : "json",
				data : 	{
							exec : "getWaitingSchedule",
							month : curMonth,
							year : curYear,
							classId : $("[name=choose_class]").val()
						},
				success : function(info){
					$.each(info, function(key, val){
						var sHtml = "";
						sHtml += "<div class='content-inside'>";
							sHtml += "<ul class='schedule_data'>";
								sHtml += "<li class='class_time'>"+val.time_start+"~"+val.time_end+"</li>";
								sHtml += "<li class='student_name'>"+val.teacher_name+"</li>";
								sHtml += "<li class='class_status'><a href='javascript:studentSched.editSchedStatus(\""+val.daystart+"\","+$("[name=choose_class]").val()+")' class='"+val.sched_status+"'>"+val.sched_status+"</a></li>";
							sHtml += "</ul>";
						sHtml += "</div>"; 
						$("#"+val.daystart + " .date_content").append(sHtml);
					});
				}
			});
		},
		attended : function(curMonth, curYear){
			$(".content-inside").empty();
			$.ajax({
				url : common.getClassUrl("classScheduleCalendar"),
				dataType : "json",
				data : 	{
							exec : "getAttendedSchedule",
							month : curMonth,
							year : curYear,
							classId : $("[name=choose_class]").val()
						},
				success : function(info){
					$.each(info, function(key, val){
						var sHtml = "";
						sHtml += "<div class='content-inside'>";
							sHtml += "<ul class='schedule_data'>";
								sHtml += "<li class='class_time'>"+val.time_start+"~"+val.time_end+"</li>";
								sHtml += "<li class='student_name'>"+val.teacher_name+"</li>";
								sHtml += "<li class='class_status'><a href='javascript:studentSched.editSchedStatus(\""+val.daystart+"\","+$("[name=choose_class]").val()+")' class='"+val.sched_status+"'>"+val.sched_status+"</a></li>";
							sHtml += "</ul>";
						sHtml += "</div>"; 
						$("#"+val.daystart + " .date_content").append(sHtml);
					});
				}
			});
		},
		absent : function(curMonth, curYear){
			$(".content-inside").empty();
			$.ajax({
				url : common.getClassUrl("classScheduleCalendar"),
				dataType : "json",
				data : 	{
							exec : "getAbsentSchedule",
							month : curMonth,
							year : curYear,
							classId : $("[name=choose_class]").val()
						},
				success : function(info){
					$.each(info, function(key, val){
						var sHtml = "";
						sHtml += "<div class='content-inside'>";
							sHtml += "<ul class='schedule_data'>";
								sHtml += "<li class='class_time'>"+val.time_start+"~"+val.time_end+"</li>";
								sHtml += "<li class='student_name'>"+val.teacher_name+"</li>";
								sHtml += "<li class='class_status'><a href='javascript:studentSched.editSchedStatus(\""+val.daystart+"\","+$("[name=choose_class]").val()+")' class='"+val.sched_status+"'>"+val.sched_status+"</a></li>";
							sHtml += "</ul>";
						sHtml += "</div>"; 
						$("#"+val.daystart + " .date_content").append(sHtml);
					});
				}
			});
		},
		cancelled : function(curMonth, curYear){
			$(".content-inside").empty();
			$.ajax({
				url : common.getClassUrl("classScheduleCalendar"),
				dataType : "json",
				data : 	{
							exec : "getCancelledSchedule",
							month : curMonth,
							year : curYear,
							classId : $("[name=choose_class]").val()
						},
				success : function(info){
					$.each(info, function(key, val){
						var sHtml = "";
						sHtml += "<div class='content-inside'>";
							sHtml += "<ul class='schedule_data'>";
								sHtml += "<li class='class_time'>"+val.time_start+"~"+val.time_end+"</li>";
								sHtml += "<li class='student_name'>"+val.teacher_name+"</li>";
								sHtml += "<li class='class_status'><a href='javascript:studentSched.editSchedStatus(\""+val.daystart+"\","+$("[name=choose_class]").val()+")' class='"+val.sched_status+"'>"+val.sched_status+"</a></li>";
							sHtml += "</ul>";
						sHtml += "</div>"; 
						$("#"+val.daystart + " .date_content").append(sHtml);
					});
				}
			});
		},
		postponed : function(curMonth, curYear){
			$(".content-inside").empty();
			$.ajax({
				url : common.getClassUrl("classScheduleCalendar"),
				dataType : "json",
				data : 	{
							exec : "getPostponedSchedule",
							month : curMonth,
							year : curYear,
							classId : $("[name=choose_class]").val()
						},
				success : function(info){
					$.each(info, function(key, val){
						var sHtml = "";
						sHtml += "<div class='content-inside'>";
							sHtml += "<ul class='schedule_data'>";
								sHtml += "<li class='class_time'>"+val.time_start+"~"+val.time_end+"</li>";
								sHtml += "<li class='student_name'>"+val.teacher_name+"</li>";
								sHtml += "<li class='class_status'><a href='javascript:studentSched.editSchedStatus(\""+val.daystart+"\","+$("[name=choose_class]").val()+")' class='"+val.sched_status+"'>"+val.sched_status+"</a></li>";
							sHtml += "</ul>";
						sHtml += "</div>"; 
						$("#"+val.daystart + " .date_content").append(sHtml);
					});
				}
			});
		}
}

$("[name=saveSchedStatus]").click(function(){
	studentSched.saveSchedStatus();
});

$("[name=uneditedSchedStatus]").click(function(){
	$("#error_popup").dialog('close');
});