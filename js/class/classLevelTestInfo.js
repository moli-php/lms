var testIdx = $("#test_idx").val()

var classLevelTestInfo = {
	createSchedule : function(idx){
		$("#teacher_schedule, #schedule_hours, #error_message").empty();
		$("#classLevelSchedulePopup").dialog({
			modal: common.dialogModal,
			draggable: common.dialogDraggable,
			closeOnEscape: common.dialogCloseOnEscape,
			minWidth : 1000,
			height: 700,
			title : "Create Level Test Schedule",
			open : function(){
				classLevelTestSchedule.createSchedule();
			},
			buttons : {
				Submit : function(){
					if (classLevelTestSchedule.timeStart == "" && classLevelTestSchedule.timeEnd == "" && classLevelTestSchedule.teacherIdx == 0){
						$("#teacher_schedule, #schedule_hours").empty();
						$("#error_message").text("Please select date of schedule.");
						return false;
					}
					
					var result = $("#levelTestForm").validateForm();

					if (result === true){
						$("#levelTestForm").ajaxSubmit({
							url : common.getClassUrl("classExecute"),
							dataType : "html",
							data : {
								exec : "saveSchedule",
								idx : testIdx,
								timeStart : classLevelTestSchedule.timeStart,
								timeEnd : classLevelTestSchedule.timeEnd,
								teacherIdx : classLevelTestSchedule.teacherIdx
							},
							success : function(aData){
								if (aData == "1"){
									window.location.reload();
								} else {
									common.message('warning', "Saving failed!");
								}
							}
						});
					}
				},
				Generate : function(){
					classLevelTestSchedule.createSchedule();
				},
				Cancel : function(){
					$(this).dialog("close");
				}
			}
		});
	},
	
	saveResult : function(){
		var result = $("#testForm").validateForm();
		
		if (result === true){
			$("#testForm").ajaxSubmit({
				url : common.getClassUrl("classExecute"),
				dataType : "html",
				data : {
					exec :  "saveTestResult",
					testIdx : testIdx
				},
				success : function(aData){
					if (aData == "1"){
						window.location.reload();
					} else {
						common.message('warning', "Saving failed!");
					}
				}
			});
		}
	},
	
	changeLevelTest : function(idx){
		var sUrl = common.getClassUrl("classLevelTestInfo");
	
		$.each(common.getUrlParameters(), function(key, val){
            if (key != "action" && key != "testIdx") sUrl += "&" + key + "=" + val;
        });
	
		window.location.href = sUrl + "&testIdx=" + idx;
	},
	
	verifyDelete : function(){
		common.createDialog("verifyDelete", "Are you sure you wan't to delete this schedule?")
		
		$("#verifyDelete").dialog({
			modal: common.dialogModal,
			resizable: common.dialogResizable,
			draggable: common.dialogDraggable,
			closeOnEscape: common.dialogCloseOnEscape,
			title : "Delete Schedule",
			buttons : {
				Yes : function(){
					$.ajax({
						url : common.getClassUrl("classExecute"),
						data : {
							exec : "deleteSchedule",
							idx : testIdx
						},
						success : function(aData){
							if (aData == "1"){
								window.location.reload();
							} else {
								common.message('warning', "Saving failed!");
							}
						}
					})
				},
				No : function(){
					$(this).dialog("close");
				}
			}
		});
	}
};

