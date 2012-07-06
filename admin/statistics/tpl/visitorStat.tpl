<?php echo Common::displayMenu(true);?>		
<pre class="brush: php">

<?php

?>
</pre>

<form class="search_form" id="search_form">			
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
			<td><input type="text" validate="required|minlength[6]|maxlength[100]" class="fix1 start_date" id="start_date" name="start_date" value="<?php echo $start_date;?>"/><label for="start_date" class="btn_calendar_icon"></label></td>
			<td>to</td>
			<td><input type="text" validate="required|minlength[6]|maxlength[100]" class="fix1 end_date" id="end_date" name="end_date"  value="<?php echo $end_date;?>"/><label for="end_date" class="btn_calendar_icon"></label></td>
			<td><b class="error_range display_none"> Period must not greater than 3 months.</b></td>
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
			<td><a href="javascript:void(0)" class="btn_apply search_btn">Search</a></td>
		</tr>
	</tbody>
</table>
</form>
<?php if($start_date != "" && $end_date != "" ){?>
<div class="table_container">
	<h4 class="data_header"><a href="#">Visitors Per Day</a> <span style="color:#DC4E22"><?php echo $sStartDateLabel . ' ~ ' . $sEndDateLabel;?></span></h4>
	<div class="graph_wrap">
		<ul class="graph_container">
			<?php $i= 0; ?>
			<?php foreach($aMonth as $rows){?>
				<li <?php echo ($i==0) ? 'class="first"' : '';?>>
					<div class="bar_container">
						<div class="days" style="height:<?php echo $rows['percent'];?>%" title="<?php echo $rows['total_visitor'];?> <?php echo ($rows['total_visitor']>1) ? "Visitors" : "Visitor";?>">
							<span class="hidden">bar</span>
						</div>
					</div>
					<p class="label"><?php echo $rows['month'] . ' ' . $rows['day'];?></p>
					<p class="count"><?php echo $rows['total_visitor'];?></p>
				</li>	
			<?php $i++;?>
			<?php }?>
		</ul>
	</div>
	<h4 class="data_header"><a href="#">Visitors Per Hour</a></h4>
	<div class="graph_wrap">
		<ul class="graph_container" style="width:2050px !important">
			<?php $i= 0; ?>
			<?php foreach($aTime as $rows){?>
				<li <?php echo ($i==0) ? 'class="first"' : "";?>>
					<div class="bar_container">
						<div class="days" style="height:<?php echo $rows['percent'];?>%" title="<?php echo $rows['total_visitor'];?> <?php echo ($rows['total_visitor']>1) ? "Visitors" : "Visitor";?>">
							<span class="hidden">bar</span>
						</div>
					</div>
					<p class="label"><?php echo $rows['start_time'] . ' ~ ' . $rows['end_time'];?></p>
					<p class="count"><?php echo $rows['total_visitor'] . '';?></p>
				</li>
				<?php $i++; ?>
			<?php }?>
		</ul>
	</div>
	<h4 class="data_header">Referred</h4>
	<table cellspacing="0" class="post_table">
		<colgroup>
			<col  />
			<col width="200px" />				
			<col width="200px" />	
		</colgroup>
		<thead>
			<tr>
				<th>URL</th>
				<th>Count</th>
				<th>&#37;</th>
			</tr>
		</thead>
		<tbody>
			<?php if($aReferer){?>
				<?php foreach($aReferer as $rows){?>
				<tr>
					<td><a href="#"><?php echo $rows['referer'];?></a></td>
					<td><?php echo $rows['total_referer'];?></td>
					<td><?php echo ( $rows['total_referer'] * $iMaxVisitor ) / 100;?>&nbsp;&#37;</td>
				</tr>
				<?php }?>
			<?php }else{?>
			<tr>
				<td colspan="3"><center>No record found</center></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>
<?php }?>
<input type="hidden" id="visitor_url" value="<?php echo CURRENT_URL;?>"/>