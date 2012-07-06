$(document).ready(function(){
    $('#verify_id').click(function(){
        $('#userid_not_found').html("");
        $('#userid_check').val("");
        $('#find_userid').fadeIn();
        $('#userid_check').focus();
    });
    $("#manage_popup").hide();
        
    $('#submit_find_userid').click(function(){
        LMSPoint.verifyID();
    });
    
    $('#submit_result_userid').click(function(){
        $('#userid').val($('#userid_check').val());
        $('#result_userid').fadeOut();
    });
    
    $('.popup_close').click(function(){
        $('#result_userid').fadeOut();
        $('#find_userid').fadeOut();
    });
    
    $("#daystart, #dayend").datepicker({beforeShow : LMSPoint.customRange ,constrainInput: true, dateFormat : "yy-mm-dd",showOn: 'button',buttonText: '<a class="btn_calendar" href="javascript:void(0);">Calendar</a>'});
    
});
var base_url = $("#base_url").val();
var LMSPoint = {
    backToList : function(){
        var sUrl = common.getClassUrl("point_history");
        location.href = sUrl;
    },   
    //verify user id 
    verifyID : function(){
        if($('#userid_check').val() != null){  
            var user_id = $('#userid_check').val();
            
            $.ajax({
                url : document.URL,
                type : "POST",
                dataType : "JSON",
                data : {action : "verifyUserId", get_user_id : user_id},
                success : function(response){
                    if(response!= null){                        
                        $('#find_userid').fadeOut();
                        $('#userid_found').text(response);
                        $('#result_userid').fadeIn();
                    } else {
                        $('#userid_not_found').html("Please try again.");
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
    //jquery calendar
    customRange : function(input)
    {
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
    
    // checkbox
    checkAll : function(selector)
    {
        if ($(selector).is(":checked") === true){
            $.browser.msie ? $(".event_mouse_over input:checkbox").prop("checked", "checked") : $(".event_mouse_over input:checkbox").attr("checked", "checked");
        }
        else {
            $.browser.msie ? $(".event_mouse_over input:checkbox").removeProp("checked") : $(".event_mouse_over input:checkbox").removeAttr("checked");
        }
    },
    
    //delete selected id
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
            $("#delete_confirm_2").dialog({
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
                                    window.location.href = base_url+ "admin/point";
                                }); 
       
                            },
                            Cancel: function() {
                                    $( this ).dialog( "destroy" );
                            }
                    }
                });
 
        }
        
    },
    
    //give points
    addPoint : function(){
        window.location.href = base_url + "admin/point/?action=point_history&sub=add_point";
    },
    
    //check user id 
    checkId : function()
    {
        $("#popup_confirm").dialog({
            modal: false,
            width : 320,
            height : 200,
            buttons : {
                "Submit" : function(){
                    $.ajax({
                        url : document.URL,
                        type : "POST",
                        data : {action : "checkUserId", user_id : $.trim($("#user_id").val())},
                        success : function(data){
                            alert(data)
                        }
                    });
                }
            }
        });
    },
    
    // save points 
    savePoints : function(){
        var userid = $("#userid").val(), reason = $("#reason").val(), amount = $("#amount").val();
        var bValidate = $("#addPoints").validateForm();
        if(bValidate === true)
        {
            
            $.ajax({
               url : document.URL,
               type : "POST",
               data : {action : "savePoints", userid : userid, reason : reason, amount : amount},
               success : function(result){
                    Menu.message(result,"Successful");
                    window.location.href = base_url+ "admin/point";
               }
            });
          
        }
    },
    
    //search
    searchQuery : function()
    {        
        var userid = $.trim($('#personnelName').val()), sDate = $.trim($('#daystart').val()), eDate = $.trim($('#dayend').val()); 
        var bvalidate = $(".search_form").validateForm();

        if(bvalidate===true)
        {
            window.location.href = base_url + "admin/point/?action=point_history&userid="+userid+"&sDate="+sDate+"&eDate="+eDate;
        }
            
    },
    // manage points configuration
    manage : function(idx, amount)
    {
       
        $(".amounts").attr('id', 'amount_points_'+idx);
        $("#amount_points_"+idx).val(amount);
            $("#manage_popup").dialog({
                modal :true,
                buttons : {
                    Submit : function(){
                        var bvalidate = $(".popup_form").validateForm();
                        var amount1 = $("#amount_points_"+idx).val(), isActive = $("input[name='inactive']:checked").val();                        
                        if(bvalidate === true){
                            $.ajax({
                                url : document.URL,
                                type : "post",
                                data : {
                                    action : "manage", idx : idx, isActive : isActive, amount : amount1 
                                },
                                success : function(data)
                                {
                                    Menu.message(data,"Successful!");
                                    window.location.href = base_url+ "admin/point/?action=point_configuration";
                                }
                            });
                        }
                    }
                }
            });
        
        
    }
}