var classLevelTestSchedule = {
	timeStart : "",
	timeEnd : "",
	teacherIdx : 0,
	
	createSchedule : function(){
		$("#teacher_schedule, #schedule_hours, #error_message").empty();
		var result = $("#levelTestForm").validateForm();
		var sDate = $("#test_date").val();
		
		if (result === true){
			$.ajax({
				url : common.getClassUrl("classExecute"),
				dataType : "json",
				data : {
					exec : "getTeacher",
					testIdx : testIdx,
					type : $("#teacher_type").val(),
					date : sDate
				},
				success : function(aData){
					if (aData.aTest.length > 0 && aData.aHoliday == 0){
						var range = parseInt($("#time_range").val());
						var string = '<tr><th colspan="2">TIME</th></tr>';
						
						for (var i = range; i <= (range + 7); i++){
							string += '<tr><th class="time_hour" rowspan="12">' + classLevelTestSchedule.stringPad(i, 2) + '</th><td>00</td></tr>';
							
							for (var j = 1; j < 12; j++)
								string += '<tr><td>' + classLevelTestSchedule.stringPad((j * 5), 2) + '</td></tr>';
						}

						$("#schedule_hours").html(string);
						
						var TRholder = $("<tr></tr>");
						var teacherTime = "";
						
						$.each(aData.aTest, function(key, val){
							TRholder.append('<th>' + val.name + '</th>');
						});
						
						var total = aData.aTest.length;
						var row = 1;

						for (var i = range; i <= (range + 7); i++){
							for (var j = 0; j < 12; j++) {
								teacherTime += '<tr>';
								
								for (var k = 0; k < total; k++){
									var sTime = classLevelTestSchedule.stringPad(i, 2) + ':' + classLevelTestSchedule.stringPad((j * 5), 2);
									var background = "";
									
									if (aData.aSchedule[k].length > 0){
										$.each(aData.aSchedule[k], function(key, val){
											if (sTime >= val.time_start && sTime <= classLevelTestSchedule.manageMinute(val.time_end, 5)){
												background = val.tablename == "test" && testIdx == val.idx ? " cell_reserved" : " cell_disabled";
											}
										});
									}

									teacherTime += '<td class="time_cell cell_' + aData.aTest[k]['idx'] + '_' + i + '_' + (j * 5) + background + '">' + sTime + '</td>';
								}
								
								teacherTime += '</tr>';
								row++;
							}
						}

						$("#teacher_schedule").html(TRholder).append(teacherTime);
					} else if (aData.aHoliday > 0){
						$("#error_message").text("The selected date is holiday.");
					} else
						$("#error_message").text("No data found.");
				}
			});
		}
	},
	
	stringPad : function(number, length) {
		var string = "" + number;
		while (string.length < length)
			string = '0' + string;

		return string;
	},
	
	manageMinute : function(time, deduct){
		var aTime = time.split(":");
		var iHour = aTime[0];
		var iMinute = aTime[1];
		
		iMinute = iMinute - deduct;
		
		if (iMinute < 0){
			iMinute = 55;
			iHour--;
		}

		return this.stringPad(iHour, 2) + ":" + this.stringPad(iMinute, 2);
	}
};

$(document).ready(function(){
	$("#test_date").datepicker({
		dateFormat : 'yy-mm-dd',
		constrainInput: true,
        showOn: 'button',
        buttonText: '<a class="btn_calendar" href="javascript:void(0);">Calendar</a>'
	}).click(function(){
		$(this).datepicker("show");
	});
	
	$(".time_cell").live("click", function(){
		$(".time_cell").removeClass("cell_active cell_modify");
		var conflict = false;
		var aCell = $(this).attr("class").split(" ")[1].replace("cell_", "").split("_");
		var time = $("#test_time").val();
		var hour = parseInt(aCell[1]);
		var minute = parseInt(aCell[2]);
		var count = 1;
		classLevelTestSchedule.timeStart = classLevelTestSchedule.stringPad(aCell[1], 2) + ":" + classLevelTestSchedule.stringPad(aCell[2], 2);
		
		for (var i = 0; i < (time / 5); i++) {
			if (minute > 55){
				minute = 5;
				hour++;
			} else {
				minute += 5;
			}
			
			var cell = $(".cell_" + aCell[0] + "_" + hour + "_" + (minute - 5));
		
			if (cell.hasClass("cell_disabled")){	
				conflict = true;
				common.reportError("Time conflict.", function(){
					$(".time_cell").removeClass("cell_active");
				});
				return false;
			} else if (cell.hasClass("cell_reserved")){	
				cell.addClass("cell_modify");
			} else
				cell.addClass("cell_active");	

			classLevelTestSchedule.timeEnd = classLevelTestSchedule.stringPad((minute > 55 ? hour + 1 : hour), 2) + ":" + classLevelTestSchedule.stringPad((minute > 55 ? 0 : minute), 2);				
			classLevelTestSchedule.teacherIdx = aCell[0];
			
			if (classLevelTestSchedule.timeEnd > "23:55"){
				common.reportError("Invalid Time.", function(){
					$(".time_cell").removeClass("cell_active");
				});
			}
		}
	});
	
	if ($.trim($(".menu_curpage_breadcrumb").text()) == ">"){
		var sClass = "classList";
		var title = "Level Test Info" ;
		$("." + sClass).find("a").addClass("current");
		$(".menu_curpage_breadcrumb").html('> <a href="' + common.getClassUrl(sClass) + '">' + title + '</a>');
		$(".breadcrumb").append('<li>> ' + (common.getUrlParameter("action") == (sClass + "Add") ? "Add New" : "Edit") + ' ' + title + '</li>');
	}
});