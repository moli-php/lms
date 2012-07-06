<?php echo Common::displayMenu(true);?>
<div class="top">
    <?php $classId = $this->query('SELECT SUBSTR(RAND('.$cid.'),-7) AS classid'); ?>
	<h3 class="title" id="showTitle"><?php if($classDetails!=null){ ?>Detail Class Page : Class ID : <?php echo $classId[0]['classid']; } else {?>Add New Class<?php } ?></h3>
	<a href="javascript:void(0);" class="btn_back_list" id="back_list" name="back_list">Back to List</a>
</div>

<!-- Manage Form -->
<form name="userAddForm" id="userAddForm" action="#">
    <table border="0" cellspacing="0" cellpadding="0" class="table_user config add_class" >
        <colgroup>
                <col width="135px" />
                <col />
        </colgroup>
        <tr>
            <th><label for="userID">User ID</label></th>
            <td>
                <span id="name_wrap">
                    <input type="text" id="user_id" name="user_id"  readonly/>
                    <a href="javascript:void(0);" class="btn_apply" id="verify_id" name="verify_id">Verify ID</a>
                </span>
            </td>
        </tr>
        <tr>
            <th>Teacher Type</th>
            <td><p class="add_type"><input type="radio" name="teacherType" id="american" <?php if($classDetails[0]['teachertype']=='1' || $classDetails[0]['teachertype']==""){?>checked="checked"<?php } ?>/>&nbsp;<label for="american">American (US)</label></p>
            <p class="add_type"><input type="radio" name="teacherType" id="filipino" <?php if($classDetails[0]['teachertype']=='0'){?>checked="checked"<?php } ?>/>&nbsp;<label for="filipino">Filipino (PH)</label></td>
        </tr>
        <tr>
            <th><label for="banner_title">Class Type</label></th>
            <td><p class="add_type"><input type="radio" name="classType" id="phone" <?php if($classDetails[0]['classtype'] == 'phone' || $classDetails[0]['classtype']==""){?>checked="checked"<?php } ?> />&nbsp;<label for="phone">Phone</label></p>
            <p class="add_type"><input type="radio" name="classType" id="camera"  <?php if($classDetails[0]['classtype'] == 'camera'){?>checked="checked"<?php } ?>/>&nbsp;<label for="videoCam">Video Cam</label></td></p>
        </tr>
        <tr>
            <th><label for="class_period">Class Period</label></th>
            <td>
                <select id="class_period" name="class_period">
                    <option selected="selected"><?php echo $classDetails[0]['period'];?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="class_name">Class Name</label></th>
            <td>
                <select id="class_name" name="class_name">
                </select>
            </td>
        </tr>
        </tr>
        <tr>
            <th><label for="payment">Way of Payment</label></th>
            <td>
                <select id="payment" name="payment">
                    <option value="card" <?php if($classDetails[0]['payment_method'] == "card"){?>selected<?php } else {?>selected<?php } ?>>Card</option>
                    <option value="cash" <?php if($classDetails[0]['payment_method'] == "cash"){?>selected<?php } ?>>Cash</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>Confirmation</th>
            <td><p class="add_type"><input type="radio" name="confirmation" id="confirmed" <?php if($classDetails[0]['sale_status'] == 'confirmed'){?>checked="checked"<?php }?> /> &nbsp;<label for="confirmed">Confirm</label></p>
            <p class="add_type"><input type="radio" name="confirmation" id="not_confirmed" <?php if($classDetails[0]['sale_status'] == 'not_confirmed'){?>checked="checked"<?php } ?> />&nbsp;<label for="not_confirmed">Not Confirm</label></td></p>
        </tr>
    </table>
</form>

<input type="hidden" value="<?php if($classDetails[0]['user_id']!=""){ echo $classDetails[0]['user_id']; } else { echo $uid; };?>" id="uid" name="uid"/>
<input type="hidden" id="inputperiod" name="inputperiod" value="<?php echo $classDetails[0]['period'];?>">
<input type="hidden" id="inputclassname" name="inputclassname" value="<?php echo $classDetails[0]['classname'];?>">
<input type="hidden" id="cid" name="cid" value="<?php echo $cid;?>">

<!-- Back TO List -->
<input type="hidden" id="get_class" name="get_class" value="<?php echo $class;?>">
<input type="hidden" id="get_teacher" name="get_teacher" value="<?php echo $teacher;?>">
<input type="hidden" id="get_branch" name="get_branch" value="<?php echo $branch;?>">
<input type="hidden" id="get_sdate" name="get_sdate" value="<?php echo $sdate;?>">
<input type="hidden" id="get_edate" name="get_edate" value="<?php echo $edate;?>">
<input type="hidden" id="get_name" name="get_name" value="<?php echo $name;?>">
<input type="hidden" id="get_rows" name="get_rows" value="<?php echo $rows;?>">
<input type="hidden" id="get_view" name="get_view" value="<?php echo $view;?>">
<input type="hidden" id="get_vstat" name="get_vstat" value="<?php echo $vstat;?>">
<input type="hidden" id="get_page" name="get_page" value="<?php echo $page;?>">
<input type="hidden" id="count_param" name="count_param" value="<?php echo count($_GET);?>">

<!-- Submit -->
<?php if(($vstat!="deleted" && $vstat!="finished") || !empty($_GET['uid'])){?>
<div class="action_btn">
	<a href="javascript:void(0);" class="btn_save" title="Save changes" id="submit_classlist" name="submit_classlist">Submit</a>
	<a href="javascript:void(0);" class="btn_return"  title="Return to Users" id="reset_classlist" name="reset_classlist">Reset to Default</a>
</div>
<?php }?>

<!-- pop ups -->
<div class="popup_window" id="find_userid" name="find_userid" style="display:none;">
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup" style="width:100%;">
        <tr>
            <th><input type="text" maxlength=10 value="" class="fix2" id="userid_check" name="userid_check"  style="width:100%;"/></th>
        </tr>
        <tr>
            <td><span id="userid_not_found" name="userid_not_found" class="not_found">&nbsp;</td>
        </tr>
	</table>
	<a href="javascript:void(0);" class="btn_save fr" id="submit_find_userid" name="submit_find_userid" title="Save changes">Submit</a>
</div>

<div class="popup_window add_class_list" id="result_userid" name="result_userid" style="display:none;">
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup" style="width:100%;">
		<tr><td>User ID found:<span class="user_id" id="userid_found" name="userid_found"></span></td></tr>
		<tr><td>Is this correct?</td></tr>
	</table>
	<a href="javascript:void(0);" class="btn_save fr" title="Save changes" id="submit_result_userid">Submit</a>
</div>
