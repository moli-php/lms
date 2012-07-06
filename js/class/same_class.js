var sameJS = {    
    searchStudent : function(){
        var course = ($("#search_class").val()=='Class') ? '' : $("#search_class").val();
        var teacher = ($("#search_teacher").val()=='Teacher') ? '' : $("#search_teacher").val();
        var branch = ($("#search_branch").val()=='Branch') ? '' : $("#search_branch").val();
        var sdate = $("#period_startdate").val();
        var edate = $("#period_enddate").val();
        var name = $("#search_id").val();
        var sUrl = common.getClassUrl($('#action').val()); 
        if(branch == undefined){
            branch = "";
        }
        window.location.href = sUrl+"&name="+name+"&sdate="+sdate+"&edate="+edate+"&teacher="+teacher+"&branch="+branch+"&class="+course; 
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
    
    gotoClasslist : function(){
//        var sUrl = common.getClassUrl("classList");
//        location.href = sUrl;
    }
};

$(document).ready(function(){  
    $('#period_startdate,#period_enddate').datepicker({
        beforeShow : sameJS.customRange,
        constrainInput: true,
        showOn: 'button',
        dateFormat : 'yy-mm-dd',
        buttonText: '<a class="btn_calendar" href="javascript:void(0);">Calendar</a>'
    });  

    $('#search_button').click(function(){
        sameJS.searchStudent();
    });
});
