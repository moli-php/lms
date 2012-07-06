<?php echo Common::displayMenu(true);?>

<div class="wrap class_list_content" style="display:inline-block">
	<table cellspacing="0" border="0" cellpadding="0" class="product_search">
    	<colgroup>
    		<col width="150"/>
    		<col width="150"/>
    		<col width="150"/>
    		<col />
    	</colgroup>
    	<tbody>
    		<tr>
    			<th><label>ID / Name:</label></th>
    			<td colspan="2"><input type="text" class="fix4" id="search_id" name="search_id" value="<?php echo $name;?>"/></td>
    			<td></td>
    		</tr>
    		<tr>
    			<th><label>Class Period:</label></th>
    			<td><input type="text" class="text_size" id="period_startdate" name="period_startdate" value="<?php echo $sdate;?>"/>~
    			<td><input type="text" class="text_size" id="period_enddate" name="period_enddate" value="<?php echo $edate;?>"/></td>
    			<td></td>
    		</tr>
    		<tr>
    			<?php if(@$_SESSION['grade_idx']== 9) {?>
        			<td><select id="search_branch" name="search_branch" class="search_class">
        			<option>Branch</option>
        			<?php foreach($branchName as $key=>$value){ ?>
        			    <option value="<?php echo $value['idx'];?>" <?php if($value['idx'] == $branch){?>selected<?php }?>><?php echo ucwords(strtolower($value['name']));?></option>
    			    <?php  }?>
        			</select></td>
        		<?php }?>

    			<td><select id="search_teacher" name="search_teacher" class="search_class">
    			    <option>Teacher</option>
    			    <?php foreach($branchName as $key=>$value){
    			        if($_SESSION['grade_idx']==9 || ($value['user_id'] == $_SESSION['user_id'])) {?>
        			    <optgroup label="<?php echo ucwords(strtolower($value['name']));?>">
        			    <?php
        			    if($value['teacher_name']!=""){
        			        for($i=0;$i<count($value['teacher_name']);$i++){ ?>
        			        <option value="<?php echo $branchName[$key]['teacher_id'][$i];?>" <?php if($branchName[$key]['teacher_id'][$i] == $teacher){?>selected<?php }?>><?php echo ucwords(strtolower($branchName[$key]['teacher_name'][$i]));?></option>
    			    <?php }
        			    } else { ?>
        			        <option disabled>No Teacher</option>
        			<?php }
    			        } ?> </optgroup>
                    <?php } ?>
        			</select></td>

    			<td><select id="search_class" name="search_class" class="search_class">
    			<option>Class</option>
    			    <?php foreach($branchName as $key=>$value){
    			        if($_SESSION['grade_idx']==9 || ($value['user_id'] == $_SESSION['user_id'])) {?>
        			    <optgroup label="<?php echo ucwords(strtolower($value['name']));?>">
        			    <?php
        			    if($value['class_name']!=""){
        			        for($i=0;$i<count($value['class_name']);$i++){ ?>
        			        <option value="<?php echo $branchName[$key]['class_id'][$i];?>" <?php if($branchName[$key]['class_id'][$i] == $class){?>selected<?php }?>><?php echo ucwords($branchName[$key]['class_name'][$i]);?></option>
    			    <?php }
        			    } else { ?>
        			        <option disabled>No Class</option>
        			<?php }
    			        } ?> </optgroup>
                    <?php } ?>
        			</select></td>

    			<td><a href="javascript:void(0);" class="btn_go" id="search_button" name="search_button">Search</a></td>
    		</tr>
    	</tbody>
    </table>
	<div class="top_3">
	    <ul class="sort_view" style="float:left;width:auto;margin:0">
			<li class="active all"><a href="javascript:void(0);">Total (<?php echo $iTotalRow;?>)</a></li>
		</ul>
		<div class="show_rows" style="float:right">
			Show Rows
			<select id="row_selected" onchange="javascript:window.location.href='<?php echo Common::urlInclude('rows'); ?>'+ $('#row_selected').val();">
				<option <?php if($iRowPerPage == 10) {?>selected<?php } ?>>10</option>
				<option <?php if($iRowPerPage == 20) {?>selected<?php } ?>>20</option>
				<option <?php if($iRowPerPage == 50) {?>selected<?php } ?>>50</option>
			</select>
		</div>
	</div>
	<table cellpadding="0" cellspacing="0" border="0" class="post_table class_list">
		<colgroup>
			<col width="80px" />
			<col width="280px" />
			<col width="*" />
			<col width="280px" />
			<col width="150px" />
			<col width="150px" />
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>Student</th>
				<th>Class Name</th>
				<th>Teacher</th>
				<th>Class Date</th>
				<th>Time</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if(count($posponedInfo)>=1){
		    foreach($posponedInfo as $key=>$value) { ?>
			<tr>
				<td><?php echo $value['iCount'];?></td>
				<td><a href="<?php echo BASE_URL.'admin/user/?user_id='.$value['user_id'].'&sub=modify_user';?>" title="Go to User Detail Page" ><?php echo ucwords(strtolower($value['full_name']));?> (<?php echo $value['user_name']; ?>) </a></li></td>
				<td><img src="../../images/class/<?php echo $value['type'];?>.png" title="<?php echo $value['type'];?> type" alt="type" style="width:18px;float:left;margin:5px;">
				<a href="<?php echo BASE_URL.'admin/class/?action=classScheduleCalendar&uid='.$value['user_id'].'&class_id='.$value['main_idx'];?>" title="Schedule Management" ><?php echo ucwords($value['classname']);?></a></td>
				<td><?php echo ($value['teacher_name']!="") ? ucwords($value['teacher_name']) : "None"; ?></td>
				<td><?php echo date("Y/m/d", strtotime($value['classdate'])); ?></td>
				<td><?php echo $value['time_start']." - ".$value['time_end']?></td>
			</tr>
		<?php }
		    } else {?>
		    <tr>
		        <td colspan="6">No records found.</td>
		    </tr>
		    <?php } ?>
		</tbody>
	</table>
	<input type="hidden" id="action" value="<?php echo $_GET['action'];?>">
	<div class="bottom_2">
        <?php echo Common::paginate($iCurPage, $iRowPerPage, $iTotalRow); ?>
    </div>
</div>
