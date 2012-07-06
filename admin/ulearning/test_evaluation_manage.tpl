<?php echo Common::displayMenu(true,array("label"=>"Back to list","most_action"=>"test_evaluation.back_to_list"));?>
<table class="post_table" cellspacing="0" cellpadding="0" border="0">
	<thead>	
	<tr>
		<th class="personnel_name" colspan="2">
		<?php echo $name; ?> <span class="puserid">(<?php echo $user; ?>)</span>
		- <?php echo $cat1; ?> > <?php echo $cat2; ?> > <?php echo $cat3; ?> (<?=$unit_title?>)
		<input type="hidden" class="status" value="<?=$status;?>"/>
		<input type="hidden" class="eval_id" value="<?=$eval_id;?>"/>
		</th>
	</tr>
	</thead>
</table>
<br />
<table id="slideCountId-0" class="result_table" width="100%" cellspacing="0" cellpadding="0" border="0">
	<colgroup>
		<col width="30%" />
		<col width="20%" />
		<col width="20%" />
		<col width="*" />
	</colgroup>
	<?php 
	$count = 0;
	$sum = 0;
	$total = 0;
	foreach($slide as $k => $v){
		if($v['fexam_type_id'] != 1 && $v['fexam_type_id'] != 19 && $v['fexam_type_id'] != 20){
			$count++;
	?>
		<thead>
			<tr>
				<th colspan="4"><p>Slide #<?=$count?>: <?=$v['fslide_name']?></p></th>
			</tr>
			<tr>
				<td>Question</td>
				<td>Correct Answer</td>
				<td>Student Answer</td>
				<td class="last">Comment</td>
			</tr>
		</thead>
			<?php 
			if(isset($slide[$k]['questions'])){
				foreach($slide[$k]['questions'] as $key => $val){
				?>
				<tr class="tbody">
					<td><?=$slide[$k]['questions'][$key]['fquestion']?></td>
					<td><?=$slide[$k]['questions'][$key]['correct_answer']?><input type="hidden" class="type_<?=$v['fexam_type_id']?>" id="answer_id_<?=$count?>" value="<?=$v['fexam_type_id']."_".$slide[$k]['questions'][$key]['answer_id']?>"/></td>
					<td><?php 
						if($slide[$k]['questions'][$key]['user_answer'] === false)
							echo "<div style='color:red;'>No answer</div>";
						else if($v['fexam_type_id'] != 12 && $v['fexam_type_id'] != 13 && $v['fexam_type_id'] != 14 && $v['fexam_type_id'] != 15 && $v['fexam_type_id'] != 18)
							echo $slide[$k]['questions'][$key]['user_answer'];
						else if(($v['fexam_type_id'] == 12 || $v['fexam_type_id'] == 13 || $v['fexam_type_id'] == 14) && $slide[$k]['questions'][$key]['user_answer'] === 0)
							echo "<div style='color:red;'>No need for answer</div>";
						
						else{?>
							<object classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" type="application/x-shockwave-flash" id="player" width="250" height="45">
								<param name="url" value="../../uploads/ulearning/recordings/<?=$slide[$k]['questions'][$key]['user_answer']?>" />
								<param name="src" value="../../uploads/ulearning/recordings/<?=$slide[$k]['questions'][$key]['user_answer']?>" />
								<param name="showcontrols" value="true" />
								<param name="autostart" value="false" />
								<!--[if !IE]>-->
								<object type="video/x-ms-wmv"  data="../../uploads/ulearning/recordings/<?=$slide[$k]['questions'][$key]['user_answer']?>"  width="250" height="45">
								<param name="src" value="../../uploads/ulearning/recordings/<?=$slide[$k]['questions'][$key]['user_answer']?>" />
								<param name="autostart" value="false" />
								<param name="controller" value="true" />
								</object>
								  <!--<![endif]-->
							</object>
						<?php }?></td>
					<td class="last">
						<textarea cols="0" rows="0" class="slide_comment comment_type_<?=$v['fexam_type_id']?>" <?php if((($v['fexam_type_id'] == 12 || $v['fexam_type_id'] == 13 || $v['fexam_type_id'] == 14) && $slide[$k]['questions'][$key]['user_answer'] === false) || $slide[$k]['questions'][$key]['fcomment'] === false) echo "readOnly='readOnly' style='color:red'"?>><?php if((($v['fexam_type_id'] == 12 || $v['fexam_type_id'] == 13 || $v['fexam_type_id'] == 14) && $slide[$k]['questions'][$key]['user_answer'] === false) || $slide[$k]['questions'][$key]['fcomment'] === false) 
							echo "No need for comment";
						else echo $slide[$k]['questions'][$key]['fcomment']?></textarea>
					</td>
				</tr>
				<?php }
			} ?>
			<tr class="tfoot">
				<td colspan="4">
				<label>Score Of This Slide</label>
				:
				<input id="slideGradeField-<?=($count-1)?>" <?php if($v['fgrade_id'] == "") echo "readOnly='readOnly'";?> class="result_value slides" type="text"  value="<?=$v['fgrade']?>" onkeyup="test_eval_manage.total()" onblur="test_eval_manage.total()"/>
				<input class="result_submit" type="button" value="Submit" onclick="test_eval_manage.slideSubmit('<?=$v['fgrade_id']?>','<?=$v['fexam_type_id']?>','<?=($count-1)?>')" />
				</td>
			</tr>
	<?php 
		$sum += $v['fgrade'];
		
		}
	}
	$total = $sum/$totalSlide;?>
</table>

<div class="total_result">
	<div>
		<label>Total Score Of This Test</label>
		:
		<input class="result_value total_value_class disabled" type="text" readonly="readonly" value="<?=number_format($total, 2, '.', '')?>" />
		<input class="result_submit" onclick="test_eval_manage.evaluate()" type="button" value="Submit" />
	</div>
</div>

