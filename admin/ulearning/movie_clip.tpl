<?php echo Common::displayMenu(true,array("label"=>"Add New Movie Clip","most_action"=>"movie_clip.add_movie_clip"));?>

<div class="top_2">
	<div class="apply_action">
		<label>Movie Title</label>
		<input type="text" value="" class="fix2" id="movie_title" />
	</div>
	
	<div class="apply_filter" style="padding-right:10px">
		<label>1 depth</label>
		<select class="allselect" id="select_category">
			<option></option>
		<?php
		foreach($movie_cat as $key => $val){
		?>
			<option value="<?php echo $val['movie_cat_id']; ?>"><?php echo $val['movie_category']; ?></option>
		<?php } ?>
		</select>
	</div>
	<div class="apply_filter">
		<label>2 depth</label>
		<select class="allselect" id="select_category_name">
			<option></option>
		</select>
	</div>
	<div class="apply_filter">
		<a href="javascript:movie_clip.search()" class="btn_apply">Search</a>
	</div>
	
</div>
<div class="top_2">
	<div class="apply_action">
		<a href="javascript:movie_clip.delete_confirm()" class="btn_apply">Delete</a>
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
		<col width="60px" />
		<col width="150px" />
		<col  />				
		<col width="250px" />	
	</colgroup>
	<thead>
		<tr>
			<th><input type="checkbox" class="check_all" /></th>
			<th>No</th>
			<th>Category</th>
			<th>Title</th>
			<th>Image</th>
		</tr>
	</thead>
	<tbody class="movie_clip_lists">
		<?php
		if(!$movie){
		?>
		<tr >
			<td colspan="5">No movie clips found.</td>
		</tr>
		<?php
		}else{
		foreach($movie as $key => $val){
		?>
		<tr >
			<td><input type="checkbox" class="check" value="<?php echo $val['movie_clip_id']; ?>"/></td>
			<td><?php echo $key+1; ?></td>
			<td><?php echo $val['movie_category'] ." > ". $val['movie_category_name']; ?></td>
			<td><a href="javascript:movie_clip.modify_clip(<?php echo $val['movie_clip_id']; ?>)"><?php echo $val['movie_clip_title']; ?></a></td>
			<td class="last"><img src="<? echo BASE_URL;?>image.php?w=200&path=ulearning/upload/<?php echo $val['movie_clip_image']; ?>" /></td>
		</tr>
		<?php }} ?>
	</tbody>
</table>
<div class="bottom">
	<div class="apply_action">
		<a href="javascript:movie_clip.delete_confirm()" class="btn_apply">Delete</a>
	</div>
</div>

<div class="popup_window hidden delete_movie_clip">
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
		<col width="275px" />
		<!--<tr><th class="popup_title">Delete Movie Clip &raquo;</th></tr>
		<tr><td></td></tr>-->
		<tr>
			<th>Are you sure?</th>
		</tr>
	</table>
	<div class="action_btn">
		<a href="javascript:movie_clip.delete_movie_clip()" class="btn_save fr" title="Delete">Delete</a>
		<a href="javascript:movie_clip.close()" class="btn_save" title="Cancel">Cancel</a>
		<span class="hidden" id="del_id"></span>
	</div>
</div>

<?php echo Common::paginate($iCurrentPage, $iRowsPerPage, $iTotalRows); ?>