<?php echo Common::displayMenu(true,array("label"=>"Back to List","most_action"=>"backtolist"));?>

<input type="hidden" id="successparam" value="<?php echo isset($aArgs['success']) ?  $aArgs['success']  : "";?>" />
<input type="hidden" id="query" value="<?php echo isset($aArgs['query']) ?  $aArgs['query']  : "";?>" />
<input type="hidden" id="age" value="<?php echo isset($aArgs['age']) ?  "true"  : "false";?>" />
<input type="hidden" id="apply" value="<?php echo isset($aArgs['apply']) ? "true"  : "false";?>" />
<input type="hidden" id="opclass" value="<?php echo isset($aArgs['class']) ?  "true"  : "false";?>" />
<!--<input type="text" id="user_email" value="<?php foreach($aUserdata as $user){echo $user['email'];} ?>" />-->

<ul class="message_email">
			<li class="search_user">
				<ul>
					<li><input type="checkbox" id="all_members" name="all_members" class="checkb" /><label for="all_members" class="label_1">All Members</label></li>
					<li>
						<form name='send' id='send'>
						<ul class="other_options">
						<?php
						if( isset($aArgs['age'])){
						$age = explode('|',$aArgs['age']);
						$agefrom = $age[0];
						$ageto = $age[1];
						}else{
						$agefrom = "";
						$ageto = "";
						}

						?>
							<li><input type="checkbox" id="message_age" name="message_age" class="checkb" /><p><label for="message_age">Age</label><span class="agefrom"><input type="text" class="small" id="agefrom" maxlength="2" name="agefrom" validate="required|digits" value="<? echo $agefrom;?>" /></span> to <span class="ageto"><input type="text" name="ageto" maxlength="2" validate="required|digits" class="small" id="ageto" value="<? echo $ageto;?>" /></span></p></li>
							<li><input type="checkbox" id="message_applied" name="message_applied" class="checkb" /><p><label for="message_applied">Only who applied class before</label></p></li>
							<li><input type="checkbox" id="message_class" name="message_class" class="checkb" /><p><label for="message_class">Only who has class for now</label></p></li>
						</ul>
						</form>	
					</li>
					<li style="margin-top:10px"><a href="#" class="btn" id="searchmailbtn">Search</a></li>
					<li class="add_csv" style="margin-top:10px">
						<strong>Upload CSV file</strong>
						<form name='addcsv' id='addcsv' enctype="multipart/form-data" method="post"><input type="file" name="file" id="file"class="btnup"/><input type="submit" name="submit" class="btnup" value="Add"/>
						<?php
						$uploadSuccess = 'false';
						   if ( isset($_FILES["file"])) {
								if ($_FILES["file"]["error"] > 0) {
									 echo "<font color='#ce1f1f'> No file selected </font>";
								}
								else {
									if ($_FILES["file"]["type"] == 'text/plain' || $_FILES["file"]["type"] == "application/vnd.ms-excel" && $_FILES["file"]["size"] < 20000){
										$uploadSuccess = 'true';
										move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT']."/uploads/csvtmp/".$_FILES["file"]["name"]);
										echo "<input type='hidden' id='uploadstat' value='".$_FILES["file"]["name"]."'>";	
									}else{
										echo "<font color='#ce1f1f'> File Type incorrect or File Size exceed at 2 mb! </font>";
									}
								}
							}
						?>
						</form>
					</li>
					<li id='search_result' class="search_result">
						<li class="add_email">
							<form name='addemailadd' id='addemailadd'><p><input type="text" class="fix" id="addemailfield" validate="required|email" /><a href="#" class="btn" id="addemail" style="float:none">Add</a></p></form>
									<ul id="search_fields">
									<?php
										if($uploadSuccess == 'true'){
												$handle = fopen($_SERVER['DOCUMENT_ROOT']."/uploads/csvtmp/".$_FILES["file"]["name"], "r");
														while (($data = fgetcsv($handle)) !== FALSE){
															foreach($data as $res){
																if (filter_var($res, FILTER_VALIDATE_EMAIL)) {
																	echo '<li class="lib" style="cursor:pointer">'.$res." " .'</li>';
																}
															}
														}
										
										}
										
									$emailcount = count($aUserdata);
									foreach($aUserdata as $user){
									if ($user['email']!=''){
										echo '<li class="lib" style="cursor:pointer;">'.$user['email'].' '.'</li>';
									}
									$emailcount--;
									}

									?>
									</ul>	
							<p><a href="#" class="btn_remove" id="rmvlist">Remove</a></p>
						</li>
					</li>
				</ul>
			</li>
			

		</ul>
		<div class="compose_area">
		</div>
		<div class="action_btn">
			<a href="#" class="btn_save" id="compose" title="Save changes">Compose</a>
		</div>
		
		<br><br><br><br><br><br>
		<a href="#" id="testlink" title="Save changes">TEST FOR TEACHER hellotest@test.com</a>
		<br><br><br>
		<input type="hidden" id="email_count" value="<?php echo count($aUserdata);?>"/>
		
		
