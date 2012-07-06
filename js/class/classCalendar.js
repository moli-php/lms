var dateNow = new Date();
var currentMonth = dateNow.getMonth() + 1;
var currentYear = dateNow.getFullYear();
var month = dateNow.getMonth();
var day = dateNow.getDate();
var dayVal = dateNow.getDay();
var year = dateNow.getFullYear();
var staticMonth = "";
var staticYear = "";
var check = 0;
var iTotalDays = 0;
var gTimeClass = "";

$(document).ready(function(){
	cal.calendar(month,year,0);
});

var cal = {
	prev: function(val,month,year){
		if (val) {
			month = (month == 12) ? 1 : month + 1;	
		}
		else {
			month = (month == 1) ? 12 : month - 1;
			if(month == 12){
				year = year - 1;
			}
		}
		cal.calendar(month,year);
	},
	next: function(val,month,year){
		if (val) {
			month = (month == 12) ? 1 : month + 1;
			if(month == 1){
				year = year + 1;
			}
		}
		else {
			month = (month == 1 || month == undefined) ? 12 : month - 1;
		}
		cal.calendar(month,year);
	},	
	calendar: function(month,year,check,iTotaldays,timeClass){
		// get checked class day
		var aClassdays = new Array();
		$("[name=class_day_check] input[type=checkbox]:checked").each(function(){
			aClassdays.push($(this).val());
		});
		
		$.ajax({
			url : common.getClassUrl("classScheduleManageExecute"),
			dataType : "json",
			type : "POST",
			data : 	{
						exec : "getHolidays",
						type : $("[name=teacher_type]").val(),
						datestart : $("[name=period_startdate]").val(),
						totalDays : $("[name=classCount]").val(),
						totalmonths : $("[name=classMonths]").val(),
						classdays : aClassdays
						
					},
			success : function(info){
				if(check == 1){
					var scheduleDate1 = info['schedule'][0].split("-");
					month = scheduleDate1[1];
					year = scheduleDate1[0];
					
					staticMonth = Number(month);
					staticYear = Number(year);
					iTotalDays = Number(iTotaldays);
					gTimeClass = timeClass;
				}
		
				var li = '<li class="prev"><a href = "javascript:void(0)" onClick=cal.prev(false,'+month+','+year+') title="Prev">Prev</a></li>';
				li +='<li class="date"></li>';
				li +='<li class="next"><a href = "javascript:void(0)" onClick=cal.next(true,'+month+','+year+') title="Next">Next</a></li>';
				
				$(".control").html(li);
				
				
				var selDate = $("#period_startdate").val(); // selected date
				var myArray = selDate.split('/');
		
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
				// get start day
				var startday = $("[name=period_startdate]").val();
				var aStartday = startday.split("/");
				
				var mm = nextMonth + 1;
				var ndays = numOfDays;
				
				var ddGet =  parseInt(dayVal) + 1;
				var strings = "";
				
				for(var ddays = 1; ddays <= ndays; ddays++){
					if(ddays % 7 == 0){
						strings += ddays+"<br>";
					}else{
						strings += ddays;
					}
					
				}
				
				// this leave a white space for days of pervious month.
				while (weekdays>0){
					htmlContent += "<td class=null></td>";
					// used in next loop.
					weekdays--;
				}
				
				for(var ctr=counter;ctr<=numOfDays;ctr++){
					if (weekdays2 > 6){
						weekdays2 = 0;
						htmlContent += "</tr><tr>";			
					}
		
					htmlContent +="<td>"+ctr+"</td>";
					weekdays2++;
		
				} 
		
				var totalDays;
				if(addDay >= 5){
					totalDays = 42 - (parseInt(numOfDays) + parseInt(addDay));
				}else{
					totalDays = 35 - (parseInt(numOfDays) + parseInt(addDay));
				}
				for(var endDay = totalDays; endDay >= 0;endDay--){
					htmlContent += "<td class=null></td>";
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
		
				var iStartday = Number(aStartday[1]);
				var totalMonth = parseInt($("input[name=classMonths]").val());
				var endMonth = staticMonth + totalMonth;
						
						$.each(info['schedule'], function(key,val){
							var scheduleDate = val;
							scheduleDate = scheduleDate.split("-");
							var scheduleYear = Number(scheduleDate[0]);
							var scheduleMonth = Number(scheduleDate[1]);
							var scheduleDay = Number(scheduleDate[2]);
							
							$.each($(".days tr"), function(){
								for(var classday=0;classday<aClassdays.length;classday++){
									if($(this).children().eq(aClassdays[classday]).html() == scheduleDay && nextMonth == scheduleMonth && parseInt(year) == scheduleYear){
										if(gTimeClass == "disabled"){
											$(this).children().eq(aClassdays[classday]).addClass('conflict');
										}else{
											$(this).children().eq(aClassdays[classday]).addClass('assigned');
										}
									}
								}
							});
						});
						
						$.each(info['holiday'], function(key,val){
							var scheduleDate = val;
							scheduleDate = scheduleDate.split("-");
							var scheduleYear = Number(scheduleDate[0]);
							var scheduleMonth = Number(scheduleDate[1]);
							var scheduleDay = Number(scheduleDate[2]);
							
							$.each($(".days tr"), function(){
								for(var classday=0;classday<aClassdays.length;classday++){
									if($(this).children().eq(aClassdays[classday]).html() == scheduleDay && nextMonth == scheduleMonth && parseInt(year) == scheduleYear){
										$(this).children().eq(aClassdays[classday]).addClass('holiday');
									}
								}
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