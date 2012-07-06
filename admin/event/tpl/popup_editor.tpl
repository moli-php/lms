
<?php echo Common::displayMenu(true,array("label"=>"Add New Popup","most_action"=>"settings.addPopupUrl"));?>

	
		<div class="top_2">
			<ul class="sort_view">
				<li class="active all"><a href="<?php echo BASE_URL.'admin/event/?action=popup_editor';?>">All (<?php echo $aData[0]['iCount']['all']; ?>)</a></li>
				<li><a href="#" onclick="javascript:window.location.href='<?php Common::urlInclude('status');?>'+ $(this).text().substr(0,6);">Active (<?php echo $aData[0]['iCount']['active']; ?>)</a></li>
				<li><a href="#" onclick="javascript:window.location.href='<?php Common::urlInclude('status');?>'+ $(this).text().substr(0,8);">Inactive (<?php echo $aData[0]['iCount']['inactive']; ?>)</a></li>
				<li style="float:right;background:none"><input type="text" /><input type="submit" value="search" id="popup_search" class="btn_apply" onclick="javascript: if($(this).prev().val())window.location.href='<?php Common::urlInclude('search');?>'+ $(this).prev().val();"/></li>
			</ul>
			<div class="show_rows">
				Show Rows
				<select onchange="javascript:window.location.href='<?php Common::urlInclude('rows');?>'+ $(this).val();">
					<?php foreach($aData[0]['aData']['showRows'] as $val){if(isset($_GET['rows'])){	?>
					<option <?php if($val == $_GET['rows']) echo "selected";?>><?php echo $val; ?></option>
					<?php }else{ ?>
					<option><?php echo $val; ?></option>
					<?php }} ?>
				</select>
			</div>
		</div>
		<table cellspacing="0" class="post_table banner" id="popup_table_list">
			<colgroup>
				<col width="40px" />
				<col width="40px" />
				<col  />	
				<col width="80px" />		
				<col width="170px" />
				<col width="170px" />
			</colgroup>
			<thead>
				<tr>
					<th><input type="checkbox" class="check_all"/></th>
					<th>No.</th>
					<th><a href="#" class="sort_down">Title</a></th>
					<th><a href="#" class="sort_down">Status</a></th>
					<th><a href="#" class="sort_down">Created</a></th>
					<th><a href="#" class="">Management</a></th>
				</tr>
			</thead>
			<tbody >
			<?php 
			if(count($aData[0]['aData']['getData']) > 0){
				foreach($aData[0]['aData']['getData'] as $val){		
				?>
					<tr>
						<td><input type="checkbox" id="<?php echo $val['idx'];?>"/></td>
						<td><?php echo $val['iNum'];?></td>
						<td><a href="<?php echo BASE_URL;?>admin/event/?action=add_popup&idx=<?php echo $val['idx'].$aData[0]['url_args']; ?>"><?php echo $val['title'];?></a></td>
						<td><?php echo $val['status']; ?></td>
						<td><?php echo date('M d, Y g:i:s a',$val['date_created']);?></td>
						<td class=""><a href="<?php echo BASE_URL;?>admin/event/?action=add_popup&idx=<?php echo $val['idx'].$aData[0]['url_args']; ?>"><img src="<?php echo BASE_URL;?>images/wrench-screwdriver.png" alt="Management" /></a>&nbsp;<a href="#" class="delete_record" id="<?php echo $val['idx']."|popup"; ?>"><img src="<?php echo BASE_URL;?>images/icons/cross-circle.png" alt="Delete" /></a></td>
					</tr>
				<?php 
				}
			}else{?>
			<tr>
			<td colspan="7">No Matches found</td>
			</tr>
			<?php
			}
			?>					
			</tbody>
		</table>
		<div class="bottom">
			<div class="apply_action">
				<a href="#" rel="popup" id="delete_records" class="btn_apply">Delete</a>
			</div>
		</div>
		<div id="del_dialog" style="display:none;">
			Delete this record?
		</div>
		<div id="dels_dialog" style="display:none;">
			This will delete the selected record(s)
		</div>
		<div id="del_no_selected">Please make a selection.</div>
	<?php echo Common::paginate($aData[0]['iCurrentPage'], $aData[0]['iRowsPerPage'], $aData[0]['iTotalRows']); ?>