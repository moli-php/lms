var timeIsClicked = 0;
var aTime = new Array();
var cmUnit = new Array();
var ulUnit = new Array();
var unit = new Array();
var month = "";
var year = "";
var gcheck = 0;
var gTotalDays = 0;
var genClassClick = 0;
var check_conflict = 0;

var classScheduleManage = {
	cmFirstCat : function()
	{
		var cm_first_cat = $("[name=cm_first_cat] option:selected").val();
		$.ajax({
			url : common.getClassUrl("classScheduleManageExecute"),
			dataType : "json",
			type : "POST",
			data : 	{
						exec : "getCmSecondCat",
						cmFirstCat : cm_first_cat
					}, 
			success : function(info){
				var sHtml = "";
				$.each(info, function(key, val){
				sHtml += "<option value="+val.fcategory_id+">"+val.fcategory_name+"</option>";
				});
				$("[name=cm_second_cat]").empty().append(sHtml);
			}
		});
	},

	ulFirstCat : function()
	{
		var ul_first_cat = $("[name=ul_first_cat]").val();
		$.ajax({
			url : common.getClassUrl("classScheduleManageExecute"),
			dataType : "json",
			type : "POST",
			data :	{
						exec : "getUlSecondCat",
						ulFirstCat : ul_first_cat
					},
			success : function(info){
				var sHtml = "";
				$.each(info, function(key, val){
				sHtml += "<option value='"+val.fcategory_id+"'>"+val.fcategory_name+"</option>";
				});
				$("[name=ul_second_cat]").empty().append(sHtml);
			}
		});
	},

	validate : function()
	{
		var iCheck = $("[name=class_day_check] input[type=checkbox]:checked").length;
		var classCount = parseInt($("[name=classCount]").val());
		var startDate = $("#period_startdate").val();
		var sTeacherType = $("[name=teacher_type]").val();
		var time_range = $("[name=time_range]").val();
		var sTime_col = "";
		var sTime_sched = "";
		var temp_sTime_col = "";
		var temp_sTime_sched = "";
		var aTime_range = time_range.split("-");
		var time_range1 = Number(aTime_range[0]);
		var time_range2 = Number(aTime_range[1]);
		var classTime = parseInt($("[name=class_time]").val());
		var dStartDate = new Date(startDate);
		var dToday = new Date();
		var dateDiff = dStartDate - dToday;
		var days = Math.round(dateDiff/(1000*60*60*24));
		var aClassdays = new Array();
		month = "";
		year = "";
		gCheck = 0;
		gTotalDays = 0;
		timeIsClicked = 0;
		aTime.length = 0;
		
		$("[name=time_sched] td").css("background-color", "");
		$(".schedule_calendar_popup").fadeOut();

		$.each($("[name=class_day_check] input[type=checkbox]:checked"), function(){
			aClassdays.push($(this).val());
		});

		if(iCheck == 0 && startDate == ""){
			$(".classday .not_found").html("This is required.");
			$(".startdate .not_found").html("This is required.");
		}if(iCheck==0 && startDate!=""){
			$(".classday .not_found").html("This is required."); 
		}if(iCheck!=0 && startDate==""){
			if(iCheck > classCount){
				$(".classday .not_found").html("This class requires to be attended for " + classCount + " days per week."); 
				$(".generated_schedule").fadeOut();
			}else{
				$(".classday .not_found").html(""); 
			}
			$(".startdate .not_found").html("This is required.");
		}if(iCheck!=0 && startDate!=""){
			if(iCheck > classCount){
				$(".classday .not_found").html("This class requires to be attended for " + classCount + " day/s per week."); 
				$(".generated_schedule").fadeOut();
			}else{
				$(".classday .not_found").html("");
				$(".not_found").html("");
				$.ajax({
					url : common.getClassUrl("classScheduleManageExecute"),
					dataType : "json",
					type : "POST",
					data : 	{
								exec : "getTeachers",
								type : sTeacherType
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
							
							for(var ctr=time_range1;ctr<=time_range2;ctr++){
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

							for(var ctr0=time_range1;ctr0<=time_range2;ctr0++){
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
										
										sTime_sched += "<td style='cursor:pointer' id='" + val.idx + "_" + timeClass + "' onclick='classScheduleManage.getTime(\""+val.idx+"\",\""+sCtr+"\",\""+sCtr0+"\", \"" + val.name + "\", \""+val.branch_idx+"\")'>" + time + "</td>";
										
									});
									sTime_sched += "</tr>";
								}
							}
							
							$(".sched_error").empty();
							$("[name=time_col]").empty().append(sTime_col);
							$("[name=time_sched]").empty().append(sTime_sched);		
							check = 1;
						}
					}
				});
				
				//check conflict with teacher schedule upon generating class
				$.ajax({
					url : common.getClassUrl("classScheduleManageExecute"),
					dataType : "json",
					type : "POST",
					data : 	{
								exec : "getTeacherSched",
								type : sTeacherType,
								datestart : $("#period_startdate").val(),
								classdays : aClassdays,
								totalmonths : $("[name=classMonths]").val(),
								totalDays : $("[name=class_day_check] input[type=checkbox]:checked").length
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
			$(".startdate .not_found").html("");
			
			if($("[name=ul_first_cat]").val() == "none"){
				//get units for class material
				$.ajax({
					url : common.getClassUrl("classScheduleManageExecute"),
					dataType : "json",
					type : "POST",
					data : 	{
								exec : "getCmUnit",
								secCat : $("[name=cm_second_cat]").val()
							},
					success : function(info){
						cmUnit = [];
						$.each(info, function(key, val){
							cmUnit.push(val.funit_id);
						});
					}
				});
			}else{
				//get units for uLearning
				$.ajax({
					url : common.getClassUrl("classScheduleManageExecute"),
					dataType : "json",
					type : "POST",
					data : 	{
								exec : "getCmUnit",
								secCat : $("[name=ul_second_cat]").val()
							},
					success : function(info){
						ulUnit = [];
						$.each(info, function(key, val){
							ulUnit.push(val.funit_id);
						});
					}
				});
			}
		}
	},

	getTime : function(user_id,ctr,ctr0,name,branch)
	{
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
				var iTotaldays = ($("[name=class_day_check] input[type=checkbox]:checked").length * 4) * parseInt($("[name=classMonths]").val());
				
				var timeClass = $("[name=time_sched]").find(idName).attr("class");
				month = aStartday[0];
				year = aStartday[2];
				gCheck = 1;
				gTotalDays = iTotaldays;
				cal.calendar(month,year,gCheck,gTotalDays, timeClass);
				
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
					var iTotaldays = ($("[name=class_day_check] input[type=checkbox]:checked").length * 4) * parseInt($("[name=classMonths]").val());
					
					var timeClass = $("[name=time_sched]").find(idName).attr("class");
					month = aStartday[0];
					year = aStartday[2];
					gCheck = 1;
					gTotalDays = iTotaldays;
					cal.calendar(month,year,gCheck,gTotalDays, timeClass);
					
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
				
				$.ajax({
					url : common.getClassUrl("classScheduleManageExecute"),
					dataType : "json",
					type : "POST",
					data : 	{
								exec : "getTeacherName",
								teacherId : user_id
							},
					success : function(info){
						$("[name=sched_info_teacher]").html(info[0].name);
					}
				});
				
				if($("[name=time_sched]").find(idName).attr("class") == "disabled"){
					check_conflict+=1;
					$("[name=sched_info_memo]").html("Conflict in schedule on the indicated red colored dates.");
				}else{
					$("[name=sched_info_memo]").html("");
				}
				$("[name=sched_info_timeRange]").html(startTimeRange + "~" + endTimeRange);
				
			}else{
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
	
	saveSchedule : function()
	{
		var sTeacherType = $("[name=teacher_type]").val();
		var aClassdays = new Array();
		var unitType = "";
		var totalDays = $("[name=class_day_check] input[type=checkbox]:checked").length;
		
		$.each($("[name=class_day_check] input[type=checkbox]:checked"), function(){
			aClassdays.push($(this).val());
		});
		
		$.each($(".generated_names tr td"), function(){
			if($(this).css("background-color") == "rgb(255, 255, 255)"){
				aTime.push($(this).attr("id"));
			}
		});
		
		//send data to php 
		if($("[name=ul_first_cat]").val() == "none"){
			unit = cmUnit;
			unitType = "classMaterial";
		}else{
			unit = ulUnit;
			unitType = "uLearning";
		}
		
		$.ajax({
			url : common.getClassUrl("classScheduleManageExecute"),
			dataType : "html",
			type : "POST",
			data : 	{
						exec : "saveSchedule",
						datestart : $("#period_startdate").val(),
						classdays : aClassdays,
						totalmonths : $("[name=classMonths]").val(),
						time : aTime,
						user : $("[name=uid]").val(),
						teacher : $("[name=teacher_name]").val(),
						oClass : $("[name=classIdx]").val(),
						unitType : unitType,
						units : unit,
						branch : $("[name=teacher_branch]").val(),
						totalDays : totalDays
					},
			success : function(info){
				if(info == 1){
					window.opener.location.reload(true);
					window.close();
				}
			}
		});
		
		$("[name=time_sched] td").css("background-color", "#D4DEF0");
		$(".schedule_calendar_popup").fadeOut();
	}
}

$("[name=cm_first_cat]").change(function(){
	classScheduleManage.cmFirstCat();
});

$("[name=ul_first_cat]").change(function(){
	classScheduleManage.ulFirstCat();
});

$("[name=generate_class]").click(function(){
	$(".generated_schedule").fadeIn();
	genClassClick = 1;
	classScheduleManage.validate();
});

$("[name=sched_cancel]").click(function(){
	month = "";
	year = "";
	gCheck = 0;
	gTotalDays = 0;
	timeIsClicked = 0;
	aTime.length = 0;
	
	$("[name=time_sched] td").css("background-color", "");
	$(".schedule_calendar_popup").fadeOut();
});

$("[name=sched_submit]").click(function(){
	if(check_conflict == 0){
		classScheduleManage.saveSchedule();
	}else{
		$(".sched_error").html("Time chosen conflicts with another schedule. Please choose another.");
		$(".schedule_calendar_popup").fadeOut();
	}
	
});

$("[name=time_range]").change(function(){
	if(genClassClick == 1){
		classScheduleManage.validate();
	}
});

$("#period_startdate").change(function(){
	if(genClassClick == 1){
		classScheduleManage.validate();
	}
});

$("[name=class_day_check]").click(function(){
	if(genClassClick == 1){
		classScheduleManage.validate();
	}
});

$(document).ready(function(){
	$(".schedule_calendar_popup").hide();
	$(".menu_curpage_breadcrumb").append("Generate New Schedule");
	$(".menu_title_breadcrumb").html("Generate New Schedule");
	$('#period_startdate').datepicker({
		constrainInput: true,
		showOn: 'button',
		buttonText: '<a class="btn_calendar" href="javascript:void(0);">Calendar</a>',
		minDate : new Date()
	}).click(function(){
		$(this).datepicker("show");
	});
	classScheduleManage.cmFirstCat();
});