<?php echo Common::displayMenu(true,array("label"=>"Back To List","most_action"=>"settings.banner_list"));?>

<?php 
if(isset($aData[0]['aData'][0])){
	foreach($aData[0]['aData'][0] as $key => $val){
	$row[$key] = $val;
	}
	
}else{
$row = array('idx'=>'','user_id'=>'1','title'=>'','banner_image'=>'','url'=>'','window'=>'','date_created'=>'','status'=>'');
}

?>
<p class="require"><span class="neccesary">*</span>Required</p>

<iframe name="upload_iframe" id="upload_iframe" style="display:none;" src=""></iframe>

<form name="pictureForm" id="formtest1" action="<?php echo BASE_URL;?>admin/event/exec/upload.php" method="POST" target="upload_iframe"  autocomplete="off" enctype="multipart/form-data">
	<table border="0" cellspacing="0" cellpadding="0" class="table_user config" >
		<colgroup>
			<col width="175px" />
			<col width="*" />
		</colgroup>
		<tr>
			<th><label for="banner_title">Title</label><span class="neccesary">*</span></th>
			<td><span id="name_wrap"><input type="text" id="banner_title" name="banner_title" class="fix" maxlength="100" value="<?php echo $row['title'];?>" validate="required"/></span></td>
		</tr>
		<tr>
			<th class="banner_image"><label for="file">Banner Image</label></th>
			<td style="position:absolute;width:600px">
				<input type="file" name="picture" id="file" onchange="javascript: if(this.value) pictureForm.submit();"/>
			</td>
		</tr>
	</table>
	<input type="hidden" id="temp_img" name="temp_img" value="">
	<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>" />
</form>

<form action="<?php echo BASE_URL;?>admin/event/?action=add_banner<?php echo $url_args;?>" method="POST"  name="pictureForm2" autocomplete="off">
	<table border="0" cellspacing="0" cellpadding="0" class="table_user config" style="margin-top:20px">
		<colgroup>
			<col width="175px" />
			<col width="*" />
		</colgroup>
		<tr>
			<th>Preview</th>
			<td>	
			<span id="picture_error"></span>

				<div id="picture_preview" class="banner_preview" style="width:400px; height:320px; overflow:auto;"><img src="<?php if($row['banner_image']){echo BASE_URL."uploads/event/banner/".$row['banner_image'];}else{echo BASE_URL."uploads/event/banner/image_preview.gif";}?>" width="300" /></div>
			</td>
		</tr>
		<tr>
			<th><label for="banner_url">URL</label></th>
			<td><span id="name_wrap"><input type="text" id="banner_url" name="banner_url" class="fix" value="<?php echo $row['url'];?>" maxlength="200" /></span></td>
		</tr>
		<tr>
			<th><label for="window_type">Window</label></th>
			<td>
				<select name="window_type" id="window_type">
					<?php
					foreach($aData[0]['aWindow'] as $val){
					?>
					<option <?php if($val == $row['window']){echo "selected";} ?>> <?php echo $val; ?> </option>
					<?php
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="status_type">Status</label></th>
			<td>
				<select name="status_type" id="status_type">
					<?php
					foreach($aData[0]['aActive'] as $val){
					?>
					<option <?php if($val == $row['status']){echo "selected";} ?>> <?php echo $val; ?></option>
					<?php
					}
					?>
				</select>
			</td>
		</tr>
	</table>
	<input type="hidden" name="sFlag" value="add_banner" />
	<input type="hidden" id="banner_image" name="banner_image" value="<?php echo $row['banner_image']; ?>">
	<input type="hidden" id="banner_image" name="old_banner_image" value="<?php echo $row['banner_image']; ?>">
	<input type="hidden" id="banner_title2" name="banner_title2" value="<?php echo $row['title'];?>">
	<input type="hidden" name="user_id2" value="<?php echo $row['user_id']; ?>" />
	
</form>

<div class="action_btn">
	<a href="#" class="btn_save" id="banner" title="Save changes">Save</a>
</div>


