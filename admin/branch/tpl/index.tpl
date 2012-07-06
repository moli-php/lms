<?php echo Common::displayMenu(true); ?>
<table cellspacing="0" border="0" cellpadding="0" class="product_search">
	<colgroup>
		<col width="100"/>
		<col width="150"/>
		<col />						
	</colgroup>
	<tbody>
		<tr>
			<th>ID / Name</th>
			<td>
				<form name="search-form">
					<input type="text" class="username" validate="required" />
				</form>
			</td>
			<td><a href="#" class="btn_apply" id="search">Search</a></td>
			<td></td>
		</tr>
	</tbody>
</table>
<div class="top_2">
	<div class="show_rows">
		Show Rows
		<select class="change-rows">
			<option>---</option>
			<option value="2">2</option>
			<option value="4">4</option>
			<option value="8">8</option>
			<option value="10">10</option>
			<option value="20">20</option>
		</select>
	</div>
</div>
<table cellspacing="0" class="post_table">
	<colgroup>
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
			<th>
				<?php
					if(!isset($_GET['sort']) OR $_GET['sort'] != 'uid'){
						echo '<a href="?sort=uid&order=asc" class="sort_up">No.</a>';
					}
					elseif(isset($_GET['sort']) AND $_GET['sort'] == 'uid' AND $_GET['order'] == 'desc')
					{
						echo '<a href="?sort=uid&order=asc" class="sort_up">No.</a>';
					}
					else
					{
						echo '<a href="?sort=uid&order=desc" class="sort_down">No.</a>';
					}
				?>				
			</th>
			<th><a href="#">ID</a></th>
			<th><a href="#">Name</a></th>
			<th><a href="#" class="sort_down">Number of Students</a></th>
			<th>
				<?php
					if(!isset($_GET['sort']) OR $_GET['sort'] != 'point'){
						echo '<a href="?sort=point&order=asc" class="sort_up">Point&nbsp;&#43;</a>';
					}
					elseif(isset($_GET['sort']) AND $_GET['sort'] == 'point' AND $_GET['order'] == 'desc')
					{
						echo '<a href="?sort=point&order=asc" class="sort_up">Point&nbsp;&#43;</a>';
					}
					else
					{
						echo '<a href="?sort=point&order=desc" class="sort_down">Point&nbsp;&#43;</a>';
					}
				?>
				
			</th>
			<th><a href="#">Active</a></th>
			<th><a href="#">Manage</a></th>
		</tr>
	</thead>
	<tbody >
		<?php
			for($x=0;$x<=(count($query) - 1);$x++)
			{
				echo '<tr>';
				echo '<td>'.$query[$x]['idx'].'</td>';
				echo '<td>'.$query[$x]['user_id'].'</td>';
				echo '<td>'.$query[$x]['name'].'</td>';
				
				$aSql	= 'SELECT COUNT(*) as "total" FROM tb_user WHERE branch_idx = '.$query[$x]['idx'];
				$aQuery	= $this->query($aSql);
				
				echo '<td>'.$aQuery[0]['total'].'</td>';
				
				if($query[$x]['points'] == '')
				{
					echo '<td>N/A</td>';
				}
				else
				{
					echo '<td>'.$query[$x]['points'].'</td>';
				}
				if($query[$x]['active'] == '')
				{
					echo '<td>N/A</td>';
				}
				else
				{
					if($query[$x]['active'] == 1)
					{
						echo '<td>Active</td>';
					}
					else
					{
						echo '<td>Deactivated</td>';
					}
				}				
				echo '</td>';
				echo '<td id="uid-'.$query[$x]['idx'].'" class="manage-branch"><a class="btn_management" href="#none">M</a></td>';
				echo '</tr>';
			}
		?>
	</tbody>
</table>
<div class="popup_window" style="width:400px;;margin-left:33%;margin-top:10%; display: none;">
	<div class="btn_close" style="float: left; margin-left: 360px;">
		<a href="#" class="btn_apply">close</a>
	</div>
	<form id="popup">
		<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
			<col width="200px" />
			<col width="200px" />
			<tr><th colspan="2" class="popup_title">Branch &raquo;</th></tr>
			<tr>
				<th colspan="2"><input type="radio" name="active" value="0" checked/><label>&nbsp;Deactivate</label></th>
				<td colspan="2"><input type="radio" name="active" value="1"/><label>&nbsp;Active</label></td>
			</tr>
			<tr>
				<th colspan="2">Point&nbsp;&#43;</th>
				<td colspan="2"><input type="text" name="point" maxlength="80" value="" class="fix" validate="required" /></td>
			</tr>
			<tr>
				<th colspan="2">Referrer</th>
				<td colspan="2"><input type="text" name="referrer" maxlength="150" value="" class="fix" validate="required" /></td>
			</tr>
			<tr>
				<th colspan="2">Description</th>
				<td><textarea cols="60" rows="5" class="pop_uptext" name="description" validate="required"></textarea></td>
			</tr>
		</table>
		<div>
			<a href="#" class="btn_save fr" title="Save changes">Submit</a>
		</div>
	</form>
</div>	
<?php
	echo Common::paginate($iCurrentPage, $iRowsPerPage, $iTotalRows);
?>
