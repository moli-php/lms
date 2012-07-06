<?php
echo Common::displayMenu(false);

function displayContent($value){
    $fixedName = ucwords(str_replace("_", " ", $value['item_name']));
?>
    <div class="top_content">
	    <strong class="total_count">Total <?php echo $fixedName." : <span>(".$value['total']; ?>)</span></strong>
    <?php

    //USER
    if($value['item_name'] == "user"){
        ?>
        <strong class="view_link"><a target="_blank" href="<?php echo BASE_URL."admin/user/"; ?>" >View All</a></strong></div>
        <ul class="count_summary">
			<li>Students <span>(<?php echo $value['no_students'];?>)</span></li>
			<li>Teachers <span>(<?php echo $value['no_teachers'];?>)</span></li>
			<li>Head Teachers <span>(<?php echo $value['no_teachers_head'];?>)</span></li>
			<li>Branch <span>(<?php echo $value['no_branches'];?>)</span></li>
		</ul>
        <p class="title_recent">Recently Added <?php echo $fixedName; if(count($value['list'])>1) { echo "s";}?></p>

        <table cellspacing="0" cellpadding="0" border="0"><tbody>
        <?php
        if(count($value['list']) >= 1){
            foreach($value['list'] as $key=>$val){ ?>
                <tr>
    				<td><?php echo $key+1;?>.</td>
    				<td><img class="thumbnail_35px" src="<?=BASE_URL?>uploads/<?=$val['profile_img']?>" width="25px" height="25px" /></td>
    				<td><a target="_blank" href="<?php echo BASE_URL."admin/user/?sub=modify_user&user_id=".$val['idx']; ?>"><?php echo ucwords(strtolower(dashboard::checkString($val['name'],20))); ?></a></td>
    				<td><?php echo ucwords(strtolower(dashboard::checkString($val['nickname'],20))); ?></td>
    				<td>(<?php echo strtolower($val['user_id']);?> |
    				<?php echo strtolower(dashboard::checkString($val['email'],30)); ?>)</td>
    				<td><?php echo date("Y/m/d", $val['date_reg'])?></td>
    			</tr>
    		<?php }
        } else{ ?>
            <tr><td colspan="6"><p class="no_entry">No Recently Added User.</p></td></tr>
        <?php } ?>
		</tbody></table>
	<?php

	//CLASS
    } else if($value['item_name'] == "class"){
        ?>
        <strong class="view_link"><a target="_blank" href="<?php echo BASE_URL."admin/class/"; ?>" >View All</a></strong></div>
        <ul class="count_summary">
			<li>Only Applied <span>(<?php echo $value['only_applied'];?>)</span></li>
			<li>Scheduled <span>(<?php echo $value['scheduled'];?>)</span></li>
			<li>Finished <span>(<?php echo $value['finished'];?>)</span></li>
			<li>Deleted <span>(<?php echo $value['deleted'];?>)</span></li>
		</ul>
        <p class="title_recent">Recently Applied <?php echo $fixedName; if(count($value['list'])>1) { echo "es";}?></p>

        <table cellspacing="0" cellpadding="0" border="0"><tbody>
        <?php
        if(count($value['list']) >= 1){
            foreach($value['list'] as $key=>$val){
                ?>
                <tr>
    				<td><?php echo $key+1;?>.</td>
    				<td><a target="_blank" href="<?php echo BASE_URL."admin/class/?action=classManageList&cid=".$val['main_idx']; ?>"><?php echo ucwords(strtolower(dashboard::checkString($val['full_name'],20))); ?></a></td>
    				<td>(<?php echo ucwords(dashboard::checkString($val['classname'],30));?> : <?php echo $val['period']."month"; if($val['period']>=2){ echo "s";}?>)</td>
                    <td>$<?php echo $value['c_amount'][$key];?></td>
    				<td><?php echo date("Y/m/d", $val['datetime_created'])?></td>
    			</tr>
    		<?php }
		} else{ ?>
            <tr><td colspan="5"><p class="no_entry">No Recently Applied Class.</p></td></tr>
        <?php } ?>
		</tbody></table>
	<?php

    //MESSAGE
    } else if($value['item_name'] == "message"){
        ?>
        <strong class="view_link"><a target="_blank" href="<?php echo BASE_URL."admin/message/"; ?>" >View All</a></strong></div>
        <ul class="count_summary">
    		<li>Read <span>(<?php echo $value['m_read_main'];?>)</span></li>
    		<li>Unread <span>(<?php echo $value['m_unread_main'];?>)</span></li>
    	</ul>
    	<p class="title_recent">Recently Added Advice <?php echo $fixedName; if(count($value['list'])>1) { echo "s";}?></p>

        <table cellspacing="0" cellpadding="0" border="0"><tbody>
        <?php
        if(count($value['list']) >= 1){
            foreach($value['list'] as $key=>$val){ ?>
                <tr>
    				<td><?php echo $key+1;?>.</td>
    				<td><a target="_blank" href="<?php echo BASE_URL."admin/message/?view_message=".$val['idx']; ?>"><?php echo ucfirst(dashboard::checkString($val['title'],60)); ?></a></td>
    				<td>(<?php echo $value['m_number'][$key]." Repl"; if($value['m_number'][$key] >=2){ echo "ies"; } else { echo "y";}?>)</td>
    				<td><?php echo date("Y/m/d", $val['date_reg'])?></td>
    			</tr>
    		<?php }
        } else{ ?>
            <tr><td colspan="4"><p class="no_entry">No Recently Added Advise Message.</p></td></tr>
        <?php } ?>
		</tbody></table>
        <?php

    //PRODUCT
    } else if($value['item_name'] == "product"){
        ?>
        <strong class="view_link"><a target="_blank" href="<?php echo BASE_URL."admin/product/"; ?>" >View All</a></strong></div>
        <ul class="count_summary">
			<li>Actived <span>(<?php echo $value['p_active'];?>)</span></li>
			<li>Deactivated <span>(<?php echo $value['p_inactive'];?>)</span></li>
		</ul>
		<p class="title_recent">Recent <?php echo $fixedName; if(count($value['list'])>1) { echo "s";}?></p>

        <table cellspacing="0" cellpadding="0" border="0"><tbody>
        <?php
        if(count($value['list']) >= 1){
            foreach($value['list'] as $key=>$val){
                ?>
                <tr>
    				<td><?php echo $key+1;?>.</td>
                    <td><a target="_blank" href="<?php echo BASE_URL."admin/product/?action=productClassEdit&idx=".$val['idx']; ?>"><?php echo ucfirst(dashboard::checkString($val['name'],20));?></a> : <?php echo $val['total_months']." month"; if($val['total_months']>=2){ echo "s";}?></td>
    				<td><img src="../../images/class/<?php echo $val['type'];?>.png" title="<?php echo "using ".$val['type'];?>" alt="type" style="width:13px;">&nbsp;<?php if($val['teacher_type'] == 0){ echo "Filipino"; } else { echo "American";} ?> Teacher</td>
    				<td><a target="_blank" href="<?php echo BASE_URL."admin/product/?action=productClassEdit&idx=".$val['idx']; ?>"><?php echo ucfirst(dashboard::checkString($val['description'],20));?></a></td>
    				<td>$<?php echo number_format($val['price'], 2, '.', ',');?></td>
    				<td><?php echo date("Y/m/d", $val['datetime_update'])?></td>
    			</tr>
    		<?php }
        } else{ ?>
            <tr><td colspan="6"><p class="no_entry">No Recent Product.</p></td></tr>
        <?php } ?>
		</tbody></table>
	<?php

    //EVENT
    } else if($value['item_name'] == "event"){
        ?>
        <strong class="view_link"><a target="_blank" href="<?php echo BASE_URL."admin/event/?action=popup_editor"; ?>" >View All</a></strong></div>
        <ul class="count_summary">
			<li>Activated <span>(<?php echo $value['e_active'];?>)</span></li>
			<li>Deactivated <span>(<?php echo $value['e_inactive'];?>)</span></li>
		</ul>
		<p class="title_recent">Recent Pop up <?php echo $fixedName;?> Title<?php if(count($value['list'])>1) { echo "s";}?></p>

        <table cellspacing="0" cellpadding="0" border="0"><tbody>
        <?php
        if(count($value['list']) >= 1){
            foreach($value['list'] as $key=>$val){ ?>
                <tr>
    				<td><?php echo $key+1;?>.</td>
    				<td><a target="_blank" href="<?php echo BASE_URL."admin/event/?action=add_popup&idx=".$val['idx']; ?>"><?php echo ucfirst(dashboard::checkString($val['title'],60));?></a></td>
    				<td><?php if($_SESSION['grade_idx'] == 9){?>(Added by <?php echo ucfirst($val['user_id']);?>)<?php } ?></td>
    				<td><?php echo date("Y/m/d", $val['date_created'])?></td>
    			</tr>
    		<?php }
        } else{ ?>
            <tr><td colspan="4"><p class="no_entry">No Recent Pop up Event Title.</p></td></tr>
        <?php } ?>
		</tbody></table>
        <?php

    //ULEARNING
    } else if($value['item_name'] == "ulearning"){
        ?>
        <strong class="view_link"><a target="_blank" href="<?php echo BASE_URL."admin/ulearning/"; ?>" >View All</a></strong></div>
        <p class="title_recent">Recent Test<?php if(count($value['list'])>1) { echo "s";}?> | Ulearning</p>

        <table cellspacing="0" cellpadding="0" border="0"><tbody>
        <?php
        if(count($value['list']) >= 1){
            foreach($value['list'] as $key=>$val){
                if($val['u_cat_main_idx'] == 1){
                    $uAction = "class_mat";
                } else if($val['u_cat_main_idx'] == 2){
                    $uAction = "homework";
                } else {
                    $uAction = "leveltest_test";
                }
                ?>
                <tr>
    				<td><?php echo $key+1;?>.</td>
    				<td><a target="_blank" href="<?php echo BASE_URL."admin/ulearning/?action="; echo $uAction ."&inner=slide&funit_id=".$val['funit_id']."&category_id=".$val['u_cat_main_idx']; ?>"><?php echo ucwords(dashboard::checkString($val['ftitle'],30));?></a></td>
    				<td>Category :
    				<?php echo ucwords($val['cat_main'])."/".ucwords($val['cat_depth1'])."/".ucwords($val['cat_depth2']);?></td>
    				<td><?php echo date("Y/m/d", $val['fdate'])?></td>
    			</tr>
    		<?php }
		} else{ ?>
            <tr><td colspan="4"><p class="no_entry">No Recent Test.</p></td></tr>
        <?php } ?>
		</tbody></table>
        <?php

    //TEST RESULT
    } else if($value['item_name'] == "test_result"){
        ?>
        <strong class="view_link"><a target="_blank" href="<?php echo BASE_URL."admin/user/"; ?>" >View All</a></strong></div>
        <p class="title_recent">Finished <?php echo $fixedName; if(count($value['list'])>1) { echo "s";}?></p>

        <table cellspacing="0" cellpadding="0" border="0"><tbody>
        <?php
        if(count($value['list']) >= 1){
            foreach($value['list'] as $key=>$val){

                ?>
                <tr>
    				<td><?php echo $key+1;?>.</td>
    				<td><a href="javascript:test_evaluation.manage(<?php echo $val['eval_id'];?>)"><?php echo ucwords(strtolower(dashboard::checkString($val['name'],20)));?></a></td>
    				<td>Grade : <?php echo $val['average'];?></td>
    				<td><?php echo ucwords(dashboard::checkString($val['ftitle'],30));?></a>
    				(<?php echo ucwords($val['fcategory_name'])."/".ucwords($val['fcategory_name2'])."/".ucwords($val['fcategory_name3']);?>)</td>
    				<td><?php echo date("Y/m/d h:i",$val['sdate']);?></td>
    			</tr>
    		<?php }
		} else{ ?>
            <tr><td colspan="6"><p class="no_entry">No Recent Test.</p></td></tr>
        <?php } ?>
		</tbody></table>
        <?php

    //BRANCH
    } else if($value['item_name'] == "branch"){
        ?>
        <strong class="view_link"><a target="_blank" href="<?php echo BASE_URL."admin/branch/"; ?>" >View All</a></strong></div>
        <?php if($_SESSION['grade_idx'] == 9){ ?>
        <ul class="count_summary">
			<li>Active <span>(<?php echo $value['b_active'];?>)</span></li>
			<li>Inactive <span>(<?php echo $value['b_inactive'];?>)</span></li>
		</ul>
		<?php  } ?>
		<p class="title_recent">Recent <?php echo $fixedName; if(count($value['list'])>1) { echo "es";}?></p>

        <table cellspacing="0" cellpadding="0" border="0"><tbody>
        <?php
        if(count($value['list']) >= 1){
            foreach($value['list'] as $key=>$val){ ?>
                <tr>
    				<td><?php echo $key+1;?>.</td>
    				<td><img class="thumbnail_35px" src="<?=BASE_URL?>uploads/<?=$val['profile_img']?>" width="25px" height="25px" /></td>
    				<td><?php echo ucwords($val['name']);?></a> (<?php echo strtolower($val['user_id']);?>)</td>
    				<td><?php echo $value['b_stud'][$key]." Student"; if($value['b_stud'][$key] >=2){ echo "s"; }?></td>
    				<td><?php echo $value['b_teacher'][$key]." Teacher"; if($value['b_teacher'][$key] >=2){ echo "s"; }?></td>
    				<td><?php echo $value['b_head_teacher'][$key]." Head Teacher"; if($value['b_head_teacher'][$key] >=2){ echo "s"; }?></td>
    				<td><?php echo date("Y/m/d", $val['date_reg'])?></td>
    			</tr>
    		<?php }
        } else{ ?>
            <tr><td colspan="7"><p class="no_entry">No Recent Branch.</p></td></tr>
        <?php } ?>
		</tbody></table>
        <?php

    //POINT
    } else if($value['item_name'] == "point"){
        ?>
        <strong class="view_link"><a target="_blank" href="<?php echo BASE_URL."admin/point/"; ?>" >View All</a></strong></div>
        <p class="title_recent">Recent <?php echo $fixedName;?> History</p>

        <table cellspacing="0" cellpadding="0" border="0"><tbody>
        <?php
        if(count($value['list']) >= 1){
            foreach($value['list'] as $key=>$val){ ?>
                <tr>
    				<td><?php echo $key+1;?>.</td>
    				<td><?php echo ucwords(strtolower(dashboard::checkString($val['name'],20))) ." (".strtolower(dashboard::checkString($val['user_id'],10)).")";?></td>
    				<td>(<?php echo ucfirst($val['reason']);?> : <?php echo $val['amount_points']." total points";?>)</td>
    				<td><?php echo date("Y/m/d", $val['date_registered'])?></td>
    			</tr>
    		<?php }
        } else{ ?>
            <tr><td colspan="4"><p class="no_entry">No Recent Point History.</p></td></tr>
        <?php } ?>
		</tbody></table>
        <?php

    //ABSENT STUDENT
    } else if($value['item_name'] == "absent_student"){
        ?>
        <strong class="view_link"><a target="_blank" href="<?php echo BASE_URL."admin/class/?action=absentStudent"; ?>" >View All</a></strong></div>
        <p class="title_recent">Recent <?php echo $fixedName; if(count($value['list'])>1) { echo "s";} ?></p>

        <table cellspacing="0" cellpadding="0" border="0"><tbody>
        <?php
        if(count($value['list']) >= 1){
            foreach($value['list'] as $key=>$val){ ?>
                <tr>
    				<td><?php echo $key+1;?>.</td>
    				<td><?php echo ucwords(strtolower(dashboard::checkString($val['full_name'],20)));?> (<?php echo $val['user_name']; ?>) </a></li></td>
    				<td><img src="../../images/class/<?php echo $val['type'];?>.png" title="Class Type" alt="type" style="width:18px;"></td>
    				<td><?php echo ucwords(dashboard::checkString($val['classname'],20));?> (Time : <?php echo $value['time_start'][$key]." - ".$value['time_end'][$key]; ?>)</td>
    				<td>Teacher : <?php echo ($value['teacher_name'][$key]!="") ? ucwords($value['teacher_name'][$key]) : "None"; ?></td>
    				<td><?php echo date("Y/m/d", strtotime($val['classdate'])); ?></td>
    			</tr>
    		<?php }
         } else{ ?>
            <tr><td colspan="5"><p class="no_entry">No Recently Absent Student.</p></td></tr>
        <?php } ?>
		</tbody></table>
	<?php

    //CANCELLED CLASS
    } else if($value['item_name'] == "cancelled_class"){
        ?>
        <strong class="view_link"><a target="_blank" href="<?php echo BASE_URL."admin/class/?action=classCancelled"; ?>" >View All</a></strong></div>
        <p class="title_recent">Recent <?php echo $fixedName; if(count($value['list'])>1) { echo "es";}?></p>

        <table cellspacing="0" cellpadding="0" border="0"><tbody>
        <?php
        if(count($value['list']) >= 1){
            foreach($value['list'] as $key=>$val){ ?>
                <tr>
    				<td><?php echo $key+1;?>.</td>
    				<td><?php echo ucwords(strtolower(dashboard::checkString($val['full_name'],20)));?> (<?php echo $val['user_name']; ?>) </a></li></td>
    				<td><img src="../../images/class/<?php echo $val['type'];?>.png" title="Class Type" alt="type" style="width:18px;"></td>
    				<td><?php echo ucwords(dashboard::checkString($val['classname'],20));?> (Time : <?php echo $value['time_start'][$key]." - ".$value['time_end'][$key]; ?>) </td>
    				<td>Teacher : <?php echo ($value['teacher_name'][$key]!="") ? ucwords($value['teacher_name'][$key]) : "None"; ?></td>
    				<td><?php echo date("Y/m/d", strtotime($val['classdate'])); ?></td>
    			</tr>
		<?php }
		} else{ ?>
		<tr><td colspan="5"><p class="no_entry">No Recent Cancelled Class.</p></td></tr>
		<?php } ?>
		</tbody></table>
	<?php

    }
}?>



