<?php if($aContents){?>
<?php foreach($aContents as $rows){ ?>
	<tr><td>1 <?php echo USER_ID;?></td><td><input type="hidden" class="adv_list_count1" value="<?php echo  count($aCount);?>" /><?php echo $rows['user_id'];?></td><td><a href="javascript:void(0);" class="adv_view_id" alt="<?php echo $rows['idx']; ?>" <?php echo ($rows['status']=='N') ? 'style="font-weight:bold"' : "";?>><?php echo $rows['title']; ?></a></td><td><?php echo $rows['status'];?></td><td><?php echo date('Y-m-d',$rows['date_sent']);?></td></tr>
<?php }?>
<?php }else{?>
	<tr><td valign="center" colspan="5"> No message.</td></tr>
<?php }?>