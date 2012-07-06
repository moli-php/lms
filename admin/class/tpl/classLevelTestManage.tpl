<?php echo Common::displayMenu(true);

$sAction = isset($aTest) ? "editLevelTest" : "saveLevelTest";

echo '<form id="classLevelForm" name="classLevelForm">';
	
	if (isset($aTest))
		echo '<input type="hidden" name="test_idx" value="' . $aTest['idx'] . '" />';
		
	echo '<input type="hidden" name="exec" value="' . $sAction . '" />
	<input type="hidden" id="current_date" value="' . $sDate . '" />
	<table border="0" cellspacing="0" cellpadding="0" class="table_user config add_class" >
		<colgroup>
			<col width="135px" />
			<col />
		</colgroup>';
		
		if (!isset($aTest)){
			echo '<tr>
				<th><label for="userID">User ID</label></th>
				<td>
					<span id="name_wrap"><input type="text" id="userID" name="userID" readonly validate="required" />
					<a href="javascript:void(0);" class="btn_apply verify_popup_btn">Verify ID</a></span>
					<input type="hidden" name="studentidx" value="" />
				</td>
			</tr>';
		}
		echo '<tr>
			<th>Desired Date</th>
			<td><input type="text" class="fix3" id="desired_period" name="desired_date" value="' . (isset($aTest) ? date("Y-m-d", $aTest['datetime_desired']) : null) . '" validate="required" />
		</tr>
		<tr>
			<th>Desired Time</th>
			<td class="time_fix1">
			<select name="desired_hours">';
				
			$aStartTime = isset($aTest) ? explode(":", date("H:s", $aTest['datetime_desired'])) : array("00","00");
	
			for ($i = 0; $i <= 23; $i++)
				echo '<option' . ((int) $aStartTime['0'] == $i ? " selected" : null) . '>' . str_pad($i, 2, "0", STR_PAD_LEFT) . '</option>';
				
			echo '</select>
			<select name="desired_minutes">';
			
			for ($i = 0; $i <= 59; $i++)
				echo '<option' . ((int) $aStartTime['1'] == $i ? " selected" : null) . '>' . str_pad($i, 2, "0", STR_PAD_LEFT) . '</option>';
				
			echo '</select>';
				
				
			echo '</td>
		</tr>
		<tr>
			<th>Way of Test</th>
			<td><p class="add_type"><label for="phone">Phone</label><input type="radio" name="level_type" id="phone" value="phone"' . (isset($aTest) && $aTest['type'] == "phone" ? " checked" : (!isset($aTest) ? " checked" : null)) . ' /></p>
			<p class="add_type"><label for="videoCam">Video Cam</label><input type="radio" name="level_type" id="videoCam" value="camera"' . (isset($aTest) && $aTest['type'] == "camera" ? " checked" : null) . ' /></td></p>
		</tr>
		<tr>
			<th><label>Memo</label></th>
			<td>
				<textarea name="level_memo">' . (isset($aTest) ? $aTest['memo'] : null) . '</textarea>
			</td>
		</tr>
	</table>
</form>
<div class="action_btn">
	<a href="javascript:void(0);" class="btn_save" title="Save changes" onclick="classLevelTest.validate();">Submit</a>';
	
	$sFullUrl = isset($_SESSION['adminClassFullUrl']) ? $_SESSION['adminClassFullUrl'] : common::getClassUrl("classLevelTest");
	unset($_SESSION['adminClassFullUrl']);
	
	echo '<a href="' . $sFullUrl . '" class="btn_return"  title="Return to List">Return to List</a>
</div>';

?>

<div id="verify_popup_window" class="popup_window" style="display:none;">
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
		<col width="60px" />
		<col width="*" />
		<tr>
			<th>ID</th>
			<td><input type="text" id="verify_popup_text" name="title" maxlength="100" value="" class="fix4" /> </td>
		</tr>
	</table>
</div>
<div id="verify_popup_result" class="popup_window add_class_list" style="display:none;">
	<p>User ID found:<span class="user_id"></span></p>
	<p style="text-align:center;display:inline-block">Is this correct?</p>
</div>

	