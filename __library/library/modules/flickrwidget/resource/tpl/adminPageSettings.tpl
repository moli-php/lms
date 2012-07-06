<div id="WRAP_{$PLUGIN_NAME}">

	<!--
	<h3 class="extension_plugin_name">Flickr</h3>
	<h3>Settings</h3>
	-->
	<p class="require"><span class="neccesary">*</span> Required</p>
	<!-- input area -->
	<form id="flickr_setup_form" name="flickr_setup_form" class="flickr_setup_form" method="POST">
	<table border="1" cellspacing="0" class="table_input_vr">
		<colgroup>
			<col width="160px" />
			<col width="*" />
		</colgroup>
		<tr>
			<th><label for="flickr_key">Flickr API Key</label></th>
			<td>
				<span><span style="color:#DC4E22;">*</span>
					<input type="text" name="flickr_key" id="flickr_key" value="<?php echo $sApiKey; ?>" fw-filter="isFill"
fw-label="flickr_key" class="_validate fix" filter="fill[0]"/>
					<a href="http://www.flickr.com/services/api/" style="margin:0 10px 0 10px;"  target="_blank">Check your API key</a>
					<a href="http://www.flickr.com/services/apps/create/apply" target="_blank">Get an API</a>
				</span>
			</td>
		</tr>
		<tr>
			<th><label for="flickr_id">Flickr User ID</label></th>
			<td>
				<span><span style="color:#DC4E22;">*</span>
					<input type="text" name="flickr_id" id="flickr_id" value="<?php echo $sUserID; ?>" fw-filter="isFill"
fw-label="flickr_id" class="_validate fix" filter="fill[0]"/>
				</span>
				<span class="module_text">It's the code that appears just after http://www.flickr.com/photos/</span>
			</td>
		</tr>
		<tr>
			<th>Display Target</th>
			<td>
				<p>
					<span class="module_label_wrap3">
						<input type="radio"name="flickr_target" id="flickr_target_0" class="fix_radio"  value="0" <?php if($sDispTarget == 0) echo "Checked"; ?> />
						<label for="flickr_target_0">Flickr Homepage</label>
					</span>
					<span class="module_label_wrap4">
						<input type="radio" name="flickr_target" id="flickr_target_1" class="fix_radio" value="1" <?php if($sDispTarget == 1) echo "Checked"; ?> />
						<label for="flickr_target_1">Lightbox</label>
					</span>
				</p>
			</td>
		</tr>
		<tr>
			<th>Display Type</th>
			<td>
				<p>
					<span class="module_label_wrap5">
						<input type="radio" name="flickr_disp_type" id="flickr_disp_type_0" class="fix_radio" value="0" <?php if($sDispType == 0) echo "Checked"; ?> onclick="PLUGIN_Flickr_admin.change_display();"/>
						<label for="flickr_disp_type_0">Default</label>
					</span>
					<span class="module_label_wrap6">
						<input type="radio" name="flickr_disp_type" id="flickr_disp_type_1" class="fix_radio" value="1" <?php if($sDispType == 1) echo "Checked"; ?> onclick="PLUGIN_Flickr_admin.change_display();" />
						<label for="flickr_disp_type_1">Carousel</label>
					</span>
				</p>
			</td>
		</tr>
		<!-- Visible if Default is selected -->
		<tr class="tr_flickr_dispnum" {if $iDispType eq "1"}style="display:none;"{/if}>
			<th><label for="flickr_photo_num">Number of photo</label></th>
			<td>
				<span>
					<input type="text" name="flickr_photo_num" id="flickr_photo_num" value="<?php echo $sDispNum; ?>" maxlength="1" fw-filter="isFill"
fw-label="flickr_photo_num" class="_validate fix2" filter="fill[0]|number[1,9]" onkeyup="if(isNaN(this.value)) this.value='';"/>
				</span>
				<span class="module_text">max: 9</span>
			</td>
		</tr>
	</table>
	<div id="pg_flickr_init">
		<input type="hidden" name="flickr_plugin_dir" id="flickr_plugin_dir" value="{$sPgDir}" />
		<input type="hidden" name="action" id="flickr_page_action" value="{$sAction}" />
		<input type="hidden" name="mode" id="flickr_page_mode" value="{$sMode}" />
		<input type="hidden" name="id" id="flickr_user_id" value="{$iUserIdx}" />
	</div>
	</form>

	<!--Save / reset -->
	<div class="tbl_lb_wide_btn">
		<a href="#" class="btn_apply" title="Save changes" onclick="PLUGIN_Flickr_admin.CheckForm();">Save</a>
		<a href="#" class="add_link" title="Reset to default" onclick="PLUGIN_Flickr_admin.reset();return false;">Reset to Default</a>
	</div>
</div>