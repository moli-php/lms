var classLevelTestSchedule = {
	createSchedule : function(){
		var result = $("#levelTestForm").validateForm();
		var sDate = $("#test_date").val();
		
		if (result === true){
			$.ajax({
				url : common.getClassUrl("classExecute"),
				dataType : "json",
				data : {
					exec : "getTeacher",
					testIdx : $("#test_idx").val(),
					type : $("#teacher_type").val(),
					date : sDate
				},
				success : function(aData){
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

					for (var i = range; i <= (range + 7); i++){
						for (var j = 0; j < 12; j++) {
							teacherTime += '<tr>';
							
							for (var k = 0; k < total; k++){
								var sTime = classLevelTestSchedule.stringPad(i, 2) + ':' + classLevelTestSchedule.stringPad((j * 5), 2);
								var generateTime = new Date(sDate + " " + sTime + ":00");
								var startTime = "00:00";
								var endTime = "00:00";

								if (aData.aSchedule[k].length > 0){
									startTime = aData.aSchedule[k][0]['time_start'];
									endTime = aData.aSchedule[k][aData.aSchedule[k].length - 1]['time_end'];
								}
			
								var background = sTime > startTime && sTime < endTime ? " cell_disabled" : ""; 
								
								teacherTime += '<td class="time_cell cell_' + i + '_' + j + '_' + k + background + '">' + sTime + '</td>';
							}
							
							teacherTime += '</tr>';
						}
					}

					$("#teacher_schedule").html(TRholder).append(teacherTime);
				}
			});
		}
	},
	
	stringPad : function(number, length) {
		var string = "" + number;
		while (string.length < length)
			string = '0' + string;

		return string;
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
});