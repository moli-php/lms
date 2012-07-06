var dashboard = {
    sortDashboard : function(){
        $('.dashboard').sortable({
            connectWith: '.dashboard',
            handle: 'h2',
            cursor: 'move',
            placeholder: 'placeholder',
            forcePlaceholderSize: true,
            opacity: 0.4,
            stop: function(event, ui){
                $(ui.item).find('h2').click();
                var sortorder= new Array();
                var total= new Array();
                $('.dashboard').each(function(){
                    var itemorder=$(this).sortable('toArray');
                    total.push(itemorder.length);
                    sortorder.push(itemorder);
                });
                $.ajax({
                    url : "index.php",
                    type : "GET",
                    dataType : "JSON",
                    data : "action=saveSettings&item_name="+sortorder+"&total="+total[0]
                });                
            }
        }).disableSelection();
    },
    
    toggleContent : function(){
        $('.dashboard_item h2').append('<a href="javascript:void(0);" class="toggle show_toggle">▲</a>');  //▼
        $('.dashboard_item h2 .toggle').hide();
        
        $('.dashboard_item').each(function(){
            $(this).hover(function(){
                $(this).find('h2 .toggle').show();
            }, function(){
                $(this).find('h2 .toggle').hide();
            })
            .find('.toggle').click(function(){
                var content = $(this).parent().siblings('.content');   
                if($(this).attr('class') == 'toggle hide_toggle'){
                    content.slideDown('fast', function(){
                        $(this).parent().find('h2').find('a').html('▲');
                        $(this).parent().find('h2').find('a').attr('class', 'toggle show_toggle');                    
                    });
                 } else {
                     content.slideUp('fast', function(){
                         $(this).parent().find('h2').find('a').html('▼');
                         $(this).parent().find('h2').find('a').attr('class', 'toggle hide_toggle');                     
                     });
                 }
                $(this).parent().parent().css("min-height","0px"); //.dashboard_item
            })  
        });
    }
    
    
}
$(document).ready(function(){ 
    $(".loader").siblings().hide();
    $(".loader").show();
    setTimeout(function(){        
        $(".loader").fadeOut(600, function(){
            $(".loader").siblings().fadeIn(500);
        });
    },400);
    
    dashboard.toggleContent();
    dashboard.sortDashboard();
});