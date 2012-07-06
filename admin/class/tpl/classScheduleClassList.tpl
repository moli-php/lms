<?php echo Common::displayMenu(true); ?>
<div class="top">
	<h3 class="title" id="showTitle">Schedule Management</h3>
</div>

<ul class="class_list_tab">
	<li onclick="javascript:classtabs.classCalendar(<?php echo $uid; ?>, <?php echo $classId; ?>)" style="cursor:pointer">Class Calendar</li>
	<li class="active" onclick="javascript:classtabs.classList(<?php echo $uid; ?>, <?php echo $classId; ?>)" style="cursor:pointer">Class List</li>
	<li onclick="javascript:classtabs.classChangeSchedule(<?php echo $uid; ?>, <?php echo $classId; ?>)" style="cursor:pointer">Change Schedule</li>
	<li onclick="javascript:classtabs.levelTestInfo(<?php echo $uid; ?>)" style="cursor:pointer">Level Test Info</li>
</ul>

<div class="content">
	<div class="user_header">
		<strong><?php echo $student[0]['name']; ?></strong>
		<em><?php echo $student[0]['user_id']; ?></em>
	</div>
	<div style="width:100%;display:inline-block">
		<div class="choose_class">
			<label>Choose Class:</label>
			<select name="choose_class" onchange="javascript: window.location.href = '<?php Common::urlInclude('class_id'); ?>' + $('[name=choose_class]').val();">
				<?php foreach($studentClass as $val){ ?>
					<option status = "<?php echo $val[0]['class_status']; ?>" value="<?php echo $val[0]['idx']; ?>" <?php if($val[0]['idx'] == $classId)echo " selected"; ?>><?php echo $val[0]['name']; ?></option>
				<?php } ?>
			</select>
			<span style="font-weight:bold;color:#DB5D1F"><?php echo "(" . $classTime[0]['class_days'] . ") at " . $classTime[0]['time_start'] . " ~ " . $classTime[0]['time_end']; ?></span>
		</div>
		<table cellpadding="0" cellspacing="0" border="0" class="post_table class_list">
			<colgroup>
				<col width="80px" />
				<col width="280px" />
				<col width="*" />
				<col width="280px" />
				<col width="100px" />
			</colgroup>
			<thead>
				<tr>
					<th>No</th>
					<th>Date</th>
					<th>Teacher</th>
					<th>Status</th>
					<th>Manage</th>
				</tr>
			</thead>
			<tbody>
				<?php 	$ctr=0;
						foreach($schedule as $val){
							$ctr+=1;
							
							echo "<tr>";
								echo "<td>".$ctr."</td>";
								echo "<td>".$val['daystart']."</td>";
								echo "<td>".$val['teacher_name']."</td>";
								echo "<td>".$val['sched_status']."</td>";
								echo "<td>";
									echo "<ul class='management_control'>";
										echo "<li><input type='button' class='btn_management' title'Detail Class Information' value = 'M' style='cursor:pointer' onclick='javascript:manageSchedule.editSingleScheduleStatus(\"".$val['daystart']."\", ".$uid.", ".$classId.")'></li>";
									echo "</ul>";
								echo "</td>";
							echo "</tr>";
						}
				?>
			</tbody>
		</table>
	</div>
	<div class="no_class" style="display:none">
		<p>No Class for this day</p>
	</div>
</div>
<div class="popup_window schedule_management_popup" style="display:none" id="change_popup">
	<form name="editSchedStatus" enctype = "multipart/form-data">
		<input type="hidden" name="datestart" value="" />
		<input type="hidden" name="classId" value="<?php echo $classId; ?>" />
		<input type="hidden" name="teacherid" value="" />
		<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
			<col width="450px" />
			<tr>
				<td style="text-align:left;font-weight:bold" id="editSchedStatTitle"></td>
			</tr>
			<tr>
				<td>
					<ul>
						<li><input type="radio" name="scheduleStatus" value="waiting" /><label for="waiting">Waiting</label></li>
						<li><input type="radio" name="scheduleStatus" value="attended" /><label for="attended">Attended</label></li>
						<li><input type="radio" name="scheduleStatus" value="absent" /><label for="absent">Absent</label></li>
						<li><input type="radio" name="scheduleStatus" value="cancelled" /><label for="cancelled">Cancelled</label></li>
						<li><input type="radio" name="scheduleStatus" value="postponed" /><label for="postponed">Postponed</label></li>
					</ul>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label_fix">Attach:</label>
					<input type="file" name="scheduleFile"/>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label_fix">Comment:</label>
					<textarea name="scheduleComment"></textarea>
				</td>
			</tr>
		</table>
		<div class="action_btn">
			<input type="button" class="btn_save fr" title="Save changes" name="saveSchedStatus" value="Submit" />
		</div>
	</form>
</div>
<div class="popup_window schedule_management_popup" style="display:none" id="error_popup">
	<p></p>
	<div class="action_btn">
		<input type="button" class="btn_save fr" name="uneditedSchedStatus" value="OK" />
	</div>
</div>