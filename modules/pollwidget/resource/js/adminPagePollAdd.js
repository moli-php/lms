$(document).ready(function() {
    options = { 'years_between' : [2000,2030],'format' : 'yyyy-mm-dd' };
    $("#start, #end").BuilderCalendar(options);
});

var adminPagePollAdd = {
        CheckForm: function(){
            if(!oValidator.formName.getMessage('pollwidget_add'))
                oValidator.generalPurpose.getMessage(false, "Fill all Required fields.");
            else{
                var siz = $('#questions_tbl table').size();
                
                if(siz==0){
                    oValidator.generalPurpose.getMessage(false, "Add at least one question.");
                    return;
                }            
                
                var proc = true;
                $("#questions_tbl textarea").each(function(){
                    var content_text = $.trim($(this).val());
                    
                    if(content_text.length < 1) {
                        oValidator.generalPurpose.getMessage(false, "Missing content of question.");
                        $(this).css("border", "2px solid #dc4e22");
                        $(this).focus();
                        return proc=false;
                    }
                    else{
                        $(this).css("border", "");
                    }
                });
                
                if(!proc) {
                    return;
                }
                
                var _siz = $('#questions_tbl table').size();

                var proc2 = true;
                for(i=0; i<_siz; i++) {
                    var type = $("input[name='question_choice_type_"+(i+1)+"']:checked").val();

                    if(type != '3') {
                        $("#content_choice_list_"+(i+1)+" .input_table").each(function(){
                            var ch_cont = $.trim($(this).val());
                            if(ch_cont.length < 1){
                                oValidator.generalPurpose.getMessage(false, "Missing choices.");
                                $(this).css("border", "2px solid #dc4e22");
                                $(this).focus();
                                proc2 = false;
                                return false;
                            } else {
                                $(this).css("border", "");
                                proc2=true;
                            }
                            if(proc2==false) {
                                return false;
                            }
                        });
                        
                        var inp_siz = $("#content_choice_list_"+(i+1)+" .input_table").size();
     
                        if(inp_siz < 2 && proc2) {
                            oValidator.generalPurpose.getMessage(false, "Question Number " + (i+1) + " requires at least 2 choices.");
                            return false;
                        }

                    } else {
                        var dmax = $("#question_cont_"+(i+1)+" .input_table").val();
                        
                        valid = this.is_numeric(dmax);
                        
                        if(!valid || dmax > 2000) {
                            oValidator.generalPurpose.getMessage(false, "Invalid input for Maximum Length.");
                            $("#question_cont_"+(i+1)+" .input_table").css("border", "2px solid #dc4e22");
                            $("#question_cont_"+(i+1)+" .input_table").focus();
                            return;
                        }
                    }
                    
                    if(proc2==false) {
                        return false;
                    }
                }

                $('#pollwidget_add').submit();
                }
        },
        
        mostAction : function()
        {
            window.location.href = usbuilder.getUrl("adminPagePollAdd");
        },
        
        add_choice : function(sel)
        {
            var qno = $(sel).parents('table').index()+1;
            var li_siz = $('#content_choice_list_' + qno + ' li').size();

            $('ul#content_choice_list_'+qno).append('<li style="padding: 2px;"><input type="text" name="' + qno + '_choice[]" class="input_table" style="width:500px;" />\n<span class="btn_input"><input type="button" id="btn_cont_plus_'+qno+'" class="btn_cont_plus" alt="add choice" onclick="javascript: adminPagePollAdd.add_choice(this);" style="width: 20px;" value="+"/>\n<input type="button" id="btn_cont_minus_'+qno+'" class="btn_cont_minus" onclick="javascript: adminPagePollAdd.remove_choice(this);" alt="delete choice" style="width: 20px;" value="-"/>\n<input type="button" id="btn_cont_top_'+qno+'" class="btn_cont_top" alt="move choice top" onclick="javascript: adminPagePollAdd.move_choice(this);" style="width: 20px;" value="<" />\n<input type="button" id="btn_cont_bt_'+qno+'" class="btn_cont_bt" alt="move choice bottom" onclick="javascript: adminPagePollAdd.move_choice(this);" style="width: 20px;" value=">" />\n</span></li>');

            $('ul#content_choice_list_' +qno + ' li:nth-child('+li_siz+') .btn_cont_plus').css('display', 'none');

            if(li_siz == 1) {
                $('ul#content_choice_list_' +qno + ' li:nth-child('+li_siz+') .btn_cont_top').css('display', '');
                $('ul#content_choice_list_' +qno + ' li:nth-child('+li_siz+') .btn_cont_bt').css('display', '');
            }
            
        },
        
        add_choice_noarr : function(sel)
        {
            var qno = $(sel).parents('table').index()+1;
            $('ul#content_choice_list_'+qno).append('<li style="padding: 2px;"><input type="text" name="'+qno+'_choice[]" class="input_table" style="width:500px;" />\n<span class="btn_input"> <input type="button" id="btn_cont_plus_'+qno+'" class="btn_cont_plus" alt="" onclick="adminPagePollAdd.add_choice(this)"  style="width: 20px;" value="+"/>\n<input type="button" id="btn_cont_minus_'+qno+'" class="btn_cont_minus" alt="" onclick="adminPagePollAdd.remove_choice(this)" style="width: 20px;" value="-"/>\n<input type="button" id="btn_cont_top_'+qno+'" class="btn_cont_top" alt="" onclick="adminPagePollAdd.move_choice(this)" style="width: 20px;display:none" value="<"/>\n<input type="button" id="btn_cont_bt_'+qno+'" class="btn_cont_bt" alt="" onclick="adminPagePollAdd.move_choice(this)" style="width: 20px;display:none" value=">"/></span>\n</li>');
            $('#choice_txt_explan_'+qno).html('If you want to get an additional opinion about this question, click the "Additional Opinion" button.');
        },
        
        remove_choice : function(sel)
        {
            var qno = $(sel).parents('table').index()+1;
            
            $(sel).parents('li').remove();

            var li_siz = $('#content_choice_list_' + qno + ' li').size();
            
            if(li_siz == 0) {
                $('#choice_txt_explan_'+qno).html('<span class="btn01"><input type="button" id="btn_add_a_choice_'+qno+'" value="&nbsp;+ add a choice&nbsp;" style="font-size:11px; width: 120px;" onclick="adminPagePollAdd.add_choice_noarr(this)"/></span>');
            } else if(li_siz == 1) {
                $('#content_choice_list_'+qno+ ' li:nth-child('+li_siz+') .btn_cont_plus').css('display', '');
                $('#content_choice_list_'+qno+ ' li:nth-child('+li_siz+') .btn_cont_minus').css('display', '');
                $('#content_choice_list_'+qno+ ' li:nth-child('+li_siz+') .btn_cont_top').css('display', 'none');
                $('#content_choice_list_'+qno+ ' li:nth-child('+li_siz+') .btn_cont_bt').css('display', 'none');
                
            }  else {
                $('#content_choice_list_'+qno+ ' li:nth-child('+li_siz+') .btn_cont_plus').css('display', '');
            }
        },
        
        move_choice : function(sel)
        {
            var qno = $(sel).parents('table').index()+1;
            var row = $(sel).parents('li:first');
            var siz = $('#content_choice_list_'+qno+' li').size();

            if($(sel).is('.btn_cont_top')) {
                
                if(row.prev().index() < 0) {
                    oValidator.generalPurpose.getMessage(false, "Cannot move further.");
                }
                
                row.insertBefore(row.prev());
                
                if(row.next()) {
                    row.children('span').children('input').eq(0).css('display', 'none');

                    if(row.index()+2 == siz || siz <= 2) {
                        row.next().children('span').children('input').eq(0).css('display', '');
                    }

                } 
            } else {
                if(row.next().index() < 0) {
                    oValidator.generalPurpose.getMessage(false, "Cannot move further.");
                }
                
                row.insertAfter(row.next());
                if(row.next()) {
                    row.children('span').children('input').eq(0).css('display', '');
                    row.prev().children('span').children('input').eq(0).css('display', 'none');
                    
                    if(row.index() < siz) {
                        row.children('span').children('input').eq(0).css('display', 'none');
                    }
                    
                    if(row.index() == siz-1)
                    {
                        row.children('span').children('input').eq(0).css('display', '');
                    }
                }
            }
        },
        
        choice_option_on : function(sel)
        {
            var qno = $(sel).parents('table').index()+1; 
            $('#question_cc_'+qno).css('display', '');
            $('#question_cc_dum_'+qno).css('display', '');
            $('#btn_add_opinion_'+qno).css('display', '');
            $('#question_cont_'+qno).css('display', 'none');
        },
        
        choice_option_off : function(sel)
        {
            var qno = $(sel).parents('table').index()+1; 
            $('#question_cc_'+qno).css('display', '');
            $('#question_cc_dum_'+qno).css('display', '');
            $('#btn_add_opinion_'+qno).css('display', 'none');
            $('#question_cont_'+qno).css('display', 'none');
        },

        choice_option_desc : function(sel)
        {
            var qno = $(sel).parents('table').index()+1; 
            $('#btn_add_opinion_'+qno).css('display', 'none');
            $('#question_cc_'+qno).css('display', 'none');
            $('#question_cc_dum_'+qno).css('display', 'none');
            $('#question_cont_'+qno).css('display', '');
            //$('<tr id="question_cont_'+qno+'"><th>Maximum Length</th><td><ul class="row_list"><li>Max <input type="text" class="input_table" style="width:100px;"> byte <span class="txt_explan">( Maximum length is 2000 bytes.)</span></li></ul></td></tr>').insertAfter('#question_cc_'+qno); 
        },
        
        add_opinion_popup : function (sel) 
        {
            popup.load('pollwidget_opinion_popup').skin('admin').layer({
                'title' : 'Additional Opinion Settings',
                'width' : 500,
                'classname': 'ly_set ly_editor'
            });
           
            var qno = $(sel).parents('table').index()+1; 
            var qst = $.trim($('#q_num_' + qno + " .question_content_" +qno).val()) == "" ? "[question not set]" : $.trim($('#q_num_' + qno + " .question_content_" +qno).val());
            
            $('#op_numbering').text(qno);
            $('#op_quest').text(qst);

            var chcount = $("#content_choice_list_"+qno+" > li").size();
            
            $('[id^=cont_not_set]').remove();

            if(chcount == 0) {
                $('.op').append('<tr id="cont_not_set"><td class="fir subject" colspan="2" style="text-align:center">Content not set.</td></tr>');
            } else {
                $('[class^=op_added]').remove();
                $("#content_choice_list_"+qno+" > li").each(function() {

                    var choice = $.trim($(".input_table", this).val());
                    var chk = $(this).attr('comment') == '1' ? 'checked' : '';

                    if(choice.length != 0) {
                        $('.op').append('<tr class="op_added"><td class="fir subject">'+ choice +'</td><th><input type="checkbox" class="chk_box" name="op_check[]" '+ chk +' value="" style="width:20px;"/></th></tr>');
                    } else {
                        $('.op').append('<tr class="op_added"><td class="fir subject">[choice not set]</td><th><input type="checkbox" class="chk_box" name="op_check[]" value="" disabled value="" style="width:20px;"/></th></tr>');
                    }               
                });
            }
            $('#add_opinion_qnum').val(qno);
            $('#btn_opinion_close').blur();
        },
        
        close_opinion_popup : function (sel)
        {
            var qno = $('#add_opinion_qnum').val();
            var ops = '';
            $('input[name="op_check[]"]').each(function(index){
                
                if(!$(this).is(':checked')) {
                    ops += '0,';
                } else {
                    ops += '1,';
                }
            });

            $('#add_opinion_qnum').val('');
            $('#choice_opinion_'+qno).val(ops);
            popup.close('pollwidget_opinion_popup');
        },
        
        add_question_form : function()
        {
            var siz = $('#questions_tbl table').size();
            var curr_num = siz + 1;
            
            var tbl = '<table border="0" cellpadding="0" cellspacing="0" class="table01 table_input_vr" style="margin-top:20px" id="q_num_'+curr_num+'">';
            
            tbl += '<colgroup><col width="160" /><col /></colgroup>';
            tbl += '<tr id="disp_num_tr_'+curr_num+'"><th>Question number</th><td><span id="span_num_'+curr_num+'">'+curr_num+'<input type="hidden" name="qnum[]" value="'+curr_num+'" /></span><div style="float:right;"  id="quest_btn_'+curr_num+'"><span class="btn01 ml10"><input type="button" value="&nbsp;Additional option&nbsp;" class="btn_add_opinion" id="btn_add_opinion_'+curr_num+'" onclick="adminPagePollAdd.add_opinion_popup(this)" style="width: 110px;"/></span>\n<span class="btn01 ml10" ><input type="button" value="&nbsp;- delete&nbsp;" class="btn_delete_a_question" id="btn_delete_a_question_'+curr_num+'" onclick="adminPagePollAdd.delete_a_question(this)" style="width: 110px;"/></span></span></div></td></tr>';
            tbl += '<tr id="question_c_'+curr_num+'"><th>Content of Question</th><td><textarea name="question_content[]" id="question_content_'+curr_num+'" fw-filter="isFill" fw-label="question_content_'+curr_num+'" class="question_content_'+curr_num+'" rows="5" style="width:100%"></textarea></td>';
            tbl += '</tr><tr id="question_r_'+curr_num+'"><th>Required</th><td><input type="checkbox" class="check_type" name="quest_reqd_'+curr_num+'" id="question_reqd_'+curr_num+'" checked="checked" value="1" style="width: 12px; padding: 1px 5px 1px 15px; border: none;"/><label for="question_reqd_'+curr_num+'">I will set this as a required questionnaire to answer.</label></td></tr>';
            tbl += '<tr id="question_t_'+curr_num+'"><th>Type of Choices</th>';
            tbl += '<td><input type="radio" id="choice_one_answer_'+curr_num+'" name="question_choice_type_'+curr_num+'" class="radio_type" checked="checked" value="0" onclick="adminPagePollAdd.choice_option_on(this)" style="width: 12px; padding: 1px 5px 1px 15px; border: none;"/><label for="choice_one_answer_'+curr_num+'">One Answer</label>';
            tbl += '<input type="radio" id="choice_multiple_answers_'+curr_num+'" name="question_choice_type_'+curr_num+'" class="radio_type list_gab" value="1" onclick="adminPagePollAdd.choice_option_on(this)" style="width: 12px; padding: 1px 5px 1px 15px; border: none;"/><label for="choice_multiple_answers_'+curr_num+'">Multiple Answers</label>';
            tbl += '<input type="radio" id="choice_ranking_'+curr_num+'" name="question_choice_type_'+curr_num+'" class="radio_type list_gab" value="2" onclick="adminPagePollAdd.choice_option_off(this)" style="width: 12px; padding: 1px 5px 1px 15px; border: none;"/><label for="choice_ranking_'+curr_num+'">Ranking</label>';
            tbl += '<input type="radio" id="choice_description_'+curr_num+'" name="question_choice_type_'+curr_num+'" class="radio_type list_gab" value="3" onclick="adminPagePollAdd.choice_option_desc(this)" style="width: 12px; padding: 1px 5px 1px 15px; border: none;"/><label for="choice_description_'+curr_num+'">A Form of Description</label></td></tr>';
            tbl += '<tr id="question_cc_'+curr_num+'">';
            tbl += '<th>Content of Choices</th><td><ul class="row_list" id="content_choice_list_'+curr_num+'">';
            tbl += '<li style="padding: 2px;"><input type="text" name="'+curr_num+'_choice[]" class="input_table" style="width:500px;" />';
            tbl += '<span class="btn_input">\n';
            tbl += '<input type="button" id="btn_cont_plus_'+curr_num+'" class="btn_cont_plus" alt="add choice" onclick="javascript: adminPagePollAdd.add_choice(this);" style="width: 20px;" value="+"/>\n';
            tbl += '<input type="button" id="btn_cont_minus_'+curr_num+'" class="btn_cont_minus" onclick="javascript: adminPagePollAdd.remove_choice(this);" alt="delete choice" style="width: 20px;" value="-"/>\n';
            tbl += '<input type="button" id="btn_cont_top_'+curr_num+'" class="btn_cont_top" alt="move choice top" onclick="javascript: adminPagePollAdd.move_choice(this);" style="width: 20px;display:none" value="<" />\n';
            tbl += '<input type="button" id="btn_cont_bt_'+curr_num+'" class="btn_cont_bt " alt="move choice bottom" onclick="javascript: adminPagePollAdd.move_choice(this);" style="width: 20px;display:none" value=">" />\n';
            tbl += '</span>';
            tbl += '</li></ul><input type="hidden" name="choice_opinion_'+curr_num+'" id="choice_opinion_'+curr_num+'" value="" /><span class="txt_explan" id="choice_txt_explan_'+curr_num+'">If you want to get an additional opinion about this question, click the "Additional Opinion" button.</span>';
            tbl += '<tr id="question_cont_'+curr_num+'" style="display:none"><th>Maximum Length</th><td><ul class="row_list"><li>Max <input type="text" name="desc_max_input_'+curr_num+'" class="input_table" style="width:100px;"> byte <span class="txt_explan">( Maximum length is 2000 bytes.)</span></li></ul></td></tr>';
            tbl += '</table>';
            
            $(tbl).insertAfter('#q_num_' + siz);
            $('#add_form_btn').css('display', '');
            
            if(siz == 0) {
                $(tbl).appendTo('#questions_tbl');
                $('#btm_add_form').css('display', 'none');
            } else {
                $('#btm_add_form').css('display', '');
            }
        },

        delete_a_question : function(sel)
        {
            var siz = $('#questions_tbl table').size();
            var ans = confirm("Are you sure you want to delete this question?");
            
            if(!ans) {
                return false;
            }
            
            if(siz <= 2) {
                $('#add_form_btn').css('display', 'none');
            }
            
            var qno = $(sel).parents('table').index()+1; 
            
            this.change_id(sel, qno);
        },

        change_id : function(sel, qno)
        {
            //var ctr = parseInt(qno);
            
            var siz = $('#questions_tbl table').size();
            var ind = $(sel).parents('#questions_tbl table').index()+1;

            $('#questions_tbl table:nth-child('+ind+')').remove();

            for(i=ind; i<siz; i++) {
                next_ind = i+1;
                //prev_ind = i-1;

                $('#questions_tbl table:nth-child('+i+')').attr('id', 'q_num_'+i);

                //FOR disp_num_tr_NUM
                $('#q_num_'+i+' tr:nth-child(1)').attr('id', 'disp_num_tr_'+i);
                $('#disp_num_tr_'+i+' #span_num_'+next_ind).attr('id', 'span_num_'+i);
                $('span#span_num_'+i).html(i+'<input type="hidden" name="qnum[]" value="'+i+'">');
                $('#disp_num_tr_'+i+' #quest_btn_'+next_ind).attr('id', 'quest_btn_'+i);
                $('#quest_btn_'+i+' #btn_add_opinion_'+next_ind).attr('id', 'btn_add_opinion_'+i);
                $('#quest_btn_'+i+' #btn_delete_a_question_'+next_ind).attr('id', 'btn_delete_a_question_'+i);
                $('#quest_btn_'+i+' #btn_add_a_question_'+next_ind).attr('id', 'btn_add_a_question_'+i);
                $('#quest_btn_'+i+' #btn_modify_a_question_'+next_ind).attr('id', 'btn_modify_a_question_'+i);
                
                //FOR question_c_NUM
                $('#q_num_'+i+' tr:nth-child(2)').attr('id', 'question_c_'+i);
                $('#question_c_'+i+' textarea').attr('name', 'question_content[]');
                $('#question_c_'+i+' textarea').attr('id', 'question_content_'+i);
                $('#question_c_'+i+' textarea').attr('class', 'question_content_'+i);
                
                //FOR question_r_NUM
                $('#q_num_'+i+' tr:nth-child(3)').attr('id', 'question_r_'+i);
                $('#question_r_'+i+' input').attr('name', 'question_reqd_'+i);
                $('#question_r_'+i+' input').attr('id', 'question_reqd_'+i);
                $('#question_r_'+i+' label').attr('for', 'question_reqd_'+i);
                
                //FOR question_t_NUM
                $('#q_num_'+i+' tr:nth-child(4)').attr('id', 'question_t_'+i);
                $('#question_t_'+i+' #choice_one_answer_'+next_ind).attr('id', 'choice_one_answer_'+i);
                $('#question_t_'+i+' input').attr('name', 'question_choice_type_'+i);
                $('#question_t_'+i+' #choice_multiple_answers_'+next_ind).attr('id', 'choice_multiple_answers_'+i);
                $('#question_t_'+i+' #choice_ranking_'+next_ind).attr('id', 'choice_ranking_'+i);
                $('#question_t_'+i+' #choice_description_'+next_ind).attr('id', 'choice_description_'+i);
                
                //FOR question_cc_NUM
                //$('#q_num_'+i+' tr:nth-child(5)').attr('id', 'question_cc_'+i);
                $('#question_cc_'+next_ind).attr('id', 'question_cc_'+i);
                $('#question_cc_'+i+' #content_choice_list_'+next_ind).attr('id', 'content_choice_list_'+i);
                $('#btn_cont_plus_'+next_ind).attr('id', 'btn_cont_plus_'+i);
                $('#btn_cont_minus_'+next_ind).attr('id', 'btn_cont_plus_'+i);
                $('#btn_cont_top_'+next_ind).attr('id', 'btn_cont_plus_'+i);
                $('#btn_cont_bt_'+next_ind).attr('id', 'btn_cont_plus_'+i);
                $('#content_choice_list_'+i+' li input').attr('name', i+'_choice[]');
                
                //FOR choice_txt_explan_NUM
                $('#question_cc_'+i+' .txt_explan').attr('id', 'choice_txt_explan_'+i);
                
                //FOR question_cont_NUM
                //$('#q_num_'+i+' tr:nth-child(6)').attr('id', 'question_cont_'+i);
                $('#question_cont_'+next_ind).attr('id', 'question_cont_'+i);
                $('#question_cont_'+i+' input').attr('name', 'desc_max_input_'+i);
                
                //FOR choice_opinion_NUM
                $('#choice_opinion_'+next_ind).attr('name','choice_opinion_'+i);
                $('#choice_opinion_'+next_ind).attr('id','choice_opinion_'+i);

                //FOR desc_max_input_3
                $("input[name='desc_max_input_"+next_ind+"']").attr('name', 'desc_max_input_'+i);
            }
            //$('#questions_tbl table:nth-child('+ind+')').remove();
            this.change_label();
        },

        change_label : function()
        {
            var siz = $('#questions_tbl table').size();

            for(i=1; i<=siz; i++) {
                $('#choice_one_answer_'+i).next().attr('for', 'choice_one_answer_'+i);
                $('#choice_multiple_answers_'+i).next().attr('for', 'choice_multiple_answers_'+i);
                $('#choice_ranking_'+i).next().attr('for', 'choice_ranking_'+i);
                $('#choice_description_'+i).next().attr('for', 'choice_description_'+i);
                $('#question_reqd_'+i).next().attr('for', 'question_reqd_'+i);
            }
        },
        
        is_numeric : function(input)
        {
            return (input - 0) == input && input.length > 0;
        },
        
        check_overlap : function(){
            if($("#start").val() != '' && $("#end").val() != ''){
                if(!isNaN(Date.parse($("#start").val())) && !isNaN(Date.parse($("#end").val()))){
                    if($("#start").val() < $("#end").val()){
                        today = new Date();
                        if(Date.parse($("#start").val()) > Date.parse(today)){
                            $.ajax({ 
                                type: "post",  
                                url: usbuilder.getUrl("apiPollCheckOverlap"),  
                                data: {"start" : $("#start").val(), "end" : $("#end").val()},
                                dataType: 'json'
                            }).done(function(result) { 
                                if(result.Data != null){
                                    oValidator.generalPurpose.getMessage(false, "Period overlaps with Poll [ " + result.Data + " ].");
                                    $("#start").val('');
                                    $("#end").val('');
                                }
                                else
                                    oValidator.generalPurpose.getMessage(true, "Valid date.");
                            });
                         }
                        else{
                            oValidator.generalPurpose.getMessage(false, "Invalid Start Date.");
                            $("#start").val('');
                            $("#end").val('');
                        }
                    }
                    else{
                        oValidator.generalPurpose.getMessage(false, "Start Date is ahead of its End Date.");
                        $("#start").val('');
                        $("#end").val('');
                    }
                }
                else{
                    oValidator.generalPurpose.getMessage(false, "Invalid Date");
                    $("#start").val('');
                    $("#end").val('');
                }
            }
        }
}