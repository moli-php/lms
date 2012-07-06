<?php echo Common::displayMenu(true);?>
				<div class="content">
					<div class="calendar_control">
						<ul>
							<li id = "prev"></li>
							<li id = "next"></li>
							<li><select name = "selYear" id = "selYear" onChange = "cal.checkDate(year)">
							<option value = "2010">2010</option>
							<option value = "2011">2011</option>
							<option value = "2012">2012</option>
							<option value = "2013">2013</option>
							<option value = "2014">2014</option>
							<option value = "2015">2015</option>
							<option value = "2016">2016</option>
							<option value = "2017">2017</option>
							<option value = "2018">2018</option>
							<option value = "2019">2019</option>
							<option value = "2020">2020</option>
							<option value = "2021">2021</option>
							<option value = "2022">2022</option>
							<option value = "2023">2023</option>
							<option value = "2024">2024</option>
							<option value = "2025">2025</option>
							</select></li>
							<li><select name = "selMonth" id = "selMonth" onChange = "cal.checkDate(month)">
							<option value = "1">01</option>
							<option value = "2">02</option>
							<option value = "3">03</option>
							<option value = "4">04</option>
							<option value = "5">05</option>
							<option value = "6">06</option>
							<option value = "7">07</option>
							<option value = "8">08</option>
							<option value = "9">09</option>
							<option value = "10">10</option>
							<option value = "11">11</option>
							<option value = "12">12</option>
							</select></li>
							<!--<li><a href="#" class="btn search">Search</a></li>-->
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
						<tbody class = "days">
						</tbody>
					</table>
				</div>
				<div class="popup_window schedule_management_popup" style="width:300px;;margin-left:2%;margin-top:0%">
					<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
						<tr>
							<td>
								<label class="label_fix">Reason:</label>
								<textarea class="fix2" name = "reason" id = "reason"/></textarea><br><b id ="error">
							</td>
						</tr>
						<tr>
							<td>
								<ul>
									<li class="margin_fix"><input type="radio" name ="holidayResult" id = "notHoliday" value ="No Holiday" checked /><label class="label_fix2" for="no_holiday">No Holiday</label></li>
									<li><input type="radio" name ="holidayResult" id = "holiday" value ="Holiday"/><label class="label_fix2" for="holiday">Holiday</label></li>
								</ul>
							</td>
						</tr>
					</table>
					
				</div>
				<div class="popupError" style="width:300px;display:none;">
					Not allowed to assign holiday on previous months
				</div>
				<div class="popupAddrecord" style="width:300px;display:none;">
					Successfully Created Holiday
				</div>
				<div class="popupModifyrecord" style="width:300px;display:none;">
					Successfully Change
				</div>