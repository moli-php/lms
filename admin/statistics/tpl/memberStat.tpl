<?php echo Common::displayMenu(true);?>	

<form class="search_form">	
<table cellspacing="0" border="0" class="statistics_search">
	<colgroup>
		<col width="80"/>
		<col width="210"/>
		<col width="40"/>
		<col width="210"/>	
		<col />					
	</colgroup>
	<tbody>
		<tr>
			<th><label>Period</label></th>
			<td><input type="text" class="fix1 start_date" id="start_date" name="start_date" validate="required|minlength[6]|maxlength[100]" value="<?php echo $start_date;?>" /><label for="start_date" class="btn_calendar_icon"></label></td>
			<td>to</td>
			<td><input type="text" class="fix1 end_date" id="end_date" name="end_date" validate="required|minlength[6]|maxlength[100]" value="<?php echo $end_date;?>"/><label for="end_date" class="btn_calendar_icon"></label></td>
			<td></td>
		</tr>
		<tr>
			<th><label>Branch</label></th>
			<td>
				<?php if(isset($_SESSION['grade_idx']) && $_SESSION['grade_idx']==9){?>
				<?php if($aContentsBranch){ ?>
				<select name="branch" id="branch">
					<?php foreach($aContentsBranch as $rows){?>
					<option value="<?php echo $rows['idx'];?>" <?php echo ($iUserIdx==$rows['idx']) ? "selected='selected'" : "";?>><?php echo $rows['name'];?></option>
					<?php }?>
				</select>
				<?php }?>
				<?php }else{?>
				<?php echo $_SESSION['user_id'];?>
				<?php }?>
			</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><a href="#" class="btn_apply search_btn">Search</a></td>
		</tr>
	</tbody>
</table>
</form>
<?php if($start_date != '' && $end_date != ""){?>
<div class="table_container">
	<table cellspacing="0" class="members_table">
		<colgroup>	
			<col width="300"/>
			<col />
			<col />
		</colgroup>
		<tr>
			<th>Total Number of Users:</th>
			<td><?php echo $total_user;?></td>
		</tr>
		<tr>
			<th>Number of User Joined during the period:</th>
			<td><?php echo $total_joined;?></td>
		</tr>
		<tr>
			<th>Number of Users who applied for any class:</th>
			<td><?php echo $total_applied; ?></td>
		</tr>
		<tr>
			<th>Age Range</th>
			<td></td>
		</tr>
		<tr>
			<th>- 0 to 10:</th>
			<td><?php echo $age_info['0-10'];?></td>
		</tr>
		<tr>
			<th>- 11 to 20:</th>
			<td><?php echo $age_info['11-20'];?></td>
		</tr>
		<tr>
			<th>- 21 to 30:</th>
			<td><?php echo $age_info['21-30'];?></td>
		</tr>
		<tr>
			<th>- 31 to 40:</th>
			<td><?php echo $age_info['31-40'];?></td>
		</tr>
		<tr>
			<th>- over 40:</th>
			<td><?php echo $age_info['41-100'];?></td>
		</tr>
		<tr>
			<th>Sex Ratio:</th>
			<td><?php echo $total_male;?>%M : <?php echo $total_female?>%F</td>
		</tr>
		<tr>
			<th>Members Quit:</th>
			<td><?php echo $total_quit;?></td>
		</tr>
	</table>
</div>
<?php }?>
<input type="hidden" value="<?php echo CURRENT_URL;?>" id="main_url" />