<?php echo Common::displayMenu(true);			

echo '<form id="productBookForm">';
	if (isset($iIdx))
		echo '<input type="hidden" name="idx" value="' . $iIdx . '" />';
		
	echo '<table cellspacing="0" border="0" cellpadding="0" class="add_product">
		<colgroup>
			<col width="190px" />
			<col width="400px" />
			<col  />
		</colgroup>
		<tbody>
			<tr>
				<th>Active</th>
				<td>
					<input type="radio" name="book_status" value="0" checked />
					<label>Deactivated</label>	
					<input type="radio" name="book_status" value="1" />
					<label>Activated</label>
				</td>
			</tr>
			<tr>
				<th><label>Book Name</label><span class="required">&#42;</span></th>
				<td>
					<input type="text" maxlength="50" class="product_input" name="book_name" value="' . (isset($aBook) ? $aBook['name'] : null) . '" validate="required" />
				</td>
				<td></td>
			</tr>
			<tr>
				<th><label>Description</label><span class="required">&#42;</span></th>
				<td><textarea cols="100" rows="10" class="productdescription" name="book_description" validate="required">' . (isset($aBook) ? $aBook['description'] : null) . '</textarea></td>
			</tr>
			<tr>
				<th><label>Book Price</label><span class="required">&#42;</span></th>
				<td>
					<input type="text" maxlength="30" class="product_input" name="book_price" value="' . (isset($aBook) ? $aBook['price'] : null) . '" validate="required|decimal" />
				</td>
				<td></td>
			</tr>
			<tr>
				<th><label>Book Image</label></th>
				<td>
					<span><img id="display_image" src="' . BASE_URL . (isset($aBook) ? "image.php?h=300&cr=8:10&path=" . $aBook['image_path'] : 'images/dummy_logo.png') . '" alt="Image" class="prof_img_con"></span>
					<input type="hidden" name="image_path" />
					<input type="button" value="Choose Image" id="image_upload" class="btn_go">
					<span id="filepath"></span>
					<input type="file" name="image_upload" style="visibility:hidden;">
				</td>
			</tr>
			<tr>
				<th><label>Book File</label></th>
				<td>
					<!-- <span><a href="#">Development.pdf</a></span> -->
					<input type="button" value="Choose File" id="file_upload" class="btn_go">
					<span id="filepath"></span>
					<input type="file" name="file_upload" style="visibility:hidden;">
				</td>
			</tr>
		</tbody>
	</table>
	<div class="bottom">
		<div class="apply_action">
			<button class="btn_save" onclick="productBook.validate();">Submit</button>
		</div>
	</div>
</form>';

?>