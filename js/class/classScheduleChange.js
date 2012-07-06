var staticMonth = "";
var staticYear = "";
var check = 0;
var gTimeClass = "";

var timeIsClicked = 0;
var aTime = new Array();
var month = "";
var year = "";
var gcheck = 0;
var check_conflict = 0;

var schedToChange = "";
var studentId = 0;
var classId = 0;
var cancelDate = 0;
var cancelUser = 0;
var cancelClass = 0;

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
		calendar: function(month,year,check,timeClass){
			var aClassdays = new Array();
			aClassdays = $("[name=classdays]").val().split(",");
			$.ajax({
				url : common.getClassUrl("classScheduleChange"),
				dataType : "json",
				type : "POST",
				data : 	{
							exec : "getHolidays",
							type : $("select[name=teacher_type] option:selected").val(),
							datestart : $("[name=period_startdate]").val(),
							classdays : $("[name=classdays]").val(),
							userid : studentId,
							classid : classId
							
						},
				success : function(info){
					if(check == 1){
						var scheduleDate1 = info['schedule'][0].split("-");
						month = scheduleDate1[1];
						year = scheduleDate1[0];
					
						staticMonth = parseInt(month);
						staticYear = parseInt(year);
						gTimeClass = timeClass;
					}
					
					var htmlContent ="";
					var FebNumberOfDays ="";
					var counter = 1;	
					var nextMonth = Number(month); //+1; //Used to match up the current month with the correct start date.
					var prevMonth = Number(month) -1;
					
					var li = '<li class="prev"><a href = "javascript:void(0)" onClick=cal.prev(false,'+month+','+year+') title="Prev">Prev</a></li>';
					li +='<li class="date"></li>';
					li +='<li class="next"><a href = "javascript:void(0)" onClick=cal.next(true,'+month+','+year+') title="Next">Next</a></li>';
					
					$(".control").html(li);

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
						
						htmlContent +="<td id="+year+"-"+month+"-"+sCtr+">"+ctr+"</td>";
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
					$(".date").html("<span>"+monthNames[nextMonth - 1]+"</span>&nbsp;<span>"+parseInt(year)+"</span>");
							
							$.each(info['schedule'], function(key,val){
								
								$.each($(".days tr"), function(){
									if(gTimeClass == "disabled"){
										$(this).find("#" + val).addClass("conflict");
									}else{
										$(this).find("#" + val).addClass("assigned");
									}
								});
							});
							
							$.each(info['holiday'], function(key,val){
								
								$.each($(".days tr"), function(){
									$(this).find("#" + val).addClass("holiday");
								});
							});
							
							$.each(info['conflict'], function(key,val){
								
								$.each($(".days tr"), function(){
									$(this).find("#" + val).addClass("conflict");
								});
							});
							
							var lastSchedule = info['schedule'].length - 1;
							var classDaysDisplay = "";
							
							$.each(aClassdays, function(key, val){
								classDaysDisplay += dayNames[val] + " ";
							});
							
							$("[name=sched_info_schedDays]").html(info['schedule'][0] + " ~ " + info['schedule'][lastSchedule]);
							$("[name=sched_info_classDays]").html(classDaysDisplay);
				}
			});
		}
	}

