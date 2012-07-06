<?php echo Common::displayMenu(true,array("label"=>"Send New Email","most_action"=>"CreateEmail"));?>
<!-- hidden -->
<input type="hidden" id="rowselected" value="<?php echo $iRow = isset($aArgs['row']) ?  $aArgs['row']  : '20';?>" />
<input type="hidden" id="successparam" value="<?php echo isset($aArgs['success']) ?  $aArgs['success']  : "";?>" />
<input type="hidden" id="keywordparam" value="<?php echo isset($aArgs['keyword']) ?  $aArgs['keyword']  : "";?>" />
<input type="hidden" id="fieldset" value="<?php echo isset($aArgs['field']) ?  $aArgs['field']  : "title";?>" />
<input type="hidden" id="orderset" value="<?php echo isset($aArgs['order']) ?  $aArgs['order']  : "asc";?>" />
		<ul class="sort_view" style="float:right">
			<li style="float:right;background:none;cursor:pointer"><input type="text" value="<?php echo isset($aArgs['keyword']) ?  $aArgs['keyword']  : "";?>" id="keyword"/><input style="cursor:pointer"type="submit" value="search" class="btn_apply" id="searchbtn"/></li>
		</ul>
		<div class="top_2">
    		<div class="apply_action">
    			<a href="#none" class="btn_apply" id="deltop">Delete</a>
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
			<col width="40px" />
			<col width="60px" />
			<col  />
			<col width="120px" />
			<col width="170px" />
		</colgroup>
		<thead>
			<tr>
				<th><input type="checkbox" class="check_all"/></th>
				<th>No.</th>
				<th><a href="#none" class="sort_down" id="title">Title</a></th>
				<th><a href="#none" class="sort_down" id="sent">Sent To</a></th>
				<th><a href="#none" class="sort_down" id="reg">Registered Date</a></th>
			</tr>
		</thead>
		<tbody >
		<?php $listcount = $iNoCount;?>
		<input type="hidden" id="chkboxcount" value="<?php echo $listcount;?>" />
		<?php if($listcount>=1){?>
		 <?php foreach ($aData as $list): ?>
			<tr>
				<td><input class="chkboxlist<?php echo $listcount?>" type="checkbox" name="ListCheck" value="<?php echo $list['idx']?>"/></td>
				<td><?php echo $listcount;?></td>
				<td><a href="javascript:displayMsg(<?php echo $list['idx']?>);"><?php echo $list['mail_title']?></a></td>
				<td><?php echo $list['sent_count']?></td>
				<td><?php echo $list['reg_date']?></td>
			</tr>
            <?php $listcount--;?>
		<?php endforeach; 
		$pagination = 'true';
		}else{
		$pagination = 'false';
		echo "<tr><td colspan='5'>Empty List!</td></tr>";
		}
		
		?>
		</tbody>
	</table>
	<div class="bottom">
		<div class="apply_action">
			<a href="#none" class="btn_apply" id="delbottom">Delete</a>
		</div>
	</div>
    <div class="popup_window message_content" id="delpopup" style="padding:20px;display:none">

    </div>
	
	<div class="message_dialog recordform_dialog" id="email_msg" style="display:none">

	</div>
	

	
<div class="message_dialog recordform_dialog" id="view_emailadd" style="display:none;word">

</div>


	
<?php 
if ($pagination=='true'){
echo Common::paginate($iCurPage, $iRowPerPage, $iRowTotRow); 
 } ?>


