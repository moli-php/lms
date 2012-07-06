var classList = {
    addClass : function(){
        var sUrl = common.getClassUrl("classManageList");
        location.href = sUrl;
    },
    
    searchClass : function(){
        var course = ($("#search_class").val()=='Class') ? '' : $("#search_class").val();
        var teacher = ($("#search_teacher").val()=='Teacher') ? '' : $("#search_teacher").val();
        var branch = ($("#search_branch").val()=='Branch') ? '' : $("#search_branch").val();
        var sdate = $("#period_startdate").val();
        var edate = $("#period_enddate").val();
        var name = $("#search_id").val();
        var sUrl = common.getClassUrl("classList"); 
        if(branch == undefined){
            branch = "";
        }
        window.location.href = sUrl+"&name="+name+"&sdate="+sdate+"&edate="+edate+"&class="+course+"&teacher="+teacher+"&branch="+branch; 
    },
    
    delClass : function(){
        var has_check = $("input[name=checkbox_class]");
        var check_box =has_check.filter(':checked').length;
        if(check_box <=0){
            common.message('warning', 'Please select the class you want to delete.');
        } else {
            $('#popup_delete').dialog({
                resizable: false,
                modal: true,
                position: "center",
                title : "Delete &raquo;",
                closeOnEscape: false,
                close : function(){ classList.closePopup(); }
            });
        }
    },
    
    customRange : function(input) {
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
    
    closePopup : function(){
        $("input[name='checkbox_class']").each(function(){
            $(this).attr('checked', false)
        });
        $('#check_all').attr('checked', false);
    },
    
    execDelete : function(){
        var sUrl = common.getClassUrl("classListExecute");
        var iNum = 0;            
        var iIdx = new Array();
        $("input[name='checkbox_class']:checked").each(function(){
            iIdx[iNum] = $(this).val();
            iNum++;
        });
        
        $.ajax({
            url : sUrl,
            type : "GET",
            dataType : "JSON",
            data : "exec=deleteClass&idx="+iIdx,
            success : function(response){
                if(response !=0){                        
                    common.message('success', "Deleted Successfully");
                    $('#popup_delete').dialog("close");
                    setTimeout(function(){
                        window.location.href = window.location.href;
                    },800);                        
                } 
           }
        });        
    },
    
    sendMail : function(email){
        var emailparam =new Array(email);
        message.send_mail(emailparam);
    },
    
    goDetailed : function(num, class_id, stat){
        var sUrl = common.getClassUrl("classManageList");
        var course = ($("#search_class").val()=='Class') ? '' : $("#search_class").val();
        var teacher = ($("#search_teacher").val()=='Teacher') ? '' : $("#search_teacher").val();
        var branch = ($("#search_branch").val()=='Branch') ? '' : $("#search_branch").val();
        var sdate = $("#period_startdate").val();
        var edate = $("#period_enddate").val();
        var name = $("#search_id").val();
        var rows = $("#row_selected").val();
        var view = $(".view_type").val();
        var page_number = $("#page_number").val();
        if(branch == undefined){
            branch = "";
        }
        
        if(num == 1){
            window.location.href = sUrl+"&cid="+class_id+"&name="+name+"&sdate="+sdate+"&edate="+edate+"&class="+course+"&teacher="+teacher+"&branch="+branch+"&rows="+rows+"&view="+view+"&page="+page_number+"&vstat="+stat;
        }
        else {
            window.location.href = sUrl+"&uid="+class_id+"&name="+name+"&sdate="+sdate+"&edate="+edate+"&class="+course+"&teacher="+teacher+"&branch="+branch+"&rows="+rows+"&view="+view+"&page="+page_number+"&vstat="+stat;
        }
    },
    
    testSchedule : function(idx){
        $.ajax({
            url : common.getClassUrl("classExecute"),
            dataType : "json",
            data : {
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
    
    classScheduleCalendar : function(user_id, class_id){
    	location.href = common.getClassUrl("classScheduleCalendar") + "&uid=" + user_id + "&class_id=" + class_id;
    }
};

$(document).ready(function(){      
    $('#search_id').keyup(function(){
        if($('#search_id').val().length ==20){
            common.message('warning', 'Unable to enter another character.');
        }
    });
    
    $('#period_startdate,#period_enddate').datepicker({
        beforeShow : classList.customRange,
        constrainInput: true,
        showOn: 'button',
        dateFormat : 'yy-mm-dd',
        buttonText: '<a class="btn_calendar" href="javascript:void(0);">Calendar</a>'
    });    
    $('input[name="checkbox_class"]').shiftcheckbox();

    $('#search_button').click(function(){
        classList.searchClass();
    });
    
    $('#cancel_del').click(function(){
        $('#popup_delete').dialog("close");
        classList.closePopup();
    });
    
    $('#delete_del').click(function(){
        classList.execDelete();
    });  
    
    $('.class_del').click(function(){
        classList.delClass();
    });
    
    $('.mobile_id').click(function () {        
        var mobile_no = new Array($(this).text());
        message.send_sms(mobile_no);
    }); 

});
