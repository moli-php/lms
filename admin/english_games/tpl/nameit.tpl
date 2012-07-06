<?php echo Common::displayMenu(true,array("label"=>"Add Object","most_action"=>"nameit.add"));?>
<div class="add-dialog display-none">
	<p class="require"><span class="neccesary">*</span>Required</p>
		<iframe src="" name="upload_iframe" id="upload_iframe"  frameborder="0" height="37px" scrolling="no" style="display:none;"></iframe>
		<form name="userAddForm" enctype="multipart/form-data" autocomplete="off"  action="<?php echo $sAppPath;?>&sub=save" method="post" target="upload_iframe" >
			<div class="form-label">
				<p class="f-label">Picture of the object:</p>
				<p class="f-field"><input type="file" name="file" id="file" onchange="javascript:if(this.value) userAddForm.submit()"/>
				<div id="picture_preview" class="picture-container display-non1e"></div>
				</p>
				<p class="f-label">Your Question:</p>
				<p class="f-field"><input type="text" class="span3" name="question" id="question" /></p>
				<p class="f-label">Select and choices answers: <i style="font-size:11px;">( You can add maximum of 5 choices and minimum of 2 choices)</i></p>
				<p class="f-field">
					<input type="text" style="width:200px;" class="choices-box span1"/>
					<a href="javascript:void(0)" class="btn add-choices">Add</a> <i style="color:#DC4E22" class="existing-choice display-none">You already added this choice.</i><br />
					<p class="choices-list" style="display:block;" ><span style="color:#DC4E22;text-align:center;display:block">-No Choices-</span></p>
				</p>
			</div>
			<!--
			<table border="1" cellspacing="0" cellpadding="0" class="table_user" >
				<colgroup>
					<col width="135px" />
					<col width="*" />
				</colgroup>
				<tr>
					<th><label for="fsite_url">Picture of the object: </label><span class="neccesary">*</span></th>
					<td>
						<span id="name_wrap"><input type="file" name="picture" id="picture"/></span>
					</td>
				</tr>
				<tr>
					<th><label for="fsite_owner">Your Question: </label><span class="neccesary">*</span></th>
					<td>
						<input type="text" name="question" id="question" maxlength="100" value="" class="fix" validate="required"  />
						<span class = "utc"><span id = "owner_char_max"></span> characters left</span>
					</td>
				</tr>
				<tr>
					<th><label for="fcompany_reg_number">Answer Choices : </label> <span class="neccesary">*</span></th>
					<td>
						<input type="text" style="width:200px;" class="choices-box"/>
						<a href="javascript:void(0)" class="btn add-choices">Add</a><br />
						<span> Add Choices Here:</span>
						<p class="choices-list" style="display:inline-block;width:100%" ><span style="color:#DC4E22;text-align:center;display:block">-No Choices-</span></p>
					</td>
				</tr>			
			</table>
			-->
		<div class="footer-option">
			<input type="submit" value="Save" class="btn1 save-btn" />
			<a href="javascript:nameit.close_dialog($('.add-dialog'))" class="btn1" >Cancel</a>
			<span style="font-size:10px;font-weight:bold;">Click to preview  -> </span><a href="#" class="btn1 preview-btn">Preview</a>
		</div>
	</form>
</div>
<input type="button" value="Save and go"class="btn1" />
<div class="preview-dialog display-none">
	<div class="image-container">
		
	</div>
	<div class="prev-question">
		<b class="prev-question-title">Q : What is this object telling about?</b>
	</div>
	<div class="prev-choices">
		<ul class="prev-choice-list">
			<li><input type="radio" /> facebook page</li>
			<li><input type="radio" /> twitter page</li>
			<li><input type="radio" /> myspace website page</li>
		</ul>
	</div>
	<div class="footer-option">
		<a href="javascript:nameit.close_dialog($('.preview-dialog'))" class="btn1">Cancel</a>
	</div>	
</div>
	<ul class="sort_view" style="float:right">
		<li class="active all">
			<a href="javascript:void(0)">All (2)</a>
		</li>
		<li>
			<a href="javascript:void(0)">Published (1)</a>
		</li>
		<li>
			<a href="javascript:void(0)">Unpublished (1)</a>
		</li>
		<li style="float:right;background:none;cursor:pointer"><input type="text" value="<?php echo isset($aArgs['keyword']) ?  $aArgs['keyword']  : "";?>" id="keyword"/><input style="cursor:pointer"type="submit" value="search" class="btn_apply" id="searchbtn"/></li>
	</ul>
	<div class="top_2">
		<div class="apply_action">
			<select id="ActionListTop">
				<option value="">Select Action</option>
				<option value="Publish">Publish</option>
				<option value="Unpublish">Unpublish</option>
				<option value="Delete">Delete</option>
			</select>
			<a id="applytop" class="btn_apply" href="#none">Apply</a>
		</div>
		<div class="show_rows">
			Show Rows
			<select id="show_row">
				<option>10</option>
				<option>20</option>
				<option>30</option>
			</select>
		</div>
	</div>
	<table cellspacing="0" class="post_table banner">
	<colgroup>
		<col width="20px" />
		<col width="100px"  />
		<col width="250px" />
		<col width="220px" />
		<col width="220px" />
		<col width="80px" />
	</colgroup>
	<thead>
		<tr>
			<th><input type="checkbox" class="check_all"/></th>
			<th><a href="" class="sort_down">Object Picture</a></th>
			<th><a href="" class="sort_down">Question</a></th>
			<th><a href="" class="sort_down">Choices</a></th>
			<th><a href="" class="sort_down">Answer</a></th>
			<th><a href="" class="sort_down">Status</a></th>
		</tr>
	</thead>
	<tbody >
	<input type="hidden" id="chkboxcount" value="<?php echo $listcount;?>" />
		<?php for($i = 0; $i < 2;$i++){?>
		<tr>
			<td><input class="chkboxlist" type="checkbox" name="ListCheck" value=""/></td>
			<td><a href="javascript:void(0);"><img src="<?php echo BASE_URL;?>image.php?w=200&path=/event/banner/1_1338874985_facebookwall.jpg" /></a></td>
			<td>What is the name if this martial artist?</td>
			<td>Donatello</td>
			<td>Dummy1</td>
			<td>Published</td>
		</tr>
		<?php }?>
	</tbody>
</table>
<div class="bottom">
	<div class="apply_action">
		<select id="ActionListBottom">
			<option value="">Select Action</option>
			<option value="Publish">Publish</option>
			<option value="Unpublish">Unpublish</option>
			<option value="Delete">Delete</option>
		</select><a id="applybottom" class="btn_apply" href="#none">Apply</a>
	</div>
</div>	