var dateNow = new Date();
var currentMonth = dateNow.getMonth() + 1;
var currentYear = dateNow.getFullYear();
var month = dateNow.getMonth();
var day = dateNow.getDate();
var year = dateNow.getFullYear();

var dayNow = dateNow.getDay();
$(document).ready(function(){
	
	cal.yearMonth(currentMonth,year);
	cal.calendar(month,year);
	// Dialog Link
	$(".popup_window").dialog({autoOpen: false,modal: true,resizable: false});
	$(".popupAddrecord").dialog({autoOpen: false,modal: true,resizable: false});
	$(".popupModifyrecord").dialog({autoOpen: false,modal: true,resizable: false});
	$(".popupError").dialog({autoOpen: false,modal: true,resizable: false});
		
});

var cal = {
	yearMonth: function(month,year){
			$("#selYear").val(year);
			$("#selMonth").val(month);
	},
	prev: function(val,month,year){
		    if (val) {
				month = (month == 11) ? 0 : month + 1;	
			}
			else {
				month = (month == 0) ? 11 : month - 1;
				if(month == 11){
					year = year - 1;
				}
			}
			cal.yearMonth(month + 1,year);
			cal.calendar(month,year);
	},
	next: function(val,month,year){
			if (val) {
				month = (month == 11) ? 0 : month + 1;
				if(month == 0){
					year = year + 1;
				}
			}
			else {
				month = (month == 0 || month == undefined) ? 12 : month - 1;
				
			}
			cal.yearMonth(month + 1,year);
			cal.calendar(month,year);
	},	
	createSched: function(year,month,day){
			$('.popup_window').dialog('open');
					$('.popup_window').dialog({
					autoOpen: false,
					width: 500,
					buttons: {
						"Ok": function() { 
							var holidayReason = $("#reason").val();
							var holidayValue = $('input[name=holidayResult]:checked').val();
							if(holidayReason == ''){
								$("#error").html("This field is required.");
								$("#reason").css("border","1px solid red");
								$("#reason").focus();
							}else{
								if(holidayValue== 'Holiday'){
									holidayValue = 1;
								}else{
									holidayValue = 2;
								}
								$.ajax({
										url : common.getClassUrl("classHoliday"),
										dataType : "json",
										data : {
											exec : "insertHoliday",
											dateAssign : year+"-"+(month + 1)+"-"+day,
											reason : holidayReason,
											typeHoliday : holidayValue
										},
										success : function(data){
											
											$('.popupAddrecord').dialog('open');
												$('.popupAddrecord').dialog({
												autoOpen: false,
												width: 300,
												buttons: {
													"Close": function() { 
														$(this).dialog("close"); 
													} 
												}
											});
											
											$("#error").html("");
											$("#reason").css("border","");
											cal.calendar(month,year);
											$('.popup_window').dialog("close"); 
										}
								});
							}
						}, 
						"Close": function() { 
							$("#error").html("");
							$("#reason").val("");
							$("#reason").css("border","");
							$(this).dialog("close"); 
						}						
					},
					beforeClose : function(){
						$("#reason").val("");
						$("#error").html("");
						$("#reason").css("border","");
					
					}
				});
	},	
	calendar: function(month,year){
		$("#prev").html('<a class="btn pn" href = "javascript:void(0)" onClick=cal.prev(false,'+month+','+year+')>Prev Month</a>');
		$("#next").html('<a class="btn pn" href = "javascript:void(0)" onClick=cal.next(true,'+month+','+year+')>Next Month</a>');
	
		var htmlContent ="";
		var FebNumberOfDays ="";
		var counter = 1;	
		var nextMonth = month + 1; //+1; //Used to match up the current month with the correct start date.
		var prevMonth = month -1;
			
		 //Determing if February (28,or 29)  
		 if (month == 1){
			if ( (year%100!=0) && (year%4==0) || (year%400==0)){
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
		 var numOfDays = dayPerMonth[month];	
	
		
	
		 // this leave a white space for days of pervious month.
		 while (weekdays>0){
			htmlContent += "<td class=null></td>";
		 // used in next loop.
			 weekdays--;
		 }

			$.ajax({
				url : common.getClassUrl("classHoliday"),
				dataType : "json",
				data : {
					exec : "getHolidays",
					year : year,
					month : nextMonth,
					day : numOfDays
				},
				success : function(data){
						$.each(data, function(key, val){
							
							if (weekdays2 > 6){
								weekdays2 = 0;
								htmlContent += "</tr><tr>";			
							}
							if (val != false && val != "false"){
								
								var cutoff = 50;
								var text = val.reason;
								var rest = val.reason.substring(cutoff);
								if (text.length > 50) {
								  var period = rest.indexOf('<br>');
								  var space = rest.indexOf(' ');
								  cutoff += Math.max(Math.min(period, space), 0);
								}
								// Assign the rest again, because we recalculated the cutoff
								rest = text.substring(cutoff);
								var visibleText = val.reason.substring(0, cutoff);
								
								htmlContent += '<td class="marked" onClick = "cal.editHoliday(\''+val.idx+'\',\''+val.reason.replace(/\'/g,'\\\'')+'\',\''+nextMonth+'\',\''+year+'\')"><span>'+counter+'</span><p class="marker">';
									if(val.typeHoliday == 1){
										htmlContent += 'Holiday';
									}else{
										htmlContent += 'No Holiday';
									}
									htmlContent += '</td>';

							} else {
								if (counter == day && currentMonth == nextMonth && year == currentYear){
									htmlContent +="<td class='current'><span>"+counter+"</span></td>";
								}else{
									if(year < currentYear){ //show the past days that cannot assigned holiday
										if((counter + addDay) % 7 == 1){
											htmlContent +="<td  class='sunday' onClick = cal.emptyLink()><span>"+counter+"</span></td>";
										}else if((counter + addDay) % 7 == 0){
											htmlContent +="<td  class='saturday' onClick = cal.emptyLink()><span>"+counter+"</span></td>";
										}else{
											htmlContent +="<td  onClick = cal.emptyLink()><span>"+counter+"</span></td>";   
										}
								
									}else{ //show the present days that can assigned holiday
										if(year == currentYear){
												if(nextMonth >= currentMonth){
												
												if(counter < day && currentMonth == nextMonth && year == currentYear){
													//shows the present day for the current month
													if((counter + addDay) % 7 == 1){
														htmlContent +="<td  class='sunday' onClick = cal.emptyLink()><span>"+counter+"</span></td>";
													}else if((counter + addDay) % 7 == 0){
														htmlContent +="<td  class='saturday' onClick = cal.emptyLink()><span>"+counter+"</span></td>";
													}else{
														htmlContent +="<td  onClick = cal.emptyLink()><span>"+counter+"</span></td>";   
													}

												}else{
													//shows the valid link for adding a holiday
													if((counter + addDay) % 7 == 1){
														htmlContent +="<td  class='sunday' onClick = 'cal.createSched("+year+","+month+","+counter+")'><span>"+counter+"</span></td>";
													}else if((counter + addDay) % 7 == 0){
														htmlContent +="<td  class='saturday' onClick = 'cal.createSched("+year+","+month+","+counter+")'><span>"+counter+"</span></td>";
													}else{
														htmlContent +="<td onClick = 'cal.createSched("+year+","+month+","+counter+")'><span>"+counter+"</span></td>";   
													}
												}
											
											}else{
												//shows the past days in a month
												if((counter + addDay) % 7 == 1){
													htmlContent +="<td  class='sunday' onClick = cal.emptyLink()><span>"+counter+"</span></td>";
												}else if((counter + addDay) % 7 == 0){
													htmlContent +="<td  class='saturday' onClick = cal.emptyLink()><span>"+counter+"</span></td>";
												}else{
													htmlContent +="<td  onClick = cal.emptyLink()><span>"+counter+"</span></td>";   
												}
											}
											
										}else{
											//shows the days in a month after the present year
												if((counter + addDay) % 7 == 1){
													htmlContent +="<td  class='sunday' onClick = 'cal.createSched("+year+","+month+","+counter+")'><span>"+counter+"</span></td>";
												}else if((counter + addDay) % 7 == 0){
													htmlContent +="<td  class='saturday' onClick = 'cal.createSched("+year+","+month+","+counter+")'><span>"+counter+"</span></td>";
												}else{
													htmlContent +="<td onClick = 'cal.createSched("+year+","+month+","+counter+")'><span>"+counter+"</span></td>";   
												}
										}
										
									}
								}
							}
							weekdays2++;
							counter++
						});
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
				}
			});
	},
	checkDate: function(val){
		if(val == 'year'){
			var year = $("#selYear").val();
			var month = $("#selMonth").val();
		}else{
			var year = $("#selYear").val();
			var month = $("#selMonth").val();
		}
	
		cal.calendar(month - 1,year);
	},
	emptyLink: function(counter,addDay,htmlContent){
		 $('.popupError').dialog('open');
			$('.popupError').dialog({
			autoOpen: false,
			width: 300,
			buttons: {
				"Close": function() { 
					$(this).dialog("close"); 
				} 
			}
		});
	},
	editHoliday: function(idx,reason,month,year){
		$("#reason").val(reason);
		 $('#holiday').prop("checked", true);
		 $('.popup_window').dialog('open');
					$('.popup_window').dialog({
					autoOpen: false,
					width: 500,
					buttons: {
						"Ok": function() { 
							var holidayReason = $("#reason").val();
							var holidayValue = $('input[name=holidayResult]:checked').val();
							if(holidayReason == ''){
								$("#reason").css("border","1px solid red");
								$("#reason").focus();
							}else{
								if(holidayValue== 'Holiday'){
									holidayValue = 1;
								}else{
									holidayValue = 2;
								}
								$.ajax({
									url : common.getClassUrl("classHoliday"),
									dataType : "json",
									data : {
										exec : "modifyHoliday",
										idx : idx,
										reason : holidayReason,
										typeHoliday : holidayValue
									},
									success : function(data){
										 $('.popupModifyrecord').dialog('open');
											$('.popupModifyrecord').dialog({
											autoOpen: false,
											width: 300,
											buttons: {
												"Close": function() { 
													$(this).dialog("close"); 
												} 
											}
										});
										
										cal.calendar(month - 1,year);
										$('.popup_window').dialog("close"); 
									}
								});
							}
						}, 
						"Cancel": function() { 
							 $("#reason").val("");
							 $("#reason").css("border","");
							$(this).dialog("close"); 
						} 
					},
					beforeClose : function(){
							$("#reason").val("");
							$("#error").html("");
							$("#reason").css("border","");
					}
				});
	}

}