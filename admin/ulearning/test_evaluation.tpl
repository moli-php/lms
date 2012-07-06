<?php echo Common::displayMenu(true);?>

<div class="top_2">
	<div class="apply_action">
		<select style="width:50px">
			<option> ID </option>
		</select>
		<input type="text" value="" class="fix2" id="search_id" />
		<a href="javascript:test_evaluation.search()" class="btn_apply">Search</a>
		<a href="#" class="btn_apply">Total</a>
	</div>
	<div class="apply_filter">
		<select class="allselect course">
			<option value="" selected>All Courses</option>
			<?php
			foreach($category1 as $key => $val){
			?>
			<option><?php echo $val['fcategory_name'];?></option>
			<?php } ?>
		</select>
		
	</div>
	<div class="apply_filter">
		<select class="allselect status">
			<option value="" selected>All Status</option>
			<option>Assigned</option>
			<option>Finished</option>
			<option>Evaluated</option>
		</select>
		
	</div>
	<div class="show_rows">
		Show Rows
		<select class="page_rows">
			<option>20</option>
			<option>30</option>
			<option>50</option>
		</select>
	</div>
</div>
<table cellspacing="0" class="post_table" border="0" cellpadding="0">
	<colgroup>
		<col width="40px" />
		<col width="40px" />
		<col width="120px" />
		<col width="250px" />				
		<col width="250px" />	
		<col  />
		<col width="170px" />	
		
		<col width="40px" />
		<col width="170px" />
		<col width="170px" />
	</colgroup>
	<thead>
		<tr>
			<th><input type="checkbox" class="check_all" /></th>
			<th>UserID</th>
			<th>Course</th>
			<th>Cat1</th>
			<th>Cat2</th>
			<th ><a href="#" class="sort_down">Title</a></th>
			<th>Status</th>
			<th>Score</th>
			<th>SDate</th>
			<th>EDate</th>
		</tr>
	</thead>
	<tbody >
		<?php
		if(!$test_eval){
		?>
		<tr >
			<td colspan="10">No records found.</td>
		</tr>
		<?php
		}else{
		foreach($test_eval as $key => $val){
		?>
		<tr >
			<td><input type="checkbox" class="check" value="<?php echo $val['eval_id']; ?>"/></td>
			<td><?php echo $val['user_id']; ?></td>
			<td><?php echo $val['course']; ?></td>
			<td><?php echo $val['category1']; ?></td>
			<td><?php echo $val['category2']; ?></td>
			<td><a href="javascript:test_evaluation.manage(<?php echo $val['eval_id']; ?>)"><?php echo $val['ftitle']; ?></a></td>
			<td></td>
			<td><?php echo number_format($val['score'],2,'.',','); ?></td>
			<td><?php echo date("F d, Y",$val['sdate']); ?></td>
			<td class="last"><?php if($val['edate'] != "") echo  date("F d, Y",$val['edate']);else echo "n/a"; ?></td>
		</tr>
		<?php }} ?>
	</tbody>
</table>
<?php echo Common::paginate($iCurrentPage, $iRowsPerPage, $iTotalRows); ?>