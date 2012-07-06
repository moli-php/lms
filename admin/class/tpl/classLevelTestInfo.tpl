<?php echo Common::displayMenu(true); 

$aNewTest = $aTest[0];

echo '<ul class="class_list_tab">
	<li><a href="#">Class Calendar</a></li>
	<li><a href="#">Class List</a></li>
	<li><a href="#">Change Schedule</a></li>
	<li class="active"><a href="#">Level Test Info</a></li>
</ul>
<div class="content level_test">
	<input type="hidden" name="user_idx" value="' . $aUser['idx'] . '" />
	<div class="user_header"><strong>' . $aUser['name'] . '</strong><em>' . $aUser['user_id'] . '</em></div>
	<div class="choose_class"><label>Choose Level Test:</label>
		<select onchange="classLevelTestInfo.changeLevelTest(this.value)">';
			foreach ($aAllTest as $iKey => $aValue){
				echo '<option value="' . $aValue['idx'] . '"' . ($aValue['idx'] == $aNewTest['idx'] ? " selected" : null) . '>'; 
				
				switch ($aValue['status']){
					case 1 : 
						echo "Scheduled";
						break;
					case 2 :
						echo "Finished";
						break;
					default :
						echo "New";
				}
				
				echo " " . date("g:s A F d, Y", $aValue['datetime_desired']) . '</option>';
			
			}
		echo '</select>
	</div>
	<h3>Requested Info</h3>
	<table border="0" cellpadding="0" cellspacing="0" class="level_info_table">
		<colgroup>
			<col width="130px" />
			<col width="200px" />
			<col width="130px" />
			<col width="200px" />
		</colgroup>
		<tr>
			<th>Desired Way:</th>
			<td>' . ucfirst($aNewTest['type']) . '</td>
			<th>Desired Date</th>
			<td>' . date("Y-m-d H:s", $aNewTest['datetime_desired']) . '</td>
		</tr>
		<tr>
			<th>English Skill:</th>
			<td>Beginner</td>
			<th>Memo:</th>
			<td>' . (trim($aNewTest['memo']) != "" ? $aNewTest['memo'] : "None") . '</td>
		</tr>';
	if ($aNewTest['status'] == 0){	
		echo '<tr>
			<td colspan="4" class="center"><a href="#" class="btn_apply" onclick="classLevelTestInfo.createSchedule();">Create Schedule</a></td>
		</tr>';
	}	
	echo '</table>';
	if ($aNewTest['status'] != 0){	
	echo '<div>
		<h3>Created Level Test Schedule</h3>
		<table border="0" cellpadding="0" cellspacing="0" class="level_info_table">
			<colgroup>
				<col width="130px" />
				<col width="200px" />
				<col width="130px" />
				<col width="200px" />
			</colgroup>
			<tr>
				<th>Teacher:</th>
				<td>' . $aTeacher['name'] . '</td>
				<th>Scheduled Date</th>
				<td>' . $aNewTest['date_test'] . ' ' . $aNewTest['time_start'] . ' ~ ' . $aNewTest['time_end'] . '</td>
			</tr>
			<tr>
				<th>Test Way</th>
				<td>' . ucfirst($aNewTest['type']) . '</td>
				<td colspan="2">&nbsp;</td>
			</tr>';
			
		if ($aNewTest['status'] != 2){	
			echo '<tr>
				<td colspan="4" class="center"><a href="javascript:void(0);" class="btn_apply" onclick="classLevelTestInfo.createSchedule();">Edit Schedule</a><a href="#" class="btn_apply" onclick="classLevelTestInfo.verifyDelete();">Delete Schedule</a></td>
			</tr>';
		}	
		echo '</table>
	<h3>Level Test Result</h3>
	<form id="testForm">
		<table border="0" cellpadding="0" cellspacing="0" class="level_info_table last">
			<colgroup>
				<col width="150px" />
				<col width="400px" />
			</colgroup>
			<tr>
				<th>Tested Day:</th>
				<td>' . $aNewTest['date_test'] . ' ' . $aNewTest['time_start'] . ' ~ ' . $aNewTest['time_end'] . '</td>
			</tr>
			<tr>
				<th>Teacher:</th>
				<td>' . $aTeacher['name'] . '</td>
			</tr>
			<tr>
				<th>Tester\'s Level:</th>
				<td><input type="text" name="tester_level" value="' . $aNewTest['tester_level'] . '" validate="required" /></td>
			</tr>
			<tr>
				<th>Tester\'s Comment:</th>
				<td><textarea name="tester_comment" validate="required">' . $aNewTest['tester_comment'] . '</textarea></td>
			</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" class="level_test_levels">
			<colgroup>
				<col width="180px" />
				<col width="100px" />
				<col width="100px" />
				<col width="100px" />
				<col width="100px" />
				<col width="100px" />
				<col width="100px" />
				<col width="100px" />
				<col width="100px" />
			</colgroup>
			<thead>
			<tr>
				<th>Result</th>
				<th>Level 1</th>
				<th>Level 2</th>
				<th>Level 3</th>
				<th>Level 4</th>
				<th>Level 5</th>
				<th>Level 6</th>
				<th>Level 7</th>
				<th>Level 8</th>
			</tr>
			</thead>
			<tbody>';
			
			$aCategory = array("Listening", "Speaking", "Pronunciation", "Vocabulary", "Reading", "Writing", "Grammar");
			$iBreak = 2;
			
			foreach ($aCategory as $sValue){
				$sString = "";
				
				if ($iBreak == 2){
					$sString = ' class="alt_td"';
					$iBreak = 0;
				}
				
				echo '<tr' . $sString . '>
					<th>' . $sValue . '</th>';
					for ($i = 1; $i <= 8; $i++)
						echo '<td><input type="radio" name="score_' . strtolower($sValue) . '" value="' . $i . '"' . ($i == 1 ? " checked" : ($aNewTest['score_' . strtolower($sValue)] == $i ? " checked" : null)) . ' /></td>';
				echo '</tr>';
				$iBreak++;
			}
			
			echo '
			</tbody>
			<tfoot><tr><td colspan="9"><a href="javascript:void(0);" class="btn_apply fr" onclick="classLevelTestInfo.saveResult();">Submit</a></td></tr></tfoot>
		</table>
	</form>
	</div>';
}	

