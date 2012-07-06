<?php echo Common::displayMenu(true,array("label"=>"Add New Category","most_action"=>"movie_category.open"));?>
<div id="content">
	<div id="firstpane" class="menu_accordion">
	<?php
	foreach($movie_cat as $key => $val){
	?>
		<div>
			<p class="menu_1stdepth"><?php echo $val['movie_category']; ?></p>
			<?php
			foreach($movie_cat[$key]['movie_cat_name'] as $k => $v){
			?>
				<div class="menu_2nddepth" style="display:none">
					<div><p><?php echo $v['movie_category_name']; ?></p>
						<span class="controller">
							<a href="javascript:movie_category.modify(<?php echo $val['movie_cat_id'];?>, <?php echo $v['movie_cat_name_id'];?>, '<?php echo $v['movie_category_name'];?>')" title="modify">M</a>
							<a href="javascript:movie_category.delete_confirm(<?php echo $v['movie_cat_name_id'];?>)" title="delete">D</a>
						</span>
					</div>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	</div>
	
	<form name="add_category" class="add_category">
		<div class="popup_window hidden add_movie_cat">
			<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
				<col width="75px" />
				<col width="200px" />
				<!--<tr><th colspan="2" class="popup_title">Add New Category &raquo;</th></tr>
				<tr><td colspan="2"></td></tr>-->
				<tr>
					<th>1 depth<span class="neccesary">*</span></th>
					<td>
						<select class="depth" name="depth" validate="required" >
							<?php
							foreach($movie_cat as $key => $val){
							?>
							<option value="<?php echo $val['movie_cat_id']; ?>"><?php echo $val['movie_category']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th>Name<span class="neccesary">*</span></th>
					<td><input type="text" name="title" validate="required" id="category_name" maxlength="80" value="" class="fix2" /></td>
				</tr>
			</table>
			<div class="action_btn">
				<a href="javascript:movie_category.add_submit()" class="btn_save fr" title="Save changes">Submit</a>
				<a href="javascript:movie_category.close()" class="btn_save" title="Cancel">Cancel</a>  
			</div>
		</div>
	</form>
	
	<form name="modify_category">
		<div class="popup_window hidden modify_movie_cat">
			<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
				<col width="280px" />
				<!--<tr><th colspan="2" class="popup_title">Modify Title &raquo;</th></tr>-->
				<tr>
					<th colspan="2"><label>Name<span class="neccesary">*</span> </label><input type="text" name="title" validate="required" id="modify_cat_name" maxlength="100" value="" class="fix2" /> </th>
					<span class="hidden" id="mod_id"></span>
					<span class="hidden" id="mod_cat_id"></span>
				</tr>
			</table>
			<div class="action_btn">
				<a href="javascript:movie_category.modify_submit()" class="btn_save fr" title="Save changes">Submit</a>
				<a href="javascript:movie_category.close()" class="btn_save" title="Cancel">Cancel</a>
			</div>
		</div>
	</form>
	
	<form name="delete_category">
		<div class="popup_window hidden delete_movie_cat" >
			<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
				<col width="275px" />
				<!--<tr><th class="popup_title">Delete Movie Category &raquo;</th></tr>
				<tr><td></td></tr>-->
				<tr>
					<th>Are you sure?</th>
				</tr>
			</table>
			<div class="action_btn">
				<a href="javascript:movie_category.delete_category()" class="btn_save fr" title="Delete">Delete</a>
				<a href="javascript:movie_category.close()" class="btn_save" title="Cancel">Cancel</a>
				<span class="hidden" id="del_id"></span>
			</div>
		</div>
	</form>
</div>