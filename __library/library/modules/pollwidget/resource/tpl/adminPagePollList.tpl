<div id='pollwidget_delete_popup_contents' style='display:none'>
<div class="admin_popup_contents">
Are you sure you want to delete the selected Poll?
<br />
<br />
<a class="btn_nor_01 btn_width_st1" href="javascript: void(0);" style='cursor:pointer' title="Delete"
onclick="javascript: adminPagePollList.DeleteCheckedValues();"> Delete </a>
</div>
</div>

<div id='pollwidget_delete_2_popup_contents' style='display:none'>
<div class="admin_popup_contents">
One of the selected Poll is now <font color="red">(in progress.)</font>
Do you really want to delete this?
<br />
<br />
<a class="btn_nor_01 btn_width_st1" href="javascript: void(0);" style='cursor:pointer' title="Delete"
onclick="javascript: adminPagePollList.DeleteCheckedValues();"> Delete </a>
</div>
</div>

<span>
    <form name="pollwidget_settings" class="pollwidget_settings" method="post">
    <strong>Graph Display Settings:</strong>
    &nbsp;
    &nbsp;
    <input type="radio" title="" class="input_text" value="1" name="graph" <?php if($sSettings == 1 || !$sSettings) echo "checked"; ?> />  Horizontal
    &nbsp;
    &nbsp;
    <input type="radio" title="" class="input_text" value="2" name="graph" <?php if($sSettings == 2) echo "checked"; ?> />  Vertical
    &nbsp;
    &nbsp;
    <a href="javascript: void(0);" onclick="javascript: pollwidget_settings.submit();" class="btn_nor_01 btn_width_st1" title="save">Save</a>
    </form>
</span>
<br />
<br />
<table border="0" cellpadding="3" cellspacing="0" class="table_hor_03">
    <tr>
        <td>
            <table cellpadding="10" cellspacing="10">
                <tr>
                    <td><span  class="title">Reg date: </span></td>
                    <td>
                    <select class="optionbox" id="options" onchange="javascript: adminPagePollList.set_Options();">
                        <option selected>Select Period</option>
                        <option value="1">Today</option>
                        <option value="3">Current Month</option>
                        <option value="4" >Last Month</option>
                        <option value="5">Current Year</option>
                        <option value="6">Last Year</option>
                    </select>&nbsp; :
                    </td>
                    <td><input type="text" id="start" class="fix" style="width: 150px;" readonly></td>
                    <td>~  &nbsp;<input type="text" id="end" class="fix" style="width: 150px;" readonly></td>
                </tr>
                <tr>
                    <td><span  class="title">Poll Title:</span></td>
                    <td colspan="3">
                        <span id="search_post">
                            <input type="text" title="" class="input_text" value="" id="keyword" maxlength="250" />
                            <a href="javascript: void(0);" onclick="javascript: adminPagePollList.SearchPoll('<?php echo $sUrl; ?>');" class="btn_nor_01 btn_width_st1" title="search">Search</a>
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br />
<br />
<a href="<?php echo $sUrl.$sPage; ?>" title="Show all polls">All(<?php echo $iCountAll; ?>)</a> &nbsp; | &nbsp;
<a href="<?php echo $sUrl; ?>&status=waiting"  title="Show waiting polls only">Waiting(<?php echo $iCountWaiting; ?>)</a> &nbsp; | &nbsp;
<a href="<?php echo $sUrl; ?>&status=ongoing"  title="Show ongoing polls only">Ongoing(<?php echo $iCountOnGoing; ?>)</a> &nbsp; | &nbsp;
<a href="<?php echo $sUrl; ?>&status=done"  title="Show done polls only">Done(<?php echo $iCountDone; ?>)</a>
<br />
<br />
<table border="1" cellpadding="0" cellspacing="0" class="table_hor_02">
<colgroup>
    <col width="44px" />
    <col width="44px" />
    <col />
    <col width="450px" />
    <col width="160px" />
</colgroup>
<thead>
   <tr>
        <th class="chk"><input type="checkbox" class="input_chk chk_all" onchange="javascript: adminPagePollList.CheckAll();"/></th>
        <th width="10px">No.</th>
        <th>Title</th>
        <th width="100px"><a href="<?php echo $sUrl.$sPage.$sSearch; ?>&sortby=period_start&sort=<?php echo $sSort; ?>" class="<?php echo $sPeriodClass; ?>">Period</a></th>
        <th width="100px"><a href="<?php echo $sUrl.$sPage.$sSearch; ?>&sortby=reg_date&sort=<?php echo $sSort; ?>" class="<?php echo $sRegDateClass; ?>">Reg Date</a></th>
        <th width="100px"># Qstn</th>
        <th width="100px">Reply</th>
        <th width="100px">Status</th>
        <th width="100px">Management</th>
   </tr>
</thead>
<tbody>
<?php
$counter = $iStartCount;
if(count($aContents) > 0)
{
    foreach($aContents as $val) {
    ?>
        <tr class="event_mouse_over">
            <td><input type="checkbox" class="input_chk" name="adminPagePollid[]" value="<?php echo $val['idx']; ?>" /></td>
            <td><?php echo $counter; ?></td>
            <td><?php echo $val['title']; ?></td>
            <td><?php echo $val['period_start']." ~ ".$val['period_end']; ?></td>
            <td><?php echo date('Y-m-d H:i:s', $val['reg_date']); ?></a></td>
            <td><?php echo $val['qstn_num']; ?></td>
            <td><?php echo $val['rply_num']; ?></td>
            <td id="Status_<?php echo $val['idx']; ?>"><?php echo $val['status']; ?></td>
            <td>
                <?php if($val['status'] == OnGoing || $val['status'] == 'Done'){ ?>
                    <a href="<?php echo $sUrlresult; ?>&idx=<?php echo $val['idx'];?>" class="btn_nor_01 btn_width_st1" title="result">Result</a>
                <?php } ?>
                <?php if($val['status'] == 'Waiting'){ ?>
                    <a href="<?php echo $sUrledit; ?>&idx=<?php echo $val['idx'];?>" class="btn_nor_01 btn_width_st1" title="modify">Modify</a>
                <?php } ?>
            </td>
        </tr>
    <?php
    $counter--;
    }
}
else
{
?>
    <tr class="event_mouse_over">
          <td colspan="9">No result found.</td>
    </tr>
<?php
}
?>
</tbody>
</table>
<br />
<a href="javascript: void;" onclick="javascript: adminPagePollList.Delete();" class="btn_nor_01 btn_width_st1" title="delete">Delete</a>
<?php echo $sPagination; ?>
