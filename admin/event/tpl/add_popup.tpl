<script type="text/javascript" src="<?php echo BASE_URL;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/event/codemirror.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/event/xml.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/event/javascript.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/event/css.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>js/event/htmlmixed.js"></script>
<?php echo Common::displayMenu(true,array("label"=>"Back To List","most_action"=>"settings.popup_editor_list"));?>

<?php 

if(isset($aData[0]['aData'][0]) ){
	foreach($aData[0]['aData'][0] as $key => $val){
	$row[$key] = $val;
	}
	$size = explode("|",$row['size']);
	$position = explode("|",$row['position']);
	
}else{
$row = array('idx'=>'','user_id'=>'','title'=>'','content'=>'','size'=>'','editor_mode'=>'html_edit','position'=>'','status'=>'','order'=>'','date_created'=>'', 'show_status' => '');
$size = array('','');
$position = array('','','Left');
$idx = "";
}

?>
		<form name="popupForm" action="<?php echo BASE_URL;?>admin/event/?action=add_popup<?php echo $url_args;?>" method="post">
		
			<table border="0" cellspacing="0" cellpadding="0" class="table_user1 config" >
				<colgroup>
					<col width="175px" />
					<col width="*" />
				</colgroup>
				<tr>
					<th><label for="banner_title">Title</label><span class="neccesary">*</span></th>
					<td><span id="name_wrap"><input type="text" id="popup_title" name="popup_title" maxlength="100" class="fix" value="<?php echo $row['title']; ?>" validate="required"/></span></td>
				</tr>
				<tr>
					<th>Mode</th>
					<td class="editor_mode">
					<?php foreach($aData[0]['aEditor_mode'] as $val){ 
					$sLabel = ($val == 'html_edit')? 'Html Editor' : 'Code Editor';
					$sIsChecked = ($val == $row['editor_mode'])? 'checked' : '';
					?>
						<p><label for="<?php echo $val; ?>"><?php echo $sLabel; ?></label><input type="radio" value="<?php echo $val; ?>" <?php echo $sIsChecked ?> name="addPopupeditor" /></p>
					<?php } ?>
					</td>
				</tr>
				<tr class="html_editor_holder" <?php if($row['editor_mode'] == 'code_edit'){echo "style='display:none;'";}?>>
					<th>Text Editor</th>
					<td>
						
						<textarea id="html_editor" style="width:600;height:400px;" name="html_editor" class="html_editor" ><?php if($row['editor_mode'] == "html_edit") echo $row['content']; ?></textarea>
						
					</td>
				</tr>
				<tr class="code_editor_holder" <?php if($row['editor_mode'] == 'html_edit'){echo "style='display:none;'";}?>>
					<th><label for="code">HTML Editor</label></th>
					<td>
						<textarea id="code" name="code" class="web_editor" ><?php if($row['editor_mode'] == "code_edit") echo $row['content']; ?></textarea>
						<p><a href="#" class="btn_apply" id="btn_preview">Update Preview</a></p>
						<script>
							var delay;
								  // Initialize CodeMirror editor with a nice html5 canvas demo.
								  var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
									mode: 'text/html',
									tabMode: 'indent'
								  });
							$(document).ready(function(){
								$("#btn_preview").click(function(){
								  function updatePreview() {
									var previewFrame = document.getElementById('preview');
									var preview =  previewFrame.contentDocument ||  previewFrame.contentWindow.document;
									preview.open();
									preview.write(editor.getValue());
									preview.close();
									return false;	
								  }
								  setTimeout(updatePreview, 700);	
							  
								});
							});
						</script>
					</td>
				</tr>
				<tr class="code_preview"  <?php if($row['editor_mode'] == 'html_edit'){echo "style='display:none;'";}?>>
					<th><label>Preview</label></th>
					<td>
						<iframe id="preview" class="preview"></iframe>
						<script>
						  
						</script>						
					</td>
				</tr>
				<tr>
					<th><label for="popup_size">Size</label><span class="neccesary">*</span></th>
					<td><input type="text" id="popup_size" name="popup_size_w" class="popup_size fix" value="<?php echo $size[0]; ?>" maxlength="4" validate="required"/> x <input type="text" id="popup_size" name="popup_size_h" class="popup_size fix" maxlength="3" value="<?php echo $size[1]; ?>" validate="required"/><span id="err_size" style="padding-left:5px;">(Max size 1024x768)</span> </td>
				</tr>
				<tr>
					<th><label for="popup_position">Position</label></th>
					<td>
						<input type="text" id="popup_position" name="popup_position_x" maxlength="4" class="popup_size fix" value="<?php echo $position[0];?>"/> X <input type="text" maxlength="4" id="popup_size" name="popup_position_y" class="popup_size fix" value="<?php echo $position[1];?>"/> Y 
						<select style="margin-left:20px" name="position">
						<?php foreach($aData[0]['aPosition_mode'] as $val){ ?>
							<option <?php if($val == $position[2])echo "selected"; ?>><?php echo $val; ?></option>
						<?php } ?>
						</select>
						<span id="err_pos" style="padding-left:5px;color:red;"></span>
					</td>
				</tr>
				<tr>
					<th><label for="status_type">Status</label></th>
					<td>
						<select name="status_type" id="status_type">
						<?php foreach($aData[0]['aActive'] as $val){ ?>
							<option <?php if($val == $row['status'])echo "selected"; ?>><?php echo $val; ?></option>
						<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="popup_order">Order</label></th>
					<td><input type="text" id="popup_order" maxlength="2" name="popup_order" class="popup_size fix" value="<?php echo $row['order'];?>"/><span id="err_order" style="padding-left:5px;color:red;"></span></td>
				</tr>
			</table>
			<input type="hidden" name="show_status" id="show_status" value="<?php echo $row['show_status']; ?>"/>
		</form>
		
		<div class="action_btn">
			<a href="#" class="btn_save" id="popup" title="Save changes">Save</a>
			<a href="#" class="btn_return"  id="preview_popup" title="Preview Poppup">Preview Popup</a>
		</div>
	</div>
	
	<div id="preview_popup_dialog" style="display:none;">
		<div id="preview_popup_content" style="border:solid 1px #ccc;overflow:auto;padding: 5px 5px 5px 5px"></div>
		<center><a href="#" class="btn_save" id="show_status_btn" title="Show only this day">This will show on this day only</a></center>
	</div>

	