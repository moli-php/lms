<?php echo Common::displayMenu(true, array("label"=>"Add New Grade","most_action"=>"LMSTeachersList.addGrade"));?>
<input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>" />
<div class="top_2">
    <div class="apply_action">
        <a href="javascript: void(0);" class="btn_apply" onclick="javascript: LMSTeachersList.deleteGrade();">Delete</a>
    </div>
</div>
<table cellspacing="0" class="post_table">
    <colgroup>
        <col width="20px" />
        <col width="20px" />
        <col width="120px" />	
        <col width="120px" />	
    </colgroup>
    <thead>
        <tr>
            <th><input type="checkbox" class="input_chk check_all" onchange="javascript: LMSTeachersList.checkAll(this);"/></th>
            <th>No.</th>
            <th ><a href="javascript: void(0);" class="">Teacher Type</a></th>
            <th><a href="javascript: void(0);" class="">Description</a></th>
        </tr>
    </thead>
    <tbody >
    <?php 
    if($aTbData == false)
    { 
         echo '<tr class="event_mouse_over">';
         echo '<td colspan="4" align="center"> No record(s) found.</td></tr>';
    }
    else
    {
        $listcount = count($aTbData);
        foreach($aTbData as $key){ ?>
            <tr class="event_mouse_over">
                <td><input type="checkbox" class="input_chk" name="checkThis" value="<?php echo $key['idx']; ?>" /></td>
                <td><?php echo $listcount; ?></td>
                <td><a href="javascript: void(0);" id="editGrade" name="editGrade" onclick="javascript: LMSTeachersList.modifyPopUp(<?php echo $key['idx']; ?>);" ><?php echo $key['grade_name']; ?></a></td>
                <td><?php echo $key['description']; ?></td>
            </tr> 
        <?php $listcount--;?>
        <?php } 
    } ?>	
      
    </tbody>
</table>
    
    
<div class="popup_window" id="add_grademanage" style="display:none;">
    <div class="btn_close fr">
        <a href="javascript: void(0);" class="popup_close"></a>
    </div>
    <table border="0" cellspacing="0" cellpadding="0" class="table_popup">
        <col width="80px" />
        <tr><th colspan="2" class="popup_title">Add Grade &raquo;</th></tr>
        <tr>
            <th class="strong">Grade Name: </th>
            <td><input type="text" name="gradeName" id="gradeName" maxlength="100" value="" class="fix4" /> </td>
        </tr>
        <tr>
            <th class="strong">Decription: </th>
            <td><input type="text" name="gradeDesc" id="gradeDesc" maxlength="100" value="" class="fix4" /> </td>
        </tr>

    </table>

</div>
<div class="popup_window" id="modify_grademanage" style="display:none;">
    <div class="btn_close fr">
        <a href="javascript: void(0);" class="popup_close"></a>
    </div>
  
    <table border="0" cellspacing="0" cellpadding="0" class="table_popup">
        <col width="80px" />
        <tr><th colspan="2" class="popup_title">Modify Grade &raquo;</th></tr>
        <tr>
            <th class="strong">Grade Name: </th>
            <td><input type="text" name="mGradeName" id="mGradeName" maxlength="100" value="" class="fix4" /> </td>
        </tr>
        <tr>
            <th class="strong">Decription: </th>
            <td><input type="text" name="mGradeDesc" id="mGradeDesc" maxlength="100" value="" class="fix4" /> </td>
            <td><input type="hidden" name="mIdx" id="mIdx" maxlength="100" value="" class="fix4" /> </td>
           
        </tr>

    </table>
   
</div>
<div class="bottom">
    <div class="apply_action">
        <a href="javascript: void(0);" class="btn_apply">Delete</a>
    </div>
    <div class="bottom_2">
        <?php Common::paginate($iCurPage, $iRowPerPage, $iRowTotRow); ?>
    </div>  
</div>
    
<div class="popup_window" id="delete_confirm" style="display:none;">
    <div id="dialog-confirm" title="Delete">
        <span>Are you sure you want to delete this item(s)?</span>
    </div>
</div>
