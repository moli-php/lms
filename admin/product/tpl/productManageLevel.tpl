<?php echo Common::displayMenu(true,array("label"=>"Back to Level List","most_action"=>"Level.backToLevelList"));?>

<p class="notice">Required <span class="required">&#42;</span></p>
<form name="level_form">
	<input type = "hidden" name="editId" value="<?php echo $level[0]['idx']; ?>" />
	<table cellspacing="0" border="0" cellpadding="0" class="add_product">
		<colgroup>
			<col width="190px" />
			<col  />
		</colgroup>
		<tbody>
			<tr>
				<th><label>Level Name</label><span class="required">&#42;</span></th>
				<td>
					<input type="text" maxlength="50" class="product_input"  name="level_name" validate="required" value="<?php echo $level[0]['name']; ?>" />
				</td>
			</tr>
				<tr>
				<th><label >Description</label><span class="required">&#42;</span></th>
				<td><textarea cols="100" rows="10" class="productdescription" name="level_description" validate="required"><?php echo $level[0]['description']; ?></textarea></td>
			</tr>
		</tbody>
	</table>
</form>
<div class="bottom">
	<div class="apply_action">
		<input type="button" name="level_submit" class="btn_save" value="Submit" />
	</div>
</div>