<html>
<head>
	<title><?php echo $sPageTitle; ?> | LMS</title>
	<link rel="stylesheet" type="text/css" href="http://lms.dev.com/css/custom-theme/jquery-ui-1.8.20.custom.css" />
	<link rel="stylesheet" type="text/css" href="http://lms.dev.com/css/style.css" />
	<link rel="stylesheet" type="text/css" href="http://lms.dev.com/css/class/class.css" />
	<script type="text/javascript" src="http://lms.dev.com/js/jquery.js"></script>
	<script type="text/javascript" src="http://lms.dev.com/js/jquery-ui-1.8.20.custom.min.js"></script>
	<script type="text/javascript" src="http://lms.dev.com/js/jquery.form.js"></script>
	<script type="text/javascript" src="http://lms.dev.com/js/jquery.validate.js"></script>
	<script type="text/javascript" src="http://lms.dev.com/js/common.js"></script>
	<script type="text/javascript" src="http://lms.dev.com/js/class/classLevelTestSchedule.js"></script>
</head>
<body>
<?php

echo '<div style="margin:30px;">
	<form id="levelTestForm">
		<input type="hidden" id="test_idx" value="' . $iTestIdx . '" />
		<table cellspacing="0" cellpadding="0" border="0" class="product_search">
			<colgroup>
				<col width="100">
				<col width="290">
				<col width="100">	
				<col width="290">
			</colgroup>
			<tbody>
				<tr>
					<th><label>Date:</label></th>
					<td><input type="text" id="test_date" name="test_date" class="fix3" value="2012-06-20" validate="required" /></td>
					<th><label>Test Time:</label></th>
					<td><select id="test_time">';
					
						for ($i = 1; $i <= 12; $i++)
							echo '<option value="' . ($i * 5) . '">' . ($i * 5) . ' minutes</option>';

					echo '</select></td>
				</tr>
				<tr>
					<th><label>Teacher Type:</label></th>
					<td><select id="teacher_type">';
						
						foreach ($aTeacherType as $iKey => $aValue)
							echo '<option value="' . $aValue['idx'] . '">' . $aValue['grade_name'] . '</option>';
						
					echo '</select></td>
					<th><label>Time Range:</label></th>
					<td><select id="time_range">
						<option value="0">0 - 7</option>
						<option value="8">8 - 15</option>
						<option value="16">16 - 23</option>
					</select></td>
				</tr>
				<tr>			
					<td colspan="4"><a style="float:right;margin-top:12px" class="btn_go" href="javascript:void(0);" onclick="classLevelTestSchedule.createSchedule();">Submit</a></td>
				</tr>
			</tbody>
		</table>
	</form>
	<div class="generated_schedule" style="display:block;">
		<table cellspacing="2" cellpadding="0" border="0" style="float:left">
			<colgroup>
				<col width="60px">
				<col width="40px">
			</colgroup>
			<tbody id="schedule_hours">';
			

		echo '</tbody></table>
			<table cellspacing="2" cellpadding="0" border="0" class="generated_names" style="float:left">
			<colgroup>
				<col width="120px">
				<col width="120px">
				<col width="120px">
				<col width="120px">
			</colgroup>
			<tbody id="teacher_schedule">
			
		</tbody></table>	
	</div>

</div';

?>

</body>
</html>





