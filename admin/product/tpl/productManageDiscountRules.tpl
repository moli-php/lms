<?php echo Common::displayMenu(true); 

$sExec = isset($iIdx) ? "editDiscount" : "saveDiscount";
$sChecked = !isset($aDiscount) ? " checked" : null;

echo '<form id="discount_form">
	<input type="hidden" name="exec" value="' . $sExec . '" />';
	
	if (isset($iIdx))
		echo '<input type="hidden" name="idx" value="' . $iIdx . '" />';
	
	echo '<table width="100%">
		<colgroup>
			<col width="120" />
			<col  />			
		</colgroup>
		<tbody>
			<tr>
				<td>
					<label>Rule name: </label>
				</td>
				<td>
					<input type="text" name="discount_name" value="' . (isset($aDiscount) ? $aDiscount['name'] : null) . '" validate="required" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Amount: </label>
				</td>
				<td>
					<input type="text"  name="discount_amount" value="' . (isset($aDiscount) && substr($aDiscount['amount'], 0, 1) == "-" ?  substr($aDiscount['amount'], 1, strlen($aDiscount['amount'])) : (isset($aDiscount['amount']) ? $aDiscount['amount']: null)) . '" validate="required|decimal" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Discount / Cost: </label>
				</td>
				<td>
					<input type="radio" name="discount_class" value="0"' . (isset($aDiscount) && substr($aDiscount['amount'], 0, 1) == "-" ? " checked" : $sChecked) . ' /><label>Discount</label>
					<input type="radio" name="discount_class" value="1"' . (isset($aDiscount) && substr($aDiscount['amount'], 0, 1) != "-" ? " checked" : null) . ' /><label>Additional Cost</label>
				</td>
			</tr>
			<tr>
				<td>
					<label>Type: </label>
				</td>
				<td>
					<input type="radio" name="discount_type" value="percent"' . (isset($aDiscount) && $aDiscount['type'] == "percent" ? " checked" : $sChecked) . ' /><label>Percent</label>
					<input type="radio" name="discount_type" value="amount"' . (isset($aDiscount) && $aDiscount['type'] == "amount" ? " checked" : null) . ' /><label>Amount of money</label>
				</td>
			</tr>
		</tbody>	
	</table>
	<div class="bottom">
		<div class="apply_action">
			<input type="button" name="level_submit" class="btn_save" value="Submit" onclick="productDiscount.validate();" />
			<a href="' . common::getClassUrl("productDiscountRules") . '" class="btn_return" title="Return to list">Return to List</a>
		</div>
	</div>
</form>';

?>