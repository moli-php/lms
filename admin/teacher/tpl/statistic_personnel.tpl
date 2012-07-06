<?php echo Common::displayMenu(true);?>
<input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>" />
<form class="search_form">
<table cellspacing="0" border="0" cellpadding="0" class="product_search point">
    <colgroup>
            <col width="50"/>
            <col width="200"/>
            <col width="150"/>
            <col width="150"/>	
            <col />						
    </colgroup>
    <tbody>
        <tr>
            <th><label>ID / Name:</label></th>
            <td><input type="text" class="fix2" id="personnelName" name="personnelName" validate="required|minlength[3]|maxlength[30]" value="<?php echo $sSearch;?>" /></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th><label>Period:</label></th>
            <td>
                <input type="text" id="daystart" name="daystart" class="fix4" style="cursor:pointer;" validate="required|minlength[6]|maxlength[100]" value="<?php echo $sDayStart;?>" readonly="readonly" />
                <span class="period_to">~</span>
                <input type="text" id="dayend" name="dayend" class="fix4" value="<?php echo $sDayEnd;?>" validate="required|minlength[6]|maxlength[100]" readonly="readonly" />
            </td>    
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th></th>
            <td><a href="javascript: void(0);" class="btn_go fr" onclick="LMSTeachersList.searchQuery();">Search</a></td>
            <td align="left"></td>
            <td></td>
        </tr>
    </tbody>
</table>
</form>
<?php if(!$aTbData){ ?>
<table cellspacing="0" class="post_table" id="stat_personnel" border="0" cellpadding="0">
    <colgroup>
        <col width="150px" />
        <col />
    </colgroup>
    <thead>
        <tr>
            <th colspan="2" class="personnel_name"> No Record(s) found.</th>
         </tr>
    </thead>
</table>
<?php }else{?>
<table cellspacing="0" class="post_table" id="stat_personnel" border="0" cellpadding="0">
    <colgroup>
        <col width="150px" />
        <col />
    </colgroup>
    <thead>
        <tr>
            <th colspan="2" class="personnel_name"> <?php echo $aTbData['name']; ?><span class="puserid">(<?php echo $aTbData['user_id']; ?>)</span> <span class="period_span">&nbsp;<?php echo $aTbData['from'];?>&nbsp;~&nbsp;<?php echo $aTbData['to'];?></span></th>
         </tr>
    </thead>
    <tbody >
        <?php if($sQuery == null){ ?>
        <tr>
            <td> No Record(s) found for this date.</td>
        </tr>
        <?php }else{ 
            foreach($sQuery as $index){ ?>
        <tr>
            <td><?php echo $index['daystart'];?></td>
            <td class="last">
                <p class="remark"><?php echo $index['iClass']; ?> Class / 0 Attend / 0 Cancelled</p>
                <span class="memo_title">Memo</span>
                <textarea class="memo" id="memo_02 memo_id_<?php echo $index['idx'];?>" name="memo_id_<?php echo $index['idx'];?>" rows="0" cols="0"><?php echo $index['memo']; ?></textarea>
                <a href="javascript: void(0);" class="btn_apply save_memo_class" id="save_memo" name="save_memo" onclick="LMSTeachersList.saveMemo(<?php echo $index['idx'];?>);return false;" > Submit </a>
            </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>
<?php }?>
