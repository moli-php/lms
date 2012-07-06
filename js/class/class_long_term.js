var dateNow = new Date();
var dayVal = dateNow.getDay();
var check = 0;
var gTimeClass = "";

var first_mnth = 0;
var checkMonth = 1;
var num_conf = 0;
var i_sched = 0;
var aClasses = new Array();
var sUrl = common.getClassUrl("classListExecute");
var classLongTerm = {    
    customRangeLterm : function(input) {
        var d_day = parseInt($('#last_date_wait').val().substr(-2))+1; 
        var final_day = $('#last_date_wait').val().substr(0,8) + d_day; 
        return {
            minDate: final_day
        };
    },
    
    customRangeSearch : function(input) {
        if (input.id == 'period_enddate') {
            return {
            minDate: $('#period_startdate').datepicker("getDate")
            };
        } else if (input.id == 'period_startdate') {
            return {
            maxDate: $('#period_enddate').datepicker("getDate")
            };
        }
    },
    
    showLterm : function(){
        $('#add_lterm').dialog({
            resizable: false,
            width: 400,
            modal: true,
            draggable: false,
            position: "center",
            title : "Add New Long Term Schedule &raquo;",
            closeOnEscape: false,
            close : function(){ classLongTerm.initiateValues(); }
        });
    },
    
    showPoint : function(){
        $('#add_point').dialog({
            width: 400,
            resizable: false,
            modal: true,
            position: "center",
            draggable: false,
            title : "Change Rest of Class to Point &raquo;",
            closeOnEscape: false,
            close : function(){ classLongTerm.initiateValues(); }
        });
    },
    
    findUserId : function(){
        if($('#userid_check').val() !=""){
            var user_id = $('#userid_check').val();              
            $.ajax({
                url : sUrl,
                type : "GET",
                dataType : "JSON",
                data : "exec=findUserId&check=1&user_id="+user_id,
                success : function(response){
                    if(response != "not_student" && response != "no_sched" && response != "deleted_class"){ 
                        $('#find_userid').dialog("close");
                        $('#userid_found').text(response[0]['name']);                          
                        aClasses = response; 
                        classLongTerm.showResult(); 
                    
                    } else {
                        var not_found_c = (response == "not_student") ? "Try again. Only students are allowed to add a new class." : "Student does not have ongoing class.";
                        $('#userid_not_found').html(not_found_c);
                        $('#userid_check').val("");
                        $('#userid_check').focus();
                    }
                }
            });
        } else {
            $('#userid_not_found').html("Please enter the user ID.");
            $('#userid_check').val("");
            $('#userid_check').focus();
        }        
    },
    
    showClasses : function(){        
        var div_class = "";     
        /*Select Classes - Show - Changed*/
        $.each(aClasses, function(index, value) {     
            if(value["class_name"]!= undefined && value["class_name"]!=null){
                div_class+="<option value='"+value["class_id"]+"'>"+value["class_name"]+"</option>";
            }
        });  
        $(".select_class").html(div_class);        

        if($('#add_point').dialog('isOpen') == true){                        
            classLongTerm.showRest();
        } else {
            classLongTerm.showWaiting(); 
        } 
    },
    
    showRest : function(){        
        var class_id = $('select[name=select_point] option:selected').val();
        $.ajax({
            url : sUrl,
            type : "GET",
            dataType : "JSON",
            data : "exec=getRemaining&class_id="+class_id,
            success : function(response){ 
                if(response!=null){  
                    $("#rest_class").html(response);
                    $('#point_check').val("");
                }
            }
        });
    },
    
    showWaiting : function(){        
        num_conf = 0;
        var class_id = $('select[name=select_lterm] option:selected').val();
        $.ajax({
            url : sUrl,
            type : "GET",
            dataType : "JSON",
            data : "exec=getWatingClasses&class_id="+class_id,
            success : function(response){ 
                if(response!=null){  
                    var pt_class ="";
                    $(".pt_info_class_days").html(response[0]['class_days']);
                    $("#teacher_id").val(response[0]['teacher_idx']);
                    $(".pt_info_stime").html(response[0]['time_start']);
                    $(".pt_info_etime").html(response[0]['time_end']);
                    $(".pt_info_remaining").html(response.length);
                    $.each(response, function(key, val){
                        if(key>=0){
                            pt_class += (parseInt(key)+1) + " ) " + val['daystart']+"\n";                            
                        }
                    });
                    $("#last_date_wait").val(response[response.length-1]['daystart']);
                    $("#start_date_wait").val(response[0]['daystart']);
                    $("#class_months").val(response[0]["total_months"]);
                    $("#textarea_lterm").html(pt_class);
                    $(".waiting_pt").show();
                }
            }
        });
    },
    
    showFindUserId : function(){
        $('#find_userid').dialog({
            resizable: false,
            draggable: false,
            position : "center",
            modal: true,
            closeOnEscape: false,
            title : "Find User ID &raquo;"
        });
    },
    
    showResult : function(){
        $('#result_userid').dialog({
            resizable: false,
            modal: true,
            draggable: false,
            position : "center",
            closeOnEscape: false,
            title : "Result &raquo;"
        });
    }, 
    
    initiateValues : function(){
        $('#result_userid').dialog("close");
        $('#find_userid').dialog("close");
        $('.user_id').val("");        
        $('#point_check').val("");
        $('#rest_class').html("0");
        $('#startdate_lterm').val("");
        $(".select_class").html("");
        $('.select_class').attr("disabled", "disabled");
        $('#point_check').attr("disabled", "disabled");
        $('#startdate_lterm').attr("disabled", "disabled");
        $('.ui-datepicker-trigger').attr("disabled", "disabled");
        $('#startdate_lterm').css("background-color", "#fff");
        $('#point_check').css("background-color", "#fff");
        $('#point_notfound').html("");
        $(".pt_name").html("");
        $("#textarea_lterm").html("");
        $(".waiting_pt").hide();
        $(".schedule_calendar_popup").hide();
    },
    
    submitPoint : function(){
        var cid = $('select[name=select_point] option:selected').val();
        var point = $('#point_check').val();
        var uid = $('#userid_point').val();
        $.ajax({
            url : sUrl,
            type : "GET",
            dataType : "JSON",
            data : "exec=savePoint&class_id="+cid+"&point="+point+"&username="+uid,
            success : function(response){ 
                if(response==1){ 
                    $('#add_point').dialog("close"); 
                    common.message('success', 'Successfully Changed the Rest of the Class to Point');
                    setTimeout(function(){                        
                        location.href = location.href;                          
                    },500);
                }
            }
        });
    },
    
    acceptsNum : function(){
        if(isNaN($('#point_check').val())){
            search = $('#point_check').val();
            $('#point_check').val(search.substr(0, search.length-1));
        }
    },
    
    saveLongterm : function(){   
        if(num_conf >=1){
            $('#lterm_notfound').html("Date chosen conflicts with another schedule. Please choose another."); 
            $('.hasDatepicker').val("");
            $(".schedule_calendar_popup").hide();
            setTimeout(function(){
                $('#lterm_notfound').html("");
            },3000);  
            
        } else {
            var cid = $('select[name=select_lterm] option:selected').val();
            var uid = $('#userid_lterm').val();
            $.ajax({
                url : sUrl,
                type : "GET",
                dataType : "JSON",
                data : "exec=saveLongterm&class_id="+cid+"&username="+uid,
                success : function(response){ 
                    if(response == 1){  
                        $('#add_lterm').dialog("close");
                        common.message('success', 'Successfully Added New Long Term Schedule'); 
                        setTimeout(function(){
                            location.href = location.href;
                        },500);
                    }
                }
            });
        }
    },
    
    searchInfo : function(){
        var course = ($("#search_class").val()=='Class') ? '' : $("#search_class").val();
        var teacher = ($("#search_teacher").val()=='Teacher') ? '' : $("#search_teacher").val();
        var branch = ($("#search_branch").val()=='Branch') ? '' : $("#search_branch").val();
        var sdate = $("#period_startdate").val();
        var edate = $("#period_enddate").val();
        var name = $("#search_id").val();
        var sUrl = common.getClassUrl("classLpostponed"); 
        if(branch == undefined){
            branch = "";
        }
        window.location.href = sUrl+"&name="+name+"&sdate="+sdate+"&edate="+edate+"&class="+course+"&teacher="+teacher+"&branch="+branch; 
    
    },    
    
    calendar: function(month,year){
        var staticMonth = parseInt(month);
        var staticYear = parseInt(year);
        
        var li = '<li class="prev"><a href = "javascript:void(0)" onClick=classLongTerm.prev(false,'+month+','+year+') title="Prev">Prev</a></li>';
        li +='<li class="date"></li>';
        li +='<li class="next"><a href = "javascript:void(0)" onClick=classLongTerm.next(true,'+month+','+year+') title="Next">Next</a></li>';
        
        $(".control").html(li);        
        
        var selDate = $("#startdate_lterm").val(); // selected date
        var myArray = selDate.split('-');

        var htmlContent ="";
        var FebNumberOfDays ="";
        var counter = 1;    
        var nextMonth = parseInt(month); //+1; //Used to match up the current month with the correct start date.
        var prevMonth = parseInt(month) -1;

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
        
        // Get Class Days
        var aClassdays = new Array();
        aClassdays = $('.pt_info_class_days').html();        
        while (weekdays>0){ // this leave a white space for days of pervious month.
            htmlContent += "<td class=null></td>";            
            weekdays--; // used in next loop.
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
        
        var class_id = $('select[name=select_lterm] option:selected').val();
        var l_mnth = $("#last_date_wait").val();
        var f_mnth = $("#start_date_wait").val();        
        var total_mnth = $("#class_months").val();
        
        $.ajax({
            url : common.getClassUrl("classListExecute"),
            dataType : "json",
            type : "POST",
            data :  {
                        exec : "getDates",
                        datestart : $("#startdate_lterm").val(),
                        totalDays : $(".pt_info_remaining").html(),
                        totalMonth : total_mnth,
                        teacherId : $("#teacher_id").val(),
                        classdays : aClassdays,
                        start_time : $(".pt_info_stime").html(),
                        end_time : $(".pt_info_etime").html(),
                        class_id : class_id
                    },
            success : function(info){  
                num_conf = 0;
                aClassdays = info['class_days'];    
                /*Conflict dates*/
                $.each(info['conflict'], function(key, infoVal){
                    $.each(infoVal, function(key,val){                    
                        var scheduleDate = val.daystart;
                        scheduleDate = scheduleDate.split("-");
                        var scheduleYear = Number(scheduleDate[0]);
                        var scheduleMonth = Number(scheduleDate[1]);
                        var scheduleDay = Number(scheduleDate[2]);
                        $.each($(".days tr"), function(){
                            for(var classday=0;classday<aClassdays.length;classday++){
                                if($(this).children().eq(aClassdays[classday]).html() == scheduleDay && nextMonth == scheduleMonth && parseInt(year) == scheduleYear){
                                    $(this).children().eq(aClassdays[classday]).addClass('conflict');
                                    num_conf+=1;
                                }
                            }
                        });
                    });
                });
                /*New Schedule dates*/
                $.each(info['schedule'], function(key,val){
                    var scheduleDate = val;
                    scheduleDate = scheduleDate.split("-");
                    var scheduleYear = Number(scheduleDate[0]);
                    var scheduleMonth = Number(scheduleDate[1]);
                    var scheduleDay = Number(scheduleDate[2]);
                    
                    $.each($(".days tr"), function(){
                        for(var classday=0;classday<aClassdays.length;classday++){
                            if($(this).children().eq(aClassdays[classday]).html() == scheduleDay && nextMonth == scheduleMonth && parseInt(year) == scheduleYear){
                                if($(this).children().eq(aClassdays[classday]).attr('class') != 'conflict'){
                                    $(this).children().eq(aClassdays[classday]).addClass('assigned');                                      
                                }
                            }
                        }
                    });
                });
                /*Holiday dates*/
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
                /*IF NEXT MONTH*/
                var attr = "";
                $.each($(".days tr"), function(){ 
                    for(var classday=0;classday<7;classday++){                
                        if($(this).children().eq(classday).attr('class') == 'holiday' || $(this).children().eq(classday).attr('class') == 'conflict' || $(this).children().eq(classday).attr('class') == 'assigned'){
                            attr = $(this).children().eq(classday).attr('class');
                        } 
                    }
                }); 
                if(first_mnth == 0 && attr == ""){
                    classLongTerm.next(true,staticMonth,staticYear);     
                    first_mnth = 1;
                }                
            }
        });
    },
    
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
        classLongTerm.calendar(month,year);
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
        classLongTerm.calendar(month,year);
    }
    
};

