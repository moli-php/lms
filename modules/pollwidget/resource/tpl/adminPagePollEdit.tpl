<div id='pollwidget_opinion_popup_contents' style='display:none'>
<div class="admin_popup_contents">
<div class="popup">
<div class="pop_content">
    <p class="pop_explan mb10" style="margin-top:0">For additional comments, please check the checkbox.</p>
        <div class="survey_print_tit mt0" style="margin-top:10px">
            <h5 class="title" style="margin-top:0;display:inline;"><span id="op_numbering"></span>.&nbsp;<span id="op_quest"></span></h5>
        </div>

        <div class="survey_print_wrap bx">
        <table border="0" cellpadding="0" cellspacing="0" class="table02 op" style="width: 100%;">
        <colgroup>
            <col />
            <col width="80" />
        </colgroup>
        <tr>
            <th class="fir">Choice</th>
            <th class="end" style="width:150px">Additional Opinion</th>
        </tr>
        </table>
    </div>
    <div class="clear"></div>
</div>
</div>
<br />
<br />
<a class="btn_nor_01 btn_width_st1" href="javascript: void(0);" style='cursor:pointer' title="opinion" onclick="adminPagePollEdit.close_opinion_popup(this)"> Save </a>
</div>
</div>

<p class="require"><span class="neccesary">*</span> Required</p>
<div>
    <p>
        <span class="module_title">Basic Information</span>
    </p>
</div>
<form name="pollwidget_edit" class="pollwidget_edit" method="post">
<input type="hidden" name="pidx" id="pidx" class="input_table" style="width:500px;" value="<?php echo $aData[0]['idx']; ?>"/>
<input type="hidden" name="add_opinion_qnum" id="add_opinion_qnum" class="input_table" style="width:500px;" value=""/>
<table border="1" cellspacing="0" cellpadding="0" class="table_input_vr">
	<tr>
		<th style="width:150px;"><label><span class="neccesary">*</span>Poll Title: </label></th>
		<td style="padding:0;"><input type="text" id="title" fw-filter="isFill" fw-label="title" name="title" class="fix" value="<?php echo $aData[0]['title']; ?>" maxlength="10"> <span class="neccesary">*</span> Write within 10 Characters.</td>
	</tr>
	<tr>
		<th><label for="clock_location1"><span class="neccesary">*</span>Period: </label></th>
		<td><input type="text" name="start" id="start" class="fix" style="width: 100px;" fw-filter="isFill" fw-label="start" onchange="adminPagePollEdit.check_overlap()"  value="<?php echo $aData[0]['period_start']; ?>"> ~ <input type="text" id="end" name="end" class="fix" style="width: 100px;" fw-filter="isFill" fw-label="end" onchange="adminPagePollEdit.check_overlap()"  value="<?php echo $aData[0]['period_end']; ?>"></td>
	</tr>
	<tr>
        <th>
            <label for="Category">Delete when over?</label>
        </th>
        <td>
            <input type="checkbox" name="autodelete" class="category_checked" style="width: 12px; padding: 1px 5px 1px 15px; border: none;" value="1" <?php if($aData[0]['auto_delete'] == 1){ echo "checked"; } ?>/>
            The poll is not displayed when the poll period is over. The data will be completely deleted.
        </td>
    </tr>
</table>
<div>
    <p>
        <span class="module_title">Questions <a href="#none" onclick="javascript: adminPagePollEdit.add_question_form();" class="btn_nor_01 btn_width_st1" title="search">Add Form</a></span>
    </p>
