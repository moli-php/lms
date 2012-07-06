<div>
    <p>
        <span class="module_title">Basic Information</span>
    </p>
</div>
<table border="1" cellspacing="0" cellpadding="0" class="table_input_vr">
	<tr>
		<th style="width:150px;"><label>Poll Title: </label></th>
		<td style="padding:0;"><?php echo $aData[0]['title']; ?></td>
	</tr>
	<tr>
		<th><label for="clock_location1">Period: </label></th>
		<td><?php echo $aData[0]['period_start']; ?> ~ <?php echo $aData[0]['period_end']; ?></td>
	</tr>
	<tr>
        <th>
            <label for="Category">Number of Questions:</label>
        </th>
        <td><?php echo $iQuestionCount; ?></td>
    </tr>
    <tr>
        <th>
            <label for="Category">Status:</label>
        </th>
        <td><?php if($aData[0]['period_start'] > date('Y-m-d')) $status = "Waiting";
                  if($aData[0]['period_start'] <= date('Y-m-d') && $aData[0]['period_end'] >= date('Y-m-d')) $status = "On Going";
                  if($aData[0]['period_end'] < date('Y-m-d')) $status = "Done";

                  echo $status;
            ?></td>
    </tr>
    <tr>
        <th>
            <label for="Category">Number of Repliers:</label>
        </th>
        <td><?php echo $iReplierCount; ?></td>
    </tr>
</table>
<div>
    <p>
        <span class="module_title">Questions</span>
    </p>