$(document).ready(function(){ 
    $('#search_button').click(function(){
        classLongTerm.searchInfo();
    });
    
    $('#point_check').keyup(function(){
        classLongTerm.acceptsNum();
    });
    
    $('#startdate_lterm').change(function(){
        first_mnth = 0;
        var month = $("#startdate_lterm").val();
        var d_year = $("#startdate_lterm").val().substr(0,4);  
        var d_month = (month.substr(5,1) == '0') ? month.substr(6,1) : month.substr(5,2); 
        classLongTerm.calendar(d_month,d_year);
        $(".schedule_calendar_popup").show();
    });    
    
    $('#point_check').keydown(function(){
        classLongTerm.acceptsNum();
    });
    
    $('#submit_point').click(function(){
        if(($('#point_check').val() > 0 != false) && $('#userid_point').val()!=""){
            classLongTerm.submitPoint();
        } else if($('#userid_point').val() == ""){
            $('#userid_point').focus();
            $('#point_notfound').html("Please enter the user ID. Click 'Verify ID' button.");
        } else if($('#point_check').val() > 0 == false){
            $('#point_check').focus();
            $('#point_notfound').html("Please enter a valid point value.");            
        }
        setTimeout(function(){
            $('#point_notfound').html("");
        },1500); 
    });
    
    $('#submit_lterm').click(function(){
        if($('#startdate_lterm').val()!="" && $('#userid_lterm').val()!=""){
            classLongTerm.saveLongterm();
        } else if($('#userid_lterm').val() == ""){
            $('#userid_lterm').focus();
            $('#lterm_notfound').html("Please enter the user ID. Click 'Verify ID' button.");
            setTimeout(function(){
                $('#lterm_notfound').html("");
            },1500); 
        } else if($('#startdate_lterm').val() == ""){
            $('#startdate_lterm').focus();
            $('#lterm_notfound').html("Please enter the start date.");
            setTimeout(function(){
                $('#lterm_notfound').html("");
            },1500);
        }
    });
    
    $('select[name=select_point]').change(function(){
        classLongTerm.showRest();
    });
    
    $('#search_id').keyup(function(){
        if($('#search_id').val().length ==20){
            common.message('warning', 'Unable to enter another character.');
        }
    });
    
    $('#period_startdate,#period_enddate').datepicker({
        beforeShow : classLongTerm.customRangeSearch,
        constrainInput: true,
        showOn: 'button',
        dateFormat : 'yy-mm-dd',
        buttonText: '<a class="btn_calendar" href="javascript:void(0);">Calendar</a>'
    }); 
    
    $('#startdate_lterm').datepicker({
        beforeShow : classLongTerm.customRangeLterm,
        constrainInput: true,
        showOn: 'button',
        dateFormat : 'yy-mm-dd',
        buttonText: '<a class="btn_calendar" href="javascript:void(0);">Calendar</a>'
    }); 
    
    $('#btn_lterm').click(function(){
        classLongTerm.initiateValues();
        classLongTerm.showLterm();
    }); 
    
    $('#btn_point').click(function(){
        classLongTerm.initiateValues();
        classLongTerm.showPoint();
    });  
    
    $('#submit_result_userid').click(function(){ 
        $('.user_id').val($('#userid_check').val());
        $('#result_userid').dialog("close");        
        if($('#add_point').dialog('isOpen') == true){         
            var n_found = '#point_notfound';
            $('#point_check').removeAttr("disabled");
        } else {
            var n_found = '#lterm_notfound';
            $('#startdate_lterm').removeAttr("disabled");
            $('.ui-datepicker-trigger').removeAttr("disabled");
            $(".schedule_calendar_popup").hide();
            $('.hasDatepicker').val("");
        }        
        $(n_found).html("<span style='color:#2489CE;font-weight:bold;margin-left:90px;'>User ID found!</span>");
        setTimeout(function(){
            $(n_found).html("");
        },1500);        
        classLongTerm.showClasses();        
        $('.select_class').removeAttr("disabled");
    });
    
    $('.select_class').change(function(){
        if($('#add_point').dialog('isOpen') == true){                        
            classLongTerm.showRest();
        } else {
            classLongTerm.showWaiting(); 
            $('.hasDatepicker').val("");
            $(".schedule_calendar_popup").hide();
        } 
    });
    
    $('#submit_find_userid').click(function(){
        classLongTerm.findUserId();
    });
    
    $('.verify_id').click(function(){
        $('#point_notfound').html("");
        $('#userid_not_found').html("");
        $('#userid_check').val("");
        classLongTerm.showFindUserId(); 
        $('#userid_check').focus();
    });   
});
