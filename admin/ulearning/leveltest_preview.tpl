<?php echo Common::displayMenu(true,array("label"=>"Add Level Test (Preview)","most_action"=>"leveltest_preview.open"));?>
<div>
	<div class="top_2">
		<div class="apply_action">
			<!--<select style="width:50px">
				<option> Title </option>
			</select>-->Search Title
			<input type="text" value="" class="fix2 search_field" />
			<a href="javascript:window.location.href='<?php Common::urlInclude('search'); ?>' + $('.search_field').val();" class="btn_apply" >Search</a>
			<a href="javascript:window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=leveltest_preview'" class="btn_apply">Total</a>
		</div>
	</div> <br /> <br />
		<div class="sidebar">
			<div class="category">
				<h3>Class Level Test</h3>
				<ul>
					<?php
					foreach($depth1 as $key => $val):
						if(empty($val['fdepth2'])){
							echo "<li>
								<a href='javascript:leveltest_preview_accordion($key)' class='link'><span class='plus$key'>+</span> ".$val['fcategory_name']."</a>
								<a href='javascript:void(0)' class='count'>(".$val['count'].")</a>
							</li>";
							foreach($depth1 as $k => $v):
								if(!empty($v['fdepth2']) && $v['fdepth2'] == $val['fcategory_id'])
									echo "<li class='sub_leveltest_preview$key' style='display:none'>
										&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='link'>- ".$v['fcategory_name']."</a>
										<a href='javascript:void(0)' class='count'>(".$v['count2'].")</a>
									</li>";
							endforeach;
						}
					endforeach;
					?>
				</ul>
			</div>
		</div> <!-- end of sidebar -->
		<div id="content">
			<table class="data_list"  border="0" cellspacing="0" cellpadding="0">
				<colgroup>
					<col width="40px" />
					<col width="100px" />	
					<col width="150px" />
					<col />	
					<col width="40" />
					<col width="100px" />
					<col width="100px" />
				</colgroup>
				<tr>
					<th class="number">No</th>
					<th class="categoryname">Category</th>
					<th class="coursename">Course</th>
					<th class="title">Title</th>
					<th class="slide_number">Slide #</th>
					<th class="view_slide">View</th>
					<th class="date">Date</th>
				</tr>
				<?php
					if($leveltest_preview){
						foreach($leveltest_preview as $key => $val):
							echo '<tr>
								<td class="number">'.$val['num'].'</td>
								<td class="categoryname">'.$val['category'].'</td>
								<td class="coursename">'.$val['course'].'</td>
								<td class="title"><a href="javascript:leveltest_preview.modify('.$val['funit_id'].',\''.$val['ftitle'].'\')">'.$val['ftitle'].'</a></td>
								<td class="slide_number">'.$val['slideCount'].'</td>
								<td class="view_slide">
									<a href="javascript:';
							if($val['slideCount'] == 0) echo 'Menu.message(\'warning\',\'No slide(s) to display\');';
							else
								echo 'preview_total_slides.view_slides('.$val['funit_id'].',0)';
							echo '" class="btn_go" title="Total Slide View Page">V</a>
									<a href="javascript:leveltest_preview.move('.$val['funit_id'].')" class="btn_go" title="Manage Slide">M</a>
									<a href="javascript:leveltest_preview.deleteOpenPopUp('.$val['funit_id'].')" class="btn_go" title="Delete">D</a>
								</td>
								<td class="date">'.date('F d, Y',$val['fdate']).'</td>
							</tr>';
						endforeach;
					}
					else
						echo "<tr><td colspan='7' style='text-align:center;padding:10px;'>No Result Found</td></tr>";
					?>
			</table>
			<?php echo Common::paginate($iCurrentPage, $iRowsPerPage, $iTotalRows); ?>
			<div class="popup_window deleteLevelPreviewPopUp" style="display:none;">
				<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
					<col width="275px" />
					<!--<tr><th class="popup_title">Delete Slide &raquo;</th></tr>
					<tr><td></td></tr>-->
					<tr>
						<th>Are you sure?</th>
					</tr>
				</table>
				<input type="hidden" name="delId"/>
				<div class="action_btn">
					<a href="javascript:void(0)" class="btn_save fr" title="Delete Data" onclick="leveltest_preview.remove()">Delete</a>
					<a href="javascript:void(0)" class="btn_save" title="Cancel" onclick="leveltest_preview.deleteClosePopUp()">Cancel</a>
					
				</div>
			</div>
			<div class="popup_window add_leveltest_preview" style="display:none;">
				<form name = "addLeveltest_preview">
				<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
					<col width="75px" />
					<col width="200px" />
					<!--<tr><th colspan="2" class="popup_title">Add Level test_preview &raquo;</th></tr>
					<tr><td colspan="2"></td></tr>-->
					<tr>
						<th>1 depth<span class="neccesary">*</span></th>
						<td>
							<select class="depth depth1" name="depth1"  onchange="leveltest_preview.depth1(this)" validate="required">
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
					<?php if($fbranch_idx == 1){?>
					<tr>
						<th>Branch<span class="neccesary">*</span></th>
						<td>
							<select class="depth branch" name="branch" validate="required">
								<option></option>
								<?php
									foreach($branch as $key => $val):
										echo "<option value='".$val['idx']."'>".$val['name']."</option>";
									endforeach
								?>
							</select>
						</td>
					</tr>
					<?php }?>
					<tr>
						<th>Title<span class="neccesary">*</span></th>
						<td><input type="text" name="title" maxlength="80" value="" class="fix2 leveltest_preview_title" validate="required"/></td>
					</tr>
				</table>
				<div class="action_btn">
					<a href="javascript:leveltest_preview.save()" class="btn_save fr" title="Save changes">Submit</a>
					<a href="javascript:leveltest_preview.close();" class="btn_save" title="Cancel">Cancel</a>
				</div>
				
			</div>
			<div class="popup_window modify_leveltest_preview" style="display:none;">
				<form name = "modifyTitle">
					<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
						<col width="250px" />
						<!--<tr><th colspan="2" class="popup_title">Modify Title &raquo;</th></tr>-->
						<tr>
							<th colspan="2"><input type="text" name="title_modify" maxlength="100" class="fix3 leveltest_preview_title_modify" validate="required" /><input type="hidden" class=" leveltest_preview_id_modify" /> </th>
						</tr>
					</table>
				</form>	
					<div class="action_btn">
						<a href="javascript:leveltest_preview.modifySave()" class="btn_save fr" title="Save changes">Submit</a>
						<a href="javascript:leveltest_preview.modifyClose()" class="btn_save" title="Cancel">Cancel</a>
						
					</div>
				
			</div>
		</div>
	</div>
</div>