<?php echo Common::displayMenu(true,array("label"=>"Back to List","most_action"=>"backtolist"));?>

<input type="hidden" id="successparam" value="<?php echo isset($aArgs['success']) ?  $aArgs['success']  : "";?>" />
<input type="hidden" id="query" value="<?php echo isset($aArgs['query']) ?  $aArgs['query']  : "";?>" />
<input type="hidden" id="age" value="<?php echo isset($aArgs['age']) ?  "true"  : "false";?>" />
<input type="hidden" id="apply" value="<?php echo isset($aArgs['apply']) ? "true"  : "false";?>" />
<input type="hidden" id="opclass" value="<?php echo isset($aArgs['class']) ?  "true"  : "false";?>" />

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
						<form name='addcsv' id='addcsv' enctype="multipart/form-data" method="post"><input type="file" name="file" class="btnup" id="file"/><input type="submit" name="submit" class="btnup" value="Add"/>
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
							<form name='addemailadd' id='addemailadd'><p><input type="text" maxlength="13" class="fix" id="addemailfield" validate="required" /><a href="#" class="btn" id="addemail" style="float:none">Add</a></p><p>e.g : 010-4321-9876</p></form>
									<ul id="search_fields">
									<?php
										if($uploadSuccess == 'true'){
												$handle = fopen($_SERVER['DOCUMENT_ROOT']."/uploads/csvtmp/".$_FILES["file"]["name"], "r");
														while (($data = fgetcsv($handle)) !== FALSE){
															foreach($data as $res){
																if(preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $res)) {
																  echo '<li class="lib" style="cursor:pointer">'.$res." " .'</li>';
																}
															}
														}
										
										}
										
									$smscount = count($aUserdata);
									foreach($aUserdata as $user){
									
									if(preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $user['phone_mob'])) {
									  echo '<li class="lib" style="cursor:pointer;">'.$user['phone_mob'].' '.'</li>';
									}
									
									$smscount--;
									}

									?>
									</ul>	
							<p><a href="#" class="btn_remove" id="rmvlist">Remove</a></p>
						</li>
					</li>
				</ul>
			</li>
			<br/><br/><br/>
			<li class="sms_template">
				<strong>SMS Template</strong>
				<br/><br/>
				From : <input id="site_mobile" class="fix" style="width:120px !important" type="text" validate="required" value="<?php echo $sSiteinfo; ?>">
				<br/><br/>
				<ul>
					<a id="addtpl" class="btn" style="float:none" href="#none">Add New Template</a>&nbsp;&nbsp;<a id="savetpl" class="btn" style="float:none" href="#">Modify</a>&nbsp;&nbsp;<a id="deltpl" class="btn" style="float:none" href="#">Delete</a>
				</ul>
				<br/><br/>
				<ul class="templates_list">
					<li>
						<p class="template_head"><input type="radio" id="radio_manual" class="radio" name="sms" /><label>Manual Template</label></p>
						<div class="template_bg">
							<textarea id="blank"></textarea>
						</div>
						<p class="template_size" id="manual"><span class="">0</span>/80 bytes</p>
					</li>
					<?php 
					
						foreach($aSmsTemplate as $tpl){

						echo '<li>';
						echo'<p class="template_head"><input type="radio" class="radio" name="sms" value='.$tpl['idx'].'||'.$tpl['tpl_title'].' /><label>'.$tpl['tpl_title'].'</label></p>';
						echo'<div class="template_bg"><p>'.$tpl['tpl_message'].'</p></div>';
						
						$valLength = strlen($tpl['tpl_message']);
							if($valLength<71){
								echo'<p class="template_size"><span class="">'.$valLength.'</span>/80 bytes</p>';
							}else{
								echo'<p class="template_size"><span class="overlimit">'.$valLength.'</span>/80 bytes</p>';
							}
						echo'</li>';
						
						}
					
					
					?>
				</ul>
			</li>
</ul>
		<div class="compose_area">
		</div>
		<div class="action_btn">
			<a href="#" class="btn_save" id="compose" title="Save changes">Send</a>
		</div>
		<br><br><br>
		<input type="hidden" id="sms_count" value="<?php echo count($aUserdata);?>"/>
		
		<a href="#" id="testlink" class="mobile_id">012-3456-789000</a>
		
<div class="new_tpl_dialog" style="display:none">
	<li class="sms_template">
			<ul class="templates_list">
				<li>
					<p class="template_head">
						Title : <label><input type="text" id="tpl_name" maxlength="15" size="15" /"></label>
					</p><br/><br/>
					<div class="template_bg">
						<textarea id="new_tpl"></textarea>
					</div>
					<div id="tpl_size"><p class="template_size" id="new_template_size"><span class="">0</span>/80 bytes</p></div>
				</li>
			<ul>
		</li>
	<div id="addedit_container"></div>
</div>
<div class="popup_window message_content" id="delpopup" style="padding:20px;display:none">

</div>


		
		
		
