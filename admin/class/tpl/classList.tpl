<?php echo Common::displayMenu(true,array("label"=>"Create New Class","most_action"=>"classList.addClass"));?>

<!-- Content -->
<div class="wrap class_list_content">
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
    		<tr> <!-- search branch -->
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
			<li class="<?php if($view == null){ ?>active<?php } ?> all"><a href="<?php echo Common::urlInclude('view');?>">All (<?php echo $all;?>)</a></li>
			<li class="<?php if($view=="only_applied"){ ?>active<?php } ?>"><span class="statTab" style="margin-right:2px;background:#FDFF72;"></span><a href="<?php echo Common::urlInclude('view');?>only_applied">Only Applied (<?php echo $only_applied;?>)</a></li>
			<li class="<?php if($view=="scheduled"){ ?>active<?php } ?>"><span class="statTab" style="margin-right:2px;background:#DDF5D5"></span><a href="<?php echo Common::urlInclude('view');?>scheduled">Scheduled (<?php echo $scheduled;?>)</a></li>
			<li class="<?php if($view=="finished"){ ?>active<?php } ?>"><span class="statTab" style="margin-right:2px;background:#CB8AFF"></span><a href="<?php echo Common::urlInclude('view');?>finished">Finished (<?php echo $finished;?>)</a></li>
		    <li class="<?php if($view=="deleted"){ ?>active<?php } ?>"><span class="statTab" style="margin-right:2px;background:#C5C5C5"></span><a href="<?php echo Common::urlInclude('view');?>deleted">Deleted (<?php echo $deleted;?>)</a></li>
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

	<?php if($view !="deleted" && count($studentInfo) != 0) {?>
	<div class="apply_action"  style="margin-bottom:10px;">
		<a href="javascript:void(0);" class="btn_apply class_del" id="class_del" name="class_del">Delete</a>
	</div>
    <?php }?>

	<table cellspacing="0" border="0" cellpadding="0" class="post_table class_list">
		<colgroup>
			<col width="4%" />
			<col width="15%" />
			<col width="15%" />
			<col width="17%" />
			<col width="14%" />
			<col width="14%" />
			<col width="12%" />
			<col width="12%" />
		</colgroup>
		<thead>
			<th><?php if($view !="deleted" && count($studentInfo) != 0){ ?><input type="checkbox" class="check_all" id="check_all"/>&nbsp;<?php } ?>No</th>
			<th>Class Entry</th>
			<th>Student Info</th>
			<th>Class Info</th>
			<th>Status</th>
			<th>Payment</th>
			<th>Management</th>
			<th><?php if($view=="deleted"){?>Date Deleted<?php } else {?>Registration<?php }?></th>
		</thead>
		<tbody>
		<?php
		if(count($studentInfo)>=1){
		    foreach($studentInfo as $key=>$value) { ?>
			<tr>
				<td><p><?php echo $value['iCount'];?></p><?php if($view !="deleted"){ ?><input type="checkbox" name="checkbox_class" value="<?php echo $value['main_idx'];?>"/><?php } ?></td>
				<td>
					<ul class="table_entry <?php echo $value['color']; ?>">
					    <li><strong>Application No.</strong><?php echo $value['appno']; ?></li>
						<li><strong>User ID</strong><a href="<?php echo BASE_URL.'admin/user/?user_id='.$value['user_id'].'&sub=modify_user';?>" title="Go to User User Detail Page" ><?php echo $value['user_name'];?></a></li>
						<li><strong>Branch</strong><?php echo $value['branchname']; ?></li>
                	    <li><strong>Teacher</strong><?php echo $value['teacher_name'];?></li>
					</ul>
				</td>
				<td>
					<ul class="table_entry <?php echo $value['color']; ?>">
						<li><strong>Name</strong><a href="<?php echo BASE_URL.'admin/user/?user_id='.$value['user_id'].'&sub=modify_user';?>" title="Go to User User Detail Page" ><?php echo ucwords(strtolower($value['full_name']));?></a></li>
						<li><strong>Nick Name</strong><?php echo ucwords(strtolower($value['nickname']));?></li>
						<?php if($value['cell']!=null && $value['cell']!="--" && $value['cell']!=""){?>
						    <li><strong>Cellphone</strong><a href="javascript:void(0);" class="mobile_id"><?php echo $value['cell'];?></a></li>
						<?php } else if($value['tel']!=null && $value['tel']!="--" && $value['tel']!="") {?>
						    <li><strong>Telephone</strong><a href="javascript:void(0);" class="mobile_id"><?php echo $value['tel'];?></a></li>
						<?php } else { ?>
						    <li><strong>Cellphone</strong>(No contact number)</li>
						<?php }?>
						<li><strong>Email Address</strong><a href="javascript:classList.sendMail('<?php echo $value['email'];?>');"><?php echo $value['email'];?></a></li>
					</ul>
				</td>
				<td>
					<ul class="table_entry <?php echo $value['color']; ?>">
						<li><strong>Class Name</strong>
						<img src="../../images/class/<?php echo $value['type'];?>.png" title="<?php echo $value['type'];?> type" alt="type" style="width:18px;float:left;margin:5px;">
						<?php echo ucwords($value['classname']);?></li>
					</ul>
				</td>
				<td>
					<ul class="table_entry <?php echo $value['color']; ?>">
					<?php if($value['class_status'] == "scheduled" || $value['class_status'] == "finished" || ($value['class_status'] == "deleted" && $value['class_days']!="")) {?>
						<li><strong>Start Date</strong><?php echo date("F j, Y", strtotime($value['startdate']));?><br/>(<?php echo $value['time_start']." - ".$value['time_end'];?>)</li>
						<li><strong>Class Day</strong><?php if($value['class_days']!=""){ echo $value['class_days']; } else { echo "None";}?></li>
						<li><strong>Status</strong><?php echo ucwords(str_replace("_", " ", $value['class_status']));?></li>
						<?php }
						else {?>
						    <li><strong><?php echo ucwords(str_replace("_", " ", $value['class_status'])); ?></strong></li>
						<?php } ?>
					</ul>
				</td>
				<td>
					<ul class="table_entry <?php echo $value['color']; ?>">
						<li><strong>Payment Method</strong><a href="javascript:classList.goDetailed('1','<?php echo $value['main_idx']."','".$value['class_status']."'"; ?>);" title="Go to User Detail Page" ><?php echo ucwords(strtolower($value['payment_method']));?></a></li>
						<?php
					        $sPerc = $this->query('SELECT ((SUM(amount) *(0.01)) * ('.$value['total_price'].')) + ('.$value['total_price'].') AS sum_percent FROM tb_product_discount WHERE type="percent" AND idx IN('.$value['discount'].')');
					        $sAmnt = $this->query('SELECT SUM(amount) AS sum_amount FROM tb_product_discount WHERE type="amount" AND idx IN('.$value['discount'].')');
						    $sTotalQ = $sPerc[0]['sum_percent'] + $sAmnt[0]['sum_amount'];
                            $aAnswer = $this->query('SELECT FORMAT(ROUND('.$sTotalQ.',2),2) AS amount FROM DUAL');
							?>
						<li><strong>Amount</strong>$<?php echo $aAnswer[0]['amount'];?></li>
						<li><strong>Status</strong><a href="javascript:classList.goDetailed('1','<?php echo $value['main_idx']."','".$value['class_status']."'"; ?>);" title="Go to Payment Detail Page" ><?php echo ucwords(str_replace("_", " ", $value['sale_status']));?></a></li>
					</ul>
				</td>
				<td>
					<ul class="management_control">
						<li><a class="btn_management" href="javascript:void(0);" onclick="common.advise_option('<?php echo $value['user_id']?>');" title="Advise Popup" >A</a></li>
						<li><a class="btn_management" href="javascript:void(0);" onclick="common.ulearning_assign('<?php echo $value['user_name']?>');" title="uLearning Popup" >U</a></li>
						<li><a class="btn_management" href="javascript:classList.goDetailed('0','<?php echo $value['user_id']."','".$value['class_status']."'"; ?>);" title="Add New Class" >C</a></li>
						<li><a class="btn_management" href="javascript:classList.goDetailed('1','<?php echo $value['main_idx']."','".$value['class_status']."'"; ?>);" title="Detail Class Information" >D</a></li>
                        <?php if($value['class_status'] == "only_applied"){ ?>
							 <li><a class="btn_management" href="javascript:void(0);" onclick="common.class_schedule('<?php echo $value['user_id']."&class=".$value['main_idx']; ?>')" title="Schedule Management" >S</a></li>
                       	<?php } else {?>
                       		 <li><a class="btn_management" href="javascript:classList.classScheduleCalendar(<?php echo $value['user_id'].",".$value['main_idx']; ?>);" title="Schedule Management" >S</a></li>
                       	<?php }?>
                        <li><a class="btn_management" href="javascript:classList.testSchedule(<?php echo $value['user_id']; ?>);" title="Level Test Popup">L</a></li>
					</ul>
				</td>
				<td><?php $date = ($view!="deleted") ? 'datetime_created' : 'datetime_deleted'; echo date('Y/m/d h:i',$value[$date]); ?>
                    <p class="rest_class<?php if($value['check_classes'] == "red_class") {echo " red_c";}?>">
                        <?php if($value['rest_classes'] == 0) {echo ""; }
                        else if($value['rest_classes'] >=1){ echo $value['rest_classes']." Class"; if($value['rest_classes'] >=2){ echo "es"; } echo " Remaining"; } ?>
                    </p>
				</td>
			</tr>
			<?php
		        }
		    } else {?>
		    <tr>
		        <td colspan="8">No records found.</td>
		    </tr>
		    <?php } ?>
		</tbody>
	</table>

	<input type="hidden" id="total_list" name="total_list" value="<?php echo count($studentInfo);?>">
    <input type="hidden" id="delete_btn" name="delete_btn" class="view_type" value="<?php echo $view;?>">
    <input type="hidden" id="page_number" name="page_number" value="<?php echo $iCurPage;?>">

	<div class="popup_window" style="display:none" id="popup_delete" name="popup_delete">
    	<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
    		<tr>
    			<th>Are you sure you want to delete these?</th>
    		</tr>
    	</table>
    	<div class="action_btn">
    	    <a href="javascript:void(0);" class="btn_save fr" style="margin-left:10px;" title="Delete" id="delete_del">Delete</a>&nbsp;
    		<a href="javascript:void(0);" class="btn_save fr" style="margin-left:10px;" title="Cancel" id="cancel_del">Cancel</a>&nbsp;
    	</div>
    </div>

    <?php if($view !="deleted" && count($studentInfo) != 0) {?>
	<div class="bottom">
		<div class="apply_action">
			<a href="javascript:void(0);" class="btn_apply class_del" id="class_del" name="class_del">Delete</a>
		</div>
	</div>
    <?php }?>

	<div class="bottom_2">
        <?php echo Common::paginate($iCurPage, $iRowPerPage, $iTotalRow); ?>
    </div>
</div>