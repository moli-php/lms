var dateNow = new Date();
var currentMonth = dateNow.getMonth() + 1;
var currentYear = dateNow.getFullYear();
var month = dateNow.getMonth();
var year = dateNow.getFullYear();
var dayNow = dateNow.getDay();
var day = dateNow.getDate();
var sUrl = common.getClassUrl("schedule");
var offset = 0;
var limit = 1;
var timeout = "";
$(document).ready(function(){
	var msg = "";
	common.adviseMessage( $('.class_image_here') );
	$(".popupModifyrecord").dialog({autoOpen: false,modal: true,resizable: false});
	$(".popupModifyrecord").dialog({autoOpen: false,modal: true,resizable: false});
	cal.yearMonth(currentMonth,year);
	cal.calendar(month,year,day,dayNow);
	cal.showTime();
	$('#period_startdate').datepicker({
		constrainInput: true,
		showOn: 'button',
		buttonText: '<a class="btn_calendar" href="javascript:void(0);"></a>'
	}).click(function(){
		$(this).datepicker("show");
	});
	//open popup for mobile
	$('.mobile_id').live('click',function () {
	var mobile_no = new Array($(this).text());
	message.send_sms(mobile_no,false);
	});
	//open popup for email
	$('.email_id').live('click',function () {
	var email = new Array($(this).text());
		message.send_email(email,false);
	});
	//end

});
var cal = {
	yearMonth: function(month,year){
			$("#selYear").val(year);
			$("#selMonth").val(month);
	},
	prev: function(val,month,year,day,numDays,dayName,numOfDaysPrev){
			$(".schedule").empty('');
			var dayVal = 0;
		    if (val) {
				month = (month == 11) ? 0 : month + 1;	
			}
			else {
				
				 dayVal = (dayName < 0) ? 0 : dayName - 1;
				 if(dayVal < 0){
					 dayVal += 7;
				 }
				 
				 if(day == 1){
					month -=  1;
					if(month < 0){
						month = 12;
						numOfDaysPrev = 31;
					}
				}
				day = (day == 1) ? numOfDaysPrev : day - 1;
				if(day == numDays){
					month = (month == 0) ? 11 : month - 1;
					if(month == 11){
						year = year - 1;
					}
				}
			}
			cal.yearMonth(month + 1,year);
			cal.calendar(month,year,day,dayVal);
			$("#hiddenDate").val(month+','+year+','+day);
	},
	next: function(val,month,year,day,numDays,dayName,numOfDaysPrev){
			$(".schedule").empty('');
			var dayVal = 0;
			if (val) {
			
				dayVal = (dayName > 6) ? 0 : dayName + 1;
				 if(dayVal > 6){
					 dayVal -= 7;
				 }
				 
				day = (day == numDays) ? 1 : day + 1;
				if(day == 1){
					month = (month == 11) ? 0 : month + 1;
					if(month == 0){
						year = year + 1;
					}
				}
				
			}
			else {
				month = (month == 0 || month == undefined) ? 12 : month - 1;
				
			}
			cal.yearMonth(month + 1,year);
			cal.calendar(month,year,day,dayVal);
			$("#hiddenDate").val(month+','+year+','+day);
			
	},	
	getPresent: function(){
		cal.calendar(month,year,day,dayNow);
	},
	calendar: function(month,year,day,dayNow){
		var htmlContent ="";
		var FebNumberOfDays ="";
		var FebNumberOfDay ="";
		var counter = 1;	
		var nextMonth = month + 1; //+1; //Used to match up the current month with the correct start date.
		var prevMonth = month -1;
		var numOfDaysPrev = month - 1;	
		 //Determing if February (28,or 29)  
		 if (month == 1){
			if ( (year%100!=0) && (year%4==0) || (year%400==0)){
			  FebNumberOfDays = 29;
			}else{
			  FebNumberOfDays = 28;
			}
		 }

		 //Determing if February (28,or 29)  
		 if (numOfDaysPrev == 1){
			if ( (year%100!=0) && (year%4==0) || (year%400==0)){
			  FebNumberOfDay = 29;
			}else{
			  FebNumberOfDay = 28;
			}
		 }
		
		 // names of months and week days.
		 var monthNames = ["January","February","March","April","May","June","July","August","September","October","November", "December"];
		 var dayNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday", "Saturday"];
		 var dayPerMonth = ["31", ""+FebNumberOfDays+"","31","30","31","30","31","31","30","31","30","31"];
		 
		 //this for the fetch month from prev 
		 var dayPerMonths = ["31", ""+FebNumberOfDay+"","31","30","31","30","31","31","30","31","30","31"];
	
			
		 // days in previous month and next one , and day of week.
		
		 var nextDate = new Date((monthNames[nextMonth - 1]) +" " + 22 + " , "+ year);
		
		 var weekdays= nextDate.getDay();
		 var addDay = weekdays;
		 var weekdays2 = weekdays;
		 var numOfDays = dayPerMonth[month];	
		 var nn = dayPerMonths[month-1]; //this for the fetch day on prev 
		 
		cal.showSched(year,month,day,dayNow);
			
	//	$("#8").html('<ul class="schedule_data">'+records+'</ul>');
		$(".prev").html('<a class="btn pn" href = "javascript:void(0)" onClick=cal.prev(false,'+month+','+year+','+day+','+numOfDays+','+dayNow+','+nn+')>Prev Day</a>');
		$(".next").html('<a class="btn pn" href = "javascript:void(0)" onClick=cal.next(true,'+month+','+year+','+day+','+numOfDays+','+dayNow+','+numOfDaysPrev+')>Next Day</a>');
		$("#dateSelected").html(" <input type= 'hidden' value = '"+day+"' id ='hiddenDay'>"+monthNames[month]+" "+day+", "+year+" ("+dayNames[dayNow]+")");
	//	May 29th, 2012 (Tuesday) 20:00~21:00
		$("#cDate").html(monthNames[month]+" "+day+", "+year+" ("+dayNames[dayNow]+") "+dateNow.getHours()+" :00 ~ "+(dateNow.getHours()+ 1)+" :00");
		$("#hiddenDate").val(year+"/"+(month + 1)+"/"+day);
		
		$("#memoDate").val(monthNames[month]+"??"+day+"??,??"+year+"??(??"+dayNames[dayNow]+"??)??"+dateNow.getHours()+":00??~??"+(dateNow.getHours()+ 1)+":00");
		$("#period_startdate").val(""+(month + 1)+"/"+day+"/"+year+"");
		
		
	},
	checkDate: function(val){
		if(val == 'year'){
			var year = $("#selYear").val();
			var month = $("#selMonth").val();
		}else{
			var year = $("#selYear").val();
			var month = $("#selMonth").val();
		}
		cal.calendar(month - 1,year,day);
	},
	showTime: function(){
		var Digital=new Date();
		var hours=Digital.getHours();
		var minutes=Digital.getMinutes();
		var seconds=Digital.getSeconds();
		var dn="AM";
			if (hours>12)
			{
				dn="PM";
				hours=hours-12;
				//this is so the hours written out is 
				//in 12-hour format, instead of the default //24-hour format.
			}
			if (hours==0)
				hours=12
			//this is so the hours written out 
			//when hours=0 (meaning 12a.m) is 12
			if (minutes<=9)
				minutes="0"+minutes;
			if (seconds<=9)
				seconds="0"+seconds;
				// seconds =  60 - seconds;
				$("#clock").html(hours+":"+minutes+":"+seconds+" "+dn);
			setTimeout("cal.showTime()",1000);
	},
	dayMonth: function(month,days){
	
		var FebNumberOfDays ="";
		var dayVal = 0;
		var aData = new Array();
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
		 var dayPerMonth = ["31", ""+FebNumberOfDays+"","31","30","31","30","31","31","30","31","30","31"];
		 
		 var aData = new Array(2);
		 aData[0] = dayPerMonth[month - 1];
		 aData[1] = dayNames[days];
		 
		 
		 return aData;
	},
	showSched: function(year,month,days,dayNow){
		var timeSelected = 0;
		var divId = "";
		var sLevel = "";
		var iTime = "";
		var sEmail = "";
		var iPhone = "";
		var classType = "";
		var aDate = [[6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],[0,1,2,3,4,5]];
		var string = "";
		for (var i in aDate) {
			for (var j in aDate[i]) {
				if(aDate[i][j] > 9){
						var string = '<td class="student_name"><ul></ul></td>';
						string += '<td class="student_time"><ul></ul></td>';
						string += '<td class="student_type"><div class="icon_type"><p class="clock">'+aDate[i][j]+':00</p> ';
						string += '<ul class="icons"></ul></div></td>';
						string += '<td class="email"><ul></ul></td>';
						string += '<td class="phone"><ul></ul></td>';
						$(".schedule").append('<tr class = "tr '+aDate[i][j]+'">'+string+'</tr>');
					}else{
						var string = '<td class="student_name"><ul></ul></td>';
						string += '<td class="student_time"><ul></ul></td>';
						string += '<td class="student_type"><div class="icon_type"><p class="clock">'+aDate[i][j]+':00</p> ';
						string += '<ul class="icons"></ul></div></td>';
						string += '<td class="email"><ul></ul></td>';
						string += '<td class="phone"><ul></ul></td>';
						$(".schedule").append('<tr class = "tr '+aDate[i][j]+'">'+string+'</tr>');
					}
			}
		}	
		var showSchedule = {
					url : document.URL,
					dataType : "json",
					data : {
						action : "selectSchedule",
						dateAssign : year+"-"+(month + 1)+"-"+days
					},
					success : function(data){
					
					for(var a = 0; a <= 23; a++){
						$('.'+a+' .student_name ul').html('');
						$('.'+a+' .student_time ul').html('');
						$('.'+a+' .student_type .icons').html('');
						$('.'+a+' .email ul').html('');
						$('.'+a+' .phone ul').html('');
					}
					if(data == ""){
					$(".schedule").empty('');
					$("#pName").html("").css({'text-align':'center','float':'left','border':'','background':'','color':'','width':'','min-height':'0px'});
					
				for (var i in aDate) {
				  for (var j in aDate[i]) {
					if(aDate[i][j] > 9){
										var string = '<td class="student_name"><ul></ul></td>';
										string += '<td class="student_time"><ul></ul></td>';
										string += '<td class="student_type"><div class="icon_type"><p class="clock">'+aDate[i][j]+':00</p> ';
										string += '<ul class="icons"></ul></div></td>';
										string += '<td class="email"><ul></ul></td>';
										string += '<td class="phone"><ul></ul></td>';
										$(".schedule").append('<tr class = "tr '+aDate[i][j]+'">'+string+'</tr>');
									}else{
										var string = '<td class="student_name"><ul></ul></td>';
										string += '<td class="student_time"><ul></ul></td>';
										string += '<td class="student_type"><div class="icon_type"><p class="clock">'+aDate[i][j]+':00</p> ';
										string += '<ul class="icons"></ul></div></td>';
										string += '<td class="email"><ul></ul></td>';
										string += '<td class="phone"><ul></ul></td>';
										$(".schedule").append('<tr class = "tr '+aDate[i][j]+'">'+string+'</tr>');
									}
							}
						}	
					}else{
						
						$.each(data, function(key,val){
							timeSelected = val.time_start.split(":");
							timeSelectedEnd = val.time_end.split(":");
							if(days == $("#hiddenDay").val()){
								var id = timeSelected[0].split("-");
								if(divId.length == ""){
								}
								for(var i = 0; i <= divId.length; i++){
								
									if(id[i] != undefined && id[i] != ""){
									
										for(var aiD = 0; aiD <= 23; aiD++){
											if(id[i] == aiD){
												if(days == $("#hiddenDay").val()){
											
													for(var a = 0; a <= 23; a++){
														if(timeSelected[0] == a){
															//show data for the current teacher scheduled time
															if(id[i] == dateNow.getHours()){
																if(timeSelected[1] <= dateNow.getMinutes() && timeSelectedEnd[1] >= dateNow.getMinutes()){
																	$("#pName").html("Prepared for"+val.name+"!!!<br><br>"+id[i]+':00').css({'text-align':'center','float':'left','border':'1px solid #fff','background':'red','color':'#fff','width':'400px','min-height':'30px','font-size':'20px'});
																	$(".name").html();
																}
															}
															iTime +=  '<li>'+val.time_start+' ~ '+val.time_end+'</li>';
															sEmail +=  '<li><a href = javascript:void(0);  id="testlink" class="email_id">'+val.email+'</a></li>';	
															iPhone +=  '<li><a id="testlink" class="mobile_id" href = javascript:void(0); >'+val.phone_mob+'</a></li>';
															if(val.type == 'camera'){
																sLevel += 	'<li><span class="cam_english">C</span>';
																classType = '<a href="javascript:void(0)" class="alarm"><span>Alarm</span></a>';
															}else if(val.type == 'phone'){
																sLevel += 	'<li><span class="phone_class">P</span>';
																classType = '<a href="javascript:void(0)" class="mobile"><span>Mobile</span></a>';
															}else{
																sLevel += 	'<li><span class="level_test">L</span>';
																// classType = '<a href="javascript:void(0)" class="mobile"><span>Mobile</span></a>';
															}
															
															switch(val.sched_status){
																	case 'waiting':
																	sLevel += 	'<span class="waiting">W</span> <a href="javascript:void(0)" onClick = cal.viewRecords('+val.idx+','+null+','+'"'+val.daystart+'"'+','+val.student_idx+','+'"'+val.time_start+'"'+','+null+')>'+val.name+'</a></li>';
																	break;
																	case 'attended':
																	sLevel += 	'<span class="attended">A</span> <a href="javascript:void(0)" onClick = cal.viewRecords('+val.idx+','+null+','+'"'+val.daystart+'"'+','+val.student_idx+','+'"'+val.time_start+'"'+','+null+')>'+val.name+'</a></li>';
																	break;
																	case 'cancelled':
																	sLevel += 	'<span class="cancelled">C</span> <a href="javascript:void(0)" onClick = cal.viewRecords('+val.idx+','+null+','+'"'+val.daystart+'"'+','+val.student_idx+','+'"'+val.time_start+'"'+','+null+')>'+val.name+'</a></li>';
																	break;
																	case 'absent':
																	sLevel += 	'<span class="absent">A</span> <a href="javascript:void(0)" onClick = cal.viewRecords('+val.idx+','+null+','+'"'+val.daystart+'"'+','+val.student_idx+','+'"'+val.time_start+'"'+','+null+')>'+val.name+'</a></li>';
																	break;
																	case 'delayed':
																	sLevel += 	'<span class="delayed">D</span> <a href="javascript:void(0)" onClick = cal.viewRecords('+val.idx+','+null+','+'"'+val.daystart+'"'+','+val.student_idx+','+'"'+val.time_start+'"'+','+null+')>'+val.name+'</a></li>';
																	break;
															}
															
															$('.'+a+' .student_name ul').append(sLevel);
															$('.'+a+' .student_time ul').append(iTime);
															$('.'+a+' .student_type .icon_type .icons').append("<li>"+classType+"</li>");
															$('.'+a+' .email ul').append(sEmail);
															$('.'+a+' .phone ul').append(iPhone);
															
															sLevel = "";	
															iTime = "";	
															iPhone = "";	
															sEmail = "";
															
														 }
														
													}
													
												}
												
											}
											
										}
										
									}
								}
								clearTimeout(timeout);
									var timeoutMinutes= 55*60*1000;
									timeout = setTimeout(function(){
										$(".schedule").empty('');
										var aData = $("#period_startdate").val().split("/");
										cal.showSched(year, month, days, dayNow);
									}, timeoutMinutes);
								
							}
						});					
				   	  }	//append records pwd rin to gamitin 
					}
			};
		$.ajax(showSchedule);
	},
	getSelected: function(){
		var dates = "";
		dates  = $("#period_startdate").val().split("/");
		var printDate = new Date(dates[2],(dates[0] - 1),dates[1]);
		cal.calendar(dates[0] - 1,dates[2],dates[1],printDate.getDay());
	},
	vPrev: function(id,vmonth,stdId,timeStart,flag){
	    var nDate = '';
	    var key = parseInt($(".checkKey").val());
	    var checkCount = parseInt($(".checkCount").val() - 1);
	    var splitDate = vmonth.split("-");
		nDate = vmonth;
		if(key == 0){
			key = 0; 
		}else{
			key = (key == null || key == 0) ? 0 : key - 1;
		}
		cal.viewRecords(null,key,nDate,stdId,timeStart,flag);
	},
	vNext: function(id,vmonth,stdId,timeStart,flag){
	    var nDate = '';
	    var key = parseInt($(".checkKey").val());
	    var checkCount = parseInt($(".checkCount").val() - 1);
	    var splitDate = vmonth.split("-");
		nDate = vmonth;
		if(key == checkCount){
			key = checkCount; 
		}else{
			key = (key == null) ? 0 : key + 1;
		}
		cal.viewRecords(id,key,nDate,stdId,timeStart,flag);
	},
	viewRecords: function(id,keyId,vmonth,stdId,timeStart,flag){
		tinyMCE.init({
		mode : "none",
		theme : "advanced",
		theme_advanced_toolbar_align : "left",
		theme_advanced_toolbar_location : "top",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "bullist,numlist,separator,outdent,indent,separator,undo,redo,separator",
		theme_advanced_buttons3 : ""
	});
	var hDate = $("#hiddenDate").val();
	$("#userId").val(id);
	var keys = 0;
	var ids = 0;
	var unitId = '';
	var levelType = '';
			$.ajax({
						url : document.URL,
						dataType : "json",
						data : {
							action : "selectAll",
							dateAssign : vmonth,
							stdId : stdId
						},
						success : function(data){
						//set tinyMCE 
							var ctr = 0;
							$.each(data, function(key,val){
								if(id == val.idx){
											if(val.type == 'camera'){
										
												$("#camClass").show();
											}else{
												$("#camClass").hide();
											}
											switch(true){
												case (val.type == 'phone'):
												$(".type_phone").html(val.type + " english");
												break;
												case (val.type == 'camera'):
												$(".type_phone").html(val.type + " english");
												break;
												default:
												$(".type_phone").html(val.type);
												break;
											}
											$(".name").html(val.name);
											$("#memo").html(val.memo);
											$("#agePhone").html(val.age+"/"+val.phone_mob);
											$('input:radio[name=attendance][value='+val.sched_status+']').attr('checked', true);
											dates  = val.daystart.split("-");
											var printDate = new Date(dates[0],(dates[1] - 1),dates[2]);
											var dayNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday", "Saturday"];
											$("#cDate").html(dates[1]+" "+dates[2]+", "+dates[0]+" ("+dayNames[printDate.getDay()]+") "+val.time_start+" ~ "+val.time_end);
											$(".rdate").html("("+dates[0]+" "+dates[1]+", "+dates[2]+")");
									keys = key;
									ids = val.idx;
									unitId = val.unit;
									levelType = val.idx;
								}else{
									if(key == keyId){
											if(val.type == 'camera'){
												$("#camClass").show();
											}else{
												$("#camClass").hide();
											}
											switch(true){
												case (val.type == 'phone'):
												$(".type_phone").html(val.type + " english");
												break;
												case (val.type == 'camera'):
												$(".type_phone").html(val.type + " english");
												break;
												default:
												$(".type_phone").html(val.type);
												break;
											}
											$(".name").html(val.name);
											$("#memo").html(val.memo);
											$("#agePhone").html(val.age+"/"+val.phone_mob);
											$('input:radio[name=attendance][value='+val.sched_status+']').attr('checked', true);
											dates  = val.daystart.split("-");
											
											var printDate = new Date(dates[0],(dates[1] - 1),dates[2]);
											var dayNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday", "Saturday"];
											$("#cDate").html(dates[1]+" "+dates[2]+", "+dates[0]+" ("+dayNames[printDate.getDay()]+") "+val.time_start+" ~ "+val.time_end);
											$(".rdate").html("("+dates[0]+" "+dates[1]+", "+dates[2]+")");
										keys = key;
									 	ids = val.idx;
										unitId = val.unit;
										levelType = val.idx;
									}
							   }
								ctr++;
							});
							 $(".checkCount").val(ctr);
							 $(".checkKey").val(keys);
							 cal.getBranch(unitId);
							 cal.getLevelType(levelType,vmonth,stdId,id);
						}
				});
				$("#vPrev").html('<a href="#" class="btn pn" onClick = cal.vPrev('+id+','+'"'+vmonth+'"'+','+stdId+','+'"'+timeStart+'"'+',0)>Prev</a>');
				$("#vNext").html('<a href="#" class="btn pn" onClick = cal.vNext('+id+','+'"'+vmonth+'"'+','+stdId+','+'"'+timeStart+'"'+',1)>Next</a>');
			
	},
	getBranch: function(unitId){
		var dept1 = '';
		var dept2 = '';
		var mainDept = '';
		var records = '';
		$(".department").html('');
		if(unitId == ''){
		
			records += ('<li  style = "width:120px;">none &gt;&nbsp;</li>');
			records += ('<li  style = "width:120px;">none &gt;&nbsp;</li>');
			records += ('<li  style = "width:120px;">none &gt;&nbsp;</li>');
			$(".department").append(records);
		}else{
		var uIds = unitId.split(",");
			for(var i in uIds)
			{
			$.ajax({
					url : document.URL,
					dataType : "json",
					data : {
						action : "selectBranch",
						unitsId : uIds[i]
					},
					success : function(data){
					records = '';
						$.each(data, function(key,val){
							records += ('<li  style = "width:120px;"><a href="#">'+val.dept1+' </a> &gt;&nbsp;</li>');
							records += ('<li  style = "width:120px;"><a href="#">'+val.depth2+' </a> &gt;&nbsp;</li>');
							records += ('<li  style = "width:120px;"><a href="#">'+val.maindept+' </a> &gt;&nbsp;</li>');
						});
						$(".department").append(records);
						
					}
			 });
			}
	     }
	
	},
	getLevelType: function(idx,vmonth,stdId,id){

			$.ajax({
					url : document.URL,
					dataType : "json",
					data : {
						action : "selectLevels",
						classIdx : idx
					},
					open : function(){
						tinyMCE.execCommand('mceAddControl', true, 'tiny_MCE');					
					},
					success : function(data){
						if(data != ''){
							$.each(data, function(key,val){
									var timer = setInterval(function(){
										if (tinyMCE.getInstanceById('tiny_MCE'))
										{
											clearInterval(timer)
											tinyMCE.get('tiny_MCE').setContent(val.comment);
										}
									},100);
									
									$('input:radio[name=listening][value='+val.listening+']').attr('checked', true);
									$('input:radio[name=speaking][value='+val.speaking+']').attr('checked', true);
									$('input:radio[name=pronunciation][value='+val.pronounciation+']').attr('checked', true);
									$('input:radio[name=vocabulary][value='+val.vocabulary+']').attr('checked', true);
									$('input:radio[name=grammar][value='+val.grammar+']').attr('checked', true);
							});
						}else{
									var timer = setInterval(function(){
										if (tinyMCE.getInstanceById('tiny_MCE'))
										{
											clearInterval(timer)
											tinyMCE.get('tiny_MCE').setContent('');
										}
									},100);
									$('input:radio[name=listening][value=1]').attr('checked', true);
									$('input:radio[name=speaking][value=1]').attr('checked', true);
									$('input:radio[name=pronunciation][value=1]').attr('checked', true);
									$('input:radio[name=vocabulary][value=1]').attr('checked', true);
									$('input:radio[name=grammar][value=1]').attr('checked', true);
						}
						
					}
			 });
					//submit records//
					$('.student_data').dialog({
							//autoOpen: false,
							width: 600,
							height: 800,
							modal:true,
							open:function(){
								tinyMCE.execCommand('mceAddControl', true, 'tiny_MCE');
							},
							close : function(){
								// Destroy dialog box and remove TinyMCE Instance to avoid problem
								if (tinyMCE.getInstanceById('tiny_MCE'))
								{
									 //Check TinyMCE Instance here and destroy
									tinyMCE.execCommand('mceFocus', false, 'tiny_MCE'); 
									tinyMCE.execCommand('mceRemoveControl', false, 'tiny_MCE');
								}
								 $(this).dialog('destroy');
								 
							},
							buttons: {
								"Ok": function() { 
								tinyMCE.triggerSave();
								var attendance = $('input[name=attendance]:checked').val();
								var listening = $('input[name=listening]:checked').val();
								var speaking = $('input[name=speaking]:checked').val();
								var pronounciation = $('input[name=pronunciation]:checked').val();
								var vocabulary = $('input[name=vocabulary]:checked').val();
								var grammar = $('input[name=grammar]:checked').val();
								var comment  = $('.tiny_MCE').val();
									$.ajax({
										url : document.URL,
										dataType : "json",
										data : {
											action : "updateSchedule",
											dateAssign : vmonth,
											classIdx : idx,
											studIdx : stdId,
											comment : comment,
											attendance : attendance,
											listening : listening,
											speaking : speaking,
											pronounciation : pronounciation,
											grammar : grammar,
											vocabulary : vocabulary
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

											$(this).dialog('destroy');
											$(".student_data").dialog("close"); 
										}
									});
								}, 
								"Close": function() { 
									$("#camClass").hide();
									var timer = setInterval(function(){
												if (tinyMCE.getInstanceById('tiny_MCE'))
												{
													clearInterval(timer)
													tinyMCE.getInstanceById('tiny_MCE').setContent('');
												}
									},100);
									$(this).dialog("close"); 
								} 
							}
						});
	}
}