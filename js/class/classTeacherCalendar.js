var classCalendar = {
	storedDate : "",
	status : "",
	queryStatus : true,
	
	loadCalendar : function(action){
		if (!action)
			action = "current";
		
		if (this.queryStatus === true){
			this.queryStatus = false;
			$.ajax({
				url : common.getClassUrl("classCalendar"),
				dataType : "json",
				data : {
					exec : "getCalendarData",
					date : $("#class_calendar").val(),
					changeAction : action,
					status : classCalendar.status
				},
				success : function(aData){
					var string = ""
				
					for (var i = 0; i <= 23; i++){
					
					var tTime = classCalendar.stringPad(i, 2) + ":00";
					
					string += '<tr><th>' + tTime + '</th>';
					
						$.each(aData.aTeacher, function(key, value){
							string += '<td>';
							if (value.aClass.length > 0){	
								string += '<ul class="class_calendar_entry">';
									
									$.each(value.aClass, function(newKey, aNewValue){
										var tStart = aNewValue.time_start;
										var tEnd = aNewValue.time_end;
										var statusCss = "";

										if (tStart >= tTime && tEnd <= classCalendar.stringPad((i + 1), 2) + ":00"){
											switch (aNewValue.sched_status){
												case "2" :
												case "attended" : 
													aNewValue.sched_status = "attend";
													statusCss = "attend";
													break;
												case "1" :
												case "waiting" :
													aNewValue.sched_status = "waiting";
													statusCss = "waiting";
													break;
												case "cancelled" :
													statusCss = "canceled";
													break;
												case "absent" :
													statusCss = "absent";
													break;
												case "posponed" :
													statusCss = "postponed";
													break;
												case "noclass" :
													statusCss = "no_class2";
													break;
											}
										
											string += '<li>';
												string += '<p><span class="icon ' + (aNewValue.stype == "class" ? "normal" : "level_test") + '">' + (aNewValue.stype == "class" ? "N" : "L") + '</span><span class="icon ' + statusCss + '">' + aNewValue.sched_status.charAt(0).toUpperCase() + '</span></p>';
												string += '<p><strong>' + aNewValue.name + '</strong></p>';
												string += '<p>(' + tStart + ') ~ (' + tEnd + ')</p>';
											string += '</li>';
										}
									});
								
								string += '</ul>';
							}
							string += '</td>';
						});
						string += '</tr>';
					}

					$("#class_calendar").val(aData.date);
					$("#schedule_body").html(string);
					
					$(".aside").css("height",$(".wrap").height());
					classCalendar.queryStatus = true;
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
	$("#class_calendar").datepicker({
		dateFormat : 'yy-mm-dd',
		constrainInput: true,
        showOn: 'button',
        buttonText: '<a class="btn_calendar" href="javascript:void(0);">Calendar</a>',
		onSelect: function(dateText) {
			classCalendar.loadCalendar();
		}
	}).click(function(){
		$(this).datepicker("show");
	});
	
	classCalendar.loadCalendar();
	
	$(document).unbind("keydown.calendar").bind("keydown.calendar", function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		var code = {left:37, right:39};
		switch (keycode) {
			case code.left:
				event.preventDefault();
				classCalendar.loadCalendar("prev");
				break;
			case code.right:
				event.preventDefault();
				classCalendar.loadCalendar("next");
				break;
		}
	});
});