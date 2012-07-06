<link rel="stylesheet" type="text/css" href='<?php echo BASE_URL . "/css/custom-theme/jquery-ui-1.8.20.custom.css"; ?>' />
<link rel="stylesheet" type="text/css" href='<?php echo BASE_URL . "/css/style.css"; ?>' />
<link rel="stylesheet" type="text/css" href='<?php echo BASE_URL . "/css/menu/superfish.css"; ?>' />
<link rel="stylesheet" type="text/css" href='<?php echo BASE_URL . "/css/menu/superfish-navbar.css"; ?>' />
<link rel="stylesheet" type="text/css" href='<?php echo BASE_URL . "/css/class/class.css"; ?>' />

<script type="text/javascript">
	window.onresize = function() 
	{
		window.resizeTo(1000,800);
	}
</script>

<div class="content">
	<input type="hidden" name="uid" value="<?php echo $user['idx']; ?>" />
	<input type="hidden" name="teacher_name" value="" />
	<input type="hidden" name="teacher_branch" value="" />
	<input type="hidden" name="classIdx" value="<?php echo $class_idx; ?>" />
	<div class="user_header"><strong><?php echo $user['name']; ?></strong><em><?php echo $user['user_id']; ?></em></div>
	<table cellspacing="2" cellpadding="0" border="0" class="schedule_info">
		<colgroup>
			<col width="160px" />
			<col width="320px" />
			<col width="160px" />
			<col width="320px" />
		</colgroup>
		<tr>
			<th>User ID:</th>
			<td><?php echo $user['user_id']; ?></td>
			<th>Name:</th>
			<td><?php echo $user['name']; ?></td>
		</tr>
		<tr>
			<th>Cell Phone:</th>
			<td><?php echo $user['phone_mob']; ?></td>
			<th>Branch:</th>
			<td><?php echo $branch[0]['name']; ?></td>
		</tr>
		<tr>
			<th>Ordered Class:</th>
			<td colspan="3" name="oClass" id="<?php echo $oClass[0]['idx']; ?>">
				<?php echo $oClass[0]['name']; ?>
			</td>
		</tr>
		<tr>
			<th>Desired Start Date:</th>
			<td>2012-03-01</td>
			<th>Desired Time:</th>
			<td>9:00 PM</td>
		</tr>
		<tr>
			<th>Memo:</th>
			<td colspan="3">
				<p>Curabitur et ultricies massa. Nullam sed est dolor. Pellentesque in placerat dolor. Curabitur convallis ligula in est accumsan venenatis. Suspendisse potenti. Phasellus ut faucibus nisl. Nam gravida consequat diam a facilisis.</p>
				<p>Etiam id magna tristique dui rhoncus lacinia id at sem. Fusce volutpat, nibh et pellentesque auctor, nulla massa varius dui, in fermentum tellus nulla vel eros. Phasellus vulputate ultricies egestas. Praesent aliquam mauris porta ante laoreet feugiat. Donec quam risus, vestibulum eget tempus eget, tincidunt at orci. Quisque vestibulum commodo enim non varius. In sit amet diam eu odio sollicitudin euismod vitae eu augue.</p>
			</td>
		</tr>
	</table>
	<div class="user_header"><strong>Generate Class</strong></div>
	<table cellspacing="2" cellpadding="0" border="0" class="schedule_info">
		<colgroup>
			<col width="160px" />
			<col width="320px" />
			<col width="160px" />
			<col width="320px" />

		</colgroup>
		<tr>
			<th>Amount of Class Time:</th>
			<td>
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
			<th>Total Count of Class:</th>
			<td>
				<input type="text" name="classCount" style="width:98%" value="<?php echo $class[0]['total_days'] . " day/s"; ?>" />
				<input type="hidden" name="classMonths" value="<?php echo $class[0]['total_months']; ?>" />
			</td>
		</tr>
		<tr>
			<th>Start Date : </th>
			<td colspan="3" class="startdate"><input type="text" class="fix3" id="period_startdate" name="period_startdate" value=""/><span class="not_found"></span></td>
		</tr>
		<tr>
			<th>Class Day:</th>
			<td colspan="3" class="classday">
				<ul name="class_day_check">
					<li><input type="checkbox" value="0" /><label>Sun</label></li>
					<li><input type="checkbox" value="1" /><label>Mon</label></li>
					<li><input type="checkbox" value="2" /><label>Tue</label></li>
					<li><input type="checkbox" value="3" /><label>Wed</label></li>
					<li><input type="checkbox" value="4" /><label>Thu</label></li>
					<li><input type="checkbox" value="5" /><label>Fri</label></li>
					<li><input type="checkbox" value="6" /><label>Sat</label></li>
				</ul>
				<span class="not_found"></span>
			</td>
		</tr>
		<tr>
			<th>Class Material:<br /><span>(uLearning Material)</span></th>
			<td>
				<label>First Category</label>
				<select class="select_fix" name="cm_first_cat" >
					<?php foreach($classMaterial as $val){?>
						<option value="<?php echo $val['fcategory_id']; ?>"><?php echo $val['fcategory_name'];?></option>
					<?php }?>
				</select>
			</td>
			<td colspan="2">
				<label>Second Category</label>
				<select class="select_fix" name="cm_second_cat" >
				</select>
				<input type="hidden" name="classMaterial" value="" />
			</td>
		</tr>
		<tr>
			<th>uLearning:</th>
			<td>
				<label>First Category</label>
				<select class="select_fix" name="ul_first_cat">
					<option value="none">--Choose uLearning--</option>
					<?php foreach($classMaterial2 as $val){?>
						<option value="<?php echo $val['fcategory_id']; ?>"><?php echo $val['fcategory_name'];?></option>
					<?php }?>
				</select>
			</td>
			<td colspan="2">
				<label>Second Category</label>
				<select class="select_fix" name="ul_second_cat"></select>
				<input type="hidden" name="uLearning" value="" />
			</td>
		</tr>
		<tr>
			<th>Teacher Type</th>
			<td>
				<select name="teacher_type">
					<?php foreach($teacher as $val){?>
						<option value="<?php echo $val['idx']; ?>"><?php echo $val['grade_name'];?></option>
					<?php }?>
				</select>
			</td>
			<th>Time Range:</th>
			<td>
				<select name="time_range">
					<option value="00-07">00 - 07</option>
					<option value="08-15">08 - 15</option>
					<option value="16-23">16 - 23</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="4" style="height:30px;text-align:center">
				<input type="button" class="btn-apply" value="Generate Class" onclick="cal.calendar(<?php echo date("m") - 1; ?>, <?php echo date("Y"); ?>, <?php echo date("d"); ?>)" name="generate_class" />
			</td>
		</tr>
	</table>
	<p style="color:#FF0000" class="sched_error"></p>
	<div class="generated_schedule" style="display:none">
		<table cellspacing="2" cellpadding="0" border="0" style="float:left" name="time_col"></table>
		<table cellspacing="2" cellpadding="0" border="0" style="float:left" class="generated_names" name="time_sched"></table>
	</div>
	<div class="popup_window message_content schedule_calendar_popup" style="width:147px;padding:10px;left:520px;top:650px;display:none">
		<ul class="control"></ul>
		<table cellpadding="0" border="0" cellspacing="1" name="calendar" style="margin-left:7px;">
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
		<input class="btn-apply" type="button" name="sched_submit" value="Submit">
		<input class="btn-apply" type="button" name="sched_cancel" value="Cancel">
	</div>
	<div class="popup_window message_content schedule_calendar_popup schedule_info_popup" style="width:350px;padding:10px;display:none">
					<table cellspacing="0" cellpadding="0" border="0" class="schedule_info">
						<colgroup>
							<col width="160px" />
							<col width="320px" />
							<col width="160px" />
							<col width="320px" />

						</colgroup>
						<tr>
							<th>Class Name:</th>
							<td colspan="3" name="sched_info_className"><?php echo $oClass[0]['name']; ?></td>
						</tr>
						<tr>
							<th>Schedule Days:</th>
							<td colspan="3" name="sched_info_schedDays"></td>
						</tr>
						<tr>
							<th>Time Range:</th>
							<td colspan="3" name="sched_info_timeRange"></td>
						</tr>
						<tr>
							<th>Class Days:</th>
							<td colspan="3" name="sched_info_classDays"></td>
						</tr>
						<tr>
							<th>Teacher:</th>
							<td colspan="3" name="sched_info_teacher"></td>
						</tr>
						<tr>
							<th>Memo:</th>
							<td colspan="3" name="sched_info_memo"></td>
						</tr>
					</table>
				</div>	
	
</div>
<!-- End of Generate New Schedule -->		


<script type="text/javascript" src="<?php echo BASE_URL . "/js/jquery.js"; ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL . "/js/class/classCalendar.js"; ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL . "/js/jquery-ui-1.8.20.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL . "/js/menu/superfish.js"; ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL . "/js/menu/jquery.cookie.js"; ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL . "/js/menu/menu.js"; ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL . "/js/jquery.form.js"; ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL . "/js/jquery.validate.js"; ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL . "/js/common.js"; ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL . "/js/class/classScheduleManage.js"; ?>"></script>