echo '</div>
<div id="classLevelSchedulePopup" style="display:none;">
	<form id="levelTestForm">
		<input type="hidden" id="test_idx" value="' . $aNewTest['idx'] . '" />
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="product_search">
			<colgroup>
				<col width="10%" />
				<col width="40%" />
				<col width="10%" />	
				<col width="40%" />
			</colgroup>
			<tbody>
				<tr>
					<th><label>Date:</label></th>
					<td><input type="text" id="test_date" name="test_date" class="fix3" value="' . ($aNewTest['status'] == 1 ? $aNewTest['date_test'] : null) . '" validate="required" /></td>
					<th><label>Test Time:</label></th>
					<td><select id="test_time">';
					
						$iDifference = round(abs(strtotime($aNewTest['time_end']) - strtotime($aNewTest['time_start'])) / 60,2);
					
						for ($i = 1; $i <= 12; $i++)
							echo '<option value="' . ($i * 5) . '"' . (($i * 5) == $iDifference ? " selected" : null) . '>' . ($i * 5) . ' minutes</option>';

					echo '</select></td>
				</tr>
				<tr>
					<th><label>Teacher Type:</label></th>
					<td><select id="teacher_type">';

						foreach ($aTeacherType as $iKey => $aValue)
							echo '<option value="' . $aValue['idx'] . '"' . (isset($aTeacher) && $aTeacher['teacher_type_idx'] == $aValue['idx'] ? " selected" : null) . '>' . $aValue['grade_name'] . '</option>';
						
					echo '</select></td>
					<th><label>Time Range:</label></th>
					<td><select id="time_range" onchange="classLevelTestSchedule.createSchedule();">';
					
						$iHour = date("G", strtotime($aNewTest['time_start']));

						for ($i = 0; $i < 3; $i++){
							$iTime = $i * 8;
							echo '<option value="' . $iTime . '"' . ($iHour >= $iTime && $iHour <= ($iTime + 7) ? " selected" : null) . '>' . $iTime . ' - ' . ($iTime + 7). '</option>';
						}
						
					echo '</select></td>
				</tr>
			</tbody>
		</table>
	</form>
	<div class="generated_schedule" style="display:block;margin-top:10px;">
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
		<div id="error_message" style="margin-top:50px;color:red;"></div>
	</div>
</div';

?>
			
		