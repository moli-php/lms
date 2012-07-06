<?php
echo Common::displayMenu(true);?>

<div class="wrap">
	<h4 class="add_h">Show on Dashboard&nbsp;&nbsp;<input type="checkbox" name="check_all" value="check_all" id="check_all" /><span class="check_all_box">Check All</span><br/></h4>

	<ul class="dashboard_list">
		<li><label for="show_user">User</label><input type="checkbox" name="show_to_dashboard" value="user"/></li>
		<li><label for="show_class">Class</label><input type="checkbox" name="show_to_dashboard" value="class" /></li>
		<li><label for="show_message">Message</label><input type="checkbox" name="show_to_dashboard" value="message" /></li>
		<li><label for="show_product">Product</label><input type="checkbox" name="show_to_dashboard" value="product" /></li>
		<li><label for="show_event">Event</label><input type="checkbox" name="show_to_dashboard" value="event" /></li>
		<li><label for="show_ulearning">uLearning</label><input type="checkbox" name="show_to_dashboard" value="ulearning" /></li>
		<li><label for="show_test_result">Test Result</label><input type="checkbox" name="show_to_dashboard" value="test_result" /></li>
		<li><label for="show_branch">Branch</label><input type="checkbox" name="show_to_dashboard" value="branch" /></li>
		<li><label for="show_point">Point</label><input type="checkbox" name="show_to_dashboard" value="point" /></li>
		<li><label for="show_absent_student">Absent Student</label><input type="checkbox" name="show_to_dashboard" value="absent_student" /></li>
		<li><label for="show_canceled_class">Cancelled Class</label><input type="checkbox" name="show_to_dashboard" value="cancelled_class" /></li>
	</ul>

    <div class="dash">
    	<ul class="dashboard_order">
    	</ul>

        <ul class="sort_buttons">
    		<li><input type="button" name="up" id="up" class="btn_sort" value="▲" /></li>
    	    <li><input type="button" name="down" id="down" class="btn_sort" value="▼" /></li>
        </ul>
    </div>

	<div class="action_btn">
		<a href="javascript:void(0);" class="btn_save" title="Save changes" id="btn_save_show" name="btn_save_show">Save</a>
		<a href="javascript:void(0);" class="btn_return"  title="Undo changes" id="btn_undo" name="btn_undo">Undo changes</a>
		<a href="javascript:void(0);" class="btn_return"  title="Return to Dashboard" id="btn_return" name="btn_return">Return to Dashboard</a>
	</div>
	</div>

</div>
