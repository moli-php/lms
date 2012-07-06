<?php __include('header'); ?>
<?php echo Common::displayMenu(true);?>
<div>
	<table border="0" cellspacing="0" cellpadding="0" class="sub_content">
		<tr>
			<th class="title" style="border-top:none;">Title</th>
			<th class="coursename">
				<?php echo $category_name;?>
				<div class="calltoaction">
					<a href="javascript:void(0)" class="btn_go" onclick="slide.deleteOpenPopUp()">Delete</a>
					<a href="javascript:void(0)" class="btn_go" onclick="slide.copyMoveSlidePopUp('copy','Copy Slide &raquo;')">Copy</a>
					<a href="javascript:void(0)" class="btn_go" onclick="slide.copyMoveSlidePopUp('move','Move Slide &raquo;')">Move</a>
				</div>
			</th>
			
		</tr>
		<tr>
			<td class="title">Slide List</td>
			<td class="slide_list">
				<?php 
				if($aSlide){
				?>
				<table border="0" cellspacing="0" cellpadding="0">
					<?php
					foreach($aSlide as $v){
						if($v['num'] % 5 == 1)
							echo "<tr>";
						?>
						<td>
						<p class="number"><?php echo $v['num']?></p>
						<div class="slide_content">
							<input type="checkbox" class="slideCheck" value="<?php echo $v['fslide_id']?>" />
							<p class="slide_title"><span>#<?php echo $v['fexam_type_id'];?></span> <?php echo $v['fslide_name'];?></p>
							<div class="slide_preview"></div>
							<a href="javascript:common.ulearning_preview_slide(<?php echo $v['fslide_id'];?>)" class="btn_apply">V</a>
						</div>
					</td>
						<?php
						if($v['num']%5==0)
						echo "</tr>";
					}
					?>
				</table>
				<?php }else{
					echo "<div style='margin:60px 0px 0px 300px;font-size:20px'>Please Add Slide</div>";
				}?>
			</td>
		</tr>
		<tr>
			<td class="title">Add</td>
			<td class="add_list">
				<table border="0" cellspacing="0" cellpadding="0">
					<?php
					foreach($exam_type as $v){
						if($v['num'] % 7 == 1)
							echo "<tr>";
						?>
						<td>
							<div class="slide_content">
								<p class="slide_title" onclick="slide.open(<?php echo $v['fexam_type_id'];?>)"><?php echo $v['ftype_name'];?></p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#<?php echo $v['num'];?></p><p class="layer_title2"><?php echo $v['falias'];?></p>
						</td>
						<?php
						if($v['num']%7==0)
						echo "</tr>";
					}
					?>
				</table>
			</td>
		</tr>
	</table>
	<div class="popup_window deleteSlidePopUp" style="display:none;">
		<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
			<col width="275px" />
			<!--<tr><th class="popup_title">Delete Slide &raquo;</th></tr>
			<tr><td></td></tr>-->
			<tr>
				<th>Are you sure?</th>
			</tr>
		</table>
		<div class="action_btn">
			<a href="javascript:void(0)" class="btn_save fr" title="Delete Data" onclick="slide.remove()">Delete</a>
			<a href="javascript:void(0)" class="btn_save" title="Cancel" onclick="slide.deleteClosePopUp()">Cancel</a>
			
		</div>
	</div>
	<div class="popup_window copyMoveSlidePopUp" style="display:none;">
		<form name="copyMoveForm">
			<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
				<col width="75px" />
				<col width="300px" />
				<tr><th colspan="2" class="popup_title"></th></tr>
				<tr><td colspan="2"><input type="hidden" name="act" /></td></tr>
				<tr>
					<th>1 depth</th>
					<td>
						<select class="depth depth1" name="depth1" onchange="slide.category()" validate="required">
							<option></option>
							<?php
								foreach($depth1 as $k => $v):
									echo "<option value='".$v['fcategory_id']."'>".$v['fcategory_name']."</option>";
								endforeach;
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th>2 depth</th>
					<td>
						<select class="depth depth2" name="depth2"  onchange="slide.depth1()" validate="required">
							<option></option>
						</select>
					</td>
				</tr>
				<tr>
					<th>3 depth</th>
					<td>
						<select class="depth depth3" name="depth3" onchange="slide.depth2()" validate="required">
							<option></option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Unit Title</th>
					<td><select class="depth unit" name="unit" validate="required"><option></option></select></td>
				</tr>
			</table>
			<div class="action_btn">
				<a href="javascript:void(0)" onclick="slide.copyMoveSave()" class="btn_save fr" title="Save changes">Submit</a>
				<!--<a href="javascript:void(0)" class="btn_save" title="Cancel" onclick="slide.copyMoveClosePopUp()">Cancel</a>-->
			</div>
		</form>
	</div>
	<div class="popup_window newSlidePopUp" style="width:785px;display:none;margin-top:100px;margin-left:23%;position:fixed;">
		<span class="handle">
		<div class="btn_close">
			<a class="popup_close" title="Close" href="javascript:slide.close()"></a>
		</div>
		<p class="required"><strong>Note:</strong> (<span class="neccesary">*</span>) = This is necessary field. Must input.</p>
		<h2 class="popup_title">Add New Slide &raquo;</h2>
		</span>
		<div class="popup_holder">
			<form name='addSlideNineTeenForm' enctype="multipart/form-data">
				<input type="hidden" name="funit_id" value='<?php echo $funit_id;?>'/>
				<input type="hidden" name="fexam_type_id" value=''/>
				<table border="0" cellspacing="0" cellpadding="0" class="ulearning">
					<colgroup>
						<col width="125px" />
						<col  />
					</colgroup>
					<tbody class="nineTeenHead">
						<tr>
							<th>Sequence <span class="neccesary">*</span></th>
							<td>
								<input type="text" validate="required|digits" value="" class="fix5" name="sequence" />
								<span class="prompt">You can use numeric word from 1 to 999. Small number slide will be shown first.</span>
							</td>
						</tr>
						<tr>
							<th>Slide Name <span class="neccesary">*</span></th>
							<td >
								<input type="text" validate="required" name="slide_name" maxlength="200" value="" class="fix6" onkeyup="slide.character(this,200)"/> <span class="character">0</span>/200 Byte (This name using for management)
							</td>
						</tr>
						<tr>
							<th>External Movie Clip</th>
							<td>
							
								<div class="holder">
									<label><span class="neccesary">*</span>1st Category:</label>
									<select validate="required" style="width:118px" name="cat1" onchange="slide.movie_cat2()">
										<option></option>
										<?php
										foreach($cat1 as $k => $v){
										?>
										<option value="<?php echo $v['movie_cat_id'];?>"><?php echo $v['movie_category'];?></option>
										<?php } ?>
									</select>
									
									<label style="margin-left:10px;"><span class="neccesary">*</span>2nd Category:</label>
									<select validate="required" style="width:118px" name="cat2"></select>
									
									<label style="margin-left:10px"><span class="neccesary">*</span>Movie Clip:</label>
									<select validate="required" style="width:118px" name="cat3"></select>
								</div>
								<span class="prompt">Choose category and Movie Clip</span>
							</td>
						</tr>
						
						<tr>
							<th class="last">Word Script</th>
							<td class="last">
							
								<div class="holder">
									<input class="fix6" id="trigger" type="text" value="" readOnly="readOnly" name="trigger" onclick="slide.fileTrigger('doc')"/>
									<input type="file" id="doc" style="display:none" name="doc" onchange="slide.fileSelect('trigger',this)"/>
									<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger('doc')"/>
								</div>
								<span class="prompt">You can upload <span>Word</span> file type.</span>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			<form name='addSlideTwentyForm' enctype="multipart/form-data">
				<input type="hidden" name="funit_id" value='<?php echo $funit_id;?>'/>
				<input type="hidden" name="fexam_type_id" value=''/>
				<table border="0" cellspacing="0" cellpadding="0" class="ulearning">
					<colgroup>
						<col width="125px" />
						<col  />
					</colgroup>
					<tbody class="twentyHead">
						<tr>
							<th>Sequence <span class="neccesary">*</span></th>
							<td>
								<input type="text" validate="required|digits" value="" class="fix5" name="sequence" />
								<span class="prompt">You can use numeric word from 1 to 999. Small number slide will be shown first.</span>
							</td>
						</tr>
						<tr>
							<th>Slide Name <span class="neccesary">*</span></th>
							<td >
								<input type="text" validate="required" name="slide_name" maxlength="200" value="" class="fix6" onkeyup="slide.character(this,200)"/> <span class="character">0</span>/200 Byte (This name using for management)
							</td>
						</tr>
						<tr>
							<th>External Movie Clip <span class="neccesary">*</span></th>
							<td>
								<div class="holder">
									<label><span class="neccesary">*</span>1st Category:</label>
									<select validate="required" style="width:118px" name="cat4" onchange="slide.movie_cat4()">
										<option></option>
										<?php
										foreach($cat1 as $k => $v){
										?>
										<option value="<?php echo $v['movie_cat_id'];?>"><?php echo $v['movie_category'];?></option>
										<?php } ?>
									</select>
									
									<label style="margin-left:10px;"><span class="neccesary">*</span>2nd Category:</label>
									<select validate="required" style="width:118px" name="cat5"></select>
									
									<label style="margin-left:10px"><span class="neccesary">*</span>Movie Clip:</label>
									<select validate="required" style="width:118px" name="cat6"></select>
								</div>
								<span class="prompt">Choose category and Movie Clip</span>
							</td>
						</tr>
						<tr>
							<th>Word Script</th>
							<td>
								<div class="holder">
									<input class="fix6" id="trigger_20" type="text" value="" readOnly="readOnly" name="trigger_20" onclick="slide.fileTrigger('doc_20')"/>
									<input type="file" id="doc_20" style="display:none" name="doc_20" onchange="slide.fileSelect('trigger_20',this)"/>
									<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger('doc_20')"/>
								</div>
								<span class="prompt">You can upload <span>Word</span> file type.</span>
							</td>
						</tr>
						<tr>
							<th>Today's Object <span class="neccesary">*</span></th>
							<td>
								<div validate="required" class="tmce_con2" cols="0" rows="0"></div>
							</td>
						</tr>
						<tr>
							<th>Warm-up Questions <span class="neccesary">*</span></th>
							<td>
								<div class="holder">
									<label><span class="neccesary">*</span> 1</label>
									<input validate="required" class="fix4" type="text" value="" maxlength="200" name="warm_up_q_1" />
								</div>
								<div class="holder">
									<label>2</label>
									<input class="fix4" type="text" value="" maxlength="200" name="warm_up_q_2" />
								</div>
								<div class="holder">
									<label>3</label>
									<input class="fix4" type="text" value="" maxlength="200" name="warm_up_q_3" />
								</div>
								<div class="holder">
									<label>4</label>
									<input class="fix4" type="text" value="" maxlength="200" name="warm_up_q_4" />
								</div>
								<div class="holder">
									<label>5</label>
									<input class="fix4" type="text" value="" maxlength="200" name="warm_up_q_5" />
								</div>
								<div class="holder">
									<label>6</label>
									<input class="fix4" type="text" value="" maxlength="200" name="warm_up_q_6" />
								</div>
							</td>
						</tr>
						<tr>
							<th>Related Article <span class="neccesary">*</span></th>
							<td>
								<div validate="required" class="tmce_con3" cols="0" rows="0"></div>
							</td>
						</tr>
						<tr>
							<th>Disquession Questions <span class="neccesary">*</span></th>
							<td>
								<div class="holder">
									<label><span class="neccesary">*</span> 1</label>
									<input validate="required" class="fix4" type="text" value="" maxlength="200" name="disque_q_1" />
								</div>
								<div class="holder">
									<label>2</label>
									<input class="fix4" type="text" value="" maxlength="200" name="disque_q_2" />
								</div>
								<div class="holder">
									<label>3</label>
									<input class="fix4" type="text" value="" maxlength="200" name="disque_q_3" />
								</div>
								<div class="holder">
									<label>4</label>
									<input class="fix4" type="text" value="" maxlength="200" name="disque_q_4" />
								</div>
								<div class="holder">
									<label>5</label>
									<input class="fix4" type="text" value="" maxlength="200" name="disque_q_5" />
								</div>
								<div class="holder">
									<label>6</label>
									<input class="fix4" type="text" value="" maxlength="200" name="disque_q_6" />
								</div>
								<div class="holder">
									<label>7</label>
									<input class="fix4" type="text" value="" maxlength="200" name="disque_q_7" />
								</div>
								<div class="holder">
									<label>8</label>
									<input class="fix4" type="text" value="" maxlength="200" name="disque_q_8" />
								</div>
								<div class="holder">
									<label>9</label>
									<input class="fix4" type="text" value="" maxlength="200" name="disque_q_9" />
								</div>
								<div class="holder">
									<label>10</label>
									<input class="fix4" type="text" value="" maxlength="200" name="disque_q_10" />
								</div>
							</td>
						</tr>
						<tr>
							<th class="last">Let's Debate <span class="neccesary">*</span></th>
							<td class="last">
								<div class="holder">
									<label><span class="neccesary">*</span> 1</label>
									<input validate="required" class="fix4" type="text" value="" maxlength="200" name="debate_1" />
								</div>
								<div class="holder">
									<label>2</label>
									<input class="fix4" type="text" value="" maxlength="200" name="debate_2" />
								</div>
								<div class="holder">
									<label>3</label>
									<input class="fix4" type="text" value="" maxlength="200" name="debate_3" />
								</div>
								<div class="holder">
									<label>4</label>
									<input class="fix4" type="text" value="" maxlength="200" name="debate_4" />
								</div>
								<div class="holder">
									<label>5</label>
									<input class="fix4" type="text" value="" maxlength="200" name="debate_5" />
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			<form name='addSlideForm' enctype="multipart/form-data">
				<input type="hidden" name="funit_id" value='<?php echo $funit_id;?>'/>
				<input type="hidden" name="fexam_type_id" value=''/>
				<table border="0" cellspacing="0" cellpadding="0" class="ulearning">
					<colgroup>
						<col width="125px" />
						<col  />
					</colgroup>
					<tbody class="commonHead">
					<tr>
						<th>Sequence <span class="neccesary">*</span></th>
						<td>
							<input type="text" value="" class="fix5" name="sequence" validate="required|digits"/>
							<span class="prompt">You can use numeric word from 1 to 999. Small number slide will be shown first.</span>
						</td>
					</tr>
					<tr>
						<th>Time Limit <span class="neccesary">*</span></th>
						<td>
							<input type="text" value="" class="fix5" name="time" validate="required|digits"/> seconds
							<span class="prompt">"0" means no limit time.</span>
						</td>
					</tr>
					<tr>
						<th>Background <span class="neccesary">*</span></th>
						<td>
							<input type="radio" name="background_css" value="0" checked="checked" /> <label>#0</label>
							<input type="radio" name="background_css" value="1" /> <label>#1</label>
							<input type="radio" name="background_css" value="2" /> <label>#2</label>
							<input type="radio" name="background_css" value="3" /> <label>#3</label>
							<input type="radio" name="background_css" value="4" /> <label>#4</label>
							<input type="radio" name="background_css" value="5" /> <label>#5</label>
							<input type="radio" name="background_css" value="6" /> <label>#6</label>
							<input type="radio" name="background_css" value="7" /> <label>#7</label>
							<input type="radio" name="background_css" value="8" /> <label>#8</label>
							<input type="radio" name="background_css" value="9" /> <label>#9</label>
						</td>
					</tr>
					<tr>
						<th>Study Part <span class="neccesary">*</span></th>
						<td>
							<span><input type="checkbox" name="study_part[]" class="study_part" value="L" style="height:auto" /></span> <label class="listening">Listening</label>
							<span><input type="checkbox" name="study_part[]" class="study_part" value="V" style="height:auto"/></span> <label class="vocabulary">Vocabulary</label>
							<span><input type="checkbox" name="study_part[]" class="study_part" value="G" style="height:auto"/></span> <label class="grammar">Grammar</label>
							<span><input type="checkbox" name="study_part[]" class="study_part" value="R" style="height:auto"/></span> <label class="reading">Reading</label>
							<span><input type="checkbox" name="study_part[]" class="study_part" value="W" style="height:auto"/></span> <label class="writing">Writing</label>
							<span><input type="checkbox" name="study_part[]" class="study_part" value="S" style="height:auto"/></span> <label class="speaking">Speaking</label>
						</td>
					</tr>
					<tr>
						<th>Slide Name <span class="neccesary">*</span></th>
						<td >
							<input type="text" name="slide_name" maxlength="200" value="" class="fix6" validate="required" onkeyup="slide.character(this,200)"/> <span class="character">0</span>/200 Byte (This name using for management)
						</td>
					</tr>
					<tr>
						<th>Study Summary <span class="study_summary_subtitle">This will be shown under title inside gray box</span></th>
						<td><div class="tmce_con" style="position:relative;width:100%;display:inline-block"> </div></td>
					</tr>
					
					<tr>
					<th>Sound File</th>
						<td>
							<div class="holder">
								<input class="fix6" type="text" id="sound_file" value="" readOnly="readOnly" maxlength="200" name="title" onclick="slide.fileTrigger('browse_file')" />
								<input type="file" id="browse_file" style="display:none" name="sound_file" onchange="slide.fileSelect('sound_file',this)" />
								<input type="button" value="Browse" class="browse" onclick="slide.fileTrigger('browse_file')" />
							</div>
							<span class="prompt">You can upload <span>Wav, Mp3</span> file type. You can choose play mode at Recrod Teacher's Voice Field.</span>
						</td>
					</tr>
					<tr>
						<th>Record Teacher's Voice</th>
						<td>
							<img src="../../../images/voice_image.jpg" alt="Record Teachers Voice" />
							<input type="hidden" name="recorded"/>
							<div class="voice_holder">
								<ul>
									<li>Student can listen teacher's recorded voice when he/she study this slide.</li>
									<li>When you 1) upload sound file 2) recorded teacher\'s voice, sound file will use for study.</li>
									<li>When recording is completed please make sure listening your voice file using play button.</li>
									<li>You can choose play mode shown below when this slide is loaded.</li>
								</ul>
								<div class="voice_option">
									<input type="radio" value="" /> <label>Manual Play</label>
									<input type="radio" value="" /> <label>Automatic Play</label>
								</div>
							</div>
							
						</td>
					</tr>
					</tbody>
					<tbody class='tbody'></tbody>
				</table>
			</form>
		</div>
		<div class="action_btn fr">
			<a href="javascript:void(0)" class="btn_save saveSlide" title="Add New User">Submit</a>
		</div>
	</div>
</div>
<?php __include('footer'); ?>