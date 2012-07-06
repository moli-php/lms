<?php
echo Common::displayMenu(true);?>

<div class="wrap">
	<h4 class="add_h">Menu sequence&nbsp;&nbsp;<input  type="checkbox" name="check_all" value="check_all" id="check_all" /><span  class="check_all_box">Check All</span><br/></h4>

	<ul class="menu_list" >
	<?php foreach($aMenuData as $key=>$val){?>
		<li><label for="show_user"><?=$val['label']?></label><input  id="chk_<?=$val['idx']?>" type="checkbox" class="show_to_menu"  name="show_to_menu" title="<?=ucwords($val['label'])?>" value="<?=$val['page']?>"/></li>
	<?php } ?>
	</ul>

    <div class="menu">
    	<ul class="menu_order">
		<li class="menu_order_item" id="user"><strong name="user">User</strong></li>
    	</ul>

        <ul class="sort_buttons">
    		<li><input type="button" name="up" id="up" class="btn_sort" value="▲" /></li>
    	    <li><input type="button" name="down" id="down" class="btn_sort" value="▼" /></li>
        </ul>
    </div>

	<div class="action_btn">
		<a href="javascript:void(0);" class="btn_save" title="Save changes" id="btn_save_show" name="btn_save_show">Save</a>
		<a href="javascript:void(0);" class="btn_return"  title="Undo changes" id="btn_undo" name="btn_undo">Undo changes</a>
		<a href="javascript:void(0);" class="btn_return" id="btn_return_default" name="btn_return_default" >Return to Default</a>
	</div>
	</div>
</div>
