
<!--menu-->
<?php echo Common::displayMenu(true,array("label"=>"Add New Grade","most_action"=>"User.view_addgrade"));?>

	<input type="hidden" name="user_type_count" id="user_type_count" value="<?=count($this->select("tb_grade")->execute())?>" />
	

	<table cellspacing="0" class="post_table">
		<colgroup>
			<col width="20px" />
			<col width="20px" />
			<col width="120px" />	
			<col width="120px" />	
			<col width="120px" />	
		</colgroup>
		<thead>
			<tr>
				<th><input type="checkbox" class="check_all" /></th>
				<th>No.</th>
				<th ><a href="#" class="sort_down">Grade Name</a></th>
				<th><a href="#" class="sort_down">Grade Number</a></th>
				<th><a href="#" class="sort_down">Regdate</a></th>
			</tr>
		</thead>
		<tbody >
		
		<!--table rows-->
		<?php foreach($aTbData as $key=>$val){?>
			<tr>
				<td>
				
				<?php if($val['fix_flag'] == 1){ ?>
					<img src="<?=BASE_URL?>images/icons/icons/chain--arrow.png" />
				<?php }else{?>
					<input type="checkbox" name="checkbox[]" value="<?=$val['idx']?>" />
				<?php } ?>
				</td>
				<td><?=($key +1)?></td>
				<td><a href="javascript:User.view_modgrade(<?=$val['idx']?>)"><?=ucwords($val['grade_name'])?></a></td>
				<td><?=$val['grade_num']?></td>
				<td><?=date("Y-m-d H:i:s", $val['date_reg'])?></td>
			</tr>
		<?php } ?>
			
		</tbody>
	</table>
	<div class="bottom">
		<div class="apply_action">
			<a href="javascript:User.delete_list('tb_grade');" class="btn_apply">Delete</a>
		</div>
	</div>
	
	
	<!--hidden popups-->
	<!--add-->
	<div id="add_grade_popup" class="popup_window" style="display:none;">
	<div class="grade_error_con" ></div>
	<form method="POST" id="userAddGrade" name="userAddGrade"  >
		<input type="hidden" value="add" name="submited" />
		<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
			<col width="80px" />
		
			<tr>
				<th class="strong">Name: </th>
				<td><input type="text" name="grade_name" maxlength="100"  class="grade_name" /> </td>
			</tr>
			<tr>
				<th class="strong">Number: </th>
				<td>
					<select name="grade_num" class="grade_num" style="width:115px">
					
					<?php 
						for($x=1;$x <= 9; $x++){ 
							if(count($this->select("tb_grade",null," grade_num =".$x)->execute()) == 0){
								echo '<option>'.$x.'</option>';
							}
						 } 
					 ?>
				
					</select> 
				</td>
			</tr>
		</table>
		<div class="action_btn" style="width:100%;height:10px;padding:0;margin-top:10px;border-top:1px solid gray;">
			<button style="margin-top:10px;float:right;"  class="btn_save" id="submit_add_grade" >Submit</button>
		</div>
		</form>
	</div>
	
	<!--modify-->
	<div id="mod_grade_popup" class="popup_window" style="display:none;">
	<form method="POST" id="userModGrade" name="userModGrade"  >
		<input type="hidden" value="mod" name="submited" />
		<input type="hidden"  name="mod_grade_idx" id="mod_grade_idx" />
		<input type="hidden"  name="mod_grade_datereg" id="mod_grade_datereg" />
		
		<table border="0" cellspacing="0" cellpadding="0" class="table_popup" >
			<col width="80px" />
		
			<tr>
				<th class="strong">Name: </th>
				<td><input type="text" name="mod_grade_name" maxlength="100"  class="mod_grade_name"  /> </td>
			</tr>
			<tr>
				<th class="strong">Number: </th>
				<td class="mod_grade_num_wrap" >
					<select name="mod_grade_num" class="mod_grade_num" style="width:115px">
					
					<?php 
						for($x=1;$x <= 9; $x++){ 
							if(count($this->select("tb_grade",null," grade_num =".$x)->execute()) == 0){
								echo '<option>'.$x.'</option>';
							}
						 } 
					 ?>
					
					</select> 
				</td>
			</tr>
			<tr><td class="mod_grade_error_con" colspan="4" ></td></tr>
		</table>
		<div  style="width:100%;height:10px;padding:0;margin-top:10px;border-top:1px solid gray;">
			<button style="margin-top:10px;float:right;" class="btn_save"  id="submit_mod_grade" >Submit</button>
		</div>
		</form>
	</div>