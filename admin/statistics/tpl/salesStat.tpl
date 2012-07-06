<?php echo Common::displayMenu(true);?>
<a href="#" class="test_link">Test Link</a>
<form class="search_form">				
<table cellspacing="0" border="0" cellpadding="0" class="statistics_search">
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
			<td><input type="text" class="fix1 start_date" name="start_date" validate="required|minlength[6]|maxlength[100]" id="start_date" value="<?php echo $start_date;?>"/><label for="start_date" class="btn_calendar_icon"></label></td>
			<td>to</td>
			<td><input type="text" class="fix1 end_date" name="end_date" validate="required|minlength[6]|maxlength[100]" id="end_date" value="<?php echo $end_date;?>"/><label for="end_date" class="btn_calendar_icon"></label></td>
			<td><a href="javascript:void(0)" class="btn_apply search_btn">Search</a></td>
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
			<td><!--<a href="javascript:void(0)" class="btn_apply search_btn">Search</a>--></td>
		</tr>
	</tbody>
</table>
</form>


<?php if($aContents){?>
<div class="table_container">
	<h4 class="data_header"><a href="#">Sales Data&nbsp;&#40;<?php echo $sStartDateLabel;?> to <?php echo $sEndDateLabel;?>&#41;</a></h4>
	<table cellspacing="0" class="post_table">
		<colgroup>
			<col width="200px" />
			<col width="200px" />
			<col width="200px" />
			<col width="200px" />				
			<col width="170px" />	
			<col  />				
		</colgroup>
		<thead>
			<tr>
				<th>Date</th>
				<th>Apply Count</th>
				<th>Not Confirmed</th>
				<th>Confirmed</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			
			<?php foreach($aContents as $rows){?>
			<tr>
				<td><?php echo $rows['datetime_purchase'];?></td>
				<td><?php echo $rows['apply_count'];?></td>
				<td>&#36;<?php echo $rows['notconfirmed_payment']; ?></td>
				<td>
					<p>Cash &#36;<?php echo $rows['payment_cash'];?></p>
					<p>Card &#36;<?php echo $rows['payment_card'];?></p>
				</td>
				<td>&#36;<?php echo $rows['total'];?></td>
			</tr>
			<?php 	}?>
			<!--
			<tr>
				<td><a href="#">2012-01-01</a></td>
				<td>100</td>
				<td>&#36;10000</td>
				<td>&#36;20000</td>
				<td>
					<p><a href="#">Cash &#36;10000</a></p>
					<p><a href="#">Card &#36;20000</a></p>
				</td>
				<td>&#36;40000</td>
			</tr>
			-->
		</tbody>
	</table>
	<table cellspacing="0" class="subtotal_table">
		<colgroup>	
			<col width="290"/>
			<col />
			<col />
		</colgroup>
		<tr>
			<th>Total Amount of Students Applied:</th>
			<td><?php echo $iTotalApplied;?></td>
		</tr>
		<tr>
			<th>Total Amount of Confirmed Money:</th>
			<td>&#36;<?php echo $iTotalConfirmed;?></td>
		</tr>
		<tr>
			<th>Total Amount of Money:</th>
			<td>&#36;<?php echo $iTotalAmountMoney;?></td>
		</tr>
	</table>
</div>


<div class="table_container">
	<h4 class="data_header"><a href="#">Income Per Class Product</a></h4>
	<table cellspacing="0" class="post_table">
		<colgroup>
			<col />
			<col width="200px" />
			<col width="200px" />
			<col width="250px" />							
		</colgroup>
		<thead>
			<tr>
				<th>Class Name</th>
				<th>Price</th>
				<th>Applied Count</th>
				<th>Income</th>
			</tr>
		</thead>
		<tbody>
			<?php if($aContentsProduct){?>
			<?php foreach($aContentsProduct as $rows){?>
				<tr>
					<td><?php echo $rows['class_name'] . ' ( ' . $rows['country'] . ' ) ';?></td>
					<td>&#36;<?php echo number_format($rows['price'],2);?></td>
					<td><?php echo $rows['total_applied'];?></td>
					<td>&#36;<?php echo number_format($rows['income'],2);?></td>
				</tr>			
			<?php 	}?>
			<?php }?>
			<!--
			<tr>
				<td><a href="#">Phone English</a>&nbsp;3 days a week&nbsp;&#40;&nbsp;<a href="#">PH</a>&nbsp;&#41;</td>
				<td>&#36;130000</td>
				<td>10</td>
				<td>&#36;130000</td>
			</tr>
			<tr>
				<td><a href="#">Phone English</a>&nbsp;3 days a week&nbsp;&#40;&nbsp;<a href="#">PH</a>&nbsp;&#41;</td>
				<td>&#36;130000</td>
				<td>10</td>
				<td>&#36;130000</td>
			</tr>
			-->			
		</tbody>
	</table>
</div>
<?php }else{?>
<div class="statistics_wrap">
	No Record Found.
</div>
<?php }?>
<input type="hidden" id="sales_url" value="<?php echo CURRENT_URL;?>"/>