<div id="container">
    <div class="container_wrap">
		<div class="top">
			<h3 class="title" style="margin-left:10px">Dashboard</h3>
		</div>
        <input type="hidden" value="" class="total">
		<div class="wrapper_dashboard">
			<ul class="dashboard">
			<?php
    			$limit = ($limit == null) ? round(count($details)/2) : $limit;
				for($num=0;$num<$limit;$num++){
				    if($details[$num]['item_name']){ ?>
                    <li class="dashboard_item" id="<?php echo $details[$num]['item_name'];?>" >
                        <h2 class="title">
                            <span><?php echo ucwords(str_replace("_", " ", $details[$num]['item_name']));?></span>
                        </h2>
                        <div class="content" >
                        <?php
                            displayContent($details[$num]);
                	     ?>
            	         <div class="loader"><center><img src="../../images/loader.gif" title="Loading"/></center></div>
                        </div>

                    </li>
                <?php }
				} ?>
			</ul>

			<ul class="dashboard">
				<?php for($num=$limit;$num<count($details);$num++){
				    if($details[$num]['item_name']){ ?>
                    <li class="dashboard_item" id="<?php echo $details[$num]['item_name'];?>" >
                        <h2 class="title">
                            <span><?php echo ucwords(str_replace("_", " ", $details[$num]['item_name']));?></span>
                        </h2>
                        <div class="content" >
                        <?php
                        displayContent($details[$num]);
                        ?>
                        <div class="loader"><img src="../../images/loader.gif" title="Loading"/></div>
                        </div>


                    </li>
                <?php }
                }?>
			</ul>
		</div>

	</div>
</div>

