<div>
	<div class="top">
		<!--<a href="#form/category/add" class="forum_btns addcategory_dialog">Add New Category</a>-->
		<a href="javascript:void(0)" class="forum_btns addCategory">Add New Category</a>
	</div>
	<table cellspacing="0" border="0" class="forum_search">
		<colgroup>
			<col width="100"/>
			<col width="150"/>
			<col width="150"/>
			<col />							
		</colgroup>
	<tbody>
		<tr>
			<th>Name / ID</th>
			<td>
				<form class="searchForm">
					<input type="text" class="forum_input" name="search_box" validate="required" />
				</form>
			</td>
			<td>
				<a href="javascript:void(0)" class="forum_btns searchBtn_category" title="Search">Search</a>
				<a href="javascript:void(0)" class="forum_btns reset_searchBtn" title="Search"  style="display: none;">Reset</a>
			</td>
			<td></td>
		</tr>
	</tbody>
	</table>
	<div class="forum_middle">
		<div class="delete">
			<a href="javascript:void(0)" class="forum_btns delete_category" title="Delete">Delete</a>
		</div>
		<div class="show_rows">
			<span>Show Rows</span>
			<select class="changeRow">
				<option>--</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
			</select>
		</div>
	</div>
	<table cellspacing="0" class="post_table category_list_tbl">
		<colgroup>
			<col width="44" />
			<col width="100"/>
			<col  />
			<col width="190" />				
			<col width="100" />	
			<col width="150" />				
		</colgroup>
		<thead>
			<tr>
				<th><input type="checkbox" name="category_list_checkbox_header" /></th>
				<th><a href="javascript:void(0)" class="sort_down">No.</a></th>
				<th><a href="javascript:void(0)">Name</a></th>
				<th><a href="javascript:void(0)">Style&nbsp;&#35;</a></th>
				<th><a href="javascript:void(0)" class="sort_down">RegDate</a></th>
				<th><a href="javascript:void(0)">Management</a></th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
	<div class="forum_bottom">
		<div class="delete">
			<a href="javascript:void(0)" class="forum_btns delete_category" title="Delete">Delete</a>
		</div>
		<div class="show_rows">
			<span>Show Rows</span>
			<select class="changeRow">
				<option>--</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
			</select>
		</div>
	</div>
	<div id="pagination-container" class="bottom_2"></div>
</div>