</div>
<div id="questions_tbl">
<?php foreach($aForm as $key => $field){
if($field['choice_type'] == 0 || $field['choice_type'] == 1){ ?>

         <?php foreach($field['choices'] as $index => $value){ ?>
         <div id='pollwidget_opinion_<?php echo $key+1; ?>_<?php echo $index; ?>_popup_contents' style='display:none'>
           <div class="admin_popup_contents">
            <table border="0" cellpadding="0" cellspacing="0" class="table_hor_02" style="width: 100%;">
            <tr>
                 <th>Opinions</th>
            </tr>
                <?php foreach($value['opinions'] as $keys => $val){ ?>
            <tr>
                 <td style="padding-left: 2px;"><?php echo $val['opinion']; ?></td>
            </tr>
           <?php } ?>
            </table>
        <br />
        <br />
        </div>
        </div>
        <?php } ?>

        <table border="0" cellpadding="0" cellspacing="5" class="" id="q_num_1" style="width: 100%;">
			<colgroup>
				<col width="1200px"/>
				<col />
			</colgroup>
			<tr id="disp_num_tr_<?php echo $key+1; ?>">
				<td><strong><?php echo $key+1; ?>.</strong> <?php echo $field['question']; ?></td>
				<td></td>
			</tr>
			<tr id="question_t_<?php echo $key+1; ?>">
				<td>
                    <table border="0" cellpadding="0" cellspacing="0" class="table_hor_02" id="q_num_1">
            			<colgroup>
            				<col />
            				<col width="100"/>
            			</colgroup>
            			<thead>
                			<tr id="disp_num_tr_<?php echo $key+1; ?>">
                				<th>Choices</th>
                				<th>Repliers</th>
                			</tr>
            			</thead>
                        <?php foreach($field['choices'] as $index => $value){ ?>
                			<tr id="disp_num_tr_<?php echo $key+1; ?>">
                				<td style="text-align: left;padding-left: 10px;">
                				    <?php echo $value['choice']; ?>
                				    <?php if($value['opinion'] == '1') echo ' <a href="javascript: void(0);" onclick="javascript: adminPagePollResult.viewOpinion(\''.($key+1).'\',\''.$index.'\');" class="btn_nor_01 btn_width_st1" title="save">Opinion</a>'; ?>
                				</td>
                				<td>
                				    <?php echo $value['replier']; ?>
                				</td>
                			</tr>
            			<?php } ?>
            		</table>
				</td>
				<td>
				    <?php if($sSettings == 1){?>
    				<table border="0" cellpadding="0" cellspacing="0" class="table_hor_02" id="q_num_1" style="width: 100%;">
                        <colgroup>
                            <col />
                        </colgroup>
                    <thead>
                        <tr id="disp_num_tr_<?php echo $key+1; ?>">
                            <td colspan="2" style="text-align: left;padding-left: 2px;">
                             <?php foreach($field['choices'] as $index => $value){ ?>
                                    <div style="background: <?php echo $aColors[$index]; ?>;width: 10px;height: 10px;display: inline-block;"></div> <?php echo $value['choice']; ?>
                             <?php } ?>
                            </td>
                        </tr>
                    </thead>
                    <?php foreach($field['choices'] as $index => $value){ ?>
                    <tr id="disp_num_tr_<?php echo $key+1; ?>">
                        <td style="text-align: left;padding-left: 2px;padding-right: 2px;" colspan="2">
                            <?php if($value['replier'] == 0){
                                      echo "0 Vote";
                                  }
                                  else{
                                      $width = ($value['replier'] / $iReplierCount) * 100;
                                      echo '<div style="background: '.$aColors[$index].';width: '.$width.'%;height: 100%;"></div>';
                                  } ?>
                        </td>
                    </tr>
                     <?php } ?>
                    </table>
                    <?php }
                    else{ ?>
                    <table border="0" cellpadding="0" cellspacing="0" class="table_hor_02" id="q_num_1"  style="width: 100%;">
                        <colgroup>
                            <col />
                        </colgroup>
                    <thead>
                        <tr id="disp_num_tr_<?php echo $key+1; ?>">
                            <td colspan="<?php echo count($field['choices']); ?>" style="text-align: left;padding-left: 2px;">
                             <?php foreach($field['choices'] as $index => $value){ ?>
                                    <div style="background: <?php echo $aColors[$index]; ?>;width: 10px;height: 10px;display: inline-block;"></div> <?php echo $value['choice']; ?>
                             <?php } ?>
                            </td>
                        </tr>
                    </thead>
                    <tr id="disp_num_tr_<?php echo $key+1; ?>">
                    <?php foreach($field['choices'] as $index => $value){ ?>
                        <td style="text-align: left;padding-left: 2px;padding-right: 2px; height: 150px;" valign="bottom">
                            <?php if($value['replier'] == 0){
                                      echo "<center>0 Vote</center>";
                                  }
                                  else{
                                      $height = ($value['replier'] / $iReplierCount) * 100;
                                      echo '<div style="background: '.$aColors[$index].';width: 100%;height: '.$height.'%;"></div>';
                                  } ?>
                        </td>
                     <?php } ?>
                    </tr>
                    </table>
                    <?php } ?>
				</td>
			</tr>
		</table>
<?php }
elseif($field['choice_type'] == 2){ ?>
    <table border="0" cellpadding="0" cellspacing="5" class="" id="q_num_1" style="width: 100%;">
        <colgroup>
            <col width="1200px"/>
            <col />
        </colgroup>
        <tr id="disp_num_tr_<?php echo $key+1; ?>">
            <td><strong><?php echo $key+1; ?>.</strong> <?php echo $field['question']; ?></td>
            <td></td>
        </tr>
        <tr id="question_t_<?php echo $key+1; ?>">
            <td>
                <table border="0" cellpadding="0" cellspacing="0" class="table_hor_02" id="q_num_1" style="width: 100%;">
                    <colgroup>
                        <col />
                        <col width="100"/>
                        <col width="100"/>
                    </colgroup>
                <thead>
                    <tr id="disp_num_tr_<?php echo $key+1; ?>">
                        <th>Choices</th>
                        <th>Ranking</th>
                        <th>Repliers</th>
                    </tr>
                </thead>
                <?php foreach($field['choices'] as $index => $value){ ?>
                <tr id="disp_num_tr_<?php echo $key+1; ?>">
                    <td style="text-align: left;padding-left: 10px;" rowspan="<?php echo count($field['choices']); ?>">
                    <?php echo $value['choice']; ?>
                    </td>
                    <td>
                    1
                    </td>
                    <td>
                    <?php echo $value['replier'][1]; ?>
                    </td>
                </tr>
                <?php for($i = 2; $i <= count($field['choices']); $i++){ ?>
                <tr>
                    <td>
                    <?php echo $i; ?>
                    </td>
                    <td>
                    <?php echo $value['replier'][$i]; ?>
                    </td>
                </tr>
                <?php }} ?>
                </table>
            </td>
            <td>
                <?php if($sSettings == 1){?>
                <table border="0" cellpadding="0" cellspacing="0" class="table_hor_02" id="q_num_1" style="width: 100%;">
                    <colgroup>
                        <col width="100" />
                        <col/>
                    </colgroup>
                <thead>
                    <tr id="disp_num_tr_<?php echo $key+1; ?>">
                        <td colspan="2" style="text-align: left;padding-left: 2px;">
                             <?php foreach($field['choices'] as $index => $value){ ?>
                                    <div style="background: <?php echo $aColors[$index]; ?>;width: 10px;height: 10px;display: inline-block;"></div> <?php echo $value['choice']; ?>
                             <?php } ?>
                        </td>
                    </tr>
                </thead>
                <?php foreach($field['choices'] as $index => $value){ ?>
                <tr id="disp_num_tr_<?php echo $key+1; ?>">
                    <td style="text-align: left;padding-left: 10px;">
                    Rank <?php echo $index+1; ?>
                    </td>
                    <td style="text-align: left;padding-left: 2px;padding-right: 2px;">
                         <?php if($value['replier'] == 0){
                                      echo "0 Vote";
                                  }
                                  else{
                                      for($i = 0; $i < count($field['choices']); $i++){
                                          if($value['replier'][$i+1] != 0 && $iReplierCount != 0){
                                              $width = ($value['replier'][$i+1] / $iReplierCount) * 100;
                                              echo '<div style="background: '.$aColors[$i].';width: '.$width.'%;height: 100%;display:inline-block;"></div>';
                                          }
                                      }
                                  } ?>
                    </td>
                </tr>
                <?php } ?>
                </table>
                <?php }
                else{ ?>
                <table border="0" cellpadding="0" cellspacing="0" class="table_hor_02" id="q_num_1" style="width: 100%;">

                <thead>
                    <tr id="disp_num_tr_<?php echo $key+1; ?>">
                        <td colspan="<?php echo count($field['choices']); ?>" style="text-align: left;padding-left: 2px;">
                             <?php foreach($field['choices'] as $index => $value){ ?>
                                    <div style="background: <?php echo $aColors[$index]; ?>;width: 10px;height: 10px;display: inline-block;"></div> <?php echo $value['choice']; ?>
                             <?php } ?>
                        </td>
                    </tr>
                </thead>
                <tr id="disp_num_tr_<?php echo $key+1; ?>">
                    <?php foreach($field['choices'] as $index => $value){ ?>
                    <td style="text-align: left;padding-left: 2px;padding-right: 2px; height: 150px;" valign="bottom">
                         <?php if($value['replier'] == 0){
                                      echo "0 Vote";
                                  }
                                  else{
                                      for($i = 0; $i < count($field['choices']); $i++){
                                          if($value['replier'][$i+1] != 0 && $iReplierCount != 0){
                                              $height = ($value['replier'][$i+1] / $iReplierCount) * 100;
                                              echo '<div style="background: '.$aColors[$i].';width: 100%;height: '.$height.'%;"></div>';
                                          }
                                      }
                                  } ?>
                                  <center>Rank <?php echo $index+1; ?></center>
                    </td>
                    <?php } ?>
                </tr>
                </table>
                <?php } ?>
            </td>
        </tr>
    </table>
<?php }
elseif($field['choice_type'] == 3){ ?>

    <div id='pollwidget_answers_<?php echo $key+1; ?>_popup_contents' style='display:none'>
    <div class="admin_popup_contents">
        <table border="0" cellpadding="0" cellspacing="0" class="table_hor_02" style="width: 100%;">
            <tr>
                <th>Descriptions</th>
            </tr>
            <?php
            $iNum_rows = count($field['desc']);
            $iRows_per_page = '10';
            $sPaginate = usbuilder()->pagination($iNum_rows, $iRows_per_page);
            foreach($field['desc'] as $keys => $val){ ?>
            <tr>
                <td style="padding-left: 2px;"><?php echo $val['answer']; ?></td>
            </tr>
            <?php } ?>
        </table>
    <br />
    <br />
    </div>
    </div>

    <table border="0" cellpadding="0" cellspacing="5" class="" id="q_num_1" style="width: 100%;">
        <colgroup>
            <col width="1200px"/>
            <col />
        </colgroup>
        <tr id="disp_num_tr_<?php echo $key+1; ?>">
            <td><strong><?php echo $key+1; ?>.</strong> <?php echo $field['question']; ?> <a href="javascript: void(0);" onclick="javascript: adminPagePollResult.viewDesc('<?php echo $key+1; ?>');" class="btn_nor_01 btn_width_st1">View Answer</a></td>
            <td></td>
        </tr>
    </table>
<?php }
 } ?>
</div>
<br /><br />
<a href="javascript: void(0);" class="add_link" title="Return to Scheduler" onclick="javascript: window.location.href = '<?php echo $sUrl; ?>';">Return to List</a>