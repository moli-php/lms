<!--menu-->
<?php echo Common::displayMenu(true);?>


<p class="require"><span class="neccesary">*</span>Required</p>

<form name="userAddForm"  id="userAddForm" enctype="multipart/form-data" method="POST" >
	<!--hidden fields-->
	<input type="hidden" value="true" name="submited" />
	<input type="hidden" value="user_list" name="action" />
	<input type="hidden" value="add_user" name="sub" />
	
		<table border="0" cellspacing="0" cellpadding="0" class="table_user" >
			<colgroup>
				<col width="170px" />
				<col width="*" />
			</colgroup>
			<tr>
				<th>
					<label>User ID</label><span class="neccesary">*</span>
				</th>
				<td>
					<span id="name_wrap"><input type="text" id="username" name="username" class="" maxlength="10" value="<?php if(isset($aUserInfo['user_id'])){ echo $aUserInfo['user_id'];}?>" validate="required|minlength[6]"  /></span><a href="javascript:void(0)" class="btn_go" id="check_duplicate_id" >Check Duplicate ID</a>
					<p class="annonce_vr">Your username must be at least six characters long.</p>    
				</td>
			</tr>
			<tr>
				<th>
					<label>Password</label><span class="neccesary">*</span>
				</th>
				<td>
					<input type="password" name="password" id="password" class="fix" value="" validate="required|minlength[6]|maxlength[15]" />
					<div class="validate_wrap">
						<span id="password_gauge" class="secu_gauge" style="display:none">
						<img id="password_img" src="images/bar_secu_1.gif" alt="Bar Security" />
						<span id="password_str" class="secu_bad">: Bad</span>
						</span>
						<span id="password_msg" class="secu_status alert_txt _bfw_validator_message" style="display:none">Please enter a password with 6 to 15 characters.</span>
						<span class="notify" style="word-wrap:break-word;word-break:break-all;">(Mininum of 6 and  Maximum 15 characters, at least 1 alphabet and 1 number are required)</span>    
					</div>
				</td>
			</tr>
			<tr>
				<th>
					<label>Confirm Password</label><span class="neccesary">*</span>
				</th>
				<td>
					<input type="password" name="confirm_password" class="fix" validate="required|minlength[6]|maxlength[15]|equalto[#password]" />
				</td>
			</tr>
			<tr>
				<th><label >Name</label></th>
				<td>
					<input type="text" name="name" id="name" maxlength="20"  class="fix" value="<?php if(isset($aUserInfo['name'])){ echo $aUserInfo['name'];}?>" validate="required" />
				</td>
			</tr>
			<tr>
				<th>
					<label >Password Question</label><span class="neccesary">*</span>
				</th>
				<td>
					<select name="pass_ques" id="pass_ques">
						<option value="1" <?php if(isset($aUserInfo['pass_ques']) && $aUserInfo['pass_ques'] == 1){ echo "selected";}?> >Where is your hometown?</option>
						<option value="2" <?php if(isset($aUserInfo['pass_ques']) && $aUserInfo['pass_ques'] == 2){ echo "selected";}?> >What is your mother's name?</option>
						<option value="3" <?php if(isset($aUserInfo['pass_ques']) && $aUserInfo['pass_ques'] == 3){ echo "selected";}?> >What is your father's name?</option>
						<option value="4" <?php if(isset($aUserInfo['pass_ques']) && $aUserInfo['pass_ques'] == 4){ echo "selected";}?> >What is your treasure?</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>
					<label > Answer</label><span class="neccesary">*</span>
				</th>
				<td>
					<input type="text" name="pass_ans" id="pass_ans" maxlength="100" validate="required" class="fix" />
				</td>
			</tr>
			<tr>
				<th>
					<label>SSN</label><span class="neccesary">*</span>
				</th>
				<td>
					<input type="text" name="ssn1" id="ssn1" maxlength="6" validate="required|minlength[6]|digits" class="fix5" /> - <input type="text" name="ssn2" id="ssn2" maxlength="7" validate="required|minlength[7]|digits" class="fix5" />  
				</td>
			</tr>
			<tr>
				<th>
					<label>Email Address</label><span class="neccesary">*</span>
				</th>
				<td>
					<input type="text" name="email" id="email" maxlength="100" validate="required|email" class="fix" /> 
				</td>
			</tr>
			<tr>
				<th>
					<label >Grade</label><span class="neccesary">*</span>
				</th>
				<td>
					<select id="grade" name="grade" >
					
					<?php foreach($aTbGradeData as $key=>$val){ ?>
						<option value="<?=$val['grade_num']?>" ><?=ucwords($val['grade_name'])?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th>
					<label>Nick Name</label><span class="neccesary">*</span>
				</th>
				<td>
					<input type="text" name="nickname" id="nickname" maxlength="20" validate="required" class="" />
				</td>
			</tr>
		</table>
		
		<br />

		<h3><a href="#" id="toggle_additional" title="Additional Information" class="add_info_title">Additional Information</a></h3>

		<table border="0" cellspacing="0" cellpadding="0"  id="area_additional" class="additional_info" style="display:none">
		<colgroup>
			<col width="135px" />
			<col width="*" />
		</colgroup>
		<tr>
			<th>
				<label>Phone Number (Home)</label>
			</th>
			<td>
				<input type="text" name="phone_home1" id="phone_home1" maxlength="3" style="width:30px" /> -   
				<input type="text" name="phone_home2" id="phone_home2" maxlength="4" style="width:40px" /> -
				<input type="text" name="phone_home3" id="phone_home3" maxlength="4" style="width:40px" />									
			</td>
		</tr>
		<tr>
			<th>
				<label>Cell Phone Number</label>
			</th>
			<td>
				<input type="text" name="phone_mob1" id="phone_mob1" maxlength="2"  style="width:20px" /> -   
				<input type="text" name="phone_mob2" id="phone_mob2" maxlength="4" style="width:40px"  /> -
				<input type="text" name="phone_mob3" id="phone_mob3" maxlength="6" style="width:50px" />									
			</td>
		</tr>
		<tr>
			<th>
				<label>Address</label>
			</th>
			<td>
				<input type="text" readonly  name="faddress" id="address" maxlength="250" class="fix" />  <a href="#" class="btn_go" id="find_add_btn" >Find Address</a>  </td>
		</tr>
		<tr>
			<th style="vertical-align:center;">
				<label >Profile Picture</label>
			</th>
			<td>
				<span ><img src="<?php if(isset($aUserInfo['profile_img'])){ echo BASE_URL."uploads/".$aUserInfo['profile_img'];}else{echo BASE_URL."uploads/profile/no_picture.png";} ?>" alt="Image" class="prof_img_con" id="prof_img_con" width="100px" height="40px" /></span>
				<input type="button" value="Choose image" id="upload_btn" class="btn_go"  />
				<span id="filepath" ></span>
				<input type="file" name="file" id="file_upload" style="visibility:hidden;" validate="accept[jpg,jpe,png,gif]"  />
			</td>
		</tr>
		<!--
		<tr>
			<th>
				<label>Point</label>
			</th>
			
			<td>
				<input type="text" name="point" maxlength="250" class="fix" /><a href="#" class="btn_go">Point Manage</a> 
			</td>
			
		</tr>
		-->
		<tr>
			<th>
				<label>Introduction</label>
			</th>
			<td>
				<textarea class="user_info" rows="0" cols="0" name="user_intro" ></textarea>
			</td>
		</tr>
	</table>
	
	<br />
	
	<div class="action_btn">
		<button class="btn_save" class="btn_save" id="btn_save_all" >Submit</button>
		<a href="?action=user_list" class="btn_return"  title="Return to Users">Back to User List</a>
	</div>

</form>
					
				
<!--hidden popups-->
<div class="popup_window" id="find_address" style="display:none">
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
		<col width="200px" />
		
		<tr>
			<th colspan="2"><input type="text" name="title" maxlength="100" value="" class="fix2" id = "find_address_input" /> </th>
		</tr>
		<tr>
			<th class = "error_msg" style = "color:#FF0000"></th>
		</tr>
	</table>
	<div class="action_btn">
		<input type = "button" class="btn_save fr" title="Save changes" id="find_address_submit" value = "Search"/>
	</div>
</div>
<div class="popup_window" id="choose_address" style="display:none">
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
		<col width="200px" />
		
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
	<div class="action_btn">
		<input type = "button" class="btn_save fr" title="Save changes" id = "choose_address_submit" value = "Submit" />
	</div>
</div>
<div class="popup_window" id = "rest_address" style="display:none">
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
		<col width="250px" />
		
		<tr>
		<th colspan="2"><input type="text" name="title" maxlength="100" value="" class="fix3" id = "rest_address_input" /> </th>
		</tr>
	</table>
	<div class="action_btn">
		<input type = "button" class="btn_save fr" title="Save changes" id = "rest_address_submit" value = "Submit" />
	</div>
</div>

<div class="message_dialog" ></div>