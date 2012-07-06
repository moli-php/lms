var answers = new Array();
$("#pollwidget_event_next").click( function(){
    current = parseInt($("#current").val());
    next = (current + 1) > $("#question_count").val() ? 1 : (current + 1);
    $("#current").val(next);
    frontPagePollwidget.showForm(next);
});

$("#pollwidget_event_prev").click( function(){
    current = parseInt($("#current").val());
    prev = (current - 1) < 1 ? $("#question_count").val() : (current - 1);
    $("#current").val(prev);
    frontPagePollwidget.showForm(prev);
});

$("#pollwidget_event_all").click( function(){
    frontPagePollwidget.getAllForm();
});

$("#pollwidget_event_result").click( function(){
    $('#all_pollwidget_result_container').dialog({title: 'Online Poll Result',width: 1000,height: 900,draggable: false, modal: true});  
});

$("#all_pollwidget_event_result").click( function(){
    $("#pollwidget_event_result").click();
});

$("#all_pollwidget_event_join").click( function(){
    $("#pollwidget_event_join").click();
});

$("#pollwidget_event_join").click( function(){
    err = 0;
    answer = '';
    opinion = '';
    answers = new Array();
    answers[0] = {"q_count" : $("#question_count").val(), "poll" : $("#pid").val()};
    for(i = 0; i < $("#question_count").val(); i++){
        choice_type = $("#choice_type_"+i).val();
        if(choice_type == 0){
            answer = $("input[name='pollwidget_"+i+"']:checked").val();
            if(answer != undefined)
                opinion = $('#opinion_'+i+'_'+answer.replace(" ","_")).val();
            else
                opinion = '';
        }
        else if(choice_type == 1){
            var values = new Array();
            var op = new Array();
            $.each($('input[name="pollwidget_'+i+'[]"]:checked'), function(index, value) {
                values.push($(this).val());
                str = $(this).val();
                if(str != undefined)
                    op.push($('#opinion_'+i+'_'+str.replace(" ","_")).val());
                else
                    op.push('');
            });
            answer = values;
            opinion = op;
        }
        else if(choice_type == 2){
            var sChoices = new Array();
            var sChoices2 = new Array();
            $.each(choice_type_3 = $('#pollwidget_choices_list_'+i+' li').find('select'), function(index, value){
                sChoices.push($(value).val());
                sChoices2.push($("#ranking_value_"+i+"_" + index).val());
            });
            answer = sChoices+"||"+sChoices2;
            opinion = '';
        }
        else if(choice_type == 3){
            answer = $("#pollwidget_"+i).val();
            opinion = '';
        }
        
        if(answer == '' || answer == undefined || answer == null){
            err += 1;
            num = i;
        }
        
        answers[parseInt(i)+1] = {"q_id" : $('#qid_'+i).val(), "q_answer" : answer,"c_type" : $('#choice_type_'+i).val(), "c_opinion" : opinion};

    }
    if(err == 0){
        $('#pollwidget_container_all').dialog("close");
        $('#submit-form').dialog({title: 'Alert Message',width: 250,height: 200,draggable: false, modal: true}); 
        window.location.href = window.location.href;
        $.ajax({ 
            type: "post",  
            url: usbuilder.getUrl("apiPollSave"),  
            data: {"answers" : answers},
            dataType: 'json'
        }).done(function(result) {
            //alert(result.Data);
        });
    }
    else{
        $('#check-form').dialog({title: 'Alert Message',width: 250,height: 200,draggable: false, modal: true}); 
        frontPagePollwidget.showForm(num+1);
    }
});

