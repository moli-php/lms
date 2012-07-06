<?php echo Common::displayMenu(true); ?>
<div class="top">
	<h3 class="title" id="showTitle">Schedule Management</h3>
</div>
<ul class="class_list_tab">
	<li onclick="javascript:classtabs.classCalendar(<?php echo $uid; ?>, <?php echo $classId; ?>)" style="cursor:pointer">Class Calendar</li>
	<li onclick="javascript:classtabs.classList(<?php echo $uid; ?>, <?php echo $classId; ?>)" style="cursor:pointer">Class List</li>
	<li class="active" onclick="javascript:classtabs.classChangeSchedule(<?php echo $uid; ?>, <?php echo $classId; ?>)" style="cursor:pointer">Change Schedule</li>
	<li onclick="javascript:classtabs.levelTestInfo(<?php echo $uid; ?>)" style="cursor:pointer">Level Test Info</li>
</ul>
<div class="content">
	<input type="hidden" name="userid" value="<?php echo $uid; ?>" />
	<input type="hidden" name="classid" value="<?php echo $classId; ?>" />
	<div class="user_header">
		<strong><?php echo $student[0]['name']; ?></strong>
		<em><?php echo $student[0]['user_id']; ?></em>
	</div>
	<div class="choose_class">
		<label>Choose Class:</label>
		<select name="choose_class" onchange="javascript: window.location.href = '<?php Common::urlInclude('class_id'); ?>' + $('[name=choose_class]').val();">
			<?php foreach($studentClass as $val){ ?>
				<option status="<?php echo $val[0]['class_status']; ?>" value="<?php echo $val[0]['idx']; ?>" <?php if($val[0]['idx'] == $classId)echo " selected"; ?>><?php echo $val[0]['name']; ?></option>
			<?php } ?>
		</select>
	</div>
	<strong>Change History</strong>
	<table cellpadding="0" cellspacing="0" border="0" class="post_table class_list" style="margin:10px 0 20px">
		<colgroup>
			<col width="80px" />
			<col width="*" />
			<col width="*" />
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>Original Class</th>
				<th>Changed Class</th>
			</tr>
		</thead>
		<tbody>
			<?php $ctr=0; 
			if($old_schedule != null && $new_schedule != null){
				for($key=0;$key<count($new_schedule);$key++){
					$ctr+=1;
					echo "<tr>";
						echo "<td>".$ctr."</td>";
						echo "<td>".$old_schedule[$key]['name']. "( ".$old_schedule[$key]['teacher_name']." - " .$old_schedule[$key]['class_days']. " " . $old_schedule[$key]['daystart'] . " ". $old_schedule[$key]['time_start'] . " ~ ". $old_schedule[$key]['time_end'] . ")"."</td>";
						echo "<td>".$new_schedule[$key][0]['name']. "( ".$new_schedule[$key][0]['teacher_name']." - " .$new_schedule[$key][0]['class_days']. " " . $new_schedule[$key][0]['daystart'] . " ". $new_schedule[$key][0]['time_start'] . " ~ ". $new_schedule[$key][0]['time_end'] . ")"."</td>";
					echo "</tr>";
				}
			}else{
				echo "<tr><td colspan=3>There are no recent changes for this schedule.</td></tr>";
			}
				
			?>
		</tbody>
	</table>
	<div class="choose_class" style="margin:0 0 10px 0"><strong>Change Schedule</strong></div>
	<table cellpadding="0" cellspacing="0" border="0" class="post_table class_list">
		<colgroup>
			<col width="80px" />
			<col width="140px" />
			<col width="*" />
			<col width="140px" />
			<col width="140px" />
			<col width="140px" />
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>Status</th>
				<th>Class Name</th>
				<th>Class Date</th>
				<th>Time</th>
				<th>Manage</th>
			</tr>
		</thead>
		<tbody>
			<?php 	$ctr=0;
			if($schedule != null){
				foreach($schedule as $val){
					$ctr+=1;
				
					echo "<tr>";
					echo "<td>".$ctr."</td>";
					echo "<td>".$val['sched_status']."</td>";
					echo "<td>".$val['name']."</td>";
					echo "<td>".$val['daystart']."</td>";
					echo "<td>".$val['time_start']." ~ ".$val['time_end']."</td>";
					echo "<td>";
					echo "<ul class='management_control'>";
					echo "<li>";
					echo "<input type='button' class='btn_management' title='Edit Schedule' value = 'M' style='cursor:pointer' onclick='javascript:manageSchedule.newScheduleInfo(\"".$val['daystart']."\", ".$uid.", ".$classId.", \"".$val['class_days']."\")'>&nbsp;";
					echo "<input type='button' class='btn_management' title='Cancel Schedule' value = 'C' style='cursor:pointer' onclick='javascript:manageSchedule.cancelSchedulePopup(\"".$val['daystart']."\", ".$uid.", ".$classId.")'>";
					echo "</li>";
					echo "</ul>";
					echo "</td>";
					echo "</tr>";
				}
			}else{
				echo "<tr><td colspan=6>This schedule is done.</td></tr>";
			}
			?>
		</tbody>
	</table>
	<div class="center_wrap" style="margin-top:20px">
		<input type="hidden" name="classdays" value="" />
		<table cellspacing="0" border="0" cellpadding="0" class="product_search" style="display:none">
			<colgroup>
				<col width="60"/>
				<col width="290"/>
				<col width="290" />	
				<col />
			</colgroup>
			<tbody>
				<tr>
					<th><label>Date:</label></th>
					<td colspan="3" class="startdate"><input type="text" class="fix3" id="period_startdate" name="period_startdate" value=""/><span class="not_found"></span></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<label>Teacher Type:</label>
						<select name="teacher_type">
							<?php foreach($teacher as $val){?>
								<option value=<?php echo $teacher[0]['idx']; ?>><?php echo $teacher[0]['grade_name']; ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						<label>Class Time:</label>
						<select name="class_time">
							<option value="5">5 minutes</option>
							<option value="10">10 minutes</option>
							<option value="15">15 minutes</option>
							<option value="20">20 minutes</option>
							<option value="25">25 minutes</option>
							<option value="30">30 minutes</option>
							<option value="35">35 minutes</option>
							<option value="40">40 minutes</option>
							<option value="45">45 minutes</option>
							<option value="50">50 minutes</option>
							<option value="55">55 minutes</option>
							<option value="60">60 minutes</option>
						</select>
					</td>					
					<td><input type="button" class="btn_go" name="editSchedInfo" style="float:left;margin-top:12px;cursor:pointer" value="Submit" /></td>
				</tr> 
			</tbody>
		</table>
		<div class="generated_schedule" style="display:none">
			<table cellspacing="2" cellpadding="0" border="0" style="float:left" name="time_col"></table>
			<table cellspacing="2" cellpadding="0" border="0" style="float:left" class="generated_names" name="time_sched"></table>
		</div>
	</div>
</div>
<p style="color:#FF0000" class="sched_error"></p>
<div class="popup_window message_content schedule_calendar_popup" style="width:147px;padding:10px;left:520px;top:650px;display:none">
	<ul class="control"></ul>
	<table cellpadding="0" border="0" cellspacing="1" name="calendar">
		<colgroup>
			<col width="20px" />
			<col width="20px" />
			<col width="20px" />
			<col width="20px" />
			<col width="20px" />
			<col width="20px" />
			<col width="20px" />
		</colgroup>
		<thead>
			<tr>
				<th><span title="Sunday">Su</span></th>
				<th><span title="Monday">Mo</span></th>
				<th><span title="Tuesday">Tu</span></th>
				<th><span title="Wednesday">We</span></th>
				<th><span title="Thursday">Th</span></th>
				<th><span title="Friday">Fr</span></th>
				<th class="ui-datepicker-week-end"><span title="Saturday">Sa</span></th>
			</tr>
		</thead>
		<tbody class = "days">
		</tbody>
	</table>
	<input class="btn-apply" type="button" name="sched_submit" value="Submit" style="margin-left:5px">
	<input class="btn-apply" type="button" name="sched_cancel" value="Cancel">
</div>
<div class="popup_window schedule_management_popup" style="display:none" id="confirm_popup">
	<p>This class will be cancelled. Would you like to proceed?</p>
	<div class="action_btn">
		<input type="button" class="btn_save fr" name="confirmCancel" value="Yes" />&nbsp;
		<input type="button" class="btn_save fr" name="noConfirmCancel" value="No" />
	</div>
</div>