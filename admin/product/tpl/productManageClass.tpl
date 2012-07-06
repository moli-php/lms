<?php echo Common::displayMenu(true);

$sChecked = !isset($aClass) ? " checked" : null;
$sPageType = !isset($aClass) ? "saveClass" : "editClass";

echo '<form id="productClassForm">
	<input type="hidden" name="exec" value="' . $sPageType . '" />';
	if (isset($iIdx))
		echo '<input type="hidden" name="idx" value="' . $iIdx . '" />';
		
	echo '<p class="notice">Required <span class="required">&#42;</span></p>
	<table cellspacing="0" border="0" cellpadding="0" class="add_product">
		<colgroup>
			<col width="190px" />
			<col  />
			<col  />
		</colgroup>
		<tbody>
			<tr>
				<th><label>Active</label><span class="required">&#42;</span></th>
				<td><input type="radio" id="deactivate" name="status" value="0"' . (isset($aClass) && $aClass['status'] == "0" ? " checked" : $sChecked) . ' /><label for="deactivate">Deactivate</label></td>
				<td><input type="radio" id="activate" name="status" value="1""' . (isset($aClass) && $aClass['status'] == "1" ? " checked" : null) . ' /><label for="activate">Activate</label></td>
			</tr>
			<tr>
				<th><label>Teacher Type</label><span class="required">&#42;</span></th>
				<td><input type="radio" id="philippines" name="country" value="0"' . (isset($aClass) && $aClass['teacher_type'] == "0" ? " checked" : $sChecked) . ' /><label for="philippines">Filipino</label></td>
				<td><input type="radio" id="america" name="country" value="1"' . (isset($aClass) && $aClass['teacher_type'] == "1" ? " checked" : null) . ' /><label for="america">American</label></td>
			</tr>
			<tr>
				<th><label>Class Type</label><span class="required">&#42;</span></th>
				<td><input type="radio" id="phone" name="type" value="phone"' . (isset($aClass) && $aClass['type'] == "phone" ? " checked" : $sChecked) . ' /><label for="phone">Phone</label></td>
				<td><input type="radio" id="camera" name="type" value="camera"' . (isset($aClass) && $aClass['type'] == "camera" ? " checked" : null) . ' /><label for="cam">Camera</label></td>
			</tr>
			<tr>
				<th><label >How many months</label><span class="required">&#42;</span></th>
				<td>
					<select name="total_months">';
					
					for ($i = 1; $i <= 12; $i++) {
						echo '<option' . (isset($aClass) && $aClass['total_months'] == $i ? " selected" : "") . '>' . $i . '</option>';
					}

					echo '</select>
				</td>
			</tr>
			<tr>
				<th><label >Day per Week</label><span class="required">&#42;</span></th>
				<td>
					<select name="total_days">';
					
					for ($i = 1; $i <= 7; $i++) {
						echo '<option' . (isset($aClass) && $aClass['total_days'] == $i ? " selected" : "") . '>' . $i . '</option>';
					}

					echo '</select>
				</td>
			</tr>
			<tr>
				<th><label >Amount of time</label><span class="required">&#42;</span></th>
				<td>
					<select name="total_time">';
					
					for ($i = 1; $i <= 12; $i++) {
						echo '<option' . (isset($aClass) && $aClass['total_time'] == ($i * 5) ? " selected" : "") . '>' . ($i * 5) . '</option>';
					}

					echo '</select>
				</td>
			</tr>
			<tr>
				<th><label >Class Name</label><span class="required">&#42;</span></th>
				<td>
					<input type="text" class="product_input" name="name" value="' . (isset($aClass) ? $aClass['name'] : "") . '" validate="required" />
				</td>
			</tr>
			<tr>
				<th><label >Actual Price</label><span class="required">&#42;</span></th>
				<td>
					<input type="text" class="product_input" name="price" value="' . (isset($aClass) ? $aClass['price'] : "") . '" validate="required|decimal" />
				</td>
			</tr>
			<tr>
				<th><label >Point</label><span class="required">&#42;</span></th>
				<td>
					<input type="text" class="product_input" name="point" value="' . (isset($aClass) ? $aClass['point'] : "") . '" validate="required|digits" />
				</td>
			</tr>
			<tr>
    			<th><label>Class Period:</label></th>
    			<td>
				<select name="starttime_hours" class="class_time">';
				
				$aStartTime = isset($aClass) ? explode(":", $aClass['start_time']) : array("00","00");
				$aEndTime = isset($aClass) ? explode(":", $aClass['end_time']) : array("00","00");
				
				for ($i = 0; $i <= 23; $i++)
					echo '<option' . ((int) $aStartTime['0'] == $i ? " selected" : null) . '>' . str_pad($i, 2, "0", STR_PAD_LEFT) . '</option>';
					
				echo '</select>
				<select name="starttime_minutes" class="class_time">';
				
				for ($i = 0; $i <= 59; $i++)
					echo '<option' . ((int) $aStartTime['1'] == $i ? " selected" : null) . '>' . str_pad($i, 2, "0", STR_PAD_LEFT) . '</option>';
					
				echo '</select> ~ 
				<select name="endtime_hours" class="class_time">';
				
				for ($i = 0; $i <= 23; $i++)
					echo '<option' . ((int) $aEndTime['0'] == $i ? " selected" : null) . '>' . str_pad($i, 2, "0", STR_PAD_LEFT) . '</option>';
					
				echo '</select>
				<select name="endtime_minutes" class="class_time">';
				
				for ($i = 0; $i <= 59; $i++)
					echo '<option' . ((int) $aEndTime['1'] == $i ? " selected" : null) . '>' . str_pad($i, 2, "0", STR_PAD_LEFT) . '</option>';
					
				echo '</select>
				</td>
    		</tr>
			<tr>
				<th><label>Description</label><span class="required">&#42;</span></th>
				<td><textarea cols="100" rows="10" class="productdescription" name="description" validate="required">' . (isset($aClass) ? $aClass['description'] : "") . '</textarea></td>
			</tr>';
			
		if (count($aDiscount) > 0) {
			echo '<tr>
				<th><label>Discount Rules</label></th>
				<td colspan="2">
					<ul style="margin-top:15px;">';
					$aDiscountList = array();
					
					if (isset($aClass))
						$aDiscountList = explode(",", $aClass['discount']);
					
					foreach($aDiscount as $iKey => $aValue){
						$sChecked = in_array($aValue['idx'], $aDiscountList) === true ? " checked" : null;
					
						echo '<li>
						<span><input type="checkbox" class="discount_rule" value="' . $aValue['idx'] . '"' . $sChecked . ' /> <label>' . $aValue['name'] . '</label></span>
						</li>';
					}
						
					echo '</ul>
					<div style="margin-top:10px;">Computation : (amount + (total discount that is not in percent)) * total percent.</div>
				</td>
			</tr>';
		}
		echo '</tbody>
	</table>
	<div class="bottom">
		<div class="apply_action">
			<button class="btn_save" onclick="productClass.validate();">Submit</button>';
			
			$sFullUrl = isset($_SESSION['adminProductFullUrl']) ? $_SESSION['adminProductFullUrl'] : common::getClassUrl("productClass");
			unset($_SESSION['adminProductFullUrl']);
			
			echo '<a href="' . $sFullUrl . '" class="btn_return" title="Return to list">Return to List</a>
		</div>
	</div>
</form>';
?>