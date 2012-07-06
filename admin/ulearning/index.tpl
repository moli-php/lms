<?php __include('header'); ?>
<?php echo Common::displayMenu(false);?>
<div class="container_wrap">
		<div id="side_opener" class="side_opener" style="display: block;">
			<img src="../../images/side_handler.gif" alt="Side Handler" />
		</div>
		<div id="side_closer" class="side_opener2" style="display: none;">
			<img src="../../images/side_handler2.gif" alt="Side Handler 2" />
		</div>
		<div class="aside">
			<div class="title">Configuration</div>
			<ul class="side_menu">
				<li class="lv_1"><a class="current" title="" href="#">Site Information</a></li>
				<li class="lv_1"><a class="" title="" href="#">Dashboard Management</a></li>
			</ul>
		</div>
		<input type="hidden" id="seq" value="<?php echo $seq;?>"/>
		<div id="sdk_message_box"></div>
		<div class="wrap">
			<ul class="breadcrumb">
				<li><a href="#">uLearning</a></li>
				<li>&gt;&nbsp;Manage Slide</li>
			</ul>
			<div class="top">
				<h3 class="title">Manage Slide</h3>
			</div>
			<table class="sub_content">
				<tr>
					<th class="title">Title</th>
					<th class="coursename"><?php echo $seq_name;?> from 1-<?php echo count($aSlide);?> Slides</th>
				</tr>
				<tr>
					<td class="title">Slide List</td>
					<td class="slide_list"><?php 
					if($aSlide){
					?>
						<table>
							<?php 
								
									foreach($aSlide as $v){
										if($v['num'] % 5 == 1)
											echo "<tr>";
										?>
										<td>
										<p class="number"><?php echo $v['num']?></p>
										<div class="slide_content">
											<p class="slide_title"><?php echo $v['slide_name'];?></p>
											<div class="slide_preview"></div>
											<a href="javascript:ViewUpdateSlide(<?php echo $v['slide_id'];?>)"><img src="[IMG]/ulearning/bullet_03.gif" alt="Slide Preview" /></a>
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
			</table>

		</div>
			<!-- pop up -->
					<div id="popup_wrap_contents">
						<div id="popup">
							<div class="content spacer">
								<form name="form" id="form">
									<input type="hidden" id="slide_id" name="slide_id"/>
									<table>
										<tr>
											<td><label class="title">Slide Name <em>*</em>:</label></td>
											<td><input type="text" value="" class="textbox" id="new_slide_name" fw-filter="isFill" /></td>
										</tr>
										<tr>
											<td><label class="title">Exam Type:</label></td>
											<td>
												<select id="new_question_type">
												<?php 
													foreach($type as $v){
														echo "<option value='".$v['question_type_id']."'>".$v['question_type_name']."</option>";
													}
												?>
												</select>
											</td>
										</tr>
										<tr>
											<td><label class="title">Time Limit <em>*</em>:</label></td>
											<td><input type="text" value="" class="textbox" id="new_time_limit" fw-filter="isFill" /></td>
										</tr>
										<tr>
											<td><label class="title">Study Summary <em>*</em>:</label></td>
											<td><textarea id="new_summary" fw-filter="isFill"></textarea></td>
										</tr>
										<tr>
											<td><label class="title">Image/Video Link:</label></td>
											<td><input type="text" value="" id="new_image_video"/></td>
										</tr>
										<tbody class="choices">
											<tr class="choice_odd">
												<td><label class="title"><input type="hidden" id="question_id_1" name="question_id_1"/>Question #1 <em>*</em>:</label></td>
												<td><input type ="text" class="textbox choice_validate question" id="question_1" fw-filter="isFill"/>
												<div class="c_answer">Correct Answer #:<input type ="text" class="textbox answer" id="answer_1" fw-filter="isNumber"/></div></td>
											</tr>
											<tr  class="choice_odd">
												<td><label class="title">Multiple Choice #1 <em>*</em>:<br /><sub>Don't leave blank in b/w fields</sub></label></td>
												<td>
													<input type="hidden" id="choice_id_11"/>
													<input type="hidden" id="choice_id_12"/>
													<input type="hidden" id="choice_id_13"/>
													<input type="hidden" id="choice_id_14"/>
													<input type="hidden" id="choice_id_15"/>
													<span><em>*</em>1.<input type ="text" class="choice choice_validate" id="choice_11" fw-filter="isFill"/></span>
													<span><em>*</em>2.<input type ="text" class="choice choice_validate" id="choice_12" fw-filter="isFill"/></span>
													<span><em></em>3.<input type ="text" class="choice" id="choice_13"/></span><br />
													<span><em></em>4.<input type ="text" class="choice" id="choice_14"/></span>
													<span><em></em>5.<input type ="text" class="choice" id="choice_15"/></span></td>
											</tr>
											<tr class="choice_even">
												<td><label class="title"><input type="hidden" id="question_id_2" name="question_id_2"/>Question #2:</label></td>
												<td><input type ="text" class="textbox question" id="question_2"/>
												<div class="c_answer">Correct Answer #:<input type ="text" class="textbox answer" id="answer_2" fw-filter="isNumber"/></div></td>
											</tr>
											<tr class="choice_even">
												<td><label class="title">Multiple Choice #2:<br /><sub>Don't leave blank in b/w fields</sub></label></td>
												<td>
													<input type="hidden" id="choice_id_21"/>
													<input type="hidden" id="choice_id_22"/>
													<input type="hidden" id="choice_id_23"/>
													<input type="hidden" id="choice_id_24"/>
													<input type="hidden" id="choice_id_25"/>
													<span><em></em>1.<input type ="text" class="choice" id="choice_21"/></span>
													<span><em></em>2.<input type ="text" class="choice" id="choice_22"/></span>
													<span><em></em>3.<input type ="text" class="choice" id="choice_23"/></span><br />
													<span><em></em>4.<input type ="text" class="choice" id="choice_24"/></span>
													<span><em></em>5.<input type ="text" class="choice" id="choice_25"/></span>
												</td>
											</tr>
											<tr class="choice_odd">
												<td><label class="title"><input type="hidden" id="question_id_3" name="question_id_3"/>Question #3:</label></td>
												<td><input type ="text" class="textbox question" id="question_3"/>
												<div class="c_answer">Correct Answer #:<input type ="text" class="textbox answer" id="answer_3" fw-filter="isNumber"/></div></td>
											</tr>
											<tr class="choice_odd">
												<td><label class="title">Multiple Choice #3:<br /><sub>Don't leave blank in b/w fields</sub></label></td>
												<td>
													<input type="hidden" id="choice_id_31"/>
													<input type="hidden" id="choice_id_32"/>
													<input type="hidden" id="choice_id_33"/>
													<input type="hidden" id="choice_id_34"/>
													<input type="hidden" id="choice_id_35"/>
													<span><em></em>1.<input type ="text" class="choice" id="choice_31"/></span>
													<span><em></em>2.<input type ="text" class="choice" id="choice_32"/></span>
													<span><em></em>3.<input type ="text" class="choice" id="choice_33"/></span><br />
													<span><em></em>4.<input type ="text" class="choice" id="choice_34"/></span>
													<span><em></em>5.<input type ="text" class="choice" id="choice_35"/></span>
												</td>
											</tr>
											<tr  class="choice_even">
												<td><label class="title"><input type="hidden" id="question_id_4" name="question_id_4"/>Question #4:</label></td>
												<td><input type ="text" class="textbox question" id="question_4"/>
												<div class="c_answer">Correct Answer #:<input type ="text" class="textbox answer" id="answer_4" fw-filter="isNumber"/></div></td>
											</tr>
											<tr class="choice_even">
												<td><label class="title">Multiple Choice #4:<br /><sub>Don't leave blank in b/w fields</sub></label></td>
												<td>
													<input type="hidden" id="choice_id_41"/>
													<input type="hidden" id="choice_id_42"/>
													<input type="hidden" id="choice_id_43"/>
													<input type="hidden" id="choice_id_44"/>
													<input type="hidden" id="choice_id_45"/>
													<span><em></em>1.<input type ="text" class="choice" id="choice_41"/></span>
													<span><em></em>2.<input type ="text" class="choice" id="choice_42"/></span>
													<span><em></em>3.<input type ="text" class="choice" id="choice_43"/></span><br />
													<span><em></em>4.<input type ="text" class="choice" id="choice_44"/></span>
													<span><em></em>5.<input type ="text" class="choice" id="choice_45"/></span>
												</td>
											</tr>
											<tr class="choice_odd">
												<td><label class="title"><input type="hidden" id="question_id_5" name="question_id_5"/>Question #5:</label></td>
												<td><input type ="text" class="textbox question" id="question_5"/>
												<div class="c_answer">Correct Answer #:<input type ="text" class="textbox answer" id="answer_5" fw-filter="isNumber"/></div></td>
											</tr>
											<tr class="choice_odd">
												<td><label class="title">Multiple Choice #5:<br /><sub>Don't leave blank in b/w fields</sub></label></td>
												<td>
													<input type="hidden" id="choice_id_51"/>
													<input type="hidden" id="choice_id_52"/>
													<input type="hidden" id="choice_id_53"/>
													<input type="hidden" id="choice_id_54"/>
													<input type="hidden" id="choice_id_55"/>
													<span><em></em>1.<input type ="text" class="choice" id="choice_51"/></span>
													<span><em></em>2.<input type ="text" class="choice" id="choice_52"/></span>
													<span><em></em>3.<input type ="text" class="choice" id="choice_53"/></span><br />
													<span><em></em>4.<input type ="text" class="choice" id="choice_54"/></span>
													<span><em></em>5.<input type ="text" class="choice" id="choice_55"/></span>
												</td>
											</tr>
										</tbody>
										<tbody class="long_write">
											<tr>
												<td class="long_write_label"><label class="title">Fill Sentence #:</label></td>
												<td class="long_write_content">
														<input type="hidden" id="long_id"/>
														<p><input type ="radio" class="long_write_radio" value="1" id="long_radio_1" checked="checked" name="long_radio"/>1</p>
														<p><input type ="radio" class="long_write_radio" value="2" id="long_radio_2" name="long_radio"/>2</p>
														<p><input type ="radio" class="long_write_radio" value="3" id="long_radio_3" name="long_radio"/>3</p>
														<p><input type ="radio" class="long_write_radio" value="4" id="long_radio_4" name="long_radio"/>4</p>
														<p><input type ="radio" class="long_write_radio" value="5" id="long_radio_5" name="long_radio"/>5</p>
												</td>
											</tr>
										</tbody>
										<tbody class="word_write">
											<tr>
												<td class="word_write_label"><label class="title">Fill Sentence #:<br /><sub>Don't leave blank in b/w fields for it won't save the remaining values</sub></label></td>
												<td class="word_write_content">
														<input type="hidden" id="word_id"/>
														<span><em></em>01.<input type ="text" class="word_write_text" id="word_1"/></span>
														<span><em></em>02.<input type ="text" class="word_write_text" id="word_2"/></span>
														<span><em></em>03.<input type ="text" class="word_write_text" id="word_3"/></span>
														<span><em></em>04.<input type ="text" class="word_write_text" id="word_4"/></span>
														<span><em></em>05.<input type ="text" class="word_write_text" id="word_5"/></span>
														<span><em></em>06.<input type ="text" class="word_write_text" id="word_6"/></span>
														<span><em></em>07.<input type ="text" class="word_write_text" id="word_7"/></span>
														<span><em></em>08.<input type ="text" class="word_write_text" id="word_8"/></span>
														<span><em></em>09.<input type ="text" class="word_write_text" id="word_9"/></span>
														<span><em></em>10.<input type ="text" class="word_write_text" id="word_10"/></span>
												</td>
											</tr>
										</tbody>
											<tr><td colspan="2"><div class="save_container"><a href="#" class="btn_apply" id="save_btn">Save</a></div></td></tr>
									</table>
								</form>
							</div>
						</div>
					</div>
			<!-- end pop up -->
</div>
<?php __include('footer'); ?>