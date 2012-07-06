<!--menu-->
<?php echo Common::displayMenu(false);?>

<div id="container">
	<div class="container_wrap">		
			<div class="wrap schedule_mgmt_content" style="display:inline-block;width:95% !important;">
				<a href="#" class="btn_message class_image_here">Message</a>
				<div class="current_time"><p style ="float:left;width:200px;">Current Time[ <b id = "clock"></b> ] </p><p id ="pName"></p></div>
				<div class="content">
					<div class="calendar_control" style="margin-top:0;">
						<ul>
							<li class = "prev"></li>
							<li><p id = "dateSelected"></p></li>
							<li class = "next"></li>
							<li><input type="text" class="choosedate" id="period_startdate" name="period_startdate" value="05/30/2012"/></li>
							<li><a href="javascript:void(0)" class="btn submit" onClick = "cal.getSelected()">Submit</a></li>
							<li><a href="javascript:void(0)" class="btn pn" onClick = "cal.getPresent()">Today</a></li>
						</ul>
					</div>
					
					<br><br>
					<table cellspacing="1" cellpadding="0" border="0" class="schedule_class_calendar">
						<colgroup>
							<col width="120px" />
							<col width="170px" />
							<col width="170px" />
							<col width="170px" />
						</colgroup>
						<tr>
								<th>Name</th>
								<th>Time</th>
								<th>Type</th>
								<th>Email</th>
								<th>Phone</th>
						</tr>
						<tbody class = "schedule">
						</tbody>
					</table>
					
					<!-- modification form -->
					<div class="student_data popup_window" style = "display:none;">
						<p class="name">Jed (jmwoo)</p>
						<input type = "hidden" id ="userId">
						<input type = "hidden" class ="checkCount">
						<input type = "hidden" class ="checkKey">
						
						<div class="buttons">
							<p>
							<a id = "camClass" href="#" class="btn pn" style = "display:none;">Join Cam Class</a>
							<a id = "vPrev" href = "#">Prev</a>
							<a id = "vNext" href = "#">Next</a>
							</p>
							<div class="btn_close">
								<a href="#" class="popup_close" title="Close"></a>
							</div>
						</div>
						<table cellspacing="1" cellpadding="0" class="sched_details">
							<colgroup>
								<col width="150px" />
								<col width="450px" />
							</colgroup>
							<tbody>
								<tr>
									<th>Information</th>
									<td><div id = "memo"></div></td>
								</tr>
								<tr>
									<th>Date</th>
									
									<td>
									<p id = "cDate"></p>
									<input type="hidden" id = "memoDate" name = "memoDate" value ="">
									<input type= 'hidden' id ='hiddenDate' value = "">
									</td>
								</tr>
								<tr>
									<th>Type</th>
									<td><p class="type_phone">Phone English</p></td>
								</tr>
								<tr>
									<th>Age/Phone</th>
									<td  id = "agePhone">33 / 011-111-1111</td>
								</tr>
								<tr>
									<th>Attendance</th>
									<td><input class="first" type="radio" name ="attendance" value ="waiting"/> Waiting 
									<input type="radio" class="first"  name ="attendance" value ="attended"/> Attend 
									<input type="radio" class="first"  name ="attendance"  value ="absent"/> Absent
									<input type="radio" class="first"  name ="attendance"  value ="cancelled"/> Canceled
									</td>
								</tr>
								<tr>
									<th>uLearning</th>
									<td>
										<ul class = 'department' style = 'width:360px;'>
										
										</ul>
									</td>
								</tr>
								<tr>
									<th>Download</th>
									<td>My English.pdf</td>
								</tr>
								<tr>
									<th  class="comment" colspan="2">Comment</th>
								</tr>
								<tr>
									<th colspan="2">
									<textarea class ="tiny_MCE" id = "tiny_MCE" name = "tiny_MCE" style = "width:100%;"></textarea>
									</th>
								</tr>
							</tbody>
						</table>
						<table cellspacing="1" cellpadding="0" border="0" class="evaluation_list">
							<colgroup>
								<col width="168px" />
								<col width="80px" />
								<col width="80px" />
								<col width="80px" />
								<col width="80px" />
								<col width="80px" />
								<col width="80px" />
								<col width="80px" />
								<col width="80px" />
							</colgroup>
							<thead>
								<tr>
									<th class="first">Result<span class ='rdate'></span></th>
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
							<tbody>
								<tr>
									<td class="first listening">Listening</td>
									<td><input type="radio" name = "listening" value ="1"  CHECKED></td>
									<td><input type="radio" name = "listening" value ="2"/></td>
									<td><input type="radio" name = "listening" value ="3"/></td>
									<td><input type="radio" name = "listening" value ="4"/></td>
									<td><input type="radio" name = "listening" value ="5"/></td>
									<td><input type="radio" name = "listening" value ="6"/></td>
									<td><input type="radio" name = "listening" value ="7"/></td>
									<td><input type="radio" name = "listening" value ="8"/></td>
								</tr>
								<tr>
									<td class="first">Speaking</td>
									<td><input type="radio"  name = "speaking" value ="1" CHECKED></td>
									<td><input type="radio"  name = "speaking" value ="2"/></td>
									<td><input type="radio"  name = "speaking" value ="3"/></td>
									<td><input type="radio"  name = "speaking" value ="4"/></td>
									<td><input type="radio"  name = "speaking" value ="5"/></td>
									<td><input type="radio"  name = "speaking" value ="6"/></td>
									<td><input type="radio"  name = "speaking" value ="7"/></td>
									<td><input type="radio"  name = "speaking" value ="8"/></td>
								</tr>
								<tr>
									<td class="first">Pronunciation</td>
									<td><input type="radio"  name = "pronunciation" value ="1" CHECKED></td>
									<td><input type="radio"  name = "pronunciation" value ="2"/></td>
									<td><input type="radio"  name = "pronunciation" value ="3"/></td>
									<td><input type="radio"  name = "pronunciation" value ="4"/></td>
									<td><input type="radio"  name = "pronunciation" value ="5"/></td>
									<td><input type="radio"  name = "pronunciation" value ="6"/></td>
									<td><input type="radio"  name = "pronunciation" value ="7"/></td>
									<td><input type="radio"  name = "pronunciation" value ="8"/></td>
								</tr>
								<tr>
									<td class="first">Vocabulary</td>
									<td><input type="radio"  name = "vocabulary" value ="1" CHECKED></td>
									<td><input type="radio"  name = "vocabulary" value ="2" /></td>
									<td><input type="radio"  name = "vocabulary" value ="3"/></td>
									<td><input type="radio"  name = "vocabulary" value ="4" /></td>
									<td><input type="radio"  name = "vocabulary" value ="5"/></td>
									<td><input type="radio"  name = "vocabulary" value ="6"/></td>
									<td><input type="radio"  name = "vocabulary" value ="7"/></td>
									<td><input type="radio"  name = "vocabulary" value ="8"/></td>
								</tr>
								<tr>
									<td class="first">Grammar</td>
									<td><input type="radio"  name = "grammar" value ="1" CHECKED></td>
									<td><input type="radio"  name = "grammar" value ="2"/></td>
									<td><input type="radio"  name = "grammar" value ="3"/></td>
									<td><input type="radio"  name = "grammar" value ="4"/></td>
									<td><input type="radio"  name = "grammar" value ="5"/></td>
									<td><input type="radio"  name = "grammar" value ="6"/></td>
									<td><input type="radio"  name = "grammar" value ="7"/></td>
									<td><input type="radio"  name = "grammar" value ="8"/></td>
								</tr>
							</tbody>
						</table>
						<!--<a href="#" class="btn_save submit">Submit</a>-->
					</div>
					<!-- Send Email form-->
					<div class="popup_window" style="width:365px;left:600px;display:none;">
						<div class="btn_close">
							<a href="#" class="popup_close" title="Close"></a>
						</div>
						<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
							<col width="90px" />
							<tr>
								<th class="strong">Send to:</th>
								<td>a@a.com</td>
							</tr>
							<tr>
								<th class="strong">Templates </th>
								<td>
									<select style="width:100px;">
										<option>Email Templates</option>
									</select>
								</td>
							</tr>
							<tr>
								<th class="strong">Title</th>
								<td><input type="text" name="title" maxlength="100" value="" class="fix" /> </td>
							</tr>
							<tr>
								<th colspan="2">
									<textarea class="user_info textarea" rows="0" cols="0"></textarea>
								</th>
							</tr>
						</table>
						<div class="action_btn">
							<a href="#" class="btn_save fr" title="Save changes">Send Email</a>
						</div>
					</div>
					<!-- send sms -->
					<div class="popup_window" style="width:280px;left:1025px;display:none;">
						<div class="btn_close">
							<a href="#" class="popup_close" title="Close"></a>
						</div>
						<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
							<colgroup>
								<col width="60px" />
								<col width="200px" />
							</colgroup>
							<tr>
								<th class="strong">To:</th>
								<td>011-111-1111</td>
							</tr>
							<tr>
								<th class="strong">From</th>
								<td><input type="text" name="title" maxlength="100" value="012-121-1212" class="fix2" /> </td>
							</tr>
							<tr>
								<th colspan="2">
									<input type="radio" /> <label>Template 1</label> 
									<input type="radio" /> <label>Template 2</label> 
									<p class="">
										<img width="100" src="../../images/schedule/sms_bg.png" alt="" />
										<img width="100" src="../../images/schedule/sms_bg.png" alt="" />
									</p>
								</th>
							</tr>
						</table>
						<div class="action_btn">
							<a href="#" class="btn_save fr" title="Save changes">Send SMS</a>
						</div>
					</div>
					
					<div class="popupModifyrecord" style="width:300px;display:none;">
						Successfully Change
					</div>
				
				</div>
			</div>	
	</div>	
</div>	