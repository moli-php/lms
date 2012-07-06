var total = 0;
var menuManagement = { 
    check : 0,
    sortable : function(){
        $('.menu_order').sortable({
            connectWith: '.menu_order',
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
    get_menu_data: function(){
		var aMenu = new Array(); 
		
		$.each($(".menu_order_item"), function(i) {
			
			/*push array*/
			aMenu.push({
				idx: $(".menu_order_item:eq("+i+")").attr('id'),
				label: $(".menu_order_item:eq("+i+")").attr('title'),
				page: $(".menu_order_item:eq("+i+")").attr('name')
			});
			
		});
		
		return aMenu;
	
	},
    saveSettings : function(){  
		
		var aData = menuManagement.get_menu_data();
		
		
        if(aData.length >= 1){
           $.ajax({
				url : "menu_management/index.php",
				dataType: 'json',
				data: {
				action: 'save',
				data: aData
				},
				success : function(response){
				//console.log(response);
                    if(response){
                        $('.menu_order_item').each(function(){     
                            $(this).attr("class", "menu_order_item");
                        });
                        Menu.message('success', 'Saved Successfully!');
						
						setTimeout(function() { location.reload(); }, 4000 );
                    }
                }
            });
        } else {
            Menu.message('warning', 'menu must contain at least one item.');
        }
    },
    
    checkAll : function(){
        if(this.check == 0){
            $("input[name='show_to_menu']").attr('checked', true);
            this.check = 1;
        }else{
            $("input[name='show_to_menu']").attr('checked', false);  
            this.check = 0;        
        } 
        menuManagement.showAll();
        menuManagement.clickItem();
    },
    
    showAll : function(){
        $('.menu_order').empty();
        var iNum = 0;            
        var aNames = new Array();
		var aId = new Array();
		var aPage = new Array();
        total = 0;
        $("input[name='show_to_menu']:checked").each(function(){
            aNames[iNum] = $(this).attr('title');
			aPage[iNum] = $(this).val();
			aId[iNum] = $(this).attr('id');
		 
            $('.menu_order').append('<li class="menu_order_item" id="'+aId[iNum].replace('chk_','')+'"  title="'+aNames[iNum]+'" name="'+aPage[iNum]+'"  ><strong name="'+aNames[iNum]+'">'+menuManagement.capitalize(aNames[iNum]).replace(/_/g, " ")+'</strong></li>');
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
            $('.menu_order_item').click(function(){     
                $(this).attr("class", "menu_order_item order_selected");
                $(this).siblings().attr("class", "menu_order_item");
            });
        }, 500);
    },
    
    showSortContainer : function(isChecked, valChecked, idChecked,pageChecked){   
        if(isChecked != undefined){   
            total++; 
            var div = '<li class="menu_order_item" id="'+idChecked+'"  title="'+valChecked+'" name="'+pageChecked+'"   ><strong name="'+valChecked+'">'+menuManagement.capitalize(valChecked).replace(/_/g, " ")+'</strong></li>';
            if(total == 1){  $('.menu_order').html(div); }
            else {  $('.menu_order').append(div); }
            menuManagement.clickItem();
        } else {
            $('strong[name="'+valChecked+'"]', '.menu_order').parent().remove();  
        }   
        menuManagement.checkNull();
    },
    
    checkNull : function(){
        if(total == 0 || $('.menu_order').html() == ""){
            total = 0;
            $('.menu_order').html('<strong class="error_null">No item selected for menu.</strong>');
        }
    },
    
    savedInformation : function(){
        $('.menu_order').empty();
        $.ajax({
            url : "menu_management/index.php",
			dataType: 'json',
			data: {
			action: 'display'
			},
            success : function(response){
			var aMenu = $.parseJSON(response);
			
                if(aMenu){
                    $("input[name='show_to_menu']").each(function(){
                        $(this).attr('checked', false);
                    });
                    $.each(aMenu, function(data, value){ 
                        if(value.label != ""){
                            $("input[name='show_to_menu']").each(function(){    						
                                if($(this).val() == value.page ){
                                    $(this).attr('checked', true);
                                } 
                            });  
							//if(value.hidden_flag == 0){
								$('.menu_order').append('<li class="menu_order_item" id="'+value.idx+'"  title="'+value.label+'" name="'+value.page+'"  ><strong name="'+value.label+'">'+menuManagement.capitalize(value.label).replace(/_/g, " ")+'</strong></li>');
							//}
                            total++; 
                        }
                    });
                }  
                menuManagement.clickItem();
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
    },
	
	ret_default: function(){
	
		var aMenu = [{"idx":1,"label":"Dashboard","page":"dashboard","seq":1,"hidden_flag":0},
				{"idx":2,"label":"Message","page":"message","seq":2,"hidden_flag":0},
				{"idx":3,"label":"Class","page":"class","seq":3,"hidden_flag":0},
				{"idx":4,"label":"User","page":"user","seq":4,"hidden_flag":0},
				{"idx":5,"label":"Teacher","page":"teacher","seq":5,"hidden_flag":0},
				{"idx":6,"label":"Point","page":"point","seq":6,"hidden_flag":0},
				{"idx":7,"label":"Ulearning","page":"ulearning","seq":7,"hidden_flag":0},
				{"idx":8,"label":"Product","page":"product","seq":8,"hidden_flag":0},
				{"idx":9,"label":"Forum","page":"forum","seq":9,"hidden_flag":0},
				{"idx":10,"label":"Branch","page":"branch","seq":10,"hidden_flag":0},
				{"idx":11,"label":"Statistics","page":"statistics","seq":11,"hidden_flag":0},
				{"idx":12,"label":"Event","page":"event","seq":12,"hidden_flag":0},
				{"idx":13,"label":"Configuration","page":"configuration","seq":13,"hidden_flag":0}];
				
				$('.menu_order').empty();
				
				 $.each(aMenu, function(data, value){ 
					if(value.label != ""){
						$("input[name='show_to_menu']").each(function(){    						
							if($(this).val() == value.page ){
								$(this).attr('checked', true);
							} 
						});  
							$('.menu_order').append('<li class="menu_order_item" id="'+value.idx+'"  title="'+value.label+'" name="'+value.page+'"  ><strong name="'+value.label+'">'+menuManagement.capitalize(value.label).replace(/_/g, " ")+'</strong></li>');
						total++; 
					}
			  });
			
	}
        
}
$(document).ready(function(){
	
    menuManagement.savedInformation();   //Show Details 
    menuManagement.sortable(); 
	
    
    $("input[name='show_to_menu']").click(function(){
        var isChecked = $(this).attr('checked');
        var valChecked = $(this).attr('title');
		 var idChecked = $(this).attr('id');
		 var pageChecked = $(this).val();
        menuManagement.showSortContainer(isChecked, valChecked,idChecked.replace("chk_",""),pageChecked);
        menuManagement.checkNull();       
    });   
    
    $("#up").live('click',function(){
        menuManagement.sortButtons("up");
    });
    
    $("#down").live('click',function(){
        menuManagement.sortButtons("down");
    });
    
    $("#check_all").click(function(){
        menuManagement.checkAll(); 
        menuManagement.checkNull();       
    });
    
    $("#btn_save_show").click(function(){
        menuManagement.saveSettings();
    });
    
    $("#btn_return").click(function(){
        window.location.href = common.getBaseUrl() + "/admin/menu/";
    });
    
    $("#btn_undo").click(function(){
        menuManagement.savedInformation();        
    });
	
	$("#btn_return_default").click(function(){
        menuManagement.ret_default();        
    });
        
});