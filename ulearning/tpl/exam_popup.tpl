<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr"> 
	<link type="text/css" rel="stylesheet" href="../../../css/ulearning/slides.css" />
	<link rel="stylesheet" type="text/css" href="../../css/custom-theme/jquery-ui-1.8.20.custom.css" />
	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script type="text/javascript" src="../../js/common.js"></script>
	<script type="text/javascript" src="../../js/ulearning/front/exam_popup.js"></script>
	<script type="text/javascript" src="../../js/jquery.form.js"></script>
	
</head>
<body>
<div id="wrap">
	<div id="content">
	<form name="exam_popup" class="exam_popup" id="exam_popup" enctype="multipart/form-data">
	<input type="hidden" name="assign_id" id="assign_id" value="<?php echo $assign_id; ?>" />
	<input type="hidden" name="exam_type_id" id="exam_type_id" value="<?php echo $preview[0]['fexam_type_id']; ?>" />
		<ul class="top_content">
			<li class="con_1"><h2 class="hidden">U-learning???</h2></li>
			<li class="con_2"><strong class="date"><?php echo $date; ?></strong></li>
			<?php if($preview[0]['fexam_type_id'] == 19 || $preview[0]['fexam_type_id'] == 20){?>
				<li class="con_3" style="width:208px;height:46px;background:url(../../images/ulearning/blubutton.jpg) left top no-repeat;display:inline-block;"><a class="doc" href="#"><strong></strong></a></li>
			<?php }else{ ?>
				<li class="con_3"><div class="time"><strong><?php echo "<span class='time_remain'>".$hours.":".$minutes.":".$seconds."</span>"; ?> remains</strong></div></li>
			<?php } ?>			
			<li class="con_4"><a href="" class="course"><strong>Business English</strong></a></li>
		</ul>
		<div class="mid_content">
			<?php if($preview[0]['fexam_type_id'] != 19 && $preview[0]['fexam_type_id'] != 20){?>
			<div class="con_1">
				<div class="slide_name">
					<p><h2 class="title"><?php echo $preview[0]['fslide_name']; ?></h2></p>
				</div>
				<div class="container">
					<div class="style">
						<div class="h_box_exp">
							<p class="text"><?php echo substr($preview[0]['fstudy_summary'],3,-4); ?></p>
						</div>	
						
						<div class="contents"><?php if(isset($contents))echo $contents; ?></div>
					</div>
				</div>	
			</div>
			<div class="control">
				<ul>
					<?php
					$study_part = explode(",",$preview[0]['fstudy_part']);
					$array = array("L","V","G","R","W","S");
					$i = 0;
					foreach($array as $key => $val){
					?>
						<li class="<?php if(empty($study_part[$i])){ echo "dull";}else if($val != $study_part[$i]){ echo "dull";} else{ echo "control_".($key+1); $i++;} ?>"><strong><?php echo $val; ?></strong></li>
					<?php } ?>
				</ul>
			</div>
			<?php }else{?>
				<div class="video_container">  
					<iframe src="<?=$video?>" width="640" height="590" scrolling="no" class="video_content" name="video_content"></iframe>
				</div>
				<ul class="video_thumbs">
					<?=$contents?>
				</ul>
			<?php }?>
		</div>
		<ul class="bottom_content">
			<li class="con_1"></li>
			<li class="con_2"><strong class="deadline"></strong></li>
			<li class="con_3">
			<?php if($preview[0]['fexam_type_id'] != 19 && $preview[0]['fexam_type_id'] != 20 && !empty($preview[0]['fsound_file'])){?>
				<object classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" type="application/x-shockwave-flash" id="player" width="209" height="46">
					<param name="url" value="../../uploads/ulearning/slide_upload/<?=$preview[0]['fsound_file']?>" />
					<param name="src" value="../../uploads/ulearning/slide_upload/<?=$preview[0]['fsound_file']?>" />
					<param name="showcontrols" value="true" />
					<param name="autostart" value="false" />
					<!--[if !IE]>-->
					<object type="video/x-ms-wmv"  data="../../uploads/ulearning/slide_upload/<?=$preview[0]['fsound_file']?>"  width="209" height="46">
					<param name="src" value="../../uploads/ulearning/slide_upload/<?=$preview[0]['fsound_file']?>" />
					<param name="autostart" value="false" />
					<param name="controller" value="true" />
					</object>
					<!--<![endif]-->
				</object>
			<?php }?>
			</li>
			<li class="con_4">
				<?php if($offset <= $total){?>
				<a href="javascript:exam_popup.next_slide(<?php echo $assign_id; ?>)" class="btn"><strong><?php echo $offset."/".$total; ?></strong></a>
				<?php }else{?>
				<a href="javascript:void(0)" class="btn"><strong><?php echo $offset."/".$total; ?></strong></a>
				<?php }?>
			</li>
		</ul>
	</form>
	</div>
</div>
</body>
</html>