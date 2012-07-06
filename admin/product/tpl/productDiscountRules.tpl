<?php echo Common::displayMenu(true,array("label"=>"Add New Discount","most_action"=>"productDiscount.addDiscount"));

echo '
<div class="top_2">
	<div class="apply_action">
		<a href="javascript:productDiscount.verifyDelete();" class="btn_apply">Delete</a>
	</div>
	<div class="show_rows">
		Show Rows
		<select id="show_rows" onchange="productDiscount.setRows();">';
		
			echo '<option value="10"' . ($iRows == 10 ? " selected" : "") . '>10</option>
                <option value="20"' . ($iRows == 20 ? " selected" : "") . '>20</option>
                <option value="50"' . ($iRows == 50 ? " selected" : "") . '>50</option>';

		echo '</select>
	</div>
</div>
<table cellspacing="0" class="post_table">
	<colgroup>
		<col width="44" />
		<col width="100" />
		<col  />
		<col width="250"/>				
	</colgroup>
	<thead>
		<tr>
			<th><input type="checkbox" onclick="productDiscount.checkAll(this);" /></th>
			<th><a href="#">No.</a></th>';

			$sUrl .= $sSort == "desc" ? "&sort=asc" : "&sort=desc";
			$sUrl .= $iPage != null ? "&page=" . $iPage : "";
			
			$sClassSort = $sSort == "desc" ? "sort_down" : "sort_up";
			
			$aColumns = array(
					"name" => "Name",
					"amount" => "Amount"
					);

			foreach ($aColumns as $sKey => $sValue)
				echo '<th><a href="' . $sUrl . '&order=' . $sKey . '" ' . ($sOrder == $sKey ? 'class="' . $sClassSort . '"' : "") . '>' . $sValue . '</a></th>';

		echo '</tr>
	</thead>
	<tbody >';
	if (isset($aDiscount) && count($aDiscount) > 0) {
		$iCount = $aData['iTotalRows'] - ($aData['iRows'] * ($aData['iPage'] - 1));
		
		foreach ($aDiscount as $iKey => $aValue) {
			$sSign = $aValue['discount'] == 0 ? "-" : "+";
			$iNumber = number_format(substr($aValue['amount'], 1, strlen($aValue['amount'])), 2, ".", ",");
			
			echo '<tr>
				<td><input type="checkbox" value="' . $aValue['idx'] . '" /></td>
				<td>' . $iCount . '</td>
				<td><a href="' . common::getClassUrl("productDiscountRulesEdit") . '&idx=' . $aValue['idx'] . '">' . $aValue['name'] . '</a></td>
				<td>' . ($aValue['type'] == "percent" ? $sSign . $iNumber . "%" : $sSign . "&#36;" . $iNumber) . '</td>
			</tr>';
			
			$iCount--;
		}
	} else {
		echo '<tr><td colspan="8">No result found.</td></tr>';
	}
	echo '</tbody>
</table>
<div class="bottom">
	<div class="apply_action">
		<a href="javascript:productDiscount.verifyDelete();" class="btn_apply">Delete</a>
	</div>
</div>
<!-- //product_classbook_list-->
<div class="bottom_2">
	' . $sPagination . '
</div>';

?>