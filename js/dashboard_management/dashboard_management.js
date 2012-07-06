var total = 0;
var dashboardManagement = { 
    check : 0,
    sortable : function(){
        $('.dashboard_order').sortable({
            connectWith: '.dashboard_order',
            handle: 'strong',
            cursor: 'move',
            placeholder: 'placeholder',
            forcePlaceholderSize: true,
            opacity: 0.4,
            stop: function(event, ui){
                $(ui.item).find('strong').click();
            }
        }).disableSelection();
    },
    
    saveSettings : function(){  
        var iNum = 0;            
        var aNames = new Array();
        $(".dashboard_order li").each(function(){
            aNames[iNum] = $(this).attr('id');
            iNum++;
        });        
        if(aNames.length >= 1){
            $.ajax({
                url : "dashboard_management/index.php",
                type : "GET",
                dataType : "JSON",
                data : "action_mngt=saveSettings&page=dash_mngt&item_name="+aNames,
                complete : function(response){
                    if(response){
                        $('.dash_order_item').each(function(){     
                            $(this).attr("class", "dash_order_item");
                        });
                        Menu.message('success', 'Saved Successfully');
                    }
                }
            });
        } else {
            Menu.message('warning', 'Dashboard must contain at least one item.');
        }
    },
    
    checkAll : function(){
        if(this.check == 0){
            $("input[name=show_to_dashboard]").attr('checked', true);
            this.check = 1;
        }else{
            $("input[name=show_to_dashboard]").attr('checked', false);  
            this.check = 0;        
        } 
        dashboardManagement.showAll();
        dashboardManagement.clickItem();
    },
    
    showAll : function(){
        $('.dashboard_order').empty();
        var iNum = 0;            
        var aNames = new Array();
        total = 0;
        $("input[name='show_to_dashboard']:checked").each(function(){
            aNames[iNum] = $(this).val();
            $('.dashboard_order').append('<li class="dash_order_item" id="'+aNames[iNum]+'"><strong name="'+aNames[iNum]+'">'+dashboardManagement.capitalize(aNames[iNum]).replace(/_/g, " ")+'</strong></li>');
            iNum++;
            total++;
        }); 
    },
    
    capitalize : function(string)
    {
        return string[0].toUpperCase() + string.slice(1);
    },
    
    clickItem : function(){
        setTimeout(function(){   
            $('.dash_order_item').click(function(){     
                $(this).attr("class", "dash_order_item order_selected");
                $(this).siblings().attr("class", "dash_order_item");
            });
        }, 500);
    },
    
    showSortContainer : function(isChecked, valChecked){   
        if(isChecked != undefined){   
            total++; 
            var div = '<li class="dash_order_item" id="'+valChecked+'" ><strong name="'+valChecked+'">'+dashboardManagement.capitalize(valChecked).replace(/_/g, " ")+'</strong></li>';
            if(total == 1){  $('.dashboard_order').html(div); }
            else {  $('.dashboard_order').append(div); }
            dashboardManagement.clickItem();
        } else {
            $('strong[name="'+valChecked+'"]', '.dashboard_order').parent().remove();  
        }   
        dashboardManagement.checkNull();
    },
    
    checkNull : function(){
        if(total == 0 || $('.dashboard_order').html() == ""){
            total = 0;
            $('.dashboard_order').html('<strong class="error_null">No item selected for dashboard.</strong>');
        }
    },
    
    savedInformation : function(){
        $('.dashboard_order').empty();
        $.ajax({
            url : "dashboard_management/index.php",
            type : "GET",
            dataType : "JSON",
            data : "action_mngt=showAll",
            success : function(response){
                if(response!=""){
                    $("input[name='show_to_dashboard']").each(function(){
                        $(this).attr('checked', false);
                    });
                    
                    var iName = response[0]['item_name'];
                    var item_name = iName.split(",");
                    
                    $.each(item_name, function(data, value){  
                        if(value != ""){
                            $("input[name='show_to_dashboard']").each(function(){                           
                                if($(this).val() == value){
                                    $(this).attr('checked', true);
                                } 
                            });  
                            $('.dashboard_order').append('<li class="dash_order_item" id="'+value+'" ><strong name="'+value+'">'+dashboardManagement.capitalize(value).replace(/_/g, " ")+'</strong></li>');
                            total++; 
                        }
                    });
                }  
                else {
                    $('.dashboard_order').html('<strong class="error_null">No item selected for dashboard.</strong>');
                }
                dashboardManagement.clickItem();
            }
        });
    },
    
    sortButtons : function(action){
        var item = $('.order_selected').attr('id');
        if(item == undefined){
            Menu.message('warning', 'Please select an item from the list.');
        }
        else {
            var curr = $('#'+item).attr('id'); 
            
            if(action == "up"){
                var prev = $("#"+curr).prev().attr('id'); 
                if(prev == undefined){
                    Menu.message('warning', 'Do not have previous item.');
                }
                else {
                    $("#"+prev).insertAfter("#"+curr); 
                }  
            } else {
                var next = $("#"+curr).next().attr('id'); 
                if(next == undefined){
                    Menu.message('warning', 'Do not have next item.');
                }
                else {
                    $("#"+next).insertBefore("#"+curr); 
                }  
            }
        }
    }
        
}
$(document).ready(function(){
    dashboardManagement.savedInformation();   //Show Details 
    dashboardManagement.sortable();           //Sort function
    
    $("input[name='show_to_dashboard']").click(function(){
        var isChecked = $(this).attr('checked');
        var valChecked = $(this).val();
        dashboardManagement.showSortContainer(isChecked, valChecked);
        dashboardManagement.checkNull();       
    });   
    
    $("#up").live('click',function(){
        dashboardManagement.sortButtons("up");
    });
    
    $("#down").live('click',function(){
        dashboardManagement.sortButtons("down");
    });
    
    $("#check_all").click(function(){
        dashboardManagement.checkAll(); 
        dashboardManagement.checkNull();       
    });
    
    $("#btn_save_show").click(function(){
        dashboardManagement.saveSettings();
    });
    
    $("#btn_return").click(function(){
        window.location.href = common.getBaseUrl() + "/admin/dashboard/";
    });
    
    $("#btn_undo").click(function(){
        dashboardManagement.savedInformation();        
    });
        
});