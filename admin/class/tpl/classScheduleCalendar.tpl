<?php echo Common::displayMenu(true); ?>
<div class="top">
	<h3 class="title" id="showTitle">Schedule Management</h3>
</div>
<ul class="class_list_tab">
	<li class="active" onclick="javascript:classtabs.classCalendar(<?php echo $uid; ?>, <?php echo $classId; ?>)" style="cursor:pointer">Class Calendar</li>
	<li onclick="javascript:classtabs.classList(<?php echo $uid; ?>, <?php echo $classId; ?>)" style="cursor:pointer">Class List</li>
	<li onclick="javascript:classtabs.classChangeSchedule(<?php echo $uid; ?>, <?php echo $classId; ?>)" style="cursor:pointer">Change Schedule</li>
	<li onclick="javascript:classtabs.levelTestInfo(<?php echo $uid; ?>)" style="cursor:pointer">Level Test Info</li>
</ul>

<div class="content">
	<div class="user_header"><strong><?php echo $student[0]['name']?></strong><em><?php echo $student[0]['user_id']?></em></div>
	<div class="choose_class">
		<label>Choose Class:</label>
			<select name="choose_class" onchange="javascript: window.location.href = '<?php Common::urlInclude('class_id'); ?>' + $('[name=choose_class]').val();">
				<?php foreach($studentClass as $val){ ?>
					<option status="<?php echo $val[0]['class_status']; ?>" value="<?php echo $val[0]['idx']; ?>" <?php if($val[0]['idx'] == $classId)echo " selected"; ?>><?php echo $val[0]['name']; ?></option>
				<?php } ?>
			</select>
	</div>
	<div class="calendar_control">
		<ul>
			<li class="btn pn" onclick="javascript:cal.prev(false,$('[name=month]').val(), $('[name=year]').val())" style="cursor:pointer">Prev Month</li>
			<li class="btn pn" onclick="javascript:cal.next(true,$('[name=month]').val(), $('[name=year]').val())" style="cursor:pointer">Next Month</li>
			<li>
				<select name="year">
					<?php 
						$curYear = date("Y"); 
						for($ctr=$curYear;$ctr<$curYear+5;$ctr++){
					?>
						<option id="<?php echo $ctr; ?>" value="<?php echo $ctr; ?>" <?php if($ctr == $startYear){echo " selected"; }?>><?php echo $ctr; ?></option>
					<?php 
						}
					?>
				</select>
			</li>
			<li>
				<select name="month">
					<?php 
						for($ctr=1;$ctr<=12;$ctr++){
							if($ctr < 10){$sCtr = "0" . $ctr;}
							else{$sCtr = $ctr;}
					?>
							<option id="<?php echo $ctr; ?>" value="<?php echo $sCtr; ?>" <?php if($sCtr == $startMonth){echo " selected"; }?>><?php echo $sCtr; ?></option>
					<?php } ?>	
				</select>
			</li>
			<li class="btn search" style="cursor:pointer" onclick="javascript:cal.calendar($('[name=month]').val(), $('[name=year]').val())">Search</li>
			<li class="btn waiting" style="cursor:pointer" onclick = "javascript:schedStatusTabs.waiting($('[name=month]').val(), $('[name=year]').val())">Waiting</li>
			<li class="btn attend" style="cursor:pointer" onclick = "javascript:schedStatusTabs.attended($('[name=month]').val(), $('[name=year]').val())">Attended</li>
			<li class="btn absent" style="cursor:pointer" onclick = "javascript:schedStatusTabs.absent($('[name=month]').val(), $('[name=year]').val())">Absent</li>
			<li class="btn canceled" style="cursor:pointer" onclick = "javascript:schedStatusTabs.cancelled($('[name=month]').val(), $('[name=year]').val())">Cancelled</li>
			<li class="btn postponed" style="cursor:pointer" onclick = "javascript:schedStatusTabs.postponed($('[name=month]').val(), $('[name=year]').val())">Postponed</li>
			<li class="btn postponed" style="background-color:#FDFF91;color:#000000">Holiday</li>
		</ul>
	</div>
	<table cellspacing="1" cellpadding="0" border="0" class="schedule_class_calendar">
		<colgroup>
			<col width="140px" />
			<col width="140px" />
			<col width="140px" />
			<col width="140px" />
			<col width="140px" />
			<col width="140px" />
			<col width="140px" />
		</colgroup>
		<thead>
			<tr>
				<th class="sunday">Sun</th>
				<th>Mon</th>
				<th>Tue</th>
				<th>Wed</th>
				<th>Thu</th>
				<th>Fri</th>
				<th class="saturday">Sat</th>
			</tr>
		</thead>
		<tbody class="days"></tbody>
	</table>
	
</div>
<div class="popup_window schedule_management_popup" style="display:none" id="change_popup">
	<input type="hidden" name="datestart" value="" />
	<input type="hidden" name="classId" value="<?php echo $classId; ?>" />
	<input type="hidden" name="teacherid" value="" />
	<form name="editSchedStatus" enctype = "multipart/form-data">
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