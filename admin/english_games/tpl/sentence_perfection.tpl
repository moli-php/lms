<?php echo Common::displayMenu(true,array("label"=>"Add New Question","most_action"=>"Question('add')"));?>
<!-- hidden -->
<input type="hidden" id="rowselected" value="<?php echo $iRow = isset($aArgs['row']) ?  $aArgs['row']  : '20';?>" />
<input type="hidden" id="successparam" value="<?php echo isset($aArgs['success']) ?  $aArgs['success']  : "";?>" />
<input type="hidden" id="keywordparam" value="<?php echo isset($aArgs['keyword']) ?  $aArgs['keyword']  : "";?>" />
<input type="hidden" id="fieldset" value="<?php echo isset($aArgs['field']) ?  $aArgs['field']  : "question";?>" />
<input type="hidden" id="orderset" value="<?php echo isset($aArgs['order']) ?  $aArgs['order']  : "asc";?>" />
<input type="hidden" id="status_hide" value="<?php echo isset($aArgs['status']) ?  $aArgs['status']  : "";?>" />
		<ul class="sort_view" style="float:right">
			<li id="all_select" class="all">
				<a href="#" >All (<?php echo $aPublish+$aUnpublish;?>)</a>
			</li >
			<li id="y_select">
				<a href="#">Published (<?php echo $aPublish?>)</a>
			</li>
			<li id="n_select">
				<a href="#">Unpublished (<?php echo $aUnpublish?>)</a>
			</li>
			<li style="float:right;background:none;cursor:pointer"><input type="text" value="<?php echo isset($aArgs['keyword']) ?  $aArgs['keyword']  : "";?>" id="keyword"/><input style="cursor:pointer"type="submit" value="search" class="btn_apply" id="searchbtn"/></li>
		</ul>
		<div class="top_2">
    		<div class="apply_action">
    			<select id="ActionListTop">
					<option value="">Select Action</option>
					<option value="Publish">Publish</option>
					<option value="Unpublish">Unpublish</option>
					<option value="Delete">Delete</option>
				</select><a id="applytop" class="btn_apply" href="#none" onclick="action(1);">Apply</a>
    		</div>
			<div class="show_rows">
				Show Rows
				<select id="show_row">
                <?php
                $showrow = array("10","20","50");
                foreach($showrow as $row)
                {
                    $sRowSelected = $row == $iRow ? " Selected " : "";
                    echo "<option ".$sRowSelected." value=".$row." >".$row."</option>";
                }
                ?>
				</select>
			</div>
		</div>
		<table cellspacing="0" class="post_table banner">
		<colgroup>
			<col width="60px" />
			<col width="50px" />
			<col  />
			<col width="250px" />
			<col width="120px" />
			<col width="60px" />
			<col width="80px" />

		</colgroup>
		<thead>
			<tr>
				<th><input type="checkbox" class="check_all"/></th>
				<th>No.</th>
				<th><a href="#none" class="sort_down" id="question">Question</a></th>
				<th><a href="#none" class="sort_down" id="answer">Answer</a></th>
				<th><a href="#none" class="sort_down" id="level">Level</a></th>
				<th><a href="#none" class="sort_down" id="point">Point</a></th>
				<th><a href="#none" class="sort_down" id="status">Status</a></th>
			</tr>
		</thead>
		<tbody >
		<?php $listcount = $iNoCount;?>
		<input type="hidden" id="chkboxcount" value="<?php echo $listcount;?>" />
			<?php if($listcount>=1){?>
			<?php foreach ($aData as $list): ?>
				<?php

								
				$question = explode(' ',$list['question']);

				$arr = str_replace(',','',$question);

				$ar = array();
				for($s=0;$s<=count($arr)-1;$s++){

				$res = '|'.$arr[$s].'|';
				array_push($ar,$res);
				}
				
				$sSubject = implode('#',$ar);
				$sSearch = explode(',',$list['answer']);
				
					$scount = count($sSearch);
					for($i=1;$i<=$scount;$i++){
							$sReplace = '<img src="../../images/question_mark_icon.png" />';

						// $replacearr = array();
						// for($l=1;$l<=strlen($sSearch[$i])-2;$l++){
							// $sReplace1 = '_';
							// array_push($replacearr,$sReplace1);
						// }
						
						// $sReplace = implode("",$replacearr);
					
					}


				$sQuestion_1 = str_replace($sSearch,$sReplace,$sSubject);
				$sReadyquestion = str_replace('|','',$sQuestion_1);
				$sReady = str_replace('#',' ',$sReadyquestion);
				$aAnswer = str_replace('|','',$list['answer']);
				
				?>
			<tr>
				<td><input class="chkboxlist<?php echo $listcount?>" type="checkbox" name="ListCheck" value="<?php echo $list['idx']?>"/></td>
				<td><?php echo $listcount;?></td>
				<td><a href="javascript:Question(<?php echo $list['idx']?>);"><?php echo $sReady?></a></td>
				<td><?php echo $aAnswer?></td>
				<td><?php echo $list['level']?></td>
				<td><?php echo $list['point']?></td>
				<td><?php echo $list['status']?></td>
			</tr>
            <?php $listcount--;?>
		<?php endforeach; 
		$pagination = 'true';
		}else{
		$pagination = 'false';
		echo "<tr><td colspan='7'>Empty List!</td></tr>";
		}
		
		?>
		</tbody>
	</table>
	<div class="bottom">
		<div class="apply_action">
			<select id="ActionListBottom">
				<option value="">Select Action</option>
				<option value="Publish">Publish</option>
				<option value="Unpublish">Unpublish</option>
				<option value="Delete">Delete</option>
			</select><a id="applybottom" class="btn_apply" href="#none" onclick="action(2);">Apply</a>
		</div>
	</div>
	
<?php 
if ($pagination=='true'){
echo Common::paginate($iCurPage, $iRowPerPage, $iRowTotRow); 
 } ?>
	
<div class="message_dialog recordform_dialog" id="addquestion" style="display:none">
<div id="warningtpl"></div>
	<form name='questionadd' id='questionadd'>
		<b>Correct Sentence</b> </br><input type="text" id="questionField" style="margin-top:5px;width:600px"/>
		</br><i>e.g : My name is Philip</i>
		</br></br>
		<b>Answer(s) to be hide</b> </br><input type="text" id="answerField" style="margin-top:5px;width:600px"/>
		</br><i>Separate by comma e.g : name,is</i><br><br>
		<b>Point(s):</b> <input type="text" id="points" maxlength="2" style="width:30px"/><span id="levelspan" style="margin-left:10px"><b>Level:</b>
		<select id="level_id"></select>
		</span><br><br>
		<b>Status</b><br><br>
		<input style="margin-left:10px" type="radio" name="status_" value="Published"> Published <br>
		<input style="margin-left:10px" type="radio" name="status_" value="Unpublished" checked="checked"> Unpublished<br><br>
		<span style="float:right"><a id="savebtn" class="btn_save" href="#none">Submit</a><a id="cancelbtn" class="btn_save" href="javascript:cancel();">Cancel</a></span>
	</form>
	<div id="allowed_array" style="display:none"></div>
</div>

<div class="popup_window message_content" id="delpopup" style="padding:20px;display:none"></div>
