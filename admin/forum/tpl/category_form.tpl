<form name="category_form" style="text-align: left;">
	<div class="label" style="display:inline-block;width:auto;float:left;">
		<p style="display:inline-block;float:left;clear:left;margin:2px 0">Style ID: </p>
		<p style="display:inline-block;float:left;clear:left;margin:2px 0">Read Authority: </p>
		<p style="display:inline-block;float:left;clear:left;margin:2px 0">Write Authority: </p>
		<p style="display:inline-block;float:left;clear:left;margin:2px 0">Title: </p>
		<p style="display:inline-block;float:left;clear:left;margin:2px 0">Row Per Page: </p>
		<p style="display:inline-block;float:left;clear:left;margin:2px 0">Allow File Attachment: </p>
		<p style="display:inline-block;float:left;clear:left;margin:2px 0">Image Display: </p>
		<p style="display:inline-block;float:left;clear:left;margin:2px 0">Allow Reply: </p>
		<p style="display:inline-block;float:left;clear:left;margin-top:2px class="fileupload_label">File Uploads: </p>
	</div>
	
	<div class="inputs" style="display:inline-block;width:auto; float:left;">
		<p style="display:inline-block;float:left;clear:left;margin:2px 0"><select name="forum_style" class="style_list"></select>	</p>
		<p style="display:inline-block;float:left;clear:left;margin:2px 0"><select name="read_auth" class="grade_list"></select></p>
		<p style="display:inline-block;float:left;clear:left;margin:2px 0"><select name="write_auth" class="grade_list"></select></p>
		<p style="display:inline-block;float:left;clear:left;margin:2px 0"><input type="text" class="fix2" name="category_title" validate="required" /></p>
		<p style="display:inline-block;float:left;clear:left;margin:2px 0"><input type="text" class="fix2" name="this_category_row" validate="required|digits" /></p>
		<p style="display:inline-block;float:left;clear:left;margin-top:12px">
			<input class="left" type="radio" name="attachment" value="0" checked /><label>No</label>
			<input class="right" type="radio" name="attachment" value="1" /><label>Yes</label>
		</p>
		<p style="display:inline-block;float:left;clear:left;margin-top:8px">
			<input style="margin-top:4px;" class="left" type="radio" name="img_display" value="0" checked /><label>No</label>
			<input style="margin-top:4px;" class="right" type="radio" name="img_display" value="1" /><label>Yes</label>
		</p>
		<p style="display:inline-block;float:left;clear:left;margin-top:8px">
			<input class="left" type="radio" name="allow_reply" value="0" checked /><label>No</label>
			<input class="right" type="radio" name="allow_reply" value="1" /><label>Yes</label>
		</p>
		<p style="display:inline-block;float:left;clear:left;margin-top:2px;">
			<img class="icon" style="display:none;"/>
			<a href="javascript:void(0)" class="forum_btns btn_save attach_file">Browse</a>
		</p>
	</div>
	<iframe style="display: none; float: right; margin-right: 200px;" class="fileupload_iframe" /></iframe>
</form>