<!--menu-->
<?php echo Common::displayMenu(true);?>
<!--<input type="hidden" id="cur_page" value="<?php echo $iCurPage;?>" />-->

<!--user list-->
<div id="user_list_wrap" >

	
	<div class="search">
	
	<?php /*if(USER_GRADE == 9){?>
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
	<?php }*/?>
	
		<input type="text" value="<?php echo $sSearch;?>" id="keyword"/>
		<a href="#" class="btn_apply" onclick="javascript: window.location.href = '<?php echo Common::urlInclude('search'); ?>'+ $('#keyword').val();">Search</a>
		
	</div>
	
	<div class="top_2">
		
		<div class="show_rows">
			Show Rows
			<select id="per_page" onchange="javascript: window.location.href = '<?php BASE_URL; ?>?action=student_list&rows=' + $('#per_page').val();" >
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
			<col width="170px" />			
			<col width="170px" />			
			<col width="170px" />
			<col width="170px" />
			<col />	
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
				<td><input type="checkbox" name="checkbox[]" value="<?=$val['idx']?>" /></td>
				<td><?=(($iRowPerPage * ($iCurPage-1))+($key+1))?></td>
				<td><a href="javascript:window.location.href='<?php echo Common::urlInclude('user_id').$val['idx']; ?>&sub=modify_user'" ><img style="float:left;" src="<?=BASE_URL?>uploads/<?=$val['profile_img']?>" width="50px" height="50px" /><?=$val['user_id']?></a></td>
				<td><a href="javascript:window.location.href='<?php echo Common::urlInclude('user_id').$val['idx']; ?>&sub=modify_user'" ><?=ucwords($val['name'])?></a></td>
				<td><?=ucwords(Index::_getDataBy("tb_grade","grade_name"," grade_num = ".$val['grade_idx']))?></td>
				<td>----</td>
				<td><a href="#"><?=$val['phone_mob']?></a></td>
				<td><a href="#"><a  class="send_email" alt="<?=$val['email']?>" href="#" ><?=$val['email']?></a></td>
				<td><?=date("Y-m-d H:i:s", $val['date_reg'])?></td>
				
			</tr>
		<?php }?>
			<!-- end rows -->
		</tbody>
	</table>
	
		<?php echo Common::paginate($iCurPage, $iRowPerPage, $iRowTotRow);
		//$sData ='<p>rffggfgfggfgfgfgfgfgfgfg<img src="../../uploads/tinymce_fileuploads/1_1337839608_moli.jpg" alt="" /></p>';
		//$this->tinymce_return($sData);
		?>
	<?php } ?>	
</div>
