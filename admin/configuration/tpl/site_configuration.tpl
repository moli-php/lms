<!--menu-->
<?php echo Common::displayMenu(true);?>
			<p class="require"><span class="neccesary">*</span>Required</p>
			<form name="userAddForm" enctype = "multipart/form-data">
				<input type = "hidden" name = "globalFileName" value = "" />
				
				<table border="0" cellspacing="0" cellpadding="0" class="table_user config" >
					<colgroup>
						<col width="175px" />
						<col width="*" />
					</colgroup>
					<tr>
						<th><label for="fsite_url">Site URL</label><span class="neccesary">*</span></th>
						<td>
							<span id="name_wrap"><input type="text" id="fsite_url" name="fsite_url" class="fix" maxlength=500 validate="required" /></span>
							<span class = "utc"><span id = "url_char_max"></span> characters left</span>
						</td>
					</tr>
					<tr>
						<th><label for="fsite_owner">Site Owner</label><span class="neccesary">*</span></th>
						<td>
							<input type="text" name="fsite_owner" id="fsite_owner" maxlength="100" value="" class="fix" validate="required"  />
							<span class = "utc"><span id = "owner_char_max"></span> characters left</span>
						</td>
					</tr>
					<tr>
						<th><label for="fcompany_name">Company Name</label><span class="neccesary">*</span></th>
						<td>
							<input type="text" name="fcompany_name" id="fcompany_name" maxlength="100" value="" class="fix" validate="required"  />
							<span class = "utc"><span id = "companyn_char_max"></span> characters left</span>
						</td>
					</tr>
					<tr>
						<th><label for="fcompany_reg_number">Company Registration number</label><span class="neccesary">*</span></th>
						<td>
							<input type="text" name="fcompany_reg_number" id="fcompany_reg_number" class="fix" value="" maxlength="100" validate="required"  />
							<span class = "utc"><span id = "companyr_char_max"></span> characters left</span>
						</td>
					</tr>
					<tr>
						<th><label for="fsecurity_manager">Security Manager</label><span class="neccesary">*</span></th>
						<td>
							<input type="text" name="fsecurity_manager" id="fsecurity_manager" class="fix" value="" maxlength="100" validate="required"  />
							<span class = "utc"><span id = "sec_char_max"></span> characters left</span>
						</td>
					</tr>
					<tr>
						<th><label for="fadmin_email">Admin Email Address</label></th>
						<td>
							<input type="text" name="fadmin_email" id="fadmin_email" class="fix" value="" />
						</td>
					</tr>
					<tr>
						<th><label for="faddress">Address</label></th>
						<td>
							<input type="text" name="faddress" id="faddress" class="fix" value="" readonly = "readonly" />
							<input type="button" value="Find Address" class="btn_find" />
						</td>
					</tr>
					<tr>
						<th><label for="fphone_number">Phone number</label></th>
						<td>
							<input type="text" name="fphone_number" id="fphone_number" class="fix" value="" />
							<span class = "utc">(e.g : 123-4567-8900)</span>
							<span class = "sc_num_error" style = "color:#FF0000"></span>
						</td>
					</tr>
					<tr>
						<th><label for="finformation">Other Information</label><span class="neccesary">*</span></th>
						<td>
							<textarea id="finformation" name="finformation" class="info_area" validate="required"  ></textarea>
						</td>
					</tr>
					<tr>
						<th><label for="ftime_zone">Time zone</label></th>
						<td>
							<p>
							<select name="ftime_zone" id="ftime_zone" class="time_zone" onchange="javascript: window.location.href = '<?php Common::urlInclude('timezone'); ?>' + $('#ftime_zone').val();">
								<option value="Pacific/Apia" <?php if($sTimezone == "Pacific/Apia"){echo "selected";} ?> >UTC -11:00 : Samoa</option>
								<option value="Pacific/Midway" <?php if($sTimezone == "Pacific/Midway"){echo "selected";} ?> >UTC -10:00 : Hawaii</option>
								<option value="America/Anchorage" <?php if($sTimezone == "America/Anchorage"){echo "selected";} ?> >UTC -09:00 : Alaska</option>
								
								<option value="America/Los_Angeles" <?php if($sTimezone == "America/Los_Angeles"){echo "selected";} ?> >UTC -08:00 : Pacific Time (US & Canada)</option>
								<option value="America/Santa_Isabel" <?php if($sTimezone == "America/Santa_Isabel"){echo "selected";} ?> >UTC -08:00 : Baja California</option>
								<option value="America/Boise" <?php if($sTimezone == "America/Boise"){echo "selected";} ?> >UTC -07:00 : Mountain Time (US & Canada)</option>
								<option value="America/Chihuahua" <?php if($sTimezone == "America/Chihuahua"){echo "selected";} ?> >UTC -07:00 : Chihuahua, La Paz, Mazatlan</option>
								<option value="America/Ojinaga" <?php if($sTimezone == "America/Ojinaga"){echo "selected";} ?> >UTC -07:00 : Arizona</option>
								
								<option value="America/Chicago" <?php if($sTimezone == "America/Chicago"){echo "selected";} ?> >UTC -06:00 : Central Time (US & Canada)</option>
								<option value="America/Costa_Rica" <?php if($sTimezone == "America/Costa_Rica"){echo "selected";} ?> >UTC -06:00 : Central America</option>
								<option value="America/Cancun" <?php if($sTimezone == "America/Cancun"){echo "selected";} ?> >UTC -06:00 : Guadalajara, Mexico City, Monterrey</option>
								<option value="America/Atikokan" <?php if($sTimezone == "America/Atikokan"){echo "selected";} ?> >UTC -05:00 : Eastern Time (US & Canada)</option>
								<option value="America/Bogota" <?php if($sTimezone == "America/Bogota"){echo "selected";} ?> >UTC -05:00 : Bogota, Lima, Quito</option>
								
								<option value="America/Indiana/Indianapolis" <?php if($sTimezone == "America/Indiana/Indianapolis"){echo "selected";} ?> >UTC -05:00 : Indiana (East)</option>
								<option value="America/Caracas" <?php if($sTimezone == "America/Caracas"){echo "selected";} ?> >UTC -04:30 : Caracas</option>
								<option value="America/Santiago" <?php if($sTimezone == "America/Santiago"){echo "selected";} ?> >UTC -04:00 : Santiago</option>
								<option value="America/Asuncion" <?php if($sTimezone == "America/Asuncion"){echo "selected";} ?> >UTC -04:00 : Asuncion</option>
								<option value="America/Antigua" <?php if($sTimezone == "America/Antigua"){echo "selected";} ?> >UTC -04:00 : Atlantic Time (Canada)</option>
								<option value="America/Cuiaba" <?php if($sTimezone == "America/Cuiaba"){echo "selected";} ?> >UTC -04:00 : Cuiaba</option>
								
								<option value="America/La_Paz" <?php if($sTimezone == "America/La_Paz"){echo "selected";} ?> >UTC -04:00 : Georgetown, La Paz, Manaus, San Juan</option>
								<option value="America/St_Johns" <?php if($sTimezone == "America/St_Johns"){echo "selected";} ?> >UTC -03:30 : Newfoundland</option>
								<option value="America/Godthab" <?php if($sTimezone == "America/Godthab"){echo "selected";} ?> >UTC -03:00 : Greenland</option>
								<option value="America/Araguaina" <?php if($sTimezone == "America/Araguaina"){echo "selected";} ?> >UTC -03:00 : Brasilia</option>
								<option value="America/Cayenne" <?php if($sTimezone == "America/Cayenne"){echo "selected";} ?> >UTC -03:00 : Cayenne, Fortaleza</option>
								<option value="America/Montevideo" <?php if($sTimezone == "America/Montevideo"){echo "selected";} ?> >UTC -03:00 : Montevideo</option>
								
								<option value="America/Argentina/Buenos_Aires" <?php if($sTimezone == "America/Argentina/Buenos_Aires"){echo "selected";} ?> >UTC -03:00 : Buenos Aires</option>
								<option value="America/Noronha" <?php if($sTimezone == "America/Noronha"){echo "selected";} ?> >UTC -02:00 : Mid-Atlantic</option>
								<option value="Atlantic/Azores" <?php if($sTimezone == "Atlantic/Azores"){echo "selected";} ?> >UTC -01:00 : Azores</option>
								<option value="Atlantic/Cape_Verde" <?php if($sTimezone == "Atlantic/Cape_Verde"){echo "selected";} ?> >UTC -01:00 : Cape Verde Is.</option>
								<option value="Africa/Casablanca" <?php if($sTimezone == "Africa/Casablanca"){echo "selected";} ?> >UTC  00:00 : Casablanca</option>
								<option value="Africa/Abidjan" <?php if($sTimezone == "Africa/Abidjan"){echo "selected";} ?> >UTC  00:00 : Dublin, Edinburgh, Lisbon, London</option>
								
								<option value="Atlantic/Reykjavik" <?php if($sTimezone == "Atlantic/Reykjavik"){echo "selected";} ?> >UTC  00:00 : Monrovia, Reykjavik</option>
								<option value="Africa/Algiers" <?php if($sTimezone == "Africa/Algiers"){echo "selected";} ?> >UTC +01:00 : West Central Africa</option>
								<option value="Africa/Windhoek" <?php if($sTimezone == "Africa/Windhoek"){echo "selected";} ?> >UTC +01:00 : Windhoek</option>
								<option value="Europe/Amsterdam" <?php if($sTimezone == "Europe/Amsterdam"){echo "selected";} ?> >UTC +01:00 : Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
								<option value="Europe/Belgrade" <?php if($sTimezone == "Europe/Belgrade"){echo "selected";} ?> >UTC +01:00 : Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
								<option value="Europe/Brussels" <?php if($sTimezone == "Europe/Brussels"){echo "selected";} ?> >UTC +01:00 : Brussels, Copenhagen, Madrid, Paris</option>
								
								<option value="Europe/Sarajevo" <?php if($sTimezone == "Europe/Sarajevo"){echo "selected";} ?> >UTC +01:00 : Sarajevo, Skopje, Warsaw, Zagreb</option>
								<option value="Africa/Johannesburg" <?php if($sTimezone == "Africa/Johannesburg"){echo "selected";} ?> >UTC +02:00 : Harare, Pretoria</option>
								<option value="Africa/Cairo" <?php if($sTimezone == "Africa/Cairol"){echo "selected";} ?> >UTC +02:00 : Cairo</option>
								<option value="Asia/Amman" <?php if($sTimezone == "Asia/Amman"){echo "selected";} ?> >UTC +02:00 : Amman</option>
								<option value="Africa/Tripoli" <?php if($sTimezone == "Africa/Tripoli"){echo "selected";} ?> >UTC +02:00 : Beirut</option>
								<option value="Asia/Damascus" <?php if($sTimezone == "Asia/Damascus"){echo "selected";} ?> >UTC +02:00 : Damascus</option>
								
								<option value="Asia/Jerusalem" <?php if($sTimezone == "Asia/Jerusalem"){echo "selected";} ?> >UTC +02:00 : Jerusalem</option>
								<option value="Europe/Athens" <?php if($sTimezone == "Europe/Athens"){echo "selected";} ?> >UTC +02:00 : Athens, Bucharest</option>
								<option value="Europe/Chisinau" <?php if($sTimezone == "Europe/Chisinau"){echo "selected";} ?> >UTC +02:00 : Minsk</option>
								<option value="Europe/Helsinki" <?php if($sTimezone == "Europe/Helsinki"){echo "selected";} ?> >UTC +02:00 : Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
								<option value="Europe/Istanbul" <?php if($sTimezone == "Europe/Istanbul"){echo "selected";} ?> >UTC +02:00 : Istanbul</option>
								<option value="Africa/Nairobi" <?php if($sTimezone == "Africa/Nairobi"){echo "selected";} ?> >UTC +03:00 : Nairobi</option>
								
								<option value="Antarctica/Syowa" <?php if($sTimezone == "Antarctica/Syowa"){echo "selected";} ?> >UTC +03:00 : Kaliningrad</option>
								<option value="Asia/Baghdad" <?php if($sTimezone == "Asia/Baghdad"){echo "selected";} ?> >UTC +03:00 : Baghdad</option>
								<option value="Asia/Kuwait" <?php if($sTimezone == "Asia/Kuwait"){echo "selected";} ?> >UTC +03:00 : Kuwait, Riyadh</option>
								<option value="Asia/Tehran" <?php if($sTimezone == "Asia/Tehran"){echo "selected";} ?> >UTC +03:30 : Tehran</option>
								<option value="Asia/Yerevan" <?php if($sTimezone == "Asia/Yerevan"){echo "selected";} ?> >UTC +04:00 : Yerevan</option>
								<option value="Asia/Muscat" <?php if($sTimezone == "Asia/Muscat"){echo "selected";} ?> >UTC +04:00 : Abu Dhabi, Muscat</option>
								
								<option value="Asia/Tbilisi" <?php if($sTimezone == "Asia/Tbilisi"){echo "selected";} ?> >UTC +04:00 : Tbilisi</option>
								<option value="Europe/Moscow" <?php if($sTimezone == "Europe/Moscow"){echo "selected";} ?> >UTC +04:00 : Moscow, St. Petersburg, Volgograd</option>
								<option value="Indian/Mahe" <?php if($sTimezone == "Indian/Mahe"){echo "selected";} ?> >UTC +04:00 : Port Louis</option>
								<option value="Asia/Kabul" <?php if($sTimezone == "Asia/Kabul"){echo "selected";} ?> >UTC +04:30 : Kabul</option>
								<option value="Asia/Tashkent" <?php if($sTimezone == "Asia/Tashkent"){echo "selected";} ?> >UTC +05:00 : Tashkent</option>
								<option value="Asia/Karachi" <?php if($sTimezone == "Asia/Karachi"){echo "selected";} ?> >UTC +05:00 : Islamabad, Karachi</option>
								
								<option value="Asia/Colombo" <?php if($sTimezone == "Asia/Colombo"){echo "selected";} ?> >UTC +05:30 : Sri Jayawardenepura</option>
								<option value="Asia/Kolkata" <?php if($sTimezone == "Asia/Kolkata"){echo "selected";} ?> >UTC +05:30 : Chennai, Kolkata, Mumbai, New Delhi</option>
								<option value="Asia/Kathmandu" <?php if($sTimezone == "Asia/Kathmandu"){echo "selected";} ?> >UTC +05:45 : Kathmandu</option>
								<option value="Antarctica/Mawson" <?php if($sTimezone == "Antarctica/Mawson"){echo "selected";} ?> >UTC +06:00 : Astana</option>
								<option value="Asia/Dhaka" <?php if($sTimezone == "Asia/Dhaka"){echo "selected";} ?> >UTC +06:00 : Dhaka</option>
								<option value="Asia/Yekaterinburg" <?php if($sTimezone == "Asia/Yekaterinburg"){echo "selected";} ?> >UTC +06:00 : Ekaterinburg</option>
								
								<option value="Asia/Rangoon" <?php if($sTimezone == "Asia/Rangoon"){echo "selected";} ?> >UTC +06:30 : Yangon (Rangoon)</option>
								<option value="Asia/Bangkok" <?php if($sTimezone == "Asia/Bangkok"){echo "selected";} ?> >UTC +07:00 : Bangkok, Hanoi, Jakarta</option>
								<option value="Asia/Novosibirsk" <?php if($sTimezone == "Asia/Novosibirsk"){echo "selected";} ?> >UTC +07:00 : Novosibirsk</option>
								<option value="Australia/Perth" <?php if($sTimezone == "Australia/Perth"){echo "selected";} ?> >UTC +08:00 : Perth</option>
								<option value="Asia/Krasnoyarsk" <?php if($sTimezone == "Asia/Krasnoyarsk"){echo "selected";} ?> >UTC +07:00 : Krasnoyarsk</option>
								<option value="Asia/Choibalsan" <?php if($sTimezone == "Asia/Choibalsan"){echo "selected";} ?> >UTC +08:00 : Beijing, Chongqing, Hong Kong, Urumqi</option>
								
								<option value="Asia/Kuala_Lumpur" <?php if($sTimezone == "Asia/Kuala_Lumpur"){echo "selected";} ?> >UTC +08:00 : Kuala Lumpur, Singapore</option>
								<option value="Asia/Taipei" <?php if($sTimezone == "Asia/Taipei"){echo "selected";} ?> >UTC +08:00 : Taipei</option>
								<option value="Asia/Ulaanbaatar" <?php if($sTimezone == "Asia/Ulaanbaatar"){echo "selected";} ?> >UTC +08:00 : Ulaanbaatar</option>
								<option value="Asia/Irkutsk" <?php if($sTimezone == "Asia/Irkutsk"){echo "selected";} ?> >UTC +09:00 : Irkutsk</option>
								<option value="Asia/Seoul" <?php if($sTimezone == "Asia/Seoul"){echo "selected";} ?> >UTC +09:00 : Seoul</option>
								<option value="Asia/Tokyo" <?php if($sTimezone == "Asia/Tokyo"){echo "selected";} ?> >UTC +09:00 : Osaka, Sapporo, Tokyo</option>
								
								<option value="Australia/Adelaide" <?php if($sTimezone == "Australia/Adelaide"){echo "selected";} ?> >UTC +09:30 : Adelaide</option>
								<option value="Australia/Darwin" <?php if($sTimezone == "Australia/Darwin"){echo "selected";} ?> >UTC +09:30 : Darwin</option>
								<option value="Asia/Yakutsk" <?php if($sTimezone == "Asia/Yakutsk"){echo "selected";} ?> >UTC +10:00 : Yakutsk</option>
								<option value="Australia/Brisbane" <?php if($sTimezone == "Australia/Brisbane"){echo "selected";} ?> >UTC +10:00 : Brisbane</option>
								<option value="Australia/Currie" <?php if($sTimezone == "Australia/Currie"){echo "selected";} ?> >UTC +10:00 : Hobart</option>
								<option value="Australia/Melbourne" <?php if($sTimezone == "Australia/Melbourne"){echo "selected";} ?> >UTC +10:00 : Canberra, Melbourne, Sydney</option>
								
								<option value="Pacific/Port_Moresby" <?php if($sTimezone == "Pacific/Port_Moresby"){echo "selected";} ?> >UTC +10:00 : Guam, Port Moresby</option>
								<option value="Asia/Vladivostok" <?php if($sTimezone == "Asia/Vladivostok"){echo "selected";} ?> >UTC +11:00 : Vladivostok</option>
								<option value="Pacific/Efate" <?php if($sTimezone == "Pacific/Efate"){echo "selected";} ?> >UTC +11:00 : Solomon Is., New Caledonia</option>
								<option value="Asia/Magadan" <?php if($sTimezone == "Asia/Magadan"){echo "selected";} ?> >UTC +12:00 : Magadan</option>
								<option value="Pacific/Auckland" <?php if($sTimezone == "Pacific/Auckland"){echo "selected";} ?> >UTC +12:00 : Auckland, Wellington</option>
								<option value="Pacific/Fiji" <?php if($sTimezone == "Pacific/Fiji"){echo "selected";} ?> >UTC +12:00 : Fiji</option>
								
								<option value="Pacific/Chatham" <?php if($sTimezone == "Pacific/Chatham"){echo "selected";} ?> >UTC +13:00 : Nukualofa</option>
							</select>
							<span id="userTimeStamp" class="utc time_zone"><?php echo $fDateTime; ?></span>
							</p>
							<p class="annonce_vr">Select your time zone. The date and time displayed on this site will reflect the selected time zone.</p>    
						</td>
					</tr>
					<tr>
						<th class="config_logo"><label for="file">Logo Image</label></th>
						<td style="position:absolute;width:600px">
							<input type="file" name="ffile" id="ffile" />
							<span class = "sc_error" style = "color:#FF0000"></span>
						</td>
					</tr>
					<tr>
						<th style="width:170px">&nbsp;</th>
						<td><div id ="sc_img_prev" style="margin-top:10px"></div></td>
					</tr>
					<tr>
						<th><label for="fpolicy">Policy</label><span class="neccesary">*</span></th>
						<td>
							<textarea id="fpolicy" name="fpolicy" class="info_area" validate="required"></textarea>
						</td>
					</tr>
				</table>
				<input type="hidden" name="temp_img" id="temp_img" />
			</form>
			<div class="popup_window" id="find_address" style="margin-left:30%;margin-top:20%;display:none">
				<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
					<col width="200px" />
					<tr><th colspan="2" class="popup_title">Find Address &raquo;</th></tr>
					<tr>
						<th colspan="2"><input type="text" name="title" maxlength="100" value="" class="fix2" id = "find_address_input" /> </th>
					</tr>
					<tr>
						<th class = "error_msg" style = "color:#FF0000"></th>
					</tr>
				</table>
				<ul class="action_btn">
					<li><input type = "button" class="btn_save fr" title="Save changes" id="find_address_submit" value = "Submit"/></li>
					<li style="margin:0"><input type = "button" class="btn_save fr" title="Cancel" id="find_address_cancel" value = "Cancel"/></li>
				</ul>
			</div>
			<div class="popup_window" id="choose_address" style="width:250px;margin-left:30%;margin-top:20%;display:none">
				<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
					<col width="200px" />
					<tr><th colspan="2" class="popup_title">Choose Your Address &raquo;</th></tr>
					<tr>
						<th colspan="2">
							<div style="" class="dropdown_list" id="sc_address_list">
							</div>
						</th>
					</tr>
					<tr>
						<th class = "error_msg" style = "color:#FF0000"></th>
					</tr>
				</table>
				<ul class="action_btn">
					<li><input type = "button" class="btn_save fr" title="Save changes" id = "choose_address_submit" value = "Submit" /></li>
					<li style="margin:0"><input type = "button" class="btn_save fr" title="Cancel" id = "choose_address_cancel" value = "Cancel" /></li>
				</ul>
			</div>
			<div class="popup_window" id = "rest_address" style="margin-left:30%;margin-top:20%;display:none">
				<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
					<col width="250px" />
					<tr><th colspan="2" class="popup_title">Input Rest of your Address &raquo;</th></tr>
					<tr>
					<th colspan="2"><input type="text" name="title" maxlength="100" value="" class="fix3" id = "rest_address_input" /> </th>
					</tr>
				</table>
				<ul class="action_btn">
					<li><input type = "button" class="btn_save fr" title="Save changes" id = "rest_address_submit" value = "Submit" /></li>
					<li style="margin:0"><input type = "button" class="btn_save fr" title="Cancel" id="rest_address_cancel" value = "Cancel"/></li>
				</ul>
			</div>