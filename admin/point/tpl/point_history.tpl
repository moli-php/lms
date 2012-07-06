<?php echo Common::displayMenu(true,array("label"=>"Give Points","most_action"=>"LMSPoint.addPoint"));?>
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
            <td><input type="text" class="fix2" id="personnelName" name="personnelName" validate="required|minlength[3]|maxlength[15]" value="<?php echo $sSearch; ?>" /></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th><label>Period:</label></th>
            <td>
                <input type="text" id="daystart" name="daystart" class="fix4" style="cursor:pointer;" validate="required|minlength[6]|maxlength[100]" value="<?php echo $sStartDate; ?>" readonly="readonly" />
                <span class="period_to">~</span>
                <input type="text" id="dayend" name="dayend" class="fix4" value="<?php echo $sEndDate; ?>" validate="required|minlength[6]|maxlength[100]" readonly="readonly" />
            </td>    
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th></th>
            <td><a href="javascript: void(0);" class="btn_go fr" onclick="LMSPoint.searchQuery();">Search</a></td>
            <td align="left"></td>
            <td></td>
        </tr>
        </tbody>
</table>
</form>
<div class="top_2">
    <div class="apply_action">
        <a href="javascript: void(0);" class="btn_apply" onclick="javascript: LMSPoint.deleteThis();">Delete</a>
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
		<col width="150px" />	
		<col width="150px" />
		<col width="150px" />	
		<col width="150px" />				
		<col width="150px" />
	</colgroup>
	<thead>
            <tr>
                <th><input type="checkbox" class="input_chk check_all" onchange="javascript: LMSTeachersList.checkAll(this);"/></th>
                <th>No.</th>
                <th><a href="javascript: void(0);" class="">User ID</a></th>
                <th><a href="javascript: void(0);" class="">Amount of Points</a></th>
                <th><a href="javascript: void(0);" class="">Type</a></th>
                <th><a href="javascript: void(0);" class="">Reason</a></th>
                <th><a href="javascript: void(0);" class="">Registered Date</a></th>
            </tr>
	</thead>
	<tbody >
    <?php 
        if($query == false)
        { 
             echo '<tr class="event_mouse_over">';
             echo '<td colspan="8" align="center"> No record(s) found.</td></tr>';
        }
        else
        {
            $listcount = count($query); 
            foreach($query as $value){?>
            <tr class="event_mouse_over">
                <td><input type="checkbox" class="input_chk" name="checkThis" value="<?php echo $value['idx']; ?>" /></td>
                <td><?php echo $listcount; ?></td>
                <td><?php echo ucFirst($value['user_id']); ?></td>
                <td><?php echo $value['amount_points']; ?></td>
                <td><?php echo ucFirst($value['status']); ?></td>
                <td><?php echo ucFirst($value['reason']); ?></td>
                <td><?php echo date("Y-m-d",$value['date_registered']); ?></td>
            </tr>
        <?php $listcount--;?>
        <?php } } ?>
        <input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>" />
	</tbody>
</table>
<div class="bottom">
    <div class="apply_action">
        <a href="javascript: void(0);" class="btn_apply" onclick="javascript: LMSPoint.deleteThis();">Delete</a>
    </div>
</div>
<div class="bottom_2">
     <?php echo $paginate; ?>
</div>
        
<div class="popup_window" id="delete_confirm_2" style="display:none;">
    <div id="dialog-confirm" title="Delete">
        <span>Are you sure you want to delete this item(s)?</span>
    </div>
</div>
        