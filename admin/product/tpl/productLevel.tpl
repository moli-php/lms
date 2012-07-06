<?php echo Common::displayMenu(true,array("label"=>"Add New Level","most_action"=>"Level.view_addlevel"));?>

<div class="popup_window" id="confirm_delete_box" style="width:250px;margin-left:30%;margin-top:10%;display:none">
	<div class="popup_title">Delete Level</div>
	<p style="text-align:center">Are you sure you would like to delete the checked levels?</p>
	<div class="action_btn">
		<input type = "button" class="btn_save fr" id="confirm_delete" value = "Delete"/>
		<input type = "button" class="btn_save fr" id="confirm_cancel" value = "Cancel"/>
	</div>
</div>

<table cellspacing="0" border="0" cellpadding="0" class="product_search">
	<colgroup>
		<col width="100"/>
		<col width="150"/>
		<col width="150"/>
		<col />						
	</colgroup>
	<tbody>
		<tr>
			<th>Level Name</th>
			<td><input type="text" class="fix2" name="level_search" /></td>
			<td><input type="button" class="btn_apply" onclick="javascript:window.location.href='<?php Common::urlInclude('sKeyword'); ?>' + $('[name=level_search]').val();" value = "Search" /></td>
			<td></td>
		</tr>
	</tbody>
</table>

<div class="top_2">
	<div class="apply_action">
		<input type="button" class="btn_apply" id="delete_level" value="Delete" />
	</div>
	<div class="show_rows">
		Show Rows
		<select id="show_rows" onchange="javascript:window.location.href='<?php Common::urlInclude('row'); ?>' + $('#show_rows').val();">
			<option value="10" <?php if($iRows=="10"){echo "selected";} ?>>10</option>
			<option value="20" <?php if($iRows=="20"){echo "selected";} ?>>20</option>
			<option value="50" <?php if($iRows=="50"){echo "selected";} ?>>50</option>
		</select>
	</div>
</div>

<table cellspacing="0" class="post_table">
	<colgroup>
		<col width="44" />
		<col width="100" />
		<col  />
	</colgroup>
	<thead>
		<tr>
			<th><input type="checkbox" class="check_all" /></th>
			<th><a href="#">No.</a></th>
			<?php 
				$sUrl .= $sSort == "desc" ? "&sort=asc" : "&sort=desc";
				$sUrl .= $sKeyword != null ? ("&keyword=" . $sKeyword) : "";
				$sUrl .= $iRows != null ? ("&row=" . $iRows) : "";
				
				$sClassSort = $sSort == "desc" ? "sort_down" : "sort_up";
				
				$aColumns = array(
						"name" => "Level"
				);
				foreach ($aColumns as $sKey => $sValue)
					echo '<th><a href="' . $sUrl . '&order=' . $sKey . '" ' . ($sOrder == $sKey ? 'class="' . $sClassSort . '"' : "") . '>' . $sValue . '</a></th>';
				
			?>
		</tr>
	</thead>
	<tbody >
		<?php $ctr = 1; ?>
		<?php if($list == null){?>
			<tr>
				<td colspan=3>No results found.</td>
			</tr>
		<?php }else{?>
			<?php foreach($list as $val){?>
				<tr>
					<td><input type="checkbox" id="<?php echo $val['idx']; ?>"/></td>
					<td><?php echo $ctr++; ?></td>
					<td><a href="javascript:window.location.href=common.getClassUrl('productManageLevel') + '&id=<?php echo $val['idx']; ?>'"><?php echo $val['name']; ?></a></td>
				</tr>
			<?php } ?>
		<?php }?>
		
	</tbody>
</table>

<div class="bottom">
	<div class="apply_action">
		<input type="button" class="btn_apply" id="delete_level" value="Delete" />
	</div>
</div>
<!-- //product_level_list-->
<div class="bottom_2">
	 <?php echo Common::paginate($iPage, $iRows, $totalRows); ?>
</div>
		