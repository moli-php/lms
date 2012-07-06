<?php echo Common::displayMenu(true);?>

<div class="wrap">
	<div class="top">
		<h3 class="title">Course</h3>
		<a href="javascript:void(0);" class="new_post" id="btn_back" name="btn_back">Back to Course List</a>
	</div>
	<p class="notice">Required <span class="required">&#42;</span></p>
	<form name="form_course" id="form_course" method="post">
	    <input type="hidden" value="<?php if(isset($_GET['idx'])){  echo $_GET['idx']; }?>" name="idx" id="idx"/>
	    <input type="hidden" value="<?php if(isset($_GET['page'])){ echo $_GET['page']; } else {echo "1";}?>" id="curr_page" name="curr_page">
    	<table cellspacing="0" border="0" cellpadding="0" class="add_product">
    		<colgroup>
    			<col width="190px" />
    			<col  />
    		</colgroup>
    		<tbody>
    			<tr>
    				<th><label >Course Name</label><span class="required">&#42;</span></th>
    				<td>
    					<input type="text" maxlength="50" class="product_input" id="name" name="name" validate="required" value="<?php if($aDetails!=null){ echo $aDetails[0]['name']; } else { echo "";}?>"/>
    				</td>
    			</tr>
    				<tr>
    				<th><label>Description</label><span class="required">&#42;</span></th>
    				<td><textarea cols="100" rows="10" class="productdescription" id="description" name="description" validate="required"><?php if($aDetails!=null){ echo $aDetails[0]['description']; } else { echo "";}?></textarea></td>
    			</tr>
    		</tbody>
    	</table>
    </form>
	<div class="bottom">
		<div class="apply_action">
			<a href="javascript:void(0);" class="btn_save" id="btn_course" name="btn_course">Submit</a>
		</div>
	</div>
</div>