<?php echo Common::displayMenu(true,array("label"=>"Add New Level Test","most_action"=>"classLevelTest.mostAction"));

echo '<table cellspacing="0" border="0" cellpadding="0" class="product_search">
	<colgroup>
		<col width="150"/>
		<col width="150"/>
		<col width="150"/>
		<col />						
	</colgroup>
	<tbody>
		<tr>
			<th><label>ID / Name:</label></th>
			<td colspan="2"><input type="text" class="fix4" id="user_name" value="' . ($sKeyword != "" ? $sKeyword : null) . '" /></td>
			<td></td>
		</tr>
		<tr>
			<th><label>Registration Date:</label></th>
			<td><input type="text" class="fix3" id="start_period" value="' . ($sStartDate != null ? $sStartDate : null) . '" />	~
			<td><input type="text" class="fix3" id="end_period" value="' . ($sEndDate != null ? $sEndDate : null) . '" /></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<select id="teacher_option">
					<option>Teacher</option>';
					
					foreach ($aBranch as $aValue){
						$iCount = 0;
						echo '<optgroup label="' . ucwords($aValue['name']) . '">';
						foreach ($aTeacher as $iKey => $aNewValue){
							if ($aValue['idx'] == $aNewValue['branch_idx']){
								echo '<option value="' . $aNewValue['idx'] . '"' . ($iTeacher != null && $iTeacher == $aNewValue['idx'] ? " selected" : null) . '>' . ucwords($aNewValue['name']) . '</option>';
									$iCount++;
							}
						}
						
						if ($iCount == 0)
							echo '<option style="color:#fb6e6e;" disabled>No Teacher</option>';
						
						echo '</optgroup>';
					}
					
				
				echo '</select>
			</td>
			<td><a href="javascript:void(0);" class="btn_go" onclick="classLevelTest.search();">Search</a></td>
			<td></td>
		</tr>
	</tbody>
</table>
<div class="top_3">
	<ul class="sort_view">'; 

	$sUrl = common::getClassUrl("classLevelTest");
	$sUrl .= $iRows != null ? ("&row=" . $iRows) : "";

	echo'<li' . ($sStatus == null ? ' class="active all"' : "") . '><a href="' . $sUrl . '" title="Show all posts">All(' . $iTotalData . ')</a></li>
	<li' . ($sStatus == "0" ? ' class="active all"' : "") . '><a href="' . $sUrl . '&status=0">Only Requested (' . $iOnlyApplied . ')</a></li>
	<li' . ($sStatus == "1" ? ' class="active all"' : "") . '><a href="' . $sUrl . '&status=1">Only Scheduled (' . $iActivated . ')</a></li>';

	echo '<li class="show_rows" style="float:right;background:none">Show Rows
			<select id="show_rows" onchange="classLevelTest.setRows();">';

			echo '<option value="10"' . ($iRows == 10 ? " selected" : "") . '>10</option>
                <option value="20"' . ($iRows == 20 ? " selected" : "") . '>20</option>
                <option value="50"' . ($iRows == 50 ? " selected" : "") . '>50</option>';

		echo '</select>
		</li>
	</ul>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="post_table class_list level_test">
	<colgroup>
		<col width="40px" />
		<col width="50px" />
		<col />
		<col width="180px" />
		<col width="180px" />
		<col width="150px" />
		<col width="150px" />
		<col width="150px" />
		<col width="150px" />
		<col width="70px" />
	</colgroup>
	<thead>
		<tr>
			<th><input type="checkbox" onclick="classLevelTest.checkAll(this);" /></th>
			<th>No</th>';
			
			$sUrl .= $sSort == "desc" ? "&sort=asc" : "&sort=desc";
			$sUrl .= $sKeyword != null ? "&keyword=" . $sKeyword : "";
			$sUrl .= $iRows != null ? "&row=" . $iRows : "";
			$sUrl .= $sType != null ? "&type=" . $sType : "";
			$sUrl .= $sStatus != null ? "&status=" . $sStatus : "";
			$sUrl .= $iPage != null ? "&page=" . $iPage : "";
			
			$sClassSort = $sSort == "desc" ? "sort_down" : "sort_up";
			
			$aColumns = array(
					"student_idx" => "User ID",
					"teacher_idx" => "Teacher",
					"type" => "Desired Test",
					"datetime_desired" => "Desired Date",
					"level" => "Level",
					"datetime_create" => "Reg Date",
					"time" => "Test Time"
					);

			foreach ($aColumns as $sKey => $sValue)
				echo '<th><a href="' . $sUrl . '&order=' . $sKey . '" ' . ($sOrder == $sKey ? 'class="' . $sClassSort . '"' : "") . '>' . $sValue . '</a></th>';
			
			
			echo '<th>Manage</th>
		</tr>
	</thead>
	<tbody>';
	
		if (count($aTest) > 0 && $aTest !== false) {
			$iCount = $iTotalRows - ($iRows * ($iPage - 1));
	
			foreach ($aTest as $iKey => $aValue){
				echo '<tr' . ($aValue['status'] == 0 ? ' class="focus"' : null) . '>
					<td><input type="checkbox" value="' . $aValue['idx'] . '" /></td>
					<td>' . $iCount . '</td>
					<td>' . ucwords($aValue['fullname']) . ' (' . $aValue['userid'] . ')</td>
					<td>' . ($aValue['teacher'] != "" ? ucwords($aValue['teacher']) : "N/A") . '</td>
					<td>' . ucfirst($aValue['type']) . '</td>
					<td>' . date("Y-m-d", $aValue['datetime_desired']) . '</td>
					<td>' . $aValue['tester_level'] . '</td>
					<td>' . date("Y-m-d", $aValue['datetime_create']) . '</td>
					<td>' . $aValue['time_start'] . '</td>
					<td>
						<ul class="management_control" style="width:60px">
							<li><a class="btn_management" href="' . common::getClassUrl("classLevelTestEdit") . "&idx=" . $aValue['idx'] . '" title="Edit Level Test Information" >M</a></li>
						</ul>
					</td>
				</tr>';
				$iCount--;
			}
		} else {
			echo '<tr><td colspan="10">No result found.</td></tr>';
		}
	
	echo '</tbody>
</table>
<div class="bottom">
	<div class="apply_action">
		<a href="javascript:void(0);" class="btn_apply" onclick="classLevelTest.verifyDelete();">Delete</a>
	</div>
</div>
<div class="bottom_2">
	' . $sPagination . '
</div>';

?>