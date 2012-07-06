<?php __include('header'); ?>
<?php echo Common::displayMenu(true,array("label"=>"Add New Category","most_action"=>"category.open"));?>
<div>
	<div id="content">
		<div id="firstpane" class="menu_accordion">
			<?php
				foreach($category as $key => $val):
					echo '<div><p class="menu_1stdepth">'.$val['fcategory_name'].'</p>';
						foreach($category[$key]['depth1'] as $k => $v):
							echo '<div><div class="menu_2nddepth" style="display:none">
								<div><p style="cursor:pointer">'.$v['fcategory_name'].'</p>
									<span class="controller">
										<a href="javascript:category.modify('.$v['fcategory_id'].',\''.$v['fcategory_name'].'\')">M</a>
										<a href="javascript:category.deleteOpenPopUp('.$v['fcategory_id'].')">D</a>
									</span>
								</div><div>';
								
								foreach($category[$key]['depth1'][$k]['depth2'] as $i => $j):
									echo '<div class="menu_3rddepth" style="display:none">
										<p>'.$j['fcategory_name'].'</p>
										<span class="controller">
										<a href="javascript:category.modify('.$j['fcategory_id'].',\''.$j['fcategory_name'].'\')">M</a>
										<a href="javascript:category.deleteOpenPopUp('.$j['fcategory_id'].')">D</a>
									</span>
									</div>';
								endforeach;
							echo '</div></div></div>';
						endforeach;
					echo "</div>";
				endforeach;
			?>
		</div>
		<div class="popup_window new_category_pop" style="display:none;">
			<form class="category_form_add">
			<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
				<col width="75px" />
				<col width="200px" />
				<!--<tr><th colspan="2" class="popup_title">Add New Category &raquo;</th></tr>
				<tr><td colspan="2"></td></tr>-->
				<tr>
					<th>1 depth<span class="neccesary">*</span></th>
					<td>
						<select class="depth depth1" name="depth1" onchange="category.depth1(this)" validate="required">
							<option></option>
							<?php
								foreach($depth1 as $key => $val):
									if(empty($val['fdepth2'])){
										echo "<option value='".$val['fcategory_id']."'>".$val['fcategory_name']."</option>";
									}
								endforeach
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th>2 depth<span class="neccesary">*</span></th>
					<td>
						<select class="depth depth2" name="depth2" validate="required">
							<option></option>
						</select>
					</td>
				</tr>
				
				<tr>
					<th>Name<span class="neccesary">*</span></th>
					<td><input type="text" name="title" maxlength="80" value="" class="fix2 category_name" validate="required" /></td>
				</tr>
			</table>
			<div class="action_btn">
				
				<a href="javascript:void(0)" class="btn_save fr" title="Save changes" onclick="category.save()">Submit</a>
				<a href="javascript:void(0)" class="btn_save" title="Cancel" onclick="category.close()">Cancel</a>
			</div>
			</form>
		</div>
		<div class="popup_window deleteCatPopUp" style="display:none;">
			<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
				<col width="275px" />
				<!--<tr><th class="popup_title">Delete Slide &raquo;</th></tr>
				<tr><td></td></tr>-->
				<tr>
					<th>Are you sure?</th>
				</tr>
			</table>
			<input type="hidden" name="delIdCat"/>
			<div class="action_btn">
				<a href="javascript:void(0)" class="btn_save fr" title="Delete Data" onclick="category.remove()">Delete</a>
				<a href="javascript:void(0)" class="btn_save" title="Cancel" onclick="category.deleteClosePopUp()">Cancel</a>
				
			</div>
		</div>
		<div class="popup_window modify_category_pop" style="display:none;">
			<form name="category_form_modify">
			<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
				<col width="250px" />
				<!--<tr><th colspan="2" class="popup_title">Modify Title &raquo;</th></tr>-->
				<tr>
					
					<th colspan="2"><label>Name</label>&nbsp;<input type="text" name="title" maxlength="100" value="" class="fix2 category_name_modify" validate="required" /><input type="hidden" class="category_id_modify" /> </th>
				</tr>
			</table>
			<div class="action_btn">
				<a href="javascript:void(0)" class="btn_save fr" title="Save changes" onclick="category.modifySave()">Submit</a>
				<a href="javascript:void(0)" class="btn_save" title="Cancel" onclick="category.modifyClose()">Cancel</a>
			</div>
			</form>
		</div>
	</div>
</div>
<?php __include('footer'); ?>