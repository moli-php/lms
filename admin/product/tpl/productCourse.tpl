<?php echo Common::displayMenu(true,array("label"=>"Add New Course","most_action"=>"productCourse.addCourse"));?>

<table cellspacing="0" border="0" cellpadding="0" class="product_search">
	<colgroup>
		<col width="100"/>
		<col width="150"/>
		<col width="150"/>
		<col />
	</colgroup>
	<tbody>
		<tr>
			<th>Course Name</th>
			<td><input type="text" class="fix2" id="search_course" name="search_course" value="<?php if($keyword !=""){ echo $keyword; } ?>"/></td>
			<td><a href="javascript:void(0);" class="btn_apply" id="btn_search_course" name="btn_search_course">Search</a></td>

			<td></td>
		</tr>
	</tbody>
</table>

<div class="top_2">
	<div class="apply_action">
		<a href="javascript:void(0);" class="btn_apply" onclick="productCourse.deleteCourse();">Delete</a>
	</div>
	<ul class="sort_view">
    	<li class="active all"><a href="#">Total Course (<?php echo $iRowTotRow;?>)</a></li>
    </ul>
	<div class="show_rows">
		Show Rows
		<select id="row_selected" onchange="javascript:window.location.href='<?php echo Common::urlInclude('rows');?>'+ $('#row_selected').val();">
			<option value="10" <?php if($iRowPerPage == 10) {?>selected<?php } ?>>10</option>
			<option value="20" <?php if($iRowPerPage == 20) {?>selected<?php } ?>>20</option>
			<option value="50" <?php if($iRowPerPage == 50) {?>selected<?php } ?>>50</option>
		</select>
	</div>
</div>
<table cellspacing="0" class="post_table">
	<colgroup>
		<col width="44" />
		<col width="100" />
		<col  />
	</colgroup>
	<thead>
		<tr>
			<th><input type="checkbox" class="check_all" id="check_all"/></th>
			<th><a href="javascript:void(0);">No.</a></th>
			<?php
			$sUrl .= $sSort == "desc" ? "&sort=asc" : "&sort=desc";
			$sUrl .= $keyword != null ? ("&keyword=" . $keyword) : "";
			$sUrl .= $iRowPerPage != null ? ("&rows=" . $iRowPerPage) : "";

			$sClassSort = $sSort == "desc" ? "sort_down" : "sort_up";
			echo '<th><a href="' . $sUrl . '&order=name" ' . 'class="' . $sClassSort . '"'. '>Course</a></th>';
		    ?>
		</tr>
	</thead>
	<tbody>
        <?php if($iRowTotRow >=1) {
	        foreach($aCourseList as $key=>$details) {?>
		<tr>
			<td><input type="checkbox" name="checkbox_course" value="<?php echo $details['idx'];?>"/></td>
			<td><?php echo $details['iCount'];?></td>
			<td><a href="<?php echo Common::getClassUrl("productCourseAdd")."&idx=".$details['idx']."&page=".$iCurPage;?>"><?php echo $details['name'];?></a></td>
		</tr>
		<?php }
            } else {?>
		    <tr>
		        <td colspan="3" class="data_none">No course found.</td>
		    </tr>
		<?php }?>
	</tbody>
</table>

<div class="popup_window" style="width:280px;;margin-left:30%;margin-top:15%;display:none;" id="popup_delete" name="popup_delete">
	<div class="btn_close fr">
        <a href="javascript: void(0);" class="popup_close"></a>
    </div>
	<table border="0" cellspacing="0" cellpadding="0" class="table_popup">
		<col width="200px" />
		<tr><th class="popup_title">Delete &raquo;</th></tr>
		<tr>
			<th>Are you sure you want to delete these?</th>
		</tr>
	</table>
	<div class="action_btn">
	    <a href="javascript:void(0);" class="btn_save fr" title="Delete" id="delete_del">Delete</a>&nbsp;
		<a href="javascript:void(0);" class="btn_save fr" title="Cancel" id="cancel_del">Cancel</a>&nbsp;
	</div>
</div>

<div class="bottom">
	<div class="apply_action">
		<a href="javascript:void(0);" class="btn_apply" onclick="productCourse.deleteCourse();">Delete</a>
	</div>
</div>
<!-- //product_course_list-->
<input type="hidden" value="<?php if($iCurPage!=null) {echo $iCurPage; } else {echo "1";}?>" id="curr_page" name="curr_page">
<div class="bottom_2">
    <?php echo Common::paginate($iCurPage, $iRowPerPage, $iRowTotRow); ?>
</div>