</div>
<div id="questions_tbl">
<?php foreach($aForm as $key => $field){ ?>
<table border="0" cellpadding="0" cellspacing="0" class="table01 table_input_vr" id="q_num_<?php echo $key+1; ?>">
			<colgroup>
				<col width="160" />
				<col />
			</colgroup>
			<tr id="disp_num_tr_<?php echo $key+1; ?>">
				<td>Question number:</td>
				<td>
				    <span id="span_num_1"><?php echo $key+1; ?><input type="hidden" name="qnum[]" value="<?php echo $key+1; ?>" /></span>
				    <div style="float:right;" id="quest_btn_<?php echo $key+1; ?>">
					<span class="btn01 ml10"><input type="button" value="&nbsp;Additional option&nbsp;" class="btn_add_opinion" id="btn_add_opinion_<?php echo $key+1; ?>" style="width: 110px;<?php if($field['choice_type'] == 3 || $field['choice_type'] == 2) echo "display:none"; ?>" onclick="adminPagePollEdit.add_opinion_popup(this)"/></span>
					<span class="btn01 ml10"><input type="button" value="&nbsp;- delete&nbsp;" onclick="adminPagePollEdit.delete_a_question(this)" class="btn_delete_a_question" id="btn_delete_a_question_<?php echo $key+1; ?>" style="width: 110px;"/></span><span class="btn01 ml10" ></span>
				    </div>
				</td>
			</tr>
			<tr id="question_c_<?php echo $key+1; ?>">
				<td>Content of Question:</td>
				<td><textarea name="question_content[]" id="question_content_<?php echo $key+1; ?>" class="question_content_<?php echo $key+1; ?>" rows="5" style="width:100%" fw-filter="isFill" fw-label="question_content_<?php echo $key+1; ?>"><?php echo $field['question']; ?></textarea></td>
			</tr>
			<tr id="question_t_<?php echo $key+1; ?>">
				<td>Type of Choices:</td>
				<td><input type="radio" id="choice_one_answer_<?php echo $key+1; ?>" name="question_choice_type_<?php echo $key+1; ?>" class="radio_type" <?php if($field['choice_type'] == 0) echo "checked"; ?> value="0" style="width: 12px; padding: 1px 5px 1px 15px; border: none;" onclick="adminPagePollEdit.choice_option_on(this)"/><label for="choice_one_answer_<?php echo $key+1; ?>">One Answer</label>
					<input type="radio" id="choice_multiple_answers_<?php echo $key+1; ?>" name="question_choice_type_<?php echo $key+1; ?>" class="radio_type list_gab" <?php if($field['choice_type'] == 1) echo "checked"; ?> value="1" style="width: 12px; padding: 1px 5px 1px 15px; border: none;"  onclick="adminPagePollEdit.choice_option_on(this)"/><label for="choice_multiple_answers_<?php echo $key+1; ?>">Multiple Answers</label>
					<input type="radio" id="choice_ranking_<?php echo $key+1; ?>" name="question_choice_type_<?php echo $key+1; ?>" class="radio_type list_gab" <?php if($field['choice_type'] == 2) echo "checked"; ?> value="2" style="width: 12px; padding: 1px 5px 1px 15px; border: none;" onclick="adminPagePollEdit.choice_option_off(this)"/><label for="choice_ranking_<?php echo $key+1; ?>">Ranking</label>
				    <input type="radio" id="choice_description_<?php echo $key+1; ?>" name="question_choice_type_<?php echo $key+1; ?>" class="radio_type list_gab" <?php if($field['choice_type'] == 3) echo "checked"; ?> value="3" style="width: 12px; padding: 1px 5px 1px 15px; border: none;"  onclick="adminPagePollEdit.choice_option_desc(this)"/><label for="choice_description_<?php echo $key+1; ?>">A Form of Description</label>
				</td>
			</tr>
			<tr id="question_cc_<?php echo $key+1; ?>" <?php if($field['choice_type'] == 3) echo "style=\"display:none\""; ?>>
				<td>Content of Choices:</td>
				<td>
					<ul class="row_list" id="content_choice_list_<?php echo $key+1; ?>">
					<?php foreach($field['choices'] as $index => $value){ ?>
						<li style="padding: 2px;"><input type="text" name="<?php echo $key+1; ?>_choice[]" class="input_table" style="width:500px;" value="<?php echo $value['choice']; ?>"/>
						     <span class="btn_input">
						         <?php if($index == (count($field['choices'])-1)){ ?><input type="button" id="btn_cont_plus<?php if($index != 0) echo "_".$index; ?>" class="btn_cont_plus" alt="add choice" onclick="javascript: adminPagePollEdit.add_choice(this);" style="width: 20px;" value="+"/><?php } ?>
    						     <input type="button" id="btn_cont_minus<?php if($index != 0) echo "_".$index; ?>" class="btn_cont_minus" onclick="javascript: adminPagePollEdit.remove_choice(this);" alt="delete choice" style="width: 20px;" value="-"/>
    						     <input type="button" id="btn_cont_top<?php if($index != 0) echo "_".$index; ?>" class="btn_cont_top" alt="move choice top" onclick="javascript: adminPagePollEdit.move_choice(this);" style="width: 20px;" value="<" />
    						     <input type="button" id="btn_cont_bt<?php if($index != 0) echo "_".$index; ?>" class="btn_cont_bt" alt="move choice bottom" onclick="javascript: adminPagePollEdit.move_choice(this);" style="width: 20px;" value=">" />
						     </span>
						     <input type="hidden" name="setting_opinion_<?php echo $key+1; ?>_<?php echo $index; ?>" id="setting_opinion_<?php echo $key+1; ?>_<?php echo $index; ?>" value="<?php echo $value['opinion']; ?>" />
						</li>
						<?php $ops .= $value['opinion'].","; } ?>
					</ul>
					<input type="hidden" name="choice_opinion_<?php echo $key+1; ?>" id="choice_opinion_<?php echo $key+1; ?>" value="<?php echo $ops; ?>" />
						<span class="txt_explan" id="choice_txt_explan_<?php echo $key+1; ?>">If you want to get an additional opinion about this question, click the "Additional Opinion" button.</span>
				</td>
			</tr>
			<tr id="question_cont_<?php echo $key+1; ?>" <?php if($field['choice_type'] != 3) echo "style=\"display:none\""; ?>>
				<th>Maximum Length</th>
			        <td>
				        <ul class="row_list">
					        <li>Max <input type="text" name="desc_max_input_<?php echo $key+1; ?>" class="input_table" style="width:100px;" <?php if($field['choice_type'] == 3) echo "value=\"".$field['limits']."\""; ?>> byte <span class="txt_explan">( Maximum length is 2000 bytes.)</span></li>
				        </ul>
			        </td>
			</tr>
		</table>
		<hr>
		<br />
		<br />
<?php } ?>
</div>
</form>
<br /><br />
<a href="javascript: void(0);" class="btn_apply" title="Save changes" onclick="javascript: adminPagePollEdit.CheckForm();">Save</a>
<a href="javascript: void(0);" class="add_link" title="Return to Scheduler" onclick="javascript: window.location.href = '<?php echo $sUrl; ?>';">Return to List</a>