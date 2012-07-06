var addClassList = {    
    backToList : function(){
        var sUrl = common.getClassUrl("classList");
        if($("#count_param").val() > 2) {
            var course = ($("#get_class").val()=='Class') ? '' : $("#get_class").val();
            var teacher = ($("#get_teacher").val()=='Teacher') ? '' : $("#get_teacher").val();
            var branch = ($("#get_branch").val()=='Branch') ? '' : $("#get_branch").val();
            var sdate = $("#get_sdate").val();
            var edate = $("#get_edate").val();
            var name = $("#get_name").val();
            var rows = $("#get_rows").val();
            var view = $("#get_view").val();
            var page_number = ($("#get_page").val()=="") ? 1 : $("#get_page").val();
            if(branch == undefined){
                branch = "";
            }            
            location.href = sUrl+"&name="+name+"&sdate="+sdate+"&edate="+edate+"&class="+course+"&teacher="+teacher+"&branch="+branch+"&rows="+rows+"&view="+view+"&page="+page_number;
        } else {
            location.href = sUrl;
        }
    },    
    
    findUserId : function(){
        if($('#userid_check').val() !=""){
            var sUrl = common.getClassUrl("classListExecute");
            var user_id = $('#userid_check').val();  
            $.ajax({
                url : sUrl,
                type : "GET",
                dataType : "JSON",
                data : "exec=findUserId&check=0&user_id="+user_id,
                success : function(response){
                    if(response!=null){                        
                        $('#find_userid').dialog("close");
                        $('#userid_found').text(response);
                        addClassList.showResult(); 
                    } else {
                        $('#userid_not_found').html("Try again. Only students are allowed to add a new class.");
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
    showPeriodClass : function(number){
        var sUrl = common.getClassUrl("classListExecute");
        var teacher = $('input[name=teacherType]:checked').attr('id');
        var classtype = $('input[name=classType]:checked').attr('id');
        var countrytype = (teacher == "american") ? 1 : 0;
        var teacher = $('input[name=teacherType]:checked').attr('id');      
        var period = $('#class_period').val() == null ? "" : $('#class_period').val();
        var user_id = $('#user_id').val() == "" ? "" : $('#user_id').val(); 
        var dataVar = (number == 1) ? { exec : 'showClass', country : countrytype, type : classtype, user_id:user_id } : { exec : 'showClass', country : countrytype, type : classtype, total_months : period, user_id:user_id};
        var curr = "";
        
        if(user_id != "" || $('#cid').val() != ""){        
            $.ajax({
                url : sUrl,
                type : "GET",
                dataType : "JSON",
                data : dataVar,
                success : function(response){
                    var div_period="";
                    var div_name="";  
                    
                    if(response){                    
                        $.each(response, function(index, value) {  
                            var selected="";
                            if(curr!=value["total_months"]){
                                if($('#inputperiod').val() == value["total_months"]){
                                    selected="selected=selected";
                                }                            
                                div_period+="<option value='"+value["total_months"]+"' "+selected+">"+value["total_months"]+"</option>";
                            }
                            if($('#inputclassname').val() == value["name"]){
                                selected="selected=selected";
                            } 
                            div_name+="<option value='"+value["idx"]+"' "+selected+">"+value["name"]+"</option>";
                            curr = value["total_months"];
                        });
                        if(number == 1) $('#class_period').html(div_period); 
                        else $('#class_name').html(div_name); 
                        $('#class_period').removeAttr('disabled');
                        $('#class_name').removeAttr('disabled');
                        $('input[name="teacherType"]').removeAttr('disabled');
                        $('input[name="classType"]').removeAttr('disabled');                        
                        $('select[name="payment"]').removeAttr('disabled');                        
                        $('input[name="confirmation"]').removeAttr('disabled');
                        $("#payment").val('card');
                        
                        if($("#get_vstat").val() == "deleted" || $("#get_vstat").val() == "finished"){
                            $('select[name="payment"]').attr('disabled','disabled');
                            $('input[name="confirmation"]').attr('disabled','disabled');
                        }
                        
                    } else {
                        $('#class_period').html("<option>No Class Period found.</option>"); 
                        $('#class_name').html("<option>No Class found.</option>"); 
                        $('#class_period').attr('disabled','disabled');
                        $('#class_name').attr('disabled','disabled');
                    }
                    
                    addClassList.checkCId();
                }        
            });
        } else {
            $('select[name="class_period"]').attr("disabled", "disabled");
            $('select[name="class_name"]').attr('disabled','disabled');
            $('select[name="payment"]').val("");
            $('select[name="payment"]').attr('disabled','disabled');
            $('#american').attr("checked","checked");
            $('#confirmed').attr("checked","checked");
            $('#phone').attr("checked","checked");
            $('#camera').attr('disabled','disabled');
            $('#filipino').attr('disabled','disabled');
            $('#not_confirmed').attr('disabled','disabled');
        }
    }, 
    
    checkCId : function(){
        if($('#cid').val() != ""){
            $('select[name="class_period"]').attr("disabled", "disabled");
            $('select[name="class_name"]').attr('disabled','disabled');
            $('input[name="teacherType"]').attr('disabled','disabled');
            $('input[name="classType"]').attr('disabled','disabled');
        }
    },
    
    resetForm : function(){
        $('input[name=teacherType]')[0].checked = true;
        $('input[name=classType]')[0].checked = true;
        
        addClassList.showPeriodClass(1);
        setTimeout(function(){
            addClassList.showPeriodClass(2);
        },200);
    },
    
    addClassDetails : function(){
        var sUrl = common.getClassUrl("classListExecute");       
        var user_idx = $('#user_id').val();
        var p_class_idx = $('#class_name').val();      
        var sale_status = $('input[name=confirmation]:checked').attr('id');
        var payment_method = $('#payment').val();
        var cid = $('#cid').val() == null ? "" : $('#cid').val();
        
        if(user_idx!=""){
            var execName = ($('#showTitle').html() =="Add New Class") ? 'addClass' : 'updateClass';
            $.ajax({
                url : sUrl,
                type : "GET",
                dataType : "JSON",
                data : { exec : execName, cid :cid, student_idx :user_idx,p_class_idx:p_class_idx,sale_status:sale_status,payment_method:payment_method },
                success : function(response){ 
                    if(response>=1){
                        if($('#showTitle').html() =="Add New Class") common.message('success', 'Successfully Added the Class');
                        else common.message('success', 'Successfully Updated the Class');
                        setTimeout(function(){
                            addClassList.backToList();
                            if($('#showTitle').html() =="Add New Class") location.href = common.getClassUrl("classList"); 
                            
                        },500);
                    } else {
                        common.message('warning', 'Please fill out the required fields properly');
                    }
                }
            });  
        } else {
            common.message('warning', 'Please fill out the User ID');
        }   
       
        
    },
    
    checkUserId : function(){
        if($('#uid').val() != ""){
            $('#verify_id').hide();
            var uid = ($('#uid').val() !="" || $('#uid').val() != undefined || $('#uid').val() != null) ? $('#uid').val() : "";
            $.ajax({
                url : common.getClassUrl("classListExecute"),
                type : "GET",
                dataType : "JSON",
                data : { exec : 'findID', idx : uid},
                success : function(response){  
                    if(response){
                        $('#user_id').val(response); 
                        if($("#cid").val() == ""){
                            addClassList.resetForm();
                        }   
                    } else {
                        $('#verify_id').show();
                    }
                }
            });
        }        
    },
    
    showFindUserId : function(){
        $('#find_userid').dialog({
            resizable: false,
            draggable: false,
            modal: true,
            position : "center",
            closeOnEscape: false,
            title : "Find User ID &raquo;"            
        });
    },
    
    showResult : function(){
        $('#result_userid').dialog({
            resizable: false,
            draggable: false,
            modal: true,
            position : "center",
            closeOnEscape: false,
            title : "Result &raquo;"            
        });
    }
};

$(document).ready(function(){
    var sTitle = ($('#cid').val() != "") ? "Detail Class Page" : "Add New Class";    
    $(".menu_curpage_breadcrumb").append("Class List&nbsp;&gt;&nbsp;"+sTitle);
    $(".classList").children().attr("class","current");
    
    $('#verify_id').show();
    addClassList.showPeriodClass(1);
    setTimeout(function(){
        addClassList.showPeriodClass(2);
    },200);
    addClassList.checkUserId();
    
    $('#submit_result_userid').click(function(){
        $('#user_id').val($('#userid_check').val());
        $('#result_userid').dialog("close");
        common.message('success', 'User ID found');
        addClassList.resetForm();
    });
    
    $('#back_list').click(function(){        
        addClassList.backToList();
    }); 
    
    $('#submit_find_userid').click(function(){
        addClassList.findUserId();
    });
    
    $('#verify_id').click(function(){
        $('#userid_not_found').html("");
        $('#userid_check').val("");
        addClassList.showFindUserId(); 
        $('#userid_check').focus();
    });   
    
    $('.popup_close').click(function(){
        $('#result_userid').dialog("close");
        $('#find_userid').dialog("close");
    });
    
    $('#reset_classlist').click(function(){
        addClassList.resetForm();
    });    
    
    $('select[name=class_period]').change(function(){ 
        addClassList.showPeriodClass(2);     
    });
    
    $('input[name=teacherType],input[name=classType]').change(function(){        
        addClassList.showPeriodClass(1);     
        setTimeout(function(){
            addClassList.showPeriodClass(2);
        },200);
    });
    
    $('#submit_classlist').click(function(){
        addClassList.addClassDetails();
    });    
});
