<?php echo Common::displayMenu(true,array("label"=>"Add New Class","most_action"=>"productClass.addClass"));?>

<table cellspacing="0" border="0" cellpadding="0" class="product_search">
	<colgroup>
		<col width="100"/>
		<col width="150"/>
		<col width="150"/>
		<col width="150"/>
		<col width="300"/>
		<col />
	</colgroup>
	<tbody>
		<tr>
			<th><label>Class Name</label></th>
			<td><input type="text" id="keyword" class="product_name" /></td>
			<?php
			echo '<td class="radio"><input type="radio" id="class_country_all" name="class_country" value="all"' . ($sCountry == null ? " checked" : null) . ' /><label for="class_country_all">All</label></td>
			<td class="radio"><input type="radio" id="class_ph" name="class_country" value="0"' . ($sCountry != null && $sCountry == "philippines" ? " checked" : null) . ' /><label for="class_ph">Philippines</label></td>
			<td class="radio"><input type="radio" id="class_usa" name="class_country" value="1"' . ($sCountry != null && $sCountry == "united states of america" ? " checked" : null) . ' /><label for="class_usa">United States of America</label></td>';
			?>
			<td></td>
		</tr>
		<tr>
			<th><label>Class Period</label></th>
			<td class="class_period">
				<select name="class_months">
				<?php
					echo '<option value="all"' . ($iMonths == null ? " selected" : null) . '>All</option>';
					
					for ($i = 1; $i <= 12; $i++) {
						echo '<option value="' . $i . '"' . ($iMonths != null && $iMonths == $i ? " selected" : null) . '>' . $i . ' month' . ($i > 1 ? "s" : "") . '</option>';
					}
				?>
				</select>
			</td>
			<?php
			echo '<td class="radio"><input type="radio" id="class_type_all" name="class_type" value="all"' . ($sType == null ? " checked" : null) . ' /><label for="class_type_all">All</label></td>
			<td class="radio"><input type="radio" id="class_phone" name="class_type" value="phone"' . ($sType != null && $sType == "phone" ? " checked" : null) . ' /><label for="class_phone">Phone</label></td>
			<td class="radio"><input type="radio" id="class_camera" name="class_type" value="camera"' . ($sType != null && $sType == "camera" ? " checked" : null) . ' /><label for="class_camera">Camera</label></td>'
			?>
			<td></td>
		</tr>
		<tr>
			<th><label>Days Per Week</label></th>
			<td class="class_period">
				<select name="class_days">
				<?php
					echo '<option value="all"' . ($iMonths == null ? " selected" : null) . '>All</option>';
					
					for ($i = 1; $i <= 7; $i++) {
						echo '<option' . ($iDays != null && $iDays == $i ? " selected" : null) . '>' . $i . '</option>';
					}
				?>
				</select>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><a id="search_button" href="javascript:void(0);" class="btn_apply">Search</a></td>
			<td></td>
		</tr>
	</tbody>
</table>
<ul class="sort_view">
	<?php
		$sUrl = common::getClassUrl("productClass");
		$sUrl .= $iRows != null ? ("&row=" . $iRows) : "";

		echo'<li' . ($sStatus == null ? ' class="active all"' : "") . '><a href="' . $sUrl . '" title="Show all posts">All(' . $iTotalData . ')</a></li>
		<li' . ($sStatus == "activated" ? ' class="active all"' : "") . '><a href="' . $sUrl . '&status=activated">Activated (' . $iActivated . ')</a></li>
		<li' . ($sStatus == "deactivated" ? ' class="active all"' : "") . '><a href="' . $sUrl . '&status=deactivated">Deactivated (' . $iDeactivated . ')</a></li>';
	?>	
</ul>
<div class="top_2">
	<div class="apply_action">
		<a href="javascript:productClass.verifyDelete();" class="btn_apply">Delete</a>
	</div>
	<div class="show_rows">
		Show Rows
		<select id="show_rows" onchange="productClass.setRows();">
			<?php 
			
			echo '<option value="10"' . ($iRows == 10 ? " selected" : "") . '>10</option>
                <option value="20"' . ($iRows == 20 ? " selected" : "") . '>20</option>
                <option value="50"' . ($iRows == 50 ? " selected" : "") . '>50</option>';
			?>
		</select>
	</div>
</div>
<table cellspacing="0" class="post_table">
	<colgroup>
		<col width="44" />
		<col width="100" />
		<col  />
		<col width="130" />
		<col width="190" />
		<col width="100" />
		<col width="100" />
		<col width="100" />
	</colgroup>
	<thead>
		<tr>
			<th><input type="checkbox" onclick="productClass.checkAll(this);" /></th>
			<th><a href="#">No.</a></th>
			<?php
			
			$sUrl .= $sSort == "desc" ? "&sort=asc" : "&sort=desc";
			$sUrl .= $sKeyword != null ? "&keyword=" . $sKeyword : "";
			$sUrl .= $iRows != null ? "&row=" . $iRows : "";
			$sUrl .= $iMonths != null ? "&months=" . $iMonths : "";
			$sUrl .= $iDays != null ? "&days=" . $iDays : "";
			$sUrl .= $sType != null ? "&type=" . $sType : "";
			$sUrl .= $sCountry != null ? "&country=" . $sCountry : "";
			$sUrl .= $sStatus != null ? "&status=" . $sStatus : "";
			$sUrl .= $iPage != null ? "&page=" . $iPage : "";
			
			$sClassSort = $sSort == "desc" ? "sort_down" : "sort_up";
			
			$aColumns = array(
					"name" => "Class",
					"total_months" => "Period",
					"total_days" => "Days Per Week",
					"total_hours" => "Total Hours",
					"price" => "Price",
					"status" => "Active"
					);

			foreach ($aColumns as $sKey => $sValue)
				echo '<th><a href="' . $sUrl . '&order=' . $sKey . '" ' . ($sOrder == $sKey ? 'class="' . $sClassSort . '"' : "") . '>' . $sValue . '</a></th>';

			?>
			
		</tr>
	</thead>
	<tbody >
		<?php
		if (count($aClass) > 0) {
			$iCount = $iTotalData - ($iRows * ($iPage - 1));
			
			foreach ($aClass as $iKey => $aValue){
				echo '	<tr>
					<td><input class="checkbox_list" type="checkbox" value="' . $aValue['idx'] . '" /></td>
					<td>' . $iCount . '</td>
					<td><a href="' . common::getClassUrl("productClassEdit") . '&idx=' . $aValue['idx'] . '">' . $aValue['name'] . '</a></td>
					<td>' . $aValue['total_months'] . ' month(s)</td>
					<td>' . $aValue['total_days'] . ' day(s)</td>
					<td>' . $aValue['total_time'] . '</td>
					<td>&#36;' . number_format($aValue['price'], 2, ".", ",") . '</td>
					<td>' . ($aValue['status'] == 0 ? "No" : "Yes") . '</td>
				</tr>';
				
				$iCount--;
			}
		} else {
			echo '<tr><td colspan="8">No result found.</td></tr>';
		}
		?>
	</tbody>
</table>
<div class="bottom">
	<div class="apply_action">
		<a href="javascript:productClass.verifyDelete();" class="btn_apply">Delete</a>
	</div>
</div>
<!-- //product_list-->
<div class="bottom_2">
	<?php echo $sPagination; ?>
</div>


