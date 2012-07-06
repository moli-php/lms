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
    			<td colspan="3"><input type="text" class="fix4" id="search_id" name="search_id" value="<?php echo $name;?>" maxlength=20/></td>
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

		<a href="javascript:void(0);" class="btn_go" id="btn_lterm" name="btn_lterm">Add New Long Term Schedule</a>
		<a href="javascript:void(0);" class="btn_go" id="btn_point" name="btn_point">Change Rest of Class to Point</a>

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
		if(count($longTerm)>=1){
		    foreach($longTerm as $key=>$value){ ?>
			<tr>
				<td><?php echo $value['iCount'];?></td>
				<td><a href="<?php echo BASE_URL.'admin/user/?user_id='.$value['user_id'].'&sub=modify_user';?>" title="Go to User Detail Page" ><?php echo ucwords(strtolower($value['full_name']));?> (<?php echo $value['user_name']; ?>) </a></li></td>
				<td><img src="../../images/class/<?php echo $value['type'];?>.png" title="<?php echo $value['type'];?> type" alt="type" style="width:18px;float:left;margin:5px;">
				<a href="<?php echo BASE_URL.'admin/class/?action=classManageList&cid='.$value['main_idx'];?>" title="Go to Class Detail Page" ><?php echo ucwords($value['classname']);?></a></td>
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

	<input type="hidden" value="" id="start_date_wait" name="start_date_wait">
	<input type="hidden" value="" id="last_date_wait" name="last_date_wait">
	<input type="hidden" value="" id="teacher_id" name="teacher_id">
	<input type="hidden" value="" id="class_months" name="class_months">

	<div class="bottom_2">
        <?php echo Common::paginate($iCurPage, $iRowPerPage, $iTotalRow); ?>
    </div>
</div>

<!-- pop ups -->
<div class="popup_window" id="find_userid" name="find_userid" style="display:none;">
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup" style="width:100%;">
        <tr>
            <th><input type="text" maxlength=10 value="" id="userid_check" name="userid_check"  style="width:100%;"/></th>
        </tr>
        <tr>
            <td><span id="userid_not_found" name="userid_not_found" class="not_found">&nbsp;</td>
        </tr>
	</table>
	<a href="javascript:void(0);" class="btn_save fr" id="submit_find_userid" name="submit_find_userid" title="Save changes">Submit</a>
</div>

<div class="popup_window add_class_list" id="result_userid" name="result_userid" style="display:none;">
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup" style="width:100%;">
		<tr><td>User ID found:<span class="user_id" id="userid_found" name="userid_found"></span></td></tr>
		<tr><td>Is this correct?</td></tr>
	</table>
	<a href="javascript:void(0);" class="btn_save fr" title="Save changes" id="submit_result_userid">Submit</a>
</div>

<div class="popup_window class_list_popup" style="display:none;padding:0 40px 30px 40px !important;" id="add_lterm" name="add_lterm">
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
	    <tr align="left"><td colspan = 2><b><span class="not_found" name="lterm_notfound" id="lterm_notfound"></span></b></td></tr>
        <tr align="left">
            <td>ID</td>
            <td><input type="text" maxlength=10 value="" readonly class="fix2 user_id" id="userid_lterm" name="userid_lterm" style="width:220px !important;margin-left:10px"/><td>
            <td><a href="javascript:void(0);" class="btn_apply verify_id" id="btn_verify_lterm" name="btn_verify_lterm">Verify ID</a></td>
        </tr>
        <tr align="left">
            <td>Choose Class</td>
            <td style="margin:0 0 0 10px;" colspan = 2><select class="select_class" name="select_lterm" style="max-width:220px;width:220px"></select></td>
        </tr>
        <tr align="left">
            <td>Start Date</td>
            <td style="margin:0 0 0 18px;" colspan = 2><input type="text" id="startdate_lterm" name="startdate_lterm" value="" style="margin:0 0 0 10px;" /></td>
        </tr>
        <tr align="left" class="waiting_pt">
            <td>Class Day : </td><td style="margin:0 0 0 18px;" colspan = 2><span class="pt_info_class_days"></span></td>
        </tr>
    </table>

    <div class="info_lterm" style="float:left;width:325px;">
        <div class="waiting_pt" style="float:left;font-size:11px;color:#DC4E22">
                Waiting Class List<br/>
                <textarea id="textarea_lterm" readonly name="textarea_lterm" style="max-width:147px;width:147px;max-height:150px;height:150px;margin-right:10px;"></textarea>
                <br/>Remaining Class : <span class="pt_info_remaining"></span>
                <br/>Time : <span class="pt_info_stime"></span>-<span class="pt_info_etime"></span>
        </div>

        <span class="schedule_calendar_popup" style="font-size:11px;color:#DC4E22;display:none;">Preview New Schedule</span><br/>
        <div class="schedule_calendar_popup" style="border:1px solid #ABADB3;width:147px;padding:5px;display:none;float:left;margin:0px;">
    		<ul class="control"></ul>
    		<table cellpadding="0" border="0" cellspacing="1" name="calendar">
    			<colgroup>
    				<col width="20px" />
    				<col width="20px" />
    				<col width="20px" />
    				<col width="20px" />
    				<col width="20px" />
    				<col width="20px" />
    				<col width="20px" />
    			</colgroup>
    			<thead>
    				<tr>
    					<th><span title="Sunday">Su</span></th>
    					<th><span title="Monday">Mo</span></th>
    					<th><span title="Tuesday">Tu</span></th>
    					<th><span title="Wednesday">We</span></th>
    					<th><span title="Thursday">Th</span></th>
    					<th><span title="Friday">Fr</span></th>
    					<th class="ui-datepicker-week-end"><span title="Saturday">Sa</span></th>
    				</tr>
    			</thead>
    			<tbody class="days">
    			</tbody>
    		</table>
    	</div>
	</div>
	<div class="action_btn">
		<a href="javascript:void(0);" class="btn_save fr" title="Save changes" style="margin-right:-40px" id="submit_lterm" name="submit_lterm">Submit</a>
	</div>
</div>

<div class="popup_window class_list_popup" style="display:none;padding:0 40px 30px 40px !important;" id="add_point" name="add_point">
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
        <tr align="left"><td colspan = 2><b><span class="not_found" name="point_notfound" id="point_notfound"></span></b></td></tr>
        <tr align="left">
            <td>ID <input type="text" readonly maxlength=10 value="" class="fix2 user_id" id="userid_point" name="userid_point" style="width:220px !important;margin-left:10px"/><td>
            <td><a href="javascript:void(0);" class="btn_apply verify_id" id="btn_verify_point" name="btn_verify_point">Verify ID</a></td>
        </tr>
        <tr align="left">
            <td>Choose Class</td>
            <td style="margin:0 0 0 18px;"><select class="search_class select_class" name="select_point" style="max-width:220px;width:220px"></select></td>
        </tr>
        <tr align="left"><td colspan = 2 style="margin:0 18 0 0px;">Count of rest of Classes : <span class="value" id="rest_class" name="rest_class"></span></td></tr>
        <tr align="left"><td>Point </td><td style="margin:0 0 0 50px;"><input type="text" value="" class="fix2" id="point_check" name="point_check" style="width:220px !important;margin-left:10px" maxlength = 10/></td></tr>

	</table>
	<div class="action_btn">
		<a href="javascript:void(0);" class="btn_save fr" style="margin-right:-40px" title="Save changes" id="submit_point" name="submit_point">Submit</a>
	</div>
</div>


