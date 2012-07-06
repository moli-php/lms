<span>
    <form name="bookmark_title" class="bookmark_title" method="post">
    <input type="hidden" name="return_url" value="<?php echo $returnUrl; ?>" />
    <strong>Title:</strong>
    &nbsp;
    &nbsp;
    <input type="text" class="input_text" value="<?php echo $sTitle; ?>" name="title" />
    &nbsp;
    &nbsp;
    <div class="tbl_lb_wide_btn">
		<a href="#" class="btn_apply" title="Save changes" onclick="javascript: bookmark_title.submit();">Save</a>
		<?php
		if ($bExtensionView === 1){
            echo '<a href="/admin/sub/?module=ExtensionPageMyextensions" class="add_link" title="Return to My Extensions">Return to My Extensions</a>';
        }
        ?>
	</div>
    </form>
</span>
<br />
<br />