var frontPagePollwidget = {
        getForm : function(){
            $.ajax({ 
                type: "post",  
                url: usbuilder.getUrl("apiPollwidget"),  
                data: {"load" : "all"},
                dataType: 'json'
            }).done(function(result) {
                if(result.Data['status'] == 'NoPoll'){
                    $("#pollwidget_choices").html("<center><font color=\"red\">There are no Scheduled Poll at this time.</font></center>");
                    $('#pollwidget_event_result').hide();
                    $('#pollwidget_event_prev').hide();
                    $('#pollwidget_event_next').hide();
                    $('#pollwidget_event_join').hide();
                    $('#pollwidget_event_all').hide();
                }
                if(result.Data['status'] == 'Done'){
                    $("#pollwidget_choices").html("<center><font color=\"red\">You are already done with this poll.</font></center>");
                    $('#pollwidget_event_prev').hide();
                    $('#pollwidget_event_next').hide();
                    $('#pollwidget_event_join').hide();
                    $('#pollwidget_event_all').hide();
                }
                else{
                $('#pollwidget_nav').append('<input type="hidden" id="question_count" value="'+result.Data.Question_Count+'">');
                $('#pollwidget_nav').append('<input type="hidden" id="pid" value="'+result.Data.PID+'">');
                $('#pollwidget_nav').append('<input type="hidden" id="current" value="1">');
                for(counter = 0; counter < result.Data.Question_Count; counter++){
                    $("#pollwidget_number").append('<strong class="question_number"  id="number_'+counter+'"><span>'+result.Data['Number_'+counter]+'.</span></strong>');
                    $("#pollwidget_question").append('<strong  class="question_title" id="question_'+counter+'">'+result.Data['Question_'+counter]+'</strong>');
                    
                    var sChoices = '<input type="hidden" id="qid_'+counter+'" value="'+result.Data['ID_'+counter]+'">';
                    sChoices += '<input type="hidden" id="choice_type_'+counter+'" value="'+result.Data['Choice_type_'+counter]+'">';
                    sChoices += '<input type="hidden" id="choice_number_'+counter+'" value="'+result.Data['Number_of_Choices_'+counter]+'">';
                    sChoices += '<ul class="pollwidget_choices_list" id="pollwidget_choices_list_'+counter+'">';
                
                    if(result.Data['Choice_type_'+counter] == 0){
                        $.each(result.Data['Choices_'+counter], function(index, value){
                            sChoices += "<li><input type=\"radio\" name=\"pollwidget_"+counter+"\" class=\"input_radio\" id=\"pollwidget_"+counter+"\" onclick=\"frontPagePollwidget.radio_mask('1','"+counter+"');\" value=\"" + value['choice'] + "\"><label class=\"choice_label\"> " + value['choice'] + "</label>";
                            if(value['opinion'] == 1){
                                str = value['choice'];
                                sChoices += "<br />Opinion: <input type=\"text\" id=\"opinion_"+counter+"_"+str.replace(" ","_")+"\" onkeyup=\"frontPagePollwidget.mask_opinion('1','"+counter+"_"+str.replace(" ","_")+"');\">";
                            }
                            sChoices += "</li>";
                        });
                    }
                    else if(result.Data['Choice_type_'+counter] == 1){
                        $.each(result.Data['Choices_'+counter], function(index, value){
                            sChoices += "<li><input type=\"checkbox\" name=\"pollwidget_"+counter+"[]\" class=\"input_checkbox\" id=\"pollwidget_"+counter+"[]\" value=\"" + value['choice'] + "\" onclick=\"javascript: frontPagePollwidget.checkbox_mask('1','"+counter+"');\"><label class=\"choice_label\"> " + value['choice'] + "</label>";
                            if(value['opinion'] == 1){
                                str = value['choice'];
                                sChoices += "<br />Opinion: <input type=\"text\" id=\"opinion_"+counter+"_"+str.replace(" ","_")+"\" onkeyup=\"frontPagePollwidget.mask_opinion('1','"+counter+"_"+str.replace(" ","_")+"');\">";
                            }
                            sChoices += "</li>";
                        });
                    }
                    else if(result.Data['Choice_type_'+counter] == 2){
                        $.each(result.Data['Choices_'+counter], function(index, value){
                            sChoices += "<li><input type=\"hidden\" id=\"ranking_"+counter+"_" + index + "\" value=\"" + (index+1) + "\"><input type=\"hidden\" id=\"ranking_value_"+counter+"_" + index + "\" value=\"" + value['choice'] + "\">";
                            sChoices += "<select class=\"input_dropbox\" name=\"pollwidget_"+counter+"_" + index + "\" id=\"pollwidget_"+counter+"_" + index + "\" onchange=\"frontPagePollwidget.setRanking('" + counter + "','" + index + "')\">";
                            for(i = 1; i <= result.Data['Choices_'+counter].length; i++){
                                sChoices += "<option";
                                if(i == (index+1))
                                    sChoices += " Selected";
                                sChoices += ">"+i+"</option>";
                            }
                            sChoices += "</select><label class=\"choice_label\"> " + value['choice'] + "</label></li>";
                        });
                    }
                    else{
                        sChoices += "<li>";
                        sChoices += "<textarea class=\"choice_texarea\" name=\"pollwidget_"+counter+"\" id=\"pollwidget_"+counter+"\" onkeyup=\"javascript: frontPagePollwidget.limitText("+counter+");\" onkeydown=\"javascript: frontPagePollwidget.limitText("+counter+");\" style=\"width: 100%;\"></textarea><input type=\"text\" class=\"textarea_counter\" id=\"limit_"+counter+"\" value=\""+result.Data['Limit_'+counter]+"\" readonly size=\"4\" style=\"float: right;\"><input type=\"hidden\" id=\"textlimit_"+counter+"\" value=\""+result.Data['Limit_'+counter]+"\" readonly size=\"4\"></li>";
                    }
                    
                    //$("#pollwidget_choices_list").html('');
                    sChoices += "</ul>";
                    $("#pollwidget_choices").append(sChoices);
                    
                    $('#number_'+counter).hide();
                    $('#question_'+counter).hide();
                    $('#pollwidget_choices_list_'+counter).hide();
                }}
        });
            
        },
        
        getAllForm : function(){
            $('#pollwidget_container_all').dialog({title: 'Online Poll',width: 900,height: 900,draggable: false, modal: true});          
        },
        
        loadStartQuestion : function(counter){
            setTimeout('frontPagePollwidget.showForm('+counter+')',1000);
        },
        
        showForm : function(counter){
            counter -= 1;
            if(counter > parseInt($('#question_count').val())-1)
                counter = 1;
            if(counter < 0)
                counter = parseInt($('#question_count').val());
            
            for(i = 0; i < parseInt($('#question_count').val()); i++){
                if(i == counter){
                    $('#number_'+i).show();
                    $('#question_'+i).show();
                    $('#pollwidget_choices_list_'+i).show();
                }
                else{
                    $('#number_'+i).hide();
                    $('#question_'+i).hide();
                    $('#pollwidget_choices_list_'+i).hide();
                }
            }
            
            
        },

        setRanking : function(counter, index){
            old_val = $('#ranking_' + counter + '_' + index).val();
            new_index = $('#pollwidget_' + counter + '_' + index).val();
            choice_type_3 = $('#pollwidget_choices_list_'+counter+' li').find('select');
            $.each(choice_type_3, function(index2, value){
                if($('#pollwidget_choices_list_'+counter+' li').find('select').index($('#pollwidget_' + counter + '_' + index)) != index2){
                    if($(value).val() == new_index){
                        $(value).val(old_val);
                        $('#pollwidget_' + counter + '_' + index).val();
                        $('#ranking_' + counter + '_' + index).val($('#ranking_' + counter + '_' + index2).val());
                        $('#ranking_' + counter + '_' + index2).val(old_val);
                        
                        $('#all_pollwidget_'+counter+'_'+index).val(new_index);
                        $('#all_pollwidget_'+counter+'_'+index2).val(old_val);
                    }
            }
            });
        },
        
        limitText : function(counter){
            str = $('#pollwidget_'+counter).val();
            $('#all_pollwidget_'+counter).val($('#pollwidget_'+counter).val());
            len = str.length;
            limit = $('#textlimit_'+counter).val();
            
            new_limit = parseInt(limit) - len;
            if(new_limit < 0){
                $('#pollwidget_'+counter).val(str.substring(0, limit));
                $('#all_pollwidget_'+counter).val(str.substring(0, limit));
            }
            else{
                $('#limit_'+counter).val(new_limit);
                $('#all_limit_'+counter).val(new_limit);
            }
        },
        
        ranking_mask : function(counter, index){
            new_val = $('#all_pollwidget_'+counter+'_'+index).val();
            $('#pollwidget_' + counter + '_' + index).val(new_val);
            frontPagePollwidget.setRanking(counter, index);
        },
        
        desc_mask : function(counter){
            $('#pollwidget_'+counter).val($('#all_pollwidget_'+counter).val());
            frontPagePollwidget.limitText(counter);
        },
        
        radio_mask : function(i, counter){
            if(i == 1)
                answer = $("input[name='pollwidget_"+counter+"']:checked").val();
            else
                answer = $("input[name='all_pollwidget_"+counter+"']:checked").val();
            
            $("input[name='pollwidget_"+counter+"']").each( function(index, value){
                  if($(value).val() == answer)
                      $(value).attr('checked', true);
            });
            $("input[name='all_pollwidget_"+counter+"']").each( function(index, value){
                if($(value).val() == answer)
                    $(value).attr('checked', true);
           });
            
        },
        
        mask_opinion : function(i, id){
            if(i == 1)
                opinion = $("#opinion_"+id).val();
            else
                opinion = $("#all_opinion_"+id).val();

            $("#opinion_"+id).val(opinion);
            $("#all_opinion_"+id).val(opinion);
        },
        
        checkbox_mask : function(i, id){
            answers = new Array();
            if(i == 1){
                $.each($('input[name="pollwidget_'+id+'[]"]:checked'), function(index, value) {
                    answers.push($(this).val());
                    $('input[name="all_pollwidget_'+id+'[]"]').removeAttr('checked');
                });
            }
            else{
                $.each($('input[name="all_pollwidget_'+id+'[]"]:checked'), function(index, value) {
                    answers.push($(this).val());
                    $('input[name="pollwidget_'+id+'[]"]').removeAttr('checked');
                });
            }
            $.each(answers, function(index, value) {
                $.each($('input[name="all_pollwidget_'+id+'[]"]'), function(ind, val) {
                    if(value == $(val).val())
                        $(val).attr('checked', true);
                });
                $.each($('input[name="pollwidget_'+id+'[]"]'), function(ind, val) {
                    if(value == $(val).val())
                        $(val).attr('checked', true);
                });
            });
        }
}