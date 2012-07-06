var dateNow = new Date();
var currentMonth = dateNow.getMonth() + 1;
var currentYear = dateNow.getFullYear();
var month = dateNow.getMonth() + 1;
var day = dateNow.getDate();
var year = dateNow.getFullYear();
$(document).ready(function(){
    $("#stat_personnel").show();
    $("#daystart, #dayend").datepicker({dateFormat: 'yy-mm-dd', beforeShow : LMSTeachersList.customRange ,constrainInput: true,showOn: 'button',buttonText: '<a class="btn_calendar" href="javascript:void(0);">Calendar</a>'});

    $("#saveGrade").click(function(){
        LMSTeachersList.saveGrade();
    });
    
    $("#modifyThis").click(function(){
        LMSTeachersList.modifyGrade();
    });
    

    LMSTeachersList.yearMonth(month, year);
    LMSTeachersList.checkDate(month, year);
    LMSTeachersList.calendar(month, year);
    
});

var base_url = $("#base_url").val();
var LMSTeachersList = {
    
     checkDate: function(type,val){
        if(type === "year"){
           var year = val;
        }else{
           var month = val;
        }
		
        LMSTeachersList.yearMonth($("#selMonth").val(),  $("#selYear").val());
        LMSTeachersList.calendar($("#selMonth").val(),$("#selYear").val());
        
     },
     
     yearMonth: function(month,year){
        $("#selYear").val(year);
		$("#selMonth").val(month);
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
          //LMSTeachersList.checkDate(month, year);
          LMSTeachersList.yearMonth(month, year);
          LMSTeachersList.calendar(month, year);
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
          //LMSTeachersList.checkDate(month, year);
          LMSTeachersList.yearMonth(month, year);
          LMSTeachersList.calendar(month, year);
     },
     
     calendar : function(month, year)
     {
        $("#prev").html('<a class="btn pn" href = "javascript:void(0)" onClick=LMSTeachersList.prev(false,'+month+','+year+')>Prev Month</a>');
        $("#next").html('<a class="btn pn" href = "javascript:void(0)" onClick=LMSTeachersList.next(true,'+month+','+year+')>Next Month</a>');
        var year1 = year, month1 = $.trim(month);
		
        var sHtml = "";
        $(".statistic_total_info").empty();
        $.ajax({
            url : document.URL,
            type :"POST",
            dataType: "json",
            data : {action : "getStatTotal", dateAssigned : year1+"-"+month1+"-01"},
            success : function(data)
            {
                var iClass = (data.iClass == "") ? "0" : data.iClass;
                var iAverage = parseInt(data['min_teacher']) + parseInt(data['max_teacher']);
                var iTotal = parseInt(data.iPostponed + data.iCancelled + data.iLTPostponed) - data.iAttend;
                iTotal = (iTotal < 1) ? "0" : iTotal;
                
                sHtml += '   <p>Total Number of Teacher: <span>'+parseInt(data.iTeacher)+'</span></p>';
                sHtml += '   <p>Total Number of Classes: <span>'+parseInt(iClass)+'</span></p>';
                sHtml += '   <p>Average number of each teacher&rsquo;s classes: <span>'+parseInt(iAverage)+'</span></p>';
                sHtml += '   <p>Maximum Class teacher : <b>'+data.max_teacher_name+'</b> <span>&nbsp;('+parseInt(data.max_teacher)+')</span></p>';
                sHtml += '   <p>Minimum Class teacher : <b>'+data.min_teacher_name+'</b> <span>('+parseInt(data.min_teacher)+')</span></p>';
                sHtml += '   <p>Attend ratio : <span>'+parseInt(data.iAttend)+' / '+parseInt(iTotal)+'</span> (<span class="total_postponed">'+data.iPostponed+'</span> postponed, <span class="total_cancelled">'+data.iCancelled+' canceled</span>, <span class="total_longterm_postponed">'+data.iLTPostponed+'</span> Long term postponed)</p>';

                $(".statistic_total_info").html(sHtml);
				
                
            }
        });
		
        
     },
     
     customRange : function(input) {
          if (input.id == 'dayend') {
            return {
              minDate: $('#daystart').datepicker("getDate")
            };
          } else if (input.id == 'daystart') {
            return {
              maxDate: $('#dayend').datepicker("getDate")
            };
          }
    },
    
    searchQuery : function()
    {
        
        var userid = $.trim($('#personnelName').val()), sDate = $.trim($('#daystart').val()), eDate = $.trim($('#dayend').val()); 
        var bvalidate = $(".search_form").validateForm();

        if(bvalidate===true)
        {
            window.location.href = base_url + "admin/teacher/?action=statistic_personnel&userid="+userid+"&sDate="+sDate+"&eDate="+eDate;
        }
            
    },
    
    saveMemo : function(idx)
    {
       // $(".save_memo_class").attr('id','memo_id_'+idx);
        var name = 'memo_id_'+idx;
        var userid = $.trim($('#personnelName').val()), sDate = $.trim($('#daystart').val()), eDate = $.trim($('#dayend').val()),  memo = $("textarea[name="+name+"]").val();
        $.ajax({
                type: "POST",
                url: document.URL,
                data : {action : "saveMemo", idx : idx, memo : memo}
        }).done(function(result) {  
            if(result == "success"){
               Menu.message(result,"Memo was successfully saved").fadeOut(5000);
               
            }else{
                Menu.message(result,"There's no changes.");
            }
            window.location.href = base_url + "admin/teacher/?action=statistic_personnel&userid="+userid+"&sDate="+sDate+"&eDate="+eDate; 
            
        });
    },
    
    checkAll : function(selector)
    {
    	if ($(selector).is(":checked") === true){
            $.browser.msie ? $(".event_mouse_over input:checkbox").prop("checked", "checked") : $(".event_mouse_over input:checkbox").attr("checked", "checked");
        }
        else {
            $.browser.msie ? $(".event_mouse_over input:checkbox").removeProp("checked") : $(".event_mouse_over input:checkbox").removeAttr("checked");
        }
    },
    
    deleteThis : function()
    {
        var fields = $(".input_chk").serializeArray();
        var idx = [];
        $.each(fields,function(i,field){
            idx.push(field.value);

        });
        if(idx == ""){
            Menu.message("warning","Please make a selection from the list.");
        }else{
            $("#delete_confirm_1").dialog({
                    resizable: false,
                    height:140,
                    modal: true,
                    buttons: {
                            "Delete all items": function() {
                               $.ajax({
                                        type: "POST",
                                        url: document.URL,
                                        data : {action : "deleteThis", idx : idx}
                                }).done(function(result) {  
                                    Menu.message(result,"Record(s) was successfully deleted");
                                    window.location.href = base_url + "admin/teacher/";
                                });
       
                            },
                            Cancel: function() {
                                    $( this ).dialog( "destroy" );
                            }
                    }
                });
            
        }

    },

    addUser : function(){
        window.location.href = base_url + "admin/user/?action=user_list&sub=add_user";
    },
    
    addGrade : function(){
        $("#add_grademanage").dialog({
            modal : true,
            buttons : {
                "Add" : function(){
                    var gradeName = $.trim($("#gradeName").val()), description = $.trim($("#gradeDesc").val());
        
                    $.ajax({
                        type: "POST",
                        url: document.URL,
                        data : {action : "saveGrade", gradeName : gradeName, description : description}
                    }).done(function(result) {
                        $("#add_grademanage").empty();
                        Menu.message(result,"Record(s) was successfully added");
                        LMSTeachersList.gradeManage();
                    });
                }
            }
        });
    },
    
    modifyPopUp : function(idx){
  
        $.ajax({
            type: "POST",
            dataType : "JSON",
            url: document.URL,
            data : {action : "get_idx", idx : idx},
            success : function(result){
            
                $.each(result,function(key, val){
                    $("#mIdx").val(val.idx);
                    $("#mGradeName").val(val.grade_name);
                    $("#mGradeDesc").val(val.description);
                });
                $("#modify_grademanage").dialog({
                    modal : true,
                    buttons : {
                        "Modify" : function(){
                            var gradeName = $.trim($("#mGradeName").val()), description = $.trim($("#mGradeDesc").val()), idx = $.trim($("#mIdx").val());
     
                            $.ajax({
                                type: "POST",
                                url: document.URL,
                                data : {action : "modifyGrade", idx : idx, gradeName : gradeName, description : description}
                            }).done(function(result) {
                                $("#modify_grademanage").empty();
                                Menu.message(result,"Record(s) was successfully modified");
                                LMSTeachersList.gradeManage();
                            });
                        }
                    }
                });
            }
            
        });
        
    },
    
    gradeManage : function(){
        window.location.href = base_url + "admin/teacher/?action=grade_manage";
    },
    
    deleteGrade : function()
    {
        
        var fields = $(".input_chk").serializeArray();
        if(fields == ""){
            Menu.message("warning","Please make a selection from the list.");
        }else{
            var idx = [];
            $.each(fields,function(i,field){
                idx.push(field.value);

            });
       
                $("#delete_confirm").dialog({
                    resizable: false,
                    height:140,
                    modal: true,
                    buttons: {
                            "Delete all items": function() {
                               $.ajax({
                                    type: "POST",
                                    url: document.URL,
                                    data : {action : "deleteThisGrade", idx : idx}
                                }).done(function(result) {  
                                    Menu.message(result,"Record(s) was successfully deleted");
                                    LMSTeachersList.gradeManage();
                                });
       
                            },
                            Cancel: function() {
                                    $( this ).dialog( "destroy" );
                            }
                    }
                });
       
                
            
        }
        
             

    }
}