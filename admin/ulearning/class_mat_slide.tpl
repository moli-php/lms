<?php __include('header'); ?>
<?php echo Common::displayMenu(true,array("label"=>"Add Material","most_action"=>"material.open"));?>
<div>
	<table border="0" cellspacing="0" cellpadding="0" class="sub_content">
		<tr>
			<th class="title" style="border-top:none;">Title</th>
			<th class="coursename">
				H-Junior Beginner 1-10
				<div class="calltoaction">
					<a href="#" class="btn_go">Delete</a>
					<a href="#" class="btn_go">Move</a>
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
							<input type="checkbox" value="" />
							<p class="slide_title"><span>#22</span><?php echo $v['slide_name'];?></p>
							<div class="slide_preview"></div>
							<a href="javascript:ViewUpdateSlide(<?php echo $v['slide_id'];?>)" class="btn_apply">V</a>
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
				<!--<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<p class="number">1</p>
							<div class="slide_content">
								<input type="checkbox" value="" />
								<p class="slide_title"><span>#22</span> Black Beauty</p>
								<div class="slide_preview"></div>
								<a href="#" class="btn_apply">V</a>
							</div>
						</td>
						<td>
							<p class="number">2</p>
							<div class="slide_content">
								<input type="checkbox" value="" />
								<p class="slide_title"><span>#22</span> The Girl Who Dre..</p>
								<div class="slide_preview"></div>
								<a href="#" class="btn_apply">V</a>
							</div>
						</td>
						<td>
							<p class="number">3</p>
							<div class="slide_content">
								<input type="checkbox" value="" />
								<p class="slide_title"><span>#22</span> The Happy Prince..</p>
								<div class="slide_preview"></div>
								<a href="#" class="btn_apply">V</a>
							</div>
						</td>
						<td>
							<p class="number">4</p>
							<div class="slide_content">
								<input type="checkbox" value="" />
								<p class="slide_title"><span>#22</span> Jerry Seinfield o..</p>
								<div class="slide_preview"></div>
								<a href="#" class="btn_apply">V</a>
							</div>
						</td>
						<td>
							<p class="number">5</p>
							<div class="slide_content">
								<input type="checkbox" value="" />
								<p class="slide_title"><span>#22</span> Aesop's Fable: T..</p>
								<div class="slide_preview"></div>
								<a href="#" class="btn_apply">V</a>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<p class="number">6</p>
							<div class="slide_content">
								<input type="checkbox" value="" />
								<p class="slide_title"><span>#22</span> Anne of Green Ga..</p>
								<div class="slide_preview"></div>
								<a href="#" class="btn_apply">V</a>
							</div>
						</td>
						<td>
							<p class="number">7</p>
							<div class="slide_content">
								<input type="checkbox" value="" />
								<p class="slide_title"><span>#22</span> White Fang</p>
								<div class="slide_preview"></div>
								<a href="#" class="btn_apply">V</a>
							</div>
						</td>
						<td>
							<p class="number">8</p>
							<div class="slide_content">
								<input type="checkbox" value="" />
								<p class="slide_title"><span>#22</span> The Wizard of Oz.</p>
								<div class="slide_preview"></div>
								<a href="#" class="btn_apply">V</a>
							</div>
						</td>
						<td>
							<p class="number">9</p>
							<div class="slide_content">
								<input type="checkbox" value="" />
								<p class="slide_title"><span>#22</span> Full House Seaso..</p>
								<div class="slide_preview"></div>
								<a href="#" class="btn_apply">V</a>
							</div>
						</td>
						<td>
							<p class="number">10</p>
							<div class="slide_content">
								<input type="checkbox" value="" />
								<p class="slide_title"><span>#22</span> The Railway Chil..</p>
								<div class="slide_preview"></div>
								<a href="#" class="btn_apply">V</a>
							</div>
						</td>
					</tr>
				</table>-->
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
								<p class="slide_title"><?php echo $v['ftype_name'];?></p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#<?php echo $v['num'];?></p><p class="layer_title2"><?php echo $v['falias'];?></p>
						</td>
						<?php
						if($v['num']%7==0)
						echo "</tr>";
					}
					?>
					<!--<tr>
						<td>
							<div class="slide_content">
								<p class="slide_title">Just View Study Watch Pic/Video Listen Voice</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#1</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title"></p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#2</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Multiple Choice Min1 and Max6</p>
								<p class="slide_subtitle">(Summery, Scripts Image, Video, Voice)</p>
							</div>
							<p class="layer_title">Layer#3</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Multiple Choice Min1 and Max5</p>
								<p class="slide_subtitle">(Long Sente.Choice)</p>
							</div>
							<p class="layer_title">Layer#4</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Multiple Choice Min1 and Max6</p>
								<p class="slide_subtitle">(Quest next Choice)</p>
							</div>
							<p class="layer_title">Layer#5</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Watch n Listen Multiple Choice Min 1 and Max4</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#6</p><p class="layer_title2">Q1-4</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Watch n Listen Multiple Choice 1</p>
								<p class="slide_subtitle">(Big Image or Video)</p>
							</div>
							<p class="layer_title">Layer#7</p><p class="layer_title2">Q1</p>
						</td>
					</tr>
					<tr>
						<td>
							<div class="slide_content">
								<p class="slide_title"></p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#8</p>
						</td>	
						<td>
							<div class="slide_content">
								<p class="slide_title"></p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#9</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Image or Video Fill up the words</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#10</p><p class="layer_title2">W1-6</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Sentence Arrangements</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#11</p><p class="layer_title2">W1-12</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Image &amp; Listen Write word Min2 and Max4</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#12</p><p class="layer_title2">W1-4</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Fill up the Words at 6 Sentence</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#13</p><p class="layer_title2">W1-12</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Fill up the Words at Scripts</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#14</p><p class="layer_title2">W1-12</p>
						</td>
					</tr>
					<tr>
						<td>
							<div class="slide_content">
								<p class="slide_title">Image or Voice Q. Text n S.Voice</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#15</p><p class="layer_title2">V1-4</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Image and Listen Voice Answer</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#16</p><p class="layer_title2">V1-4</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Image and Q. Text Voice Answer</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#17</p><p class="layer_title2">V1-4</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Watch Image or Video File and 1 Voice Answer</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#18</p><p class="layer_title2">V1</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Sentence Making</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#19</p><p class="layer_title2">W1-6</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Fill up the Words at 6 Sentence</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#20</p><p class="layer_title2">W1-12</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">Long Writing by Topic</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#21</p><p class="layer_title2">WL1</p>
						</td>
					</tr>
					<tr>
						<td>
							<div class="slide_content">
								<p class="slide_title">External MOV Basic Type</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#22</p><p class="layer_title2">MT1</p>
						</td>
						<td>
							<div class="slide_content">
								<p class="slide_title">External MOV BBS Type</p>
								<p class="slide_subtitle"></p>
							</div>
							<p class="layer_title">Layer#23</p><p class="layer_title2">MT2</p>
						</td>
					</tr>-->
				</table>
			</td>
		</tr>
	</table>
		<div class="popup_window" style="width:300px;display:none;margin-left:23%;margin-top:10%">
			<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
				<col width="75px" />
				<col width="200px" />
				<tr><th colspan="2" class="popup_title">Add New Slide &raquo;</th></tr>
				<tr><td colspan="2"></td></tr>
				<tr>
					<th>1 depth</th>
					<td>
						<select class="depth">
							<option>H-Junior Beginner</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>2 depth</th>
					<td>
						<select class="depth">
							<option>H jBeginner</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>3 depth</th>
					<td>
						<select class="depth">
							<option>H jBeginner</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Title</th>
					<td><input type="text" name="title" maxlength="80" value="" class="fix2" /></td>
				</tr>
			</table>
			<div class="action_btn">
				<a href="#" class="btn_save fr" title="Save changes">Submit</a>
			</div>
		</div>
	</div>
</div>
<?php __include('footer'); ?>