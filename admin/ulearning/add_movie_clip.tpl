<?php echo Common::displayMenu(true);?>
<p class="require"><span class="neccesary">*</span>Required</p>
<form name="userAddForm" enctype="multipart/form-data" class="moviefrm" >
	<table border="0" cellspacing="0" cellpadding="0" class="table_user " >
		<colgroup>
			<col width="135px" />
			<col width="*" />
		</colgroup>
		<tr>
			<th><label>1st Category</label><span class="neccesary">*</span></th>
			<td>
				<select id="select_category" validate="required" name="select_cat">
					<option <?php if($modify) echo "value='".$modify[0]['movie_cat_id']."'"; ?>><?php if($modify) echo $modify[0]['movie_category']; ?></option>
				<?php
				foreach($movie_cat as $key => $val){
				?>
					<option value="<?php echo $val['movie_cat_id']; ?>"><?php echo $val['movie_category']; ?></option>
				<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label>2nd Category</label><span class="neccesary">*</span></th>
			<td>
				<select id="select_category_name" validate="required" name="select_cat_name">
					<option value="<?php if(isset($modify[0]['movie_cat_name_id'])){echo $modify[0]['movie_cat_name_id'];} ?>"><?php if(isset($modify[0]['movie_cat_name_id'])){echo $modify[0]['movie_category_name'];} ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label >Movie Title</label><span class="neccesary">*</span></th>
			<td><input type="text" validate="required" id="mov_title" name="title" value="<?php if(isset($modify[0]['movie_clip_title'])){echo $modify[0]['movie_clip_title'];} ?>" class="fix" /></td>
		</tr>
		<tr>
			<th><label >Movie Description</label></th>
			<td><textarea class="user_info memo" id="mov_description" rows="0" cols="0" name="description"><?php if(isset($modify[0]['movie_clip_description'])){echo $modify[0]['movie_clip_description'];} ?></textarea></td>
		</tr>
		<tr>
			<th><label >Movie URL</label><span class="neccesary">*</span></th>
			<td><input type="text" validate="required" id="mov_url" name="url" value="<?php if(isset($modify[0]['movie_clip_url'])){echo $modify[0]['movie_clip_url'];} ?>" class="fix" /></td>
		</tr>
		<tr>
			<th class="user_logo">
				<label for="file">Image File (max:1MB)</label>
			</th>
			<td>
				<input type="file" name="file" id="image_file" />
				<div class="image_preview">
				<?php if(isset($modify[0]['movie_clip_image']) && $modify[0]['movie_clip_image'] != ""){echo '<img src="'.BASE_URL.'uploads/ulearning/upload/'. $modify[0]['movie_clip_image'] .'" width="200" alt="Image Preview" /><a href="javascript:movie_clip.delete_preview(\''. $modify[0]['movie_clip_image'] .'\')" class="image_preview_close" title="Delete Image" >[X]</a>';} ?>
				</div>
				<span class="image_name hidden"><?php if(isset($modify[0]['movie_clip_image']) && $modify[0]['movie_clip_image'] != ""){echo $modify[0]['movie_clip_image'];} ?></span>
			</td>
		</tr>
	</table>
</form>					
<div class="action_btn">
	<a href="<?php if($modify) echo "javascript:movie_clip.modify_movie_clip(". $modify[0]['movie_clip_id'] .")"; else echo "javascript:movie_clip.submit_movie_clip()";?>" class="btn_save" title="Add New User">Submit</a>
	<a href="javascript:window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=movie_clip'" class="btn_return"  title="Return to Point History">Back to List</a>
</div>