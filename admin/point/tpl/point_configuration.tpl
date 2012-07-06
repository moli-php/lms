<?php echo Common::displayMenu(true);?>
<input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>" />
<table cellspacing="0" class="post_table">
    <colgroup>
        <col width="100px" />
        <col width="150px" />	
        <col width="150px" />
        <col width="150px" />	
    </colgroup>
    <thead>
        <tr>
            <th ><a href="javascript: void(0);" class="">Reason</a></th>
            <th><a href="javascript: void(0);" class="">Amount</a></th>
            <th><a href="javascript: void(0);" class="">Activated</a></th>
            <th><a href="javascript: void(0);" class="">Manage</a></th>
        </tr>
    </thead>
    <tbody >
        <?php foreach($sQuery as $key): ?>
        <tr>
            <td><?php echo ucfirst($key['reason']); ?></td>
            <td><?php echo $key['amount']; ?></td>
            <td><?php echo ucfirst($key['isActive']); ?></td>
            <td><a href="javascript: void(0);" class="btn_apply" id="manage_id1" name="manage_id1" onclick="LMSPoint.manage(<?php echo $key['idx']; ?>, <?php echo $key['amount']; ?>);" >M</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="popup_window" id="manage_popup">
    <div class="btn_close fr">
        <a href="javascript: void(0);" class="popup_close"></a>
    </div>
    <form class="popup_form">
    <table border="0" cellspacing="0" cellpadding="0" class="table_popup">
        <col width="75px" />
        <col width="200px" />
        <tr><th colspan="2" class="popup_title">Manage Point &raquo;</th></tr>
        <tr><td colspan="2" height="5"></td></tr>
        <tr>
            <th colspan="2">
                <input type="radio" name="inactive" id="active" value="yes" checked="checked" />
                <label class="radio_title" for="active">&nbsp;Activate</label>&nbsp;       
                <input type="radio" name="inactive" id="inactive" value="no" />
                <label class="radio_title" for="inactive">&nbsp;Deactivated</label>
           </th>
        </tr>
        <tr><td colspan="2"></td></tr>
        <tr>
            <th>Amount&nbsp;&#43;</th>
            <td><input type="text" name="amount_points" class="amounts" id="amount_points" value="" validate="required|digits|minlength[3]|maxlength[5]" /></td>
        </tr>
    </table>
    </form>
</div>

