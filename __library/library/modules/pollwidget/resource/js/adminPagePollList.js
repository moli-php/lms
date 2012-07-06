$(document).ready(function() {
    options = { 'years_between' : [2000,2030],'format' : 'yyyy-mm-dd' };
    $("#start, #end").BuilderCalendar(options);
});
var ongoing = 0;
var adminPagePollList = {
        CheckAll : function(){
            if($('.chk_all').is(':checked') == false)
                $('.input_chk').each( function() { $(this).removeAttr('checked') });
            else
                $('.input_chk').each( function() { $(this).attr('checked', true) });
        },

        GetCheckedValues: function(){
            ongoing = 0;
            var values = new Array();
            $.each($('input[name="adminPagePollid[]"]:checked'), function() {
                values.push($(this).val());
                if($('#Status_'+$(this).val()).html() == 'OnGoing')
                    ongoing += 1;
            });
            
            return values;
        },
        
        Delete: function(){
            if(adminPagePollList.GetCheckedValues() != '')
            {
                if(ongoing == 0){
                    popup.load('pollwidget_delete_popup').skin('admin').layer({
                        'title' : 'Delete',
                        'width' : 250,
                        'classname': 'ly_set ly_editor'
                    });
                }
                else{
                    popup.load('pollwidget_delete_2_popup').skin('admin').layer({
                        'title' : 'Delete',
                        'width' : 250,
                        'classname': 'ly_set ly_editor'
                    });
                }
            }
            else
                oValidator.generalPurpose.getMessage(false, "No item(s) selected.");
        },
        
        DeleteCheckedValues: function(){
            $.ajax({ 
                type: "POST",  
                url: usbuilder.getUrl("apiPollDelete"),  
                data: "adminPagePollid=" + adminPagePollList.GetCheckedValues()
            }).done(function(result) { 
                oValidator.generalPurpose.getMessage(true, "Deleted successfully"); 
                window.location.href = window.location.href;
            });
        },
        
        
        SearchPoll: function(url){
            uri = '';
            if($("#keyword").val() != ''){
                uri += "&search=" + $("#keyword").val();
            }
            if($("#start").val() != '' && $("#end").val() != '' && ($("#start").val() <= $("#end").val())){
                uri += "&s=" + $("#start").val() + "&e=" + $("#end").val();
            }
            if($("#start").val() == '' && $("#end").val() == '' && $("#keyword").val() == ''){
                oValidator.generalPurpose.getMessage(false, "Invalid search code.");
            }
            
            if(uri != ''){
                window.location.href = url+uri;
            }
        },
        
        mostAction : function()
        {
            window.location.href = usbuilder.getUrl("adminPagePollAdd");
        },
        
        set_Options : function(){
            if($("#options").val() == '1'){
                $("#start").val((new Date).getFullYear() + '-' + ((new Date).getMonth()+1 >= 9 ? (new Date).getMonth()+1 : '0'+(parseInt((new Date).getMonth())+1)) + '-' + ((new Date).getDate() >= 9 ? (new Date).getDate() : '0'+(new Date).getDate()));
                $("#end").val((new Date).getFullYear() + '-' + ((new Date).getMonth()+1 >= 9 ? (new Date).getMonth()+1 : '0'+(parseInt((new Date).getMonth())+1)) + '-' + ((new Date).getDate() >= 9 ? (new Date).getDate() : '0'+(new Date).getDate()));
            }
            if($("#options").val() == '3'){
                $("#start").val((new Date).getFullYear() + '-' + ((new Date).getMonth()+1 >= 9 ? (new Date).getMonth()+1 : '0'+(parseInt((new Date).getMonth())+1)) + '-01');
                $("#end").val((new Date).getFullYear() + '-' + ((new Date).getMonth()+1 >= 9 ? (new Date).getMonth()+1 : '0'+(parseInt((new Date).getMonth())+1)) + '-' + (new Date((new Date).getFullYear(), (new Date).getMonth()+1, 0).getDate()));
            }
            if($("#options").val() == '4'){
                if((new Date).getMonth() == 0){
                    var year = (new Date).getFullYear() - 1;
                    var mon = 12;
                    var mon2 = 12;
                }
                else{
                    var year = (new Date).getFullYear();
                    var mon = (new Date).getMonth() >= 9 ? (new Date).getMonth() : '0'+(parseInt((new Date).getMonth())+1);
                    var mon2 = (new Date).getMonth();
                }
                    
                $("#start").val(year + '-' + mon + '-01');
                $("#end").val(year + '-' + mon + '-' + (new Date((new Date).getFullYear(), mon2, 0).getDate()));
            }
            if($("#options").val() == '5'){
                $("#start").val((new Date).getFullYear() + '-01-01');
                $("#end").val((new Date).getFullYear() + '-12-31');
            }
            if($("#options").val() == '6'){
                $("#start").val((new Date).getFullYear()-1 + '-01-01');
                $("#end").val((new Date).getFullYear()-1 + '-01-31');
            }
        }
}