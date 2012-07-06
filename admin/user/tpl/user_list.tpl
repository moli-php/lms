<!--menu-->
<?php echo Common::displayMenu(true,array("label"=>"Add New User","most_action"=>"User.view_adduser"));?>
<input type="hidden" id="cur_page" value="<?php echo $iCurPage;?>" />

<!--user list-->
<div id="user_list_wrap" >
	<ul class="sort_view">
		<li class="active all"><a href="<?=BASE_URL?>admin/user/?action=user_list&type_search=all" >All (<?=$iStatRowTotRow?>)</a></li>
		<li><a href="<?=BASE_URL?>admin/user/?action=user_list&type_search=1">Student (<?=$iStatRowTotStud?>)</a></li>
		<li><a href="<?=BASE_URL?>admin/user/?action=user_list&type_search=6">Teacher (<?=$iStatRowTotTeac?>)</a></li>
		<li><a href="<?=BASE_URL?>admin/user/?action=user_list&type_search=7">Head Teacher (<?=$iStatRowTotHeadTeac?>)</a></li>
		<li><a href="<?=BASE_URL?>admin/user/?action=user_list&type_search=8">Branch (<?=$iStatRowTotBranch?>)</a></li>
	</ul>
	
	<div class="search">
	
	<?php if(USER_GRADE == 9){?>
		<select name="search_branch_type" id="search_branch_type" onchange="javascript: window.location.href = '<?php BASE_URL; ?>?action=user_list&branch_search=' + $('#search_branch_type').val();"  >
			<option <?php if(isset($aArgs['branch_search']) && $aArgs['branch_search'] == "none"){echo "selected";} ?>value="none">-select branch-</option>
			<!--options for branches-->
			<?php
				foreach(Index::_getDataBy("tb_user",null," grade_idx = 8",true) as $key=>$val){
					$sSelected = (isset($sBranch_search) && $sBranch_search == $val['idx'])?"selected":'';
					echo '<option '.$sSelected.' value="'.$val['idx'].'">'.$val['user_id'].'</option>';
				}
			?>
			<!--end options for branches-->
		</select>
	<?php }?>
	
		<input type="text" value="<?php echo $sSearch;?>" id="keyword"/>
		<a href="#" class="btn_apply" onclick="javascript: window.location.href = '<?php BASE_URL; ?>?action=user_list&search='+ $('#keyword').val();">Search</a>
		
	</div>
	
	<div class="top_2">
		<div class="apply_action">
			<a href="javascript:User.prep_delete('tb_user');" class="btn_apply">Delete</a>
		</div>
		<div class="show_rows">
			Show Rows
			<select id="per_page" onchange="javascript: window.location.href = '<?php BASE_URL; ?>?action=user_list&rows=' + $('#per_page').val();" >
				<option <?php if($iRowPerPage == 10){echo "selected";} ?>>10</option>
				<option <?php if($iRowPerPage == 20){echo "selected";} ?>>20</option>
				<option <?php if($iRowPerPage == 50){echo "selected";} ?> >50</option>
			</select>
		</div>
	</div>
	
	<table cellspacing="0" class="post_table">
		<colgroup>
			<col width="40px" />
			<col width="40px" />
			<col width="170px" />	
			<col  />			
			<col width="150px" />			
			<col  />
			<col width="150px" />
			<col  />	
			<col width="170px" />
			<col  />
		</colgroup>
		<thead>
			<tr>
				<th><input type="checkbox" class="check_all" /></th>
				<th>No</th>
				<th><a href="#" class="sort_down">User ID</a></th>
				<th><a href="#" class="">Name</a></th>
				<th><a href="#" class="sort_down">Grade</a></th>
				<th><a href="#" class="">Teacher</a></th>
				<th>Phone#</th>
				<th>Email Address</th>
				<th><a href="#" class="sort_down">Join Date</a></th>
				<th><a href="#" class="">Management</a></th>
			</tr>
		</thead>
		<tbody>
			<!-- rows -->
			<?php 
				if(empty($aTbData)){
					echo "<tr><td colspan='10' >No record(s) found</td></tr>";
					echo "</tbody></table>";
				}else{
				foreach($aTbData as $key=>$val){
			?>
			<tr>
				<td>
				<input type="checkbox" name="checkbox[]" value="<?=$val['idx']?>" />
				</td>
				<td><?=(($iRowPerPage * ($iCurPage-1))+($key+1))?></td>
				<td><a href="javascript:window.location.href='<?php echo Index::urlIncluded('user_id').$val['idx']; ?>&sub=modify_user'" ><?=$val['user_id']?></a></td>
				<td><a href="javascript:window.location.href='<?php echo Index::urlIncluded('user_id').$val['idx']; ?>&sub=modify_user'" ><?=ucwords($val['name'])?></a></td>
				<td><?=ucwords(Index::_getDataBy("tb_grade","grade_name"," grade_num = ".$val['grade_idx']))?></td>
				<td><?php 
						if($val['grade_idx'] == 1){
							$aTeacherInfo = $this->select("tb_class_ext",'',"student_idx =".$val['idx'])->execute();
							
							if(!empty($aTeacherInfo)){
								foreach($aTeacherInfo as $key2=>$val2){
									$sTeacher = Index::_getDataBy("tb_user","name"," idx = ".$val2['teacher_idx']);
									echo (empty($sTeacher))?"<p style='color:gray;' >N/A </p>":"<p>Class(".$val2['class_idx'].") : ".ucwords($sTeacher)."</p>";
								}
							}else{
								echo "<p style='color:gray;'>No class enrolled</p>";
							}
						}else{
							echo "<p style='color:gray;'>N/A</p>";
						}
					?>
				</td>
				<td><a href="#" class="mobile_id" ><?=$val['phone_mob']?></a></td>
				<td><a href="#"><a  class="send_email" alt="<?=$val['email']?>" href="#" ><?=$val['email']?></a></td>
				<td><?=date("Y-m-d H:i:s", $val['date_reg'])?></td>
				<td class="options" style="border-right:1px solid #DEDEDE;">
					<ul class="option_btns">
						<li><a class="btn_management" href="javascript:common.advise_option(<?=$val['idx']?>);" title="Advise">A</a></li>
						<li><a class="btn_management" href="javascript:common.ulearning_assign('<?=$val['user_id']?>');" title="uLearning">U</a></li>
						<li><a class="btn_management" <?php if($val['grade_idx'] != 1){?> onclick="User.warning('User <?=$val['user_id']?> is not a student');return false;" <?php } ?>  href="<?=BASE_URL?>admin/class/?action=classManageList&uid=<?=$val['idx']?>" title="Add New Class Page">C</a></li>
					</ul>
				</td>
			</tr>
		<?php }?>
			<!-- end rows -->
		</tbody>
	</table>
	
	<div class="bottom">
		<div class="apply_action">
			<a href="javascript:User.prep_delete('tb_user');" class="btn_apply">Delete</a>
		</div>
	</div>
		<?php echo Common::paginate($iCurPage, $iRowPerPage, $iRowTotRow);?>
	<?php } ?>	
</div>

<!--confirm box-->
<div id="dialog-confirm" title="Confirm" style="display:none;">
    <p>All record(s) for this user(s) will also be removed.</p><br />
	<p><b> Are you sure you want to remove user(s) info?</b></p>
</div>