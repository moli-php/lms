<?php echo Common::displayMenu(true,array("label"=>"Back To List","most_action"=>"LMSPoint.backToList"));?>
<input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>" />
<p class="require"><span class="neccesary">*</span>Required</p>
<form name="addPoints" id="addPoints" action="#">
    <table border="0" cellspacing="0" cellpadding="0" class="table_user" >
        <colgroup>
            <col width="135px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th><label>User ID</label><span class="neccesary">*</span></th>
            <td>
                
                <span id="name_wrap"><input type="text" id="userid" name="userid" class="" maxlength="10"  validate="required|minlength[3]|maxlength[15]" readonly="readonly" value="<?php echo $user; ?>" /></span>
                <a href="javascript: void(0);" class="btn_go" id="verify_id" name="verify_id" >Verify ID</a>

            </td>
        </tr>
        <tr>
            <th><label >Reason</label></th>
            <td>
                <select id="reason">
                    <?php foreach ($sQuery as $val): 
                        if($val['reason'] != "Long Term Postponed Class"){ 
                            echo '<option value="'.$val['reason'].'" >'.$val['reason'].'</option>';
                        }
                    endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label >Amount</label></th>
            <td><input type="text" name="amount" id="amount" maxlength="20" value="" class="" validate="required|digits|minlength[3]|maxlength[5]" /></td>
        </tr>
    </table>
</form>					
<div class="action_btn">
    <a href="javascript: void(0);" class="btn_save" title="Add New User" onclick="LMSPoint.savePoints();" >Submit</a>
    <!--<a href="javascript: void(0);" class="btn_return"  title="Return to Point History">Back to List</a>-->
</div>
<!-- pop ups -->
<div class="popup_window" id="find_userid" name="find_userid" style="display:none;width:210px;;margin-left:30%;margin-top:25%">
	<div class="btn_close fr">
        <a href="javascript: void(0);" class="popup_close"></a>
    </div>
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
		<col width="200px" />
		<tr><th colspan="2" class="popup_title">Find User ID &raquo;</th></tr>
                <tr>
                    <th colspan="2"><input type="text" maxlength="100" value="" class="fix2" id="userid_check" name="userid_check"/> </th>
                </tr>
                <tr>
                    <td colspan="2"><span id="userid_not_found" name="userid_not_found" class="not_found"></td>
                </tr>
	</table>
	<div class="action_btn">
		<a href="javascript:void(0);" class="btn_save fr" id="submit_find_userid" name="submit_find_userid" title="Save changes">Submit</a>
	</div>
</div>

<div class="popup_window add_class_list" id="result_userid" name="result_userid" style="display:none;width:210px;;margin-left:30%;margin-top:25%">
    <div class="btn_close fr">
        <a href="javascript: void(0);" class="popup_close"></a>
    </div>
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
		<col width="200px" />
		<tr><th colspan="2" class="popup_title">Result &raquo;</th></tr>

		</tr>
	</table>
	<p>User ID found:<span class="user_id" id="userid_found" name="userid_found"></span></p>
	<p style="width:98%;text-align:center;display:inline-block">Is this correct?</p>
	<div class="action_btn">
		<a href="javascript:void(0);" class="btn_save fr" title="Save changes" id="submit_result_userid">Submit</a>
	</div>
</div>