var manageSchedule = {
	newScheduleInfo : function(date, user_id, class_id, class_days){
		schedToChange = date;
		studentId = user_id;
		classId = class_id;
		$(".product_search").fadeIn();
		$("[name=classdays]").val(class_days);
		$('html, body').animate({
			scrollTop: $(".product_search").offset().top
        }, 2000);

	},
	cancelSchedulePopup : function(date, user_id, class_id){
		cancelDate = date;
		cancelUser = user_id;
		cancelClass = class_id;
		$("#confirm_popup").dialog({
			title : "Cancel Class",
			width : 450,
			height : 150,
			modal:true
		});
	},
	cancelSchedule : function(date, user_id, class_id){
		$.ajax({
			url : common.getClassUrl("classScheduleChange"),
			dataType : "json",
			data : 	{
						exec : "cancelSingleSchedule",
						date : date,
						user_id : user_id,
						class_id : class_id
					},
			success : function(info){
				if(info){
					$("#confirm_popup").dialog('close');
					window.location.reload();
				}
			}
		});
	},
	changeSingleSchedule : function(){
		if($("#period_startdate").val() == ""){
			$(".not_found").html("This is required.");
		}else{
			$(".not_found").html("");
			var sTime_col = "";
			var temp_sTime_col = "";
			var sTime_sched = "";
			
			$.ajax({
				url : common.getClassUrl("classScheduleChange"),
				dataType : "json",
				type : "POST",
				data : 	{
							exec : "getTeachers",
							type : $("select[name=teacher_type] option:selected").val()
						},
				success : function(info){
					if(info == null){
						$("[name=time_col]").empty();
						$("[name=time_sched]").empty();
						$(".sched_error").html("No availabe teachers.");
					}else{
						sTime_col += "<colgroup><col width='60px' /><col width='40px' /></colgroup>";
						sTime_col += "<tr><th colspan='2'>TIME</th></tr>";
						
						for(var ctr=5;ctr<=55;ctr+=5){
							temp_sTime_col += "<tr><td>"+ctr+"</td></tr>";
						}
						
						for(var ctr=0;ctr<=23;ctr++){
							if(ctr<10){ctr = "0" + ctr;}
							sTime_col += "<tr><th rowspan='12' class='time_hour'>"+ctr+"</th>";
							sTime_col += "<td>00</td></tr>";
							sTime_col += temp_sTime_col;
						}

						sTime_sched += "<tr>";
						$.each(info, function(key, val){
							sTime_sched += "<th width='120px' id='"+val.user_id+"'>"+val.name+"</th>";
						});
						sTime_sched += "</tr>";

						for(var ctr0=0;ctr0<=23;ctr0++){
							var sCtr0 = ctr0.toString();
							if(sCtr0.length < 2){sCtr0 = "0" + sCtr0;}
							if(ctr0<10 && ctr0 > 0){ctr0 = "0" + ctr0;}
							for(var ctr=0;ctr<=55;ctr+=5){
								var sCtr = ctr.toString();
								if(sCtr.length < 2){sCtr = "0" + sCtr;}
								sTime_sched += "<tr>";
								$.each(info, function(key,val){
									var time = sCtr0+":"+sCtr;
									var timeClass = sCtr0 + "_" + sCtr;
									
									sTime_sched += "<td style='cursor:pointer' id='" + val.idx + "_" + timeClass + "' onclick='manageSchedule.getTime(\""+val.idx+"\",\""+sCtr+"\",\""+sCtr0+"\", \"" + val.name + "\", \""+val.branch_idx+"\")'>" + time + "</td>";
									
								});
								sTime_sched += "</tr>";
							}
						}
						
						$(".sched_error").empty();
						$("[name=time_col]").empty().append(sTime_col);
						$("[name=time_sched]").empty().append(sTime_sched);		
						$(".generated_schedule").fadeIn();

						$('html, body').animate({
							scrollTop: $(".product_search").offset().top
					    }, 2000);
					}
				}
			});
			
			//check conflict with teacher schedule upon generating class
			$.ajax({
				url : common.getClassUrl("classScheduleChange"),
				dataType : "json",
				type : "POST",
				data : 	{
							exec : "getTeacherSched",
							type : $("select[name=teacher_type] option:selected").val(),
							datestart : $("#period_startdate").val(),
							classdays : $("[name=classdays]").val()
						},
				success : function(info){
					if(info){
						$.each(info , function(key, infoVal){
							$.each(infoVal, function(key, val){
								var teacherId = val.teacher_idx;
								//schedule 
								var schedTimeStart = val.sched_time_start.replace(":", "_");
								var schedTimeEnd = val.sched_time_end.replace(":", "_");
								var classDays = val.class_days;
								var schedDate = val.daystart;
								var levelTestDate = val.date_test;
								var schedStartId = "#" + teacherId + "_" + schedTimeStart;
								var aSchedTimeStart = val.sched_time_start.split(":");
								var schedMinutes = aSchedTimeStart[1];
								var schedHour = aSchedTimeStart[0];
								var schedConvertedTimestart = (Number(val.sched_time_start.split(':')[0])*60+Number(val.sched_time_start.split(':')[1]))*60;
								var schedConvertedTimeend = (Number(val.sched_time_end.split(':')[0])*60+Number(val.sched_time_end.split(':')[1]))*60;
								var schedDifference = schedConvertedTimeend - schedConvertedTimestart;
								schedDifference /= 60; 
								
								switch(schedDifference)
								{
									case 5 		: 	schedCtr = 0; break;
									case 10 	:	schedCtr = 1; break;
									case 15 	:	schedCtr = 2; break;
									case 20		: 	schedCtr = 3; break;
									case 25		:	schedCtr = 4; break;
									case 30		:	schedCtr = 5; break;
									case 35		: 	schedCtr = 6; break;
									case 40		:	schedCtr = 7; break;
									case 45		:	schedCtr = 8; break;
									case 50		:	schedCtr = 9; break;
									case 55		:	schedCtr = 10; break;
									case 60		: 	schedCtr = 11; break;
								}
								
								$("[name=time_sched]").find(schedStartId).addClass("disabled");
								
								for(var ctr=0;ctr<schedCtr;ctr++){
									schedMinutes = parseInt(schedMinutes) + 5;
									if(schedMinutes == 60){
										schedHour = parseInt(schedHour) + 1;
										schedMinutes = 0;
										if(schedHour < 10){
											schedHour = "0" + schedHour;
										}
									}
									if(schedMinutes < 10){
										schedMinutes = "0" + schedMinutes;
									}else{
										schedMinutes = schedMinutes;
									}
									
									var schedConflictId = "#" + val.teacher_idx + "_" + schedHour + "_" + schedMinutes;
									
									$("[name=time_sched]").find(schedConflictId).addClass("disabled");
								}
								
								//level test
								if(val.time_start){
									var levelTestTimeStart = val.time_start.replace(":", "_");
									var levelTestTimeEnd = val.time_end.replace(":", "_");
									var levelTestStartId = "#" + teacherId + "_" + levelTestTimeStart;
									var aLevelTestTimeStart = val.time_start.split(":");
									var levelTestMinutes = aLevelTestTimeStart[1];
									var levelTestHour = aLevelTestTimeStart[0];
									var levelTestConvertedTimestart = (Number(val.time_start.split(':')[0])*60+Number(val.time_start.split(':')[1]))*60;
									var levelTestConvertedTimeend = (Number(val.time_end.split(':')[0])*60+Number(val.time_end.split(':')[1]))*60;
									var levelTestDifference = levelTestConvertedTimeend - levelTestConvertedTimestart;
									levelTestDifference /= 60; 
									
									switch(levelTestDifference)
									{
										case 5 		: 	levelTestCtr = 0; break;
										case 10 	:	levelTestCtr = 1; break;
										case 15 	:	levelTestCtr = 2; break;
										case 20		: 	levelTestCtr = 3; break;
										case 25		:	levelTestCtr = 4; break;
										case 30		:	levelTestCtr = 5; break;
										case 35		: 	levelTestCtr = 6; break;
										case 40		:	levelTestCtr = 7; break;
										case 45		:	levelTestCtr = 8; break;
										case 50		:	levelTestCtr = 9; break;
										case 55		:	levelTestCtr = 10; break;
										case 60		: 	levelTestCtr = 11; break;
									}
									
									$("[name=time_sched]").find(levelTestStartId).addClass("disabled");
									
									for(var ctr=0;ctr<levelTestCtr;ctr++){
										levelTestMinutes = parseInt(levelTestMinutes) + 5;
										if(levelTestMinutes == 60){
											levelTestHour = parseInt(levelTestHour) + 1;
											levelTestMinutes = 0;
											if(levelTestHour < 10){
												levelTestHour = "0" + levelTestHour;
											}
										}
										if(levelTestMinutes < 10){
											levelTestMinutes = "0" + levelTestMinutes;
										}else{
											levelTestMinutes = levelTestMinutes;
										}
										
										var levelTestConflictId = "#" + val.teacher_idx + "_" + levelTestHour + "_" + levelTestMinutes;
										
										$("[name=time_sched]").find(levelTestConflictId).addClass("disabled");
									}
								}
							});
						});
					}
				}
			});
		}
	},
	getTime : function(user_id,ctr,ctr0,name,branch){
		if(timeIsClicked == 0){
			$("[name=teacher_name]").val(name);
			$("[name=teacher_branch]").val(branch);
			timeIsClicked = 1;
			var startTimeRange = ctr0 + ":" + ctr;
			var endTimeRange = "";
			var classTime = $("[name=class_time]").val();
			var idName = "#" + user_id + "_" + ctr0 +"_"+ctr;
			var iCtr = 0;
			check_conflict = 0;
			var mCtr = ctr;
			var hCtr = ctr0;
			var eCtr = parseInt(ctr);
			var eCtr0 = parseInt(ctr0);
			
			switch(classTime)
			{
				case "5"	: 	iCtr = -1; break;
				case "10" 	:	iCtr = 0; break;
				case "15" 	:	iCtr = 1; break;
				case "20"	: 	iCtr = 2; break;
				case "25"	:	iCtr = 3; break;
				case "30"	:	iCtr = 4; break;
				case "35"	: 	iCtr = 5; break;
				case "40"	:	iCtr = 6; break;
				case "45"	:	iCtr = 7; break;
				case "50"	:	iCtr = 8; break;
				case "55"	:	iCtr = 9; break;
				case "60"	: 	iCtr = 10; break;
			}
			
			if($("[name=time_sched]").find(idName).attr("class") != "disabled"){
				$("[name=time_sched]").find(idName).css("background-color", "#FFFFFF");
			}
			
			if(iCtr == -1){
				var x = $("[name=time_sched]").find(idName).offset().left + 130;
				var y = $("[name=time_sched]").find(idName).offset().top - (20 * iCtr);
				
				$(".schedule_calendar_popup").fadeIn().css({
					top : y,
					left : x
				});
				$(".schedule_info_popup").fadeIn().css({
					left : x + 170,
					height : 183
				});
				
				var startday = $("[name=period_startdate]").val();
				var aStartday = startday.split("/");
				
				var timeClass = $("[name=time_sched]").find(idName).attr("class");
				month = aStartday[0];
				year = aStartday[2];
				gCheck = 1;
				cal.calendar(month,year,gCheck,timeClass);
				
				//display end time range
				eCtr = eCtr + 5;
				if(eCtr == 60){
					eCtr = 0;
					eCtr0 = eCtr0 + 1;
				}
				if(eCtr < 10){
					eCtr = "0" + eCtr;
				}
				endTimeRange = eCtr0 + ":" + eCtr;
			}
			
			for(var i=0;i<=iCtr;i++){
				ctr = parseInt(ctr) + 5;
				var sCtr = ctr.toString();
				if(sCtr == "60"){
					ctr0 = parseInt(ctr0) + 1; 
					ctr = 0;
					sCtr = "00";
				}
				
				var sCtr0 = ctr0.toString();
				if(sCtr.length < 2){
					sCtr = "0" + sCtr;
				}
				if(sCtr0.length < 2){
					sCtr0 = "0" + sCtr0;
				}
				
				idName = "#" + user_id + "_" + sCtr0 +"_"+sCtr;
				
				
				if($("[name=time_sched]").find(idName).attr("class") == "disabled"){
					check_conflict+=1;
					$("[name=sched_info_memo]").html("Conflict in schedule on the indicated red colored dates.");
				}
				
			}
			
			if(check_conflict == 0){
				for(var i=0;i<=iCtr;i++){
					mCtr = parseInt(mCtr) + 5;
					var sCtr = mCtr.toString();
					if(sCtr == "60"){
						hCtr = parseInt(hCtr) + 1; 
						mCtr = 0;
						sCtr = "00";
					}
					
					var sCtr0 = hCtr.toString();
					if(sCtr.length < 2){
						sCtr = "0" + sCtr;
					}
					if(sCtr0.length < 2){
						sCtr0 = "0" + sCtr0;
					}
					
					idName = "#" + user_id + "_" + sCtr0 +"_"+sCtr;
					
					$(".sched_error").html("");
					if($("[name=time_sched]").find(idName).attr("class") != "disabled"){
						$("[name=time_sched]").find(idName).css("background-color", "#FFFFFF");
					}
					
					var x = $("[name=time_sched]").find(idName).offset().left + 130;
					var y = $("[name=time_sched]").find(idName).offset().top - (20 * iCtr);
					
					$(".schedule_calendar_popup").fadeIn().css({
						top : y,
						left : x
					});
					$(".schedule_info_popup").fadeIn().css({
						left : x + 170,
						height : 183
					});
					
					var startday = $("[name=period_startdate]").val();
					var aStartday = startday.split("/");
					
					var timeClass = $("[name=time_sched]").find(idName).attr("class");
					month = aStartday[0];
					year = aStartday[2];
					gCheck = 1;
					cal.calendar(month,year,gCheck,timeClass);
					
					//display end time range
					eCtr = eCtr + 5;
					if(eCtr == 60){
						eCtr =  0;
						eCtr0 = eCtr0 + 1;
					}
					if(i==iCtr){
						eCtr = eCtr + 5;
						if(eCtr == 60){
							eCtr =  0;
							eCtr0 = eCtr0 + 1;
						}
						if(eCtr < 10){
							eCtr = "0" + eCtr;
						}
					}
					
					endTimeRange = eCtr0 + ":" + eCtr;
				}
				if($("[name=time_sched]").find(idName).attr("class") == "disabled"){
					check_conflict+=1;
					$("[name=sched_info_memo]").html("Conflict in schedule on the indicated red colored dates.");
				}else{
					$("[name=sched_info_memo]").html("");
				}
				$("[name=sched_info_timeRange]").html(startTimeRange + "~" + endTimeRange);
				
			}else{
				alert(1);
				month = "";
				year = "";
				gCheck = 0;
				gTotalDays = 0;
				timeIsClicked = 0;
				aTime.length = 0;
				
				$(".sched_error").html("Time chosen conflicts with another schedule. Please choose another.");
				$("[name=time_sched] td").css("background-color", "");
			}
		}
	},
	saveNewSchedule : function()
	{
		var sTeacherType = $("[name=teacher_type]").val();
		var aClassdays = $("[name=classdays]").val();
		
		$.each($("[name=class_day_check] input[type=checkbox]:checked"), function(){
			aClassdays.push($(this).val());
		});
		
		$.each($(".generated_names tr td"), function(){
			if($(this).css("background-color") == "rgb(255, 255, 255)"){
				aTime.push($(this).attr("id"));
			}
		});
		
		//send data to php 
		$.ajax({
			url : common.getClassUrl("classScheduleChange"),
			dataType : "html",
			type : "POST",
			data : 	{
						exec : "saveSchedule",
						datestart : $("#period_startdate").val(),
						classdays : aClassdays,
						time : aTime,
						user : $("[name=userid]").val(),
						oClass : $("[name=classid]").val(),
						dateToChange : schedToChange
					},
			success : function(info){
				if(info == 1){
					window.location.reload(true);
				}
			}
		});
		
		$("[name=time_sched] td").css("background-color", "#D4DEF0");
		$(".schedule_calendar_popup").fadeOut();
	}
}

$("[name=editSchedInfo]").click(function(){
	manageSchedule.changeSingleSchedule();
});

$("[name=sched_cancel]").click(function(){
	month = "";
	year = "";
	gCheck = 0;
	timeIsClicked = 0;
	aTime.length = 0;
	
	$("[name=time_sched] td").css("background-color", "");
	$(".schedule_calendar_popup").fadeOut();
});

$("[name=sched_submit]").click(function(){
	if(check_conflict == 0){
		manageSchedule.saveNewSchedule();
	}else{
		$(".sched_error").html("Time chosen conflicts with another schedule. Please choose another.");
		$(".schedule_calendar_popup").fadeOut();
	}
});

$("[name=noConfirmCancel]").click(function(){
	$("#confirm_popup").dialog('close');
});

$("[name=confirmCancel]").click(function(){
	manageSchedule.cancelSchedule(cancelDate, cancelUser, cancelClass);
});

$(document).ready(function(){
	$('#period_startdate').datepicker({
		constrainInput: true,
		showOn: 'button',
		buttonText: '<a class="btn_calendar" href="javascript:void(0);">Calendar</a>',
		minDate : new Date()
	}).click(function(){
		$(this).datepicker("show");
	});
});