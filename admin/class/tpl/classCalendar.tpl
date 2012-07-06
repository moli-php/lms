<?php echo Common::displayMenu(true);

echo '<div class="top">
		<ul class="class_calender">
			<li><a href="javascript:void(0);" class="btn pn" onclick="classCalendar.loadCalendar(\'prev\');">Prev Day</a></li>
			<li><a href="javascript:void(0);" class="btn pn" onclick="classCalendar.loadCalendar(\'next\');">Next Day</a></li>
			<li>
				<label>Date:</label>
				<input type="text" class="fix3" id="class_calendar" value="' . date("Y-m-d") . '" readonly />
			</li>
		</ul>
	</div>
	<div class="content">
		<div class="calendar_control">
			<ul>
				<li><a href="#" class="btn level">Level Test</a></li>
				<li><a href="#" class="btn normal">Normal Class</a></li>
			</ul>
			<ul style="float:right;margin-right:50px">
				<li><a href="#" class="btn waiting">Waiting</a></li>
				<li><a href="#" class="btn attend">Attended</a></li>
				<li><a href="#" class="btn absent">Absent</a></li>
				<li><a href="#" class="btn canceled">Canceled</a></li>
				<li><a href="#" class="btn postponed">Postponed</a></li>
				<li><a href="#" class="btn no_class">No Class</a></li>
			</ul>
		</div>
		<table cellspacing="1" cellpadding="0" border="0" class="schedule_class_calendar class_calendar">
			<thead id="schedule_head">
				<tr>
					<th>TIME</th>';
					
					foreach ($aTeacher as $iKey => $aValue){
						echo '<th>' . $aValue['name'] . '</th>';
					}
					
				echo '</tr>
			</thead>
			<tbody id="schedule_body">
			</tbody>
		</table>
	</div>';

?>
			