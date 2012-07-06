var keyword = $('#keywordparam').val();
var keywordparam = keyword != '' ? '&keyword=' + keyword : '';
var row_selected = $('#rowselected').val();
var rowparam = row_selected != '20' ? '&row=' + row_selected : '';
var flag = '';
$(document).ready(function () {


    if ($('#successparam').val() == "delete") {
        Menu.message('success', "Record(s) was successfully deleted");
    } else if ($('#successparam').val() == "error") {
        Menu.message('warning', "Delete Error");
    } else if ($('#successparam').val() == "update") {
        Menu.message('success', "Record(s) was successfully Updated!");
    } else if ($('#successparam').val() == "save") {
        Menu.message('success', "Record(s) was successfully Saved!");
    }

    $('#searchbtn').click(function () {
        window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection' + rowparam + '&keyword=' + $('#keyword').val();
    });
    $('#show_row').change(function () {
        var row = $(this).val();
        window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection&row=' + row + keywordparam;
    });
	
	if($('#status_hide').val()=="Published"){
		$('#y_select').attr('class','active');
	}else if($('#status_hide').val()=="Unpublished"){
		$('#n_select').attr('class','active');
	}else{
	$('#all_select').attr('class','active all');
	}
	
	
	$('#all_select').click(function () {
		window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection';
    });
	$('#y_select').click(function () {
		window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection&status=Published';
    });
	$('#n_select').click(function () {
		window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection&status=Unpublished';
    });
	
	var orderby = $('#orderset').val()!='desc' ? 'desc':'asc';
	$('#question').click(function () {
		window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection'+rowparam+keywordparam+'&field=question&order='+orderby;
    });
	$('#answer').click(function () {
		window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection'+rowparam+keywordparam+'&field=answer&order='+orderby;
    });
	$('#level').click(function () {
		window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection'+rowparam+keywordparam+'&field=level&order='+orderby;
    });
	$('#point').click(function () {
		window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection'+rowparam+keywordparam+'&field=point&order='+orderby;
    });
	$('#status').click(function () {
		window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection'+rowparam+keywordparam+'&field=status&order='+orderby;
    });
	
	if($('#orderset').val()=='asc'){
	$('#'+$('#fieldset').val()).attr('class','sort_down');
	}else{
	$('#'+$('#fieldset').val()).attr('class','sort_up');
	}
	
    $('#savebtn').live('click', function () {

        if ($('#questionField').val() == '') {
            $('#questionField').attr('class', 'error');
        }
        if ($('#answerField').val() == '') {
            $('#answerField').attr('class', 'error');
        }
        if ($('#points').val() == '' || !$('#points').val().match(/^[0-9]+$/)) {
            $('#points').attr('class', 'error');
        }
        if ($('[name="status_"]:checked').val() && $('#questionField').val() != '' && $('#answerField').val() != '' && $('#points').val() != '' && $('#points').val().match(/^[0-9]+$/)) {


            var arrayques = $('#questionField').val().split(' ');
            var quesarray = new Array();
            for (var i = 0; i <= arrayques.length - 1; i++) {

                var rmvcomma = arrayques[i].replace(',', '');
                quesarray.push(rmvcomma);
            }

            var arraysearch = $('#answerField').val().split(',');

            for (var i = 0; i <= arraysearch.length - 1; i++) {
                if (jQuery.inArray(arraysearch[i], quesarray) > -1) {
                    var insert = '1';
                } else {
                    var insert = '0';
                }
                $('#allowed_array').append(insert);
            }



            if ($('#allowed_array').text().match(/0/g)) {
                alert('Answer did not match to question');
            } else {

                var arr = arraysearch;

                var ar = new Array();
                for (var s = 0; s <= arr.length - 1; s++) {

                    var res = '|' + arr[s] + '|';
                    ar.push(res);
                }

                var answer_ = ar.toString();

                $.ajax({
                    url: common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection&sub=update',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        req: 'saveData',
                        question: $('#questionField').val(),
                        answer: answer_,
                        point: $('#points').val(),
                        level: $('#level_id').val(),
                        status: $('[name="status_"]:checked').val(),
                        idx: flag
                    },
                    success: function (data) {
                        window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection&row=' + row_selected + '&success=' + data;
                    }
                });
            }

        }

    });

    $('#questionField,#answerField,#points').keyup(function () {

        $(this).attr('class', '');
        $('#allowed_array').html('');

    });

});

function Question(con) {
flag = con;
    if (con == 'add') {
        var title1 = "Add New Question";
        $('#questionField').val('');
        $('#answerField').val('');
        $('#points').val('');
        $('[value="Unpublished"]').attr('checked', 'checked');

        $('#level_id').empty();
        var selected = '';
        selected += '	<option>Basic</option>';
        selected += '<option>Intermediate</option>';
        selected += '<option>Advanced</option>';
        $('#level_id').html(selected);

    } else {
        var title1 = "Edit Question";

        $.ajax({
            url: common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection&sub=update',
            type: 'get',
            dataType: 'json',
            data: {
                req: 'getData',
                idx: con
            },
            success: function (data) {
                $('#questionField').val(data[0].question);
                var editanswer = data[0].answer.replace(/[|]/g, '');
                $('#answerField').val(editanswer);
                $('#points').val(data[0].point);

                data[0].status == "Published" ? $('[value="Published"]').attr('checked', 'checked') : $('[value="Unpublished"]').attr('checked', 'checked');
                data[0].level;

                $('#level_id').empty();
                var arr_level = new Array();
                var level_arr = new Array('Basic', 'Intermediate', 'Advanced');
                for (var i in level_arr) {
                    var selected = level_arr[i] == data[0].level ? 'selected' : '';
                    var level_select = '<option ' + selected + '>' + level_arr[i] + '</option>';
                    arr_level.push(level_select);
                }
                $('#level_id').html(arr_level.toString().replace(/,/g, ''));



            }
        });


    }

    $('#addquestion').dialog({
        width: 664.467,
        height: 318.467,
        title: title1,
        resizable: false,
        show: {
            effect: 'clip'
        }
    });




};

function cancel() {

    $('#addquestion').dialog('destroy');
    $('#delpopup').dialog('destroy');

};
var array = "";

function action(val) {

    actionlistval = val == 1 ? $('#ActionListTop').val() : $('#ActionListBottom').val();

    if (actionlistval == "") {
        Menu.message('warning', 'Please make a selection from the list.');
    } else {

        array = new Array();
        for (var i = 1; i <= $('#chkboxcount').val(); i++) {
            if ($('.chkboxlist' + i + ':checked').val()) {
                array.push($('.chkboxlist' + i + ':checked').val());
            }
        }

        if (array.length == 0) {
            Menu.message('warning', "Please make a selection from the list");
        } else {

            if (actionlistval == 'Publish' || actionlistval == 'Unpublish') {
                var UpdateStat = {
                    url: common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection&sub=update',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        idx: array,
                        req: 'updatestat',
                        status: actionlistval
                    },
                    success: function (data) {
                        window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection&row=' + row_selected + '&success=update';
                    },
                    error: function () {
                        Menu.message('warning', 'Record(s) Update Failed');
                    }
                }
                $.ajax(UpdateStat);
            }
            if (actionlistval == 'Delete') {

                $('#delpopup span').remove();
                var delpop = '';
                delpop += '<span>';
                delpop += '<p>Are you sure you want to delete ' + array.length + ' Question(s) ?</p></br>';
                delpop += '<div class="action_btn fr">';
                delpop += '<a href="#" class="btn_save" id="delbtn" title="Save changes" style="margin:3px">Submit</a>';
                delpop += '<a href="javascript:cancel();"  class="btn_save"  title="Return to Users" style="margin:3px">Cancel</a>';
                delpop += '</div>';
                delpop += '</span>';
                $('#delpopup').append(delpop);


                $('#delpopup').dialog({
                    width: 348.467,
                    height: 182.467,
                    resizable: true
                });

                $('#delbtn').click(function () {
                    var delLog = {
                        url: common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection&sub=update',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            idx: array,
                            req: 'del'
                        },
                        success: function (data) {
                            $('#delpopup').dialog("close");
                            window.location = common.getBaseUrl() + '/admin/english_games/?action=sentence_perfection&row=' + row_selected + '&success=' + data;
                        },
                        error: function () {
                            Menu.message('warning', 'Record(s) Delete Failed');
                        }
                    }
                    $.ajax(delLog);
                });
            }
        }

    }
};