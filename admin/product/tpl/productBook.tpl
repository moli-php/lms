<?php echo Common::displayMenu(true,array("label"=>"Add New Book","most_action"=>"productBook.addBook"));

echo '
<table cellspacing="0" border="0" cellpadding="0" class="product_search">
	<colgroup>
		<col width="100"/>
		<col width="150"/>
		<col width="150"/>
		<col />						
	</colgroup>
	<tbody>
		<tr>
			<th>Book Name</th>
			<td><input type="text" class="fix2"/></td>
			<td><a href="#" class="btn_apply">Search</a></td>

			<td></td>
		</tr>
	</tbody>
</table>
<ul class="sort_view">
	<li class="active all"><a href="#">All (5)</a></li>
	<li><a href="#">Activated (5)</a></li>
	<li><a href="#">Deactivated (0)</a></li>
</ul>
<div class="top_2">
	<div class="apply_action">
		<a href="#" class="btn_apply">Delete</a>
	</div>
	<div class="show_rows">
		Show Rows
		<select>
			<option>10</option>
			<option>20</option>
			<option>50</option>
		</select>
	</div>
</div>
<table cellspacing="0" class="post_table">
	<colgroup>
		<col width="44" />
		<col width="100" />
		<col  />
		<col width="250"/>
		<col width="190" />				
		<col width="100" />	
	</colgroup>
	<thead>
		<tr>
			<th><input type="checkbox" /></th>
			<th><a href="#" class="sort_down">No.</a></th>
			<th><a href="#" class="sort_down">Book Name</a></th>
			<th><a href="#">Thumbnail</a></th>
			<th><a href="#" class="sort_down">Price</a></th>
			<th><a href="#">Activated</a></th>
		</tr>
	</thead>
	<tbody >';
		
	foreach ($aBook as $iKey => $sValue) {
		echo '<tr>
			<td><input type="checkbox" /></td>
			<td>1</td>
			<td><a href="' . common::getClassUrl("productBookEdit") . '&idx=' . $sValue['idx'] . '">' . $sValue['name'] . '</a></td>
			<td><img src="' . BASE_URL . 'image.php?h=100&cr=8:10&path=' . $sValue['image_path'] . '" alt="Book Thumbnail" /></td>
			<td>&#36;' . number_format($sValue['price'], 2, ".", ",") . '</td>
			<td>' . ($sValue['status'] == 0 ? "No" : "Yes") . '</td>
		</tr>';
	}
		
	echo '</tbody>
</table>
<div class="bottom">
	<div class="apply_action">
		<a href="#" class="btn_apply">Delete</a>
	</div>
</div>
<!-- //product_classbook_list-->
<div class="bottom_2">
	' . $sPagination . '
</div>';

?>