<?php
class Questions extends Simplexi_Controller{
	public function run($aArgs){
		if($aArgs['type'] == 2){
			echo '<tr>
				<th class="highlight">Question#1<span class="neccesary">*</span></th>
				<td>
					<input type="text" value="" class="fix6" id="question_1" name="question_1" validate="required" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight">+ Correct Answer# is</span> <span class="neccesary">*</span>
					<input type="text" value="" class="fix7" id="answer_1" name="answer_1" maxlength="1" validate="required|digits"/>
				</td>
			</tr>
			<tr>
				<th class="highlight">Multi. Choice#1<span class="neccesary">*</span></th>
				<td>
					<span class="neccesary">*</span>1. <input type="text" value="" class="fix8" id="choice_11" name="choice_11" validate="required"/>
					<span class="neccesary">*</span>2. <input type="text" value="" class="fix8" id="choice_12" name="choice_12" validate="required"/>
					3. <input type="text" value="" class="fix8" id="choice_13" name="choice_13"/>
					4. <input type="text" value="" class="fix8" id="choice_14" name="choice_14"/>
					5. <input type="text" value="" class="fix8" id="choice_15" name="choice_15"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Question#2</th>
				<td>
					<input type="text" value="" class="fix6" id="question_2" name="question_2" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight2">+ Correct Answer# is</span>
					<input type="text" value="" class="fix7" id="answer_2" name="answer_2" maxlength="1" validate="digits"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Multi. Choice#2</th>
				<td>
					1. <input type="text" value="" class="fix8" id="choice_21" name="choice_21"/>
					2. <input type="text" value="" class="fix8" id="choice_22" name="choice_22"/>
					3. <input type="text" value="" class="fix8" id="choice_23" name="choice_23"/>
					4. <input type="text" value="" class="fix8" id="choice_24" name="choice_24"/>
					5. <input type="text" value="" class="fix8" id="choice_25" name="choice_25"/>
				</td>
			</tr>
			<tr>
				<th class="highlight">Question#3</th>
				<td>
					<input type="text" value="" class="fix6" id="question_3" name="question_3" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight">+ Correct Answer# is</span>
					<input type="text" value="" class="fix7" id="answer_3" name="answer_3" maxlength="1" validate="digits"/>
				</td>
			</tr>
			<tr>
				<th class="highlight">Multi. Choice#3</th>
				<td>
					1. <input type="text" value="" class="fix8" id="choice_31" name="choice_31"/>
					2. <input type="text" value="" class="fix8" id="choice_32" name="choice_32"/>
					3. <input type="text" value="" class="fix8" id="choice_33" name="choice_33"/>
					4. <input type="text" value="" class="fix8" id="choice_34" name="choice_34">
					5. <input type="text" value="" class="fix8" id="choice_35" name="choice_35"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Question#4</th>
				<td>
					<input type="text" value="" class="fix6" id="question_4" name="question_4" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight2">+ Correct Answer# is</span>
					<input type="text" value="" class="fix7" id="answer_4" name="answer_4" maxlength="1" validate="digits"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Multi. Choice#4</th>
				<td>
					1. <input type="text" value="" class="fix8" id="choice_41" name="choice_41"/>
					2. <input type="text" value="" class="fix8" id="choice_42" name="choice_42"/>
					3. <input type="text" value="" class="fix8" id="choice_43" name="choice_43"/>
					4. <input type="text" value="" class="fix8" id="choice_44" name="choice_44"/>
					5. <input type="text" value="" class="fix8" id="choice_45" name="choice_45"/>
				</td>
			</tr>
			<tr>
				<th class="highlight">Question#5</th>
				<td>
					<input type="text" value="" class="fix6" id="question_5" name="question_5" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight">+ Correct Answer# is</span>
					<input type="text" value="" class="fix7" id="answer_5" name="answer_5" maxlength="1" validate="digits"/>
				</td>
			</tr>
			<tr>
				<th class="highlight">Multi. Choice#5</th>
				<td>
					1. <input type="text" value="" class="fix8" id="choice_51" name="choice_51"/>
					2. <input type="text" value="" class="fix8" id="choice_52" name="choice_52"/>
					3. <input type="text" value="" class="fix8" id="choice_53" name="choice_53"/>
					4. <input type="text" value="" class="fix8" id="choice_54" name="choice_54"/>
					5. <input type="text" value="" class="fix8" id="choice_55" name="choice_55"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Question#6</th>
				<td>
					<input type="text" value="" class="fix6" id="question_6" name="question_6" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight2">+ Correct Answer# is</span>
					<input type="text" value="" class="fix7" id="answer_6" name="answer_6" maxlength="1" validate="digits"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2 last">Multi. Choice#6</th>
				<td class="last">
					1. <input type="text" value="" class="fix8" id="choice_61" name="choice_61"/>
					2. <input type="text" value="" class="fix8" id="choice_62" name="choice_62"/>
					3. <input type="text" value="" class="fix8" id="choice_63" name="choice_63"/>
					4. <input type="text" value="" class="fix8" id="choice_64" name="choice_64"/>
					5. <input type="text" value="" class="fix8" id="choice_65" name="choice_65"/>
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 3){
			echo '<tr>
				<th class="highlight">Question#1<span class="neccesary">*</span></th>
				<td>
					<input type="text" value="" class="fix6" name="question_1" validate="required" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight">+ Correct Answer# is</span> <span class="neccesary">*</span>
					<input type="text" value="" class="fix7" name="answer_1" validate="required|digits" maxlength="1"/>
				</td>
			</tr>
			<tr>
				<th class="highlight">Multi. Choice#1<span class="neccesary">*</span></th>
				<td>
					<div class="holder">
						<span class="neccesary">*</span>1. <input type="text" value="" class="fix6" name="choice_11" validate="required" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary">*</span>2. <input type="text" value="" class="fix6" name="choice_12" validate="required" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>3. <input type="text" value="" class="fix6" name="choice_13" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>4. <input type="text" value="" class="fix6" name="choice_14" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>5. <input type="text" value="" class="fix6" name="choice_15" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Question#2<span class="neccesary not">*</span></th>
				<td>
					<input type="text" value="" class="fix6" name="question_2" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight2">+ Correct Answer# is</span> <span class="neccesary not">*</span>
					<input type="text" value="" class="fix7" name="answer_2" maxlength="1" validate="digits"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Multi. Choice#2<span class="neccesary not">*</span></th>
				<td>
					<div class="holder">
						<span class="neccesary not">*</span>1. <input type="text" value="" class="fix6" name="choice_21" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>2. <input type="text" value="" class="fix6" name="choice_22" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>3. <input type="text" value="" class="fix6" name="choice_23" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>4. <input type="text" value="" class="fix6" name="choice_24" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>5. <input type="text" value="" class="fix6" name="choice_25" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
				</td>
			</tr>
			<tr>
				<th class="highlight">Question#3<span class="neccesary not">*</span></th>
				<td>
					<input type="text" value="" class="fix6" name="question_3" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight">+ Correct Answer# is</span> <span class="neccesary">*</span>
					<input type="text" value="" class="fix7" name="answer_3" maxlength="1" validate="digits"/>
				</td>
			</tr>
			<tr>
				<th class="highlight">Multi. Choice#3<span class="neccesary not">*</span></th>
				<td>
					<div class="holder">
						<span class="neccesary">*</span>1. <input type="text" value="" class="fix6" name="choice_31" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary">*</span>2. <input type="text" value="" class="fix6" name="choice_32" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>3. <input type="text" value="" class="fix6" name="choice_33" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>4. <input type="text" value="" class="fix6" name="choice_34" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>5. <input type="text" value="" class="fix6" name="choice_35" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Question#4<span class="neccesary not">*</span></th>
				<td>
					<input type="text" value="" class="fix6" name="question_4" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight2">+ Correct Answer# is</span> <span class="neccesary not">*</span>
					<input type="text" value="" class="fix7" name="answer_4" maxlength="1" validate="digits"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Multi. Choice#4<span class="neccesary not">*</span></th>
				<td>
					<div class="holder">
						<span class="neccesary not">*</span>1. <input type="text" value="" class="fix6" name="choice_41" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>2. <input type="text" value="" class="fix6" name="choice_42" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>3. <input type="text" value="" class="fix6" name="choice_43" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>4. <input type="text" value="" class="fix6" name="choice_44" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>5. <input type="text" value="" class="fix6" name="choice_45" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
				</td>
			</tr>
			<tr>
				<th class="highlight">Question#5<span class="neccesary not">*</span></th>
				<td>
					<input type="text" value="" class="fix6" name="question_5" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight">+ Correct Answer# is</span> <span class="neccesary not">*</span>
					<input type="text" value="" class="fix7" name="answer_5" maxlength="1" validate="digits"/>
				</td>
			</tr>
			<tr>
				<th class="highlight last">Multi. Choice#5<span class="neccesary not">*</span></th>
				<td class="last">
					<div class="holder">
						<span class="neccesary not">*</span>1. <input type="text" value="" class="fix6" name="choice_51" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>2. <input type="text" value="" class="fix6" name="choice_52" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>3. <input type="text" value="" class="fix6" name="choice_53" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>4. <input type="text" value="" class="fix6" name="choice_54" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>5. <input type="text" value="" class="fix6" name="choice_55" maxlength="150" onkeyup="slide.character(this,150)"/> <span class="character">0</span>/150 Byte
					</div>
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 5){
			echo '<tr>
				<th class="highlight">Question#1<span class="neccesary">*</span></th>
				<td>
					<input type="text" value="" class="fix6" name="question_1" validate="required" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight">+ Correct Answer# is</span> <span class="neccesary">*</span>
					<input type="text" value="" class="fix7" name="answer_1" validate="required|digits" maxlength="1"/>
				</td>
			</tr>
			<tr>
				<th class="highlight">Multi. Choice#1<span class="neccesary">*</span></th>
				<td>
					<span class="neccesary">*</span>1. <input type="text" value="" class="fix8" name="choice_11" validate="required"/>
					<span class="neccesary">*</span>2. <input type="text" value="" class="fix8" name="choice_12" validate="required"/>
					3. <input type="text" value="" class="fix8" name="choice_13"/>
					4. <input type="text" value="" class="fix8" name="choice_14"/>
					5. <input type="text" value="" class="fix8" name="choice_15"/>
				</td>
			</tr>
			<tr>
				<th class="highlight">Q.Image#1<span class="neccesary">*</span></th>
				<td>
					<div class="holder">
						<input class="fix6" id="trigger_1" type="text" value="" readOnly="readOnly" validate="required" name="trigger_1" onclick="slide.fileTrigger(\'image_1\')"/>
						<input type="file" id="image_1" style="display:none" name="image_1" onchange="slide.fileSelect(\'trigger_1\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_1\')"/>
					</div>
					<span class="prompt">We recommend this image file size to 140x100 pixel and JPG file type.</span>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Question#2</th>
				<td>
					<input type="text" value="" class="fix6" name="question_2" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight2">+ Correct Answer# is</span>
					<input type="text" value="" class="fix7" name="answer_2" validate="digits" maxlength="1"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Multi. Choice#2</th>
				<td>
					1. <input type="text" value="" class="fix8" name="choice_21"/>
					2. <input type="text" value="" class="fix8" name="choice_22"/>
					3. <input type="text" value="" class="fix8" name="choice_23"/>
					4. <input type="text" value="" class="fix8" name="choice_24"/>
					5. <input type="text" value="" class="fix8" name="choice_25"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2 last">Q.Image#2</th>
				<td class="last">
					<div class="holder">
						<input class="fix6" id="trigger_2" type="text" value="" readOnly="readOnly" name="trigger_2" onclick="slide.fileTrigger(\'image_2\')"/>
						<input type="file" id="image_2" style="display:none" name="image_2" onchange="slide.fileSelect(\'trigger_2\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_2\')"/>
					</div>
					<span class="prompt">We recommend this image file size to 140x100 pixel and JPG file type.</span>
				</td>
			</tr>
			<tr>
				<th class="highlight">Question#1</th>
				<td>
					<input type="text" value="" class="fix6" name="question_3" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight">+ Correct Answer# is</span>
					<input type="text" value="" class="fix7" name="answer_3" validate="digits" maxlength="1"/>
				</td>
			</tr>
			<tr>
				<th class="highlight">Multi. Choice#1</th>
				<td>
					1. <input type="text" value="" class="fix8" name="choice_31"/>
					2. <input type="text" value="" class="fix8" name="choice_32"/>
					3. <input type="text" value="" class="fix8" name="choice_33"/>
					4. <input type="text" value="" class="fix8" name="choice_34"/>
					5. <input type="text" value="" class="fix8" name="choice_35"/>
				</td>
			</tr>
			<tr>
				<th class="highlight">Q.Image#1</th>
				<td>
					<div class="holder">
						<input class="fix6" id="trigger_3" type="text" value="" readOnly="readOnly" name="trigger_3" onclick="slide.fileTrigger(\'image_3\')"/>
						<input type="file" id="image_3" style="display:none" name="image_3" onchange="slide.fileSelect(\'trigger_3\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_3\')"/>
					</div>
					<span class="prompt">We recommend this image file size to 140x100 pixel and JPG file type.</span>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Question#2</th>
				<td>
					<input type="text" value="" class="fix6" name="question_4" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					<span class="highlight2">+ Correct Answer# is</span>
					<input type="text" value="" class="fix7" name="answer_4" validate="digits" maxlength="1"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Multi. Choice#2</th>
				<td>
					1. <input type="text" value="" class="fix8" name="choice_41"/>
					2. <input type="text" value="" class="fix8" name="choice_42"/>
					3. <input type="text" value="" class="fix8" name="choice_43"/>
					4. <input type="text" value="" class="fix8" name="choice_44"/>
					5. <input type="text" value="" class="fix8" name="choice_45"/>
				</td>
			</tr>
			<tr>
				<th class="highlight2 last">Q.Image#2</th>
				<td class="last">
					<div class="holder">
						<input class="fix6" id="trigger_4" type="text" value="" readOnly="readOnly" name="trigger_4" onclick="slide.fileTrigger(\'image_4\')"/>
						<input type="file" id="image_4" style="display:none" name="image_4" onchange="slide.fileSelect(\'trigger_4\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_4\')"/>
					</div>
					<span class="prompt">We recommend this image file size to 140x100 pixel and JPG file type.</span>
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 6){
			echo '<tr>
				<th class="highlight last">Multi. Choice#1<span class="neccesary">*</span></th>
				<td class="last">
					<span class="neccesary">*</span>1. <input type="text" value="" class="fix8" name="choice_1" validate="required" />
					<span class="neccesary">*</span>2. <input type="text" value="" class="fix8" name="choice_2" validate="required" />
					3. <input type="text" value="" class="fix8" name="choice_3" />
					4. <input type="text" value="" class="fix8" name="choice_4" />
					5. <input type="text" value="" class="fix8" name="choice_5" />
					<span class="highlight">+ Correct Answer# is</span> <span class="neccesary">*</span>
					<input type="text" value="" class="fix7" maxlength="1" name="answer" validate="required|digits"  />
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 7){
			echo '<tr>
				<th class="last">Correct Word<span class="neccesary">*</span></th>
				<td class="last">
					<div class="holder">
						<span class="neccesary">*</span>1. <input type="text" value="" class="fix3" validate="required" name="word_1" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					</div>
					
					<div class="holder">
						<span class="neccesary">*</span>2. <input type="text" value="" class="fix3" validate="required" name="word_2" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					</div>
					
					<div class="holder">
						<span class="neccesary not">*</span>3. <input type="text" value="" class="fix3" name="word_3" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>4. <input type="text" value="" class="fix3" name="word_4" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					</div>
					
					<div class="holder">
						<span class="neccesary not">*</span>5. <input type="text" value="" class="fix3" name="word_5" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					</div>
					
					<div class="holder">
						<span class="neccesary not">*</span>6. <input type="text" value="" class="fix3" name="word_6" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte 
					</div>
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 8){
			echo '<tr>
				<th class="last">Words with correct sequence<span class="neccesary">*</span></th>
				<td class="last">
					<div class="holder">
						<span class="neccesary">*</span>01. <input type="text" validate="required" value="" name="word_1" />
						02. <input type="text" value="" name="word_2" />
						03. <input type="text" value="" name="word_3" />
						04. <input type="text" value="" name="word_4" />
					</div>
					<div class="holder">
						05. <input type="text" value="" name="word_5" />
						06. <input type="text" value="" name="word_6" />
						07. <input type="text" value="" name="word_7" />
						08. <input type="text" value="" name="word_8" />
					</div>
					<div class="holder">
						09. <input type="text" value="" name="word_9" />
						10. <input type="text" value="" name="word_10" />
						11. <input type="text" value="" name="word_11" />
						12. <input type="text" value="" name="word_12" />
					</div>
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 9){
			echo '<tr>
				<th class="highlight">Word#1<span class="neccesary">*</span></th>
				<td>
					<div class="holder">
						<input type="text" validate="required" value="" class="fix4" name="word_1" maxlength="50" onkeyup="slide.character(this,50)" /> <span class="character">0</span>/50 Byte 
						<span class="prompt">Attach image file for each question. Recommend 300x150 pixel size.</span>
					</div>
					
				</td>
			</tr>
			<tr>
				<th class="highlight">Q.Image#1<span class="neccesary">*</span></th>
				<td>
					<div class="holder">
						<input class="fix6" validate="required" id="trigger_1" type="text" value="" readOnly="readOnly" name="trigger_1" onclick="slide.fileTrigger(\'image_1\')"/>
						<input type="file" id="image_1" style="display:none" name="image_1" onchange="slide.fileSelect(\'trigger_1\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_1\')"/>
					</div>
					<span class="prompt">We recommend this image file size to 140x100 pixel and JPG file type.</span>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Word#2<span class="neccesary">*</span></th>
				<td>
					<div class="holder">
						<input type="text" validate="required" value="" class="fix4" name="word_2" maxlength="50" onkeyup="slide.character(this,50)" /> <span class="character">0</span>/50 Byte 
						<span class="prompt">Recommend record voice for each question.</span>
					</div>
					
				</td>
			</tr>
			<tr>
				<th class="highlight2">Q.Image#2<span class="neccesary">*</span></th>
				<td>
					<div class="holder">
						<input class="fix6" validate="required" id="trigger_2" type="text" value="" readOnly="readOnly" name="trigger_2" onclick="slide.fileTrigger(\'image_2\')"/>
						<input type="file" id="image_2" style="display:none" name="image_2" onchange="slide.fileSelect(\'trigger_2\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_2\')"/>
					</div>
				</td>
			</tr>
			<tr>
				<th class="highlight">Word#3</th>
				<td>
					<div class="holder">
						<input type="text" value="" class="fix4" name="word_3" maxlength="50" onkeyup="slide.character(this,50)" /> <span class="character">0</span>/50 Byte 
					</div>
					
				</td>
			</tr>
			<tr>
				<th class="highlight">Q.Image#3</th>
				<td class="last">
					<div class="holder">
						<input class="fix6" id="trigger_3" type="text" value="" readOnly="readOnly" name="trigger_3" onclick="slide.fileTrigger(\'image_3\')"/>
						<input type="file" id="image_3" style="display:none" name="image_3" onchange="slide.fileSelect(\'trigger_3\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_3\')"/>
					</div>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Word#4</th>
				<td>
					<div class="holder">
						<input type="text" value="" class="fix4" name="word_4" maxlength="50" onkeyup="slide.character(this,50)" /> <span class="character">0</span>/50 Byte 
					</div>
					
				</td>
			</tr>
			<tr>
				<th class="highlight2 last">Q.Image#4</th>
				<td class="last">
					<div class="holder">
						<input class="fix6" id="trigger_4" type="text" value="" readOnly="readOnly" name="trigger_4" onclick="slide.fileTrigger(\'image_4\')"/>
						<input type="file" id="image_4" style="display:none" name="image_4" onchange="slide.fileSelect(\'trigger_4\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_4\')"/>
					</div>
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 10){
			echo '<tr>
				<th>Words with correct sequence<span class="neccesary">*</span></th>
				<td>
					<div class="holder">
						<span class="neccesary">*</span>01. <input type="text" validate="required" value="" name="word_1" />
						02. <input type="text" value="" name="word_2" />
						03. <input type="text" value="" name="word_3" />
						04. <input type="text" value="" name="word_4" />
					</div>
					<div class="holder">
						05. <input type="text" value="" name="word_5" />
						06. <input type="text" value="" name="word_6" />
						07. <input type="text" value="" name="word_7" />
						08. <input type="text" value="" name="word_8" />
					</div>
					<div class="holder">
						09. <input type="text" value="" name="word_9" />
						10. <input type="text" value="" name="word_10" />
						11. <input type="text" value="" name="word_11" />
						12. <input type="text" value="" name="word_12" />
					</div>
				</td>
			</tr>
			<tr>
				<th>Sentence#1<span class="neccesary">*</span></th>
				<td>
					<div class="holder">
						<input class="fix6" validate="required" type="text" value="" maxlength="200" name="sentence_1" /> 0/250 Byte 
					</div>
					<span class="prompt">Pull the blank word field as [[blank#1]] [[blank#2]] [[blank#3]] .. [[blank#12]]. You can use max 12 blank.</span>
				</td>
			</tr>
			<tr>
				<th>Sentence#2</th>
				<td>
					<div class="holder">
						<input class="fix6" type="text" value="" maxlength="200" name="sentence_2" /> 0/250 Byte 
					</div>
					<span class="prompt">If you want to make special width use below option. Only 3 type is available for this slide. 1 word blank is [[blank#1]1], <br />max 3 word blank is [[blank#1]3] max 6 word blank is [[blank#1]6].</span>
				</td>
			</tr>
			<tr>
				<th>Sentence#3</th>
				<td>
					<div class="holder">
						<input class="fix6" type="text" value="" maxlength="200" name="sentence_3" /> 0/250 Byte 
					</div>
				</td>
			</tr>
			<tr>
				<th>Sentence#4</th>
				<td>
					<div class="holder">
						<input class="fix6" type="text" value="" maxlength="200" name="sentence_4" /> 0/250 Byte 
					</div>
				</td>
			</tr>
			<tr>
				<th>Sentence#5</th>
				<td>
					<div class="holder">
						<input class="fix6" type="text" value="" maxlength="200" name="sentence_5" /> 0/250 Byte 
					</div>
				</td>
			</tr>
			<tr>
				<th class="last">Sentence#6</th>
				<td class="last">
					<div class="holder">
						<input class="fix6" type="text" value="" maxlength="200" name="sentence_6" /> 0/250 Byte 
					</div>
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 11){
			echo '<tr>
				<th>Sentence</th>
				<td>
					<textarea cols="0" rows="0" validate="required" name="sentence" onfocus="slide.remove_sentence()">Write here using with [[blank#1]][[blank#2]][[blank#3]][[blank#4]][[blank#5]][[blank#6]][[blank#7]][[blank#8]][[blank#9]][[blank#10]][[blank#11]][[blank#12]]</textarea>
				</td>
			</tr>
			<tr>
				<th class="last">Words with correct sequence<span class="neccesary">*</span></th>
				<td class="last">
					<div class="holder">
						<span class="neccesary">*</span>01. <input type="text" validate="required" value="" name="word_1" />
						<span class="neccesary not">*</span>02. <input type="text" value="" name="word_2" />
						<span class="neccesary not">*</span>03. <input type="text" value="" name="word_3" />
						<span class="neccesary not">*</span>04. <input type="text" value="" name="word_4" />
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>05. <input type="text" value="" name="word_5" />
						<span class="neccesary not">*</span>06. <input type="text" value="" name="word_6" />
						<span class="neccesary not">*</span>07. <input type="text" value="" name="word_7" />
						<span class="neccesary not">*</span>08. <input type="text" value="" name="word_8" />
					</div>
					<div class="holder">
						<span class="neccesary not">*</span>09. <input type="text" value="" name="word_9" />
						<span class="neccesary not">*</span>10. <input type="text" value="" name="word_10" />
						<span class="neccesary not">*</span>11. <input type="text" value="" name="word_11" />
						<span class="neccesary not">*</span>12. <input type="text" value="" name="word_12" />
					</div>
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 12){
			echo '<tr>
				<th class="highlight">Record#1<span class="neccesary">*</span></th>
				<td>
						<input type="radio" checked="checked" class="radio" name="radio_1" value="1" /> <label>Required</label><input type="radio" class="radio" name="radio_1" value="0" /> <label>Not Receive Voice Record</label><span class="prompt">White question text when you request student voice.</span>
				</td>
			</tr>
			<tr>
				<th class="highlight">Q.Text#1<span class="neccesary">*</span></th>
				<td >
					<input type="text" validate="required" name="question_1" maxlength="100" value="" class="fix6" onkeyup="slide.character(this,100)" /> <span class="character">0</span>/100 Byte
				</td>
			</tr>
			<tr>
				<th class="highlight2">Record#2</th>
				<td>
						<input type="radio" checked="checked" class="radio" name="radio_2" value="1" /> <label>Required</label><input type="radio" class="radio" name="radio_2" value="0" /> <label>Not Receive Voice Record</label>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Q.Text#2</th>
				<td >
					<input type="text" name="question_2" maxlength="100" value="" class="fix6" onkeyup="slide.character(this,100)" /> <span class="character">0</span>/100 Byte
				</td>
			</tr>
			<tr>
				<th class="highlight">Record#3</th>
				<td>
						<input type="radio" checked="checked" class="radio" name="radio_3" value="1" /> <label>Required</label><input type="radio" class="radio" name="radio_3" value="0" /> <label>Not Receive Voice Record</label>
				</td>
			</tr>
			<tr>
				<th class="highlight">Q.Text#3</th>
				<td >
					<input type="text" name="question_3" maxlength="100" value="" class="fix6" onkeyup="slide.character(this,100)" /> <span class="character">0</span>/100 Byte
				</td>
			</tr>
			<tr>
				<th class="highlight2">Record#4</th>
				<td>
						<input type="radio" checked="checked" class="radio" name="radio_4" value="1" /> <label>Required</label><input type="radio" class="radio" name="radio_4" value="0" /> <label>Not Receive Voice Record</label>
				</td>
			</tr>
			<tr>
				<th class="highlight2 last">Q.Text#4</th>
				<td class="last">
					<input type="text" name="question_4" maxlength="100" value="" class="fix6" onkeyup="slide.character(this,100)" /> <span class="character">0</span>/100 Byte
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 13){
			echo '<tr>
				<th class="highlight">Record#1<span class="neccesary">*</span></th>
				<td>
						<input type="radio" class="radio" checked="checked" name="radio_1" /> <label>Required</label><input type="radio" class="radio" name="radio_1" /> <label>Not Receive Voice Record</label><span class="prompt">Attach image file for each question. Recommend 300x150 pixel size.</span>
				</td>
			</tr>
			<tr>
				<th class="highlight">Q.Image#1<span class="neccesary">*</span></th>
				<td >
					<div class="holder">
						<input class="fix6" validate="required" id="trigger_1" type="text" value="" readOnly="readOnly" name="trigger_1" onclick="slide.fileTrigger(\'image_1\')"/>
						<input type="file" id="image_1" style="display:none" name="image_1" onchange="slide.fileSelect(\'trigger_1\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_1\')"/>
					</div>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Record#2</th>
				<td>
						<input type="radio" class="radio" checked="checked" name="radio_2" /> <label>Required</label><input type="radio" class="radio" name="radio_2" /> <label>Not Receive Voice Record</label><span class="prompt">If you are request, You have to record voice at Record Question.</span>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Q.Image#2</th>
				<td >
					<div class="holder">
						<input class="fix6" id="trigger_2" type="text" value="" readOnly="readOnly" name="trigger_2" onclick="slide.fileTrigger(\'image_2\')"/>
						<input type="file" id="image_2" style="display:none" name="image_2" onchange="slide.fileSelect(\'trigger_2\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_2\')"/>
					</div>
				</td>
			</tr>
			<tr>
				<th class="highlight">Record#3</th>
				<td>
						<input type="radio" class="radio" checked="checked" name="radio_3" /> <label>Required</label><input type="radio" class="radio" name="radio_3" /> <label>Not Receive Voice Record</label>
				</td>
			</tr>
			<tr>
				<th class="highlight">Q.Image#3</th>
				<td >
					<div class="holder">
						<input class="fix6" id="trigger_3" type="text" value="" readOnly="readOnly" name="trigger_3" onclick="slide.fileTrigger(\'image_3\')"/>
						<input type="file" id="image_3" style="display:none" name="image_3" onchange="slide.fileSelect(\'trigger_3\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_3\')"/>
					</div>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Record#4</th>
				<td>
						<input type="radio" class="radio" checked="checked" name="radio_4" /> <label>Required</label><input type="radio" class="radio" name="radio_4" /> <label>Not Receive Voice Record</label>
				</td>
			</tr>
			<tr>
				<th class="highlight2 last">Q.Image#4</th>
				<td class="last" >
					<div class="holder">
						<input class="fix6" id="trigger_4" type="text" value="" readOnly="readOnly" name="trigger_4" onclick="slide.fileTrigger(\'image_4\')"/>
						<input type="file" id="image_4" style="display:none" name="image_4" onchange="slide.fileSelect(\'trigger_4\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_4\')"/>
					</div>
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 14){
			echo'<tr>
				<th class="highlight">Record#1<span class="neccesary">*</span></th>
				<td>
						<input type="radio" checked="checked" class="radio" name="radio_1" value="1" /> <label>Required</label><input type="radio" class="radio" name="radio_1" value="0" /> <label>Not Receive Voice Record</label><span class="prompt">Attach image file for each question. Recommend 300x150 pixel size.</span>
				</td>
			</tr>
			<tr>
				<th class="highlight">Q.Text#1<span class="neccesary">*</span></th>
				<td >
					<input type="text" name="question_1" validate="required" maxlength="100" value="" class="fix6" onkeyup="slide.character(this,100)" /> <span class="character">0</span>/100 Byte
				</td>
			</tr>
			<tr>
				<th class="highlight">Q.Image#1<span class="neccesary">*</span></th>
				<td >
					<div class="holder">
						<input class="fix6" validate="required" id="trigger_1" type="text" value="" readOnly="readOnly" name="trigger_1" onclick="slide.fileTrigger(\'image_1\')"/>
						<input type="file" id="image_1" style="display:none" name="image_1" onchange="slide.fileSelect(\'trigger_1\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_1\')"/>
					</div>
					<span class="prompt">We recommend this image file size to 140x100 pixel and JPG file type.</span>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Record#2</th>
				<td>
						<input type="radio" checked="checked" class="radio" name="radio_2" value="1" /> <label>Required</label><input type="radio" class="radio" name="radio_2" value="0" /> <label>Not Receive Voice Record</label><span class="prompt">If you are request, You have to record voice at Record Question.</span>
				</td>
			</tr>
			<tr>
				<th class="highlight2">Q.Text#2</th>
				<td >
					<input type="text" name="question_2" maxlength="100" value="" class="fix6" onkeyup="slide.character(this,100)" /> <span class="character">0</span>/100 Byte
				</td>
			</tr>
			<tr>
				<th class="highlight2">Q.Image#2</th>
				<td >
					<div class="holder">
						<input class="fix6" id="trigger_2" type="text" value="" readOnly="readOnly" name="trigger_2" onclick="slide.fileTrigger(\'image_2\')"/>
						<input type="file" id="image_2" style="display:none" name="image_2" onchange="slide.fileSelect(\'trigger_2\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_2\')"/>
					</div>
				</td>
			</tr>
			<tr>
				<th class="highlight">Record#3</th>
				<td>
						<input type="radio" checked="checked" class="radio" name="radio_3" value="1" /> <label>Required</label><input type="radio" class="radio" name="radio_3" value="0" /> <label>Not Receive Voice Record</label>
				</td>
			</tr>
			<tr>
				<th class="highlight">Q.Text#3</th>
				<td >
					<input type="text" name="question_3" maxlength="100" value="" class="fix6" onkeyup="slide.character(this,100)" /> <span class="character">0</span>/100 Byte
				</td>
			</tr>
			<tr>
				<th class="highlight last">Q.Image#3</th>
				<td class="last">
					<div class="holder">
						<input class="fix6" id="trigger_3" type="text" value="" readOnly="readOnly" name="trigger_3" onclick="slide.fileTrigger(\'image_3\')"/>
						<input type="file" id="image_3" style="display:none" name="image_3" onchange="slide.fileSelect(\'trigger_3\',this)"/>
						<input  type="button" value="Browse"  class="browse" onclick="slide.fileTrigger(\'image_3\')"/>
					</div>
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 16){
			echo '<tr>
				<th>Kor. Sentence#1<span class="neccesary">*</span></th>
				<td>
					<input type="text" name="word_1" maxlength="200" value="" class="fix6" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte
					<span class="prompt">You have to write korean sentence, Student will write as english. (Teacher have to mark manually)</span>
				</td>
			</tr>
			<tr>
				<th>Kor. Sentence#2</th>
				<td >
					<input type="text" name="word_2" maxlength="200" value="" class="fix6" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte
				</td>
			</tr>
			<tr>
				<th>Kor. Sentence#3</th>
				<td >
					<input type="text" name="word_3" maxlength="200" value="" class="fix6" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte
				</td>
			</tr>
			<tr>
				<th>Kor. Sentence#4</th>
				<td >
					<input type="text" name="word_4" maxlength="200" value="" class="fix6" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte
				</td>
			</tr>
			<tr>
				<th>Kor. Sentence#5</th>
				<td >
					<input type="text" name="word_5" maxlength="200" value="" class="fix6" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte
				</td>
			</tr>
			<tr>
				<th class="last">Kor. Sentence#6</th>
				<td class="last">
					<input type="text" name="word_6" maxlength="200" value="" class="fix6" maxlength="250" onkeyup="slide.character(this,250)"/> <span class="character">0</span>/250 Byte
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 17){
			echo '<tr>
				<th class="last">Fill Sentence#<span class="neccesary">*</span></th>
				<td class="last">
					<input type="radio" name="long" value="1" checked="checked" /> <label>1</label>
					<input type="radio" name="long" value="2" /> <label>2</label>
					<input type="radio" name="long" value="3" /> <label>3</label>
					<input type="radio" name="long" value="4" /> <label>4</label>
					<input type="radio" name="long" value="5" /> <label>5</label>
					<input type="radio" name="long" value="6" /> <label>6</label>
					<input type="radio" name="long" value="7" /> <label>7</label>
					<input type="radio" name="long" value="8" /> <label>8</label>
					<input type="radio" name="long" value="9" /> <label>9</label>
					<input type="radio" name="long" value="10" /> <label>10</label>
					<input type="radio" name="long" value="11" /> <label>11</label>
					<input type="radio" name="long" value="12" /> <label>12</label>
				</td>
			</tr>';
		}
		else if($aArgs['type'] == 19){
		
		}
		else if($aArgs['type'] == 20){
		
		}
	}
}
?>