<?php echo Common::displayMenu(true,array("label"=>"Add New User","most_action"=>"LMSTeachersList.addUser"));?>
<!--hidden info for admin user-->
<input type="hidden" name="sess_idx" id="sess_idx" value="<?=$_SESSION['idx']?>" />
<input type="hidden" name="sess_user_id" id="sess_user_id" value="<?=$_SESSION['user_id']?>" />
<input type="hidden" name="sess_grade_idx" id="sess_grade_idx" value="<?=$_SESSION['grade_idx']?>" />
<div class="top_2">
    <div class="apply_filter">
        <label>Teacher Name: </label>
        <input type="text" id="keyword" name="keyword" value="" />
        <a href="javascript: void(0);" class="btn_apply" onclick="javascript: window.location.href = '<?php Common::urlInclude('search'); ?>' + $('#keyword').val();">Search</a>
    </div>
</div>
<div class="top_2">
    <div class="apply_action">
        <a href="javascript: void(0);" class="btn_apply" onclick="javascript: LMSTeachersList.deleteThis();">Delete</a>
    </div>

    <div class="show_rows">
        Show Rows

        <select id="showRows" onchange="javascript: window.location.href = '<?php Common::urlInclude('rows'); ?>' + $('#showRows').val();">
            <option <?php if($iRowPerPage == 10){echo "selected";} ?>>10</option>
            <option <?php if($iRowPerPage == 20){echo "selected";} ?>>20</option>
            <option <?php if($iRowPerPage == 50){echo "selected";} ?>>50</option>
        </select> 
    </div>

</div>
<table cellspacing="0" class="post_table">
    <colgroup>
        <col width="40px" />
        <col width="40px" />
        <col width="200px" />	
        <col width="200px" />	
        <col width="200px" />				
        <col width="200px" />
        <col width="200px" />
        <col width="120px" />
    </colgroup>
    <thead>
        <tr>
            <th><input type="checkbox" class="input_chk check_all" onchange="javascript: LMSTeachersList.checkAll(this);"/></th>
            <th>No.</th>
            <th >ID</th>
            <th>Name</th>
            <th>Profile Picture</th>
            <th>Students #</th>
            <th>Class # of this month</th>
            <th># of Cancel</th>
        </tr>
    </thead>
    <tbody>

<?php 
    if($aTeacher == false)
    { 
         echo '<tr class="event_mouse_over">';
         echo '<td colspan="8" align="center"> No record(s) found.</td></tr>';
    }
    else
    {
        $listcount = count($aTeacher);
        foreach($aTeacher as $key){ ?>

        <tr class="event_mouse_over">
            <td><input type="checkbox" class="input_chk" name="checkThis" value="<?php echo $key['idx']; ?>" /></td>
            <td><?php echo $listcount; ?></td>
            <td><a href="javascript: void(0);"><?php echo $key['user_id']; ?></a></td>
            <td><a href="javascript: void(0);"><?php echo $key['name']; ?></a></td>
            <td><img src=<?php echo BASE_URL.'/image.php?h=100&cr=20:20&path='.$key['profile_img']; ?>></td>
            <td><?php echo $key['number']; ?></td>
            <td><?php echo $key['numberClass']; ?></td>
            <td class="last"><?php echo $key['numberCancel']; ?></td>
        </tr>
    <?php $listcount--;?>
    <?php } }?>	
     <input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>" />
    </tbody>
</table>
<div class="bottom">
        <div class="apply_action">
                <a href="#" class="btn_apply">Delete</a>
        </div>
</div>
<div class="bottom_2">
        <?php echo Common::paginate($iCurPage, $iRowPerPage, $iRowTotRow); ?>
</div>
</div>

<div class="popup_window" id="delete_confirm_1" style="display:none;">
    <div id="dialog-confirm" title="Delete">
        <span>Are you sure you want to delete this item(s)?</span>
    </div>
</div>


