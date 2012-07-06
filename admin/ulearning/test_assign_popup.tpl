<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link type="text/css" rel="stylesheet" href="../../css/style.css" media="all" />
	<link rel="stylesheet" type="text/css" href="../../css/custom-theme/jquery-ui-1.8.20.custom.css" />
	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script type="text/javascript" src="../../js/jquery-ui.js"></script>
	<script type="text/javascript" src="../../js/menu/superfish.js"></script>
	<script type="text/javascript" src="../../js/menu/jquery.cookie.js"></script>
	<script type="text/javascript" src="../../js/menu/menu.js"></script>
	<script type="text/javascript" src="../../js/jquery.form.js"></script>
	<script type="text/javascript" src="../../js/jquery.validate.js"></script>
	<script type="text/javascript" src="../../js/common.js"></script>
	<script type="text/javascript">
		window.onresize = function() 
		{
			window.resizeTo(1000,800);
		};
		/* create an array of days which need to be disabled */
		//var enabledDays = [];
		//function scheduledDays(date) {
		//	var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
		//	for (i = 0; i < enabledDays.length; i++) {
		//		if($.inArray((m+1) + '-' + d + '-' + y,enabledDays) != -1 && new Date() < date) {
		//			return [true];
		//		}
		//	}
		//	return [false];
		//}
		$(function() {
			if($('[name=user_idx]').val() == 0)
				Menu.message("warning","Insert and Verify user ID first");
			else
				Menu.message("success","User ID has been verified");
			$('.course').val(0);
			$(".date").datepicker({ dateFormat: "yy-mm-dd",miDate:new Date(<?php echo date("Y");?>,<?php echo date("n");?>,<?php echo date("j");?>) });
			var dates = $( "#sdate, #edate" ).datepicker({
				dateFormat: "yy-mm-dd",
				onSelect: function( selectedDate ) {
					var option = this.id == "sdate" ? "minDate" : "maxDate",
						instance = $( this ).data( "datepicker" ),
						date = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings );
					dates.not( this ).datepicker( "option", option, date );
				}
				});
			$(".rows").change(function(){
				window.location.href = common.getBaseUrl()+"/admin/ulearning/?action=test_assign&inner=popup&user_id="+$('[name=username]').val()+"&rows="+$(this).val();
			});
		});
		</script>
	<script type="text/javascript" src="../../js/ulearning/test_assign_popup.js"></script>
	<style type="text/css">
		.wrap {width:98% !important;padding:10px !important;margin-right:10px;}
	</style>
	
</head>
<body>
	<div id="container">
		<div class="container_wrap2">
			<div class="wrap">
				
				<div class="top">
					<h3 class="title">Test Assign</h3>
				</div>
				<div id="message_wrap_con"></div>
				<form name="userAddForm" action="#">
					<table border="0" cellspacing="0" cellpadding="0" class="table_user" >
								<colgroup>
									<col width="170px" />
									<col width="*" />
								</colgroup>
								<tr>
									<th><label>User ID</label><span class="neccesary">*</span></th>
									<td><span id="name_wrap"><input type="hidden" name="user_idx" value="<?php echo $user_idx;?>"/><input type="text" id="username" name="username" class="user_id" maxlength="10" value="<?php echo $user_id;?>" validate="required" /></span><a href="javascript:window.location.href='<?php Common::urlInclude('user_id'); ?>' + $('.user_id').val()" class="btn_go">Verify ID</a> </td>
								</tr>
								<tr>
									<th><label>Select Class</label><span class="neccesary">*</span></th>
									<td>
									<select class="allselect class" name="class" validate="required">
										<option></option>
										<?php
											foreach($class as $k => $v):
												echo "<option value='".$v['idx']."'>".$v['name']."</option>";
											endforeach;
										?>
									</select></td>
								</tr>
								<tr>
									<th><label >Course</label><span class="neccesary">*</span></th>
									<td>
										<select class="allselect course" onchange="assign.category()" name="course" validate="required">
											<option></option>
											<?php
												foreach($course as $k => $v):
													echo "<option value='".$v['fcategory_id']."'>".$v['fcategory_name']."</option>";
												endforeach;
											?>
										</select>
									</td>
								</tr>

								<tr>
									<th><label >Category1</label><span class="neccesary">*</span></th>
									<td>
										<select class="allselect depth1" onchange="assign.depth1()" name="category1" validate="required">
											<option></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><label >Category2</label><span class="neccesary">*</span></th>
									<td>
										<select class="allselect depth2" onchange="assign.depth2()" name="category2" validate="required">
											<option></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><label >Unit</label><span class="neccesary unit_required">*</span></th>
									<td>
										<select class="allselect unit" name="unit" validate="required">
											<option></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><label>Date</label><span class="neccesary">*</span></th>
									<td><input type="text" name="date" value="" class="date" validate="required" /><a href="javascript:assign.date()"><img class="calendar_icon" src="../../images/icons/calendar-day.png" alt="Calendar" /></td>
								</tr>
					</table>
					<div class="top">
					<div class="action_btn">
						<a href="javascript:assign.remove()" class="btn_save" title="Delete">Delete</a>
						<a href="javascript:assign.addAssignment()" class="btn_save" title="Add New User" style="margin-left:10px">Add New Assigment</a>
						<a href="javascript:assign.class_schedule(<?php echo $user_idx;?>,$('.class').val())" class="btn_save" title="Assign uLearning Course" style="margin-left:10px">Assign uLearning Course</a><br />
					</div>
					</div>
				</form>	
				<table cellspacing="0" border="0" cellpadding="0" class="product_search">
					<colgroup>
						<col width="100"/>
						<col />
						<col width="150"/>
						<col width="150"/>					
					</colgroup>
					<tbody>
						<tr>
							<th><label>Class Period:</label></th>
							<td>
								<input type="text" class="fix8 sdate" id="sdate" name="sdate" readOnly="readOnly" value="<?php echo $sdate;?>" /><a href="javascript:assign.sdate()"><img class="calendar_icon" alt="Calendar" src="../../images/icons/calendar-day.png"></a> 
								<span class="period_to">~</span>
								<input type="text" class="fix8 edate" id="edate" name="edate" readOnly="readOnly" value="<?php echo $edate;?>"/><a href="javascript:assign.edate();"><img class="calendar_icon"  alt="Calendar" src="../../images/icons/calendar-day.png"></a>
							</td>
							<td></td>
							<td></td>
						</tr>
						<?php if($fbranch_idx == 1){?>
						<tr>
							<th><label>Branch:</label></th>
							<td>
								<select class="allselect branch" style="border: 1px solid #CCCCCC;height: 17px;width:100px">
									<option></option>
									<?php
										foreach($branch as $key => $val):
											echo "<option value='".$val['idx']."'";
												if($fbranch_id == $val['idx'])
													echo " selected='selected' ";
											echo ">".$val['name']."</option>";
										endforeach
									?>
								</select>
							</td>
							<td align="left"></td>
							<td></td>
							
						</tr>
						<?php }?>
						<tr>
							<th></th>
							<td></td>
							<td align="left"></td>
							<td><a href="javascript:void(0)" onclick="assign.total()" class="btn_go fr">Total</a><a href="javascript:void(0)" onclick="assign.search()" class="btn_go fr">Search</a></td>
							
						</tr>
					</tbody>
				</table>
				<div class="top_2">
					<ul class="sort_view">
						<li class="<?php if(!isset($_GET['filter']) || $_GET['filter'] == "" ) echo 'active';?> all"><a href="javascript:window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=test_assign&inner=popup&user_id=<?php echo $user_id;?>&filter=&sdate='+$('.sdate').val()+'&edate='+$('.edate').val()" >All (<?php echo $allCount;?>)</a></li>
						<li <?php if(isset($_GET['filter']) && $_GET['filter'] == 1) echo 'class="active"';?>><a href="javascript:window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=test_assign&inner=popup&user_id=<?php echo $user_id;?>&filter=1&sdate='+$('.sdate').val()+'&edate='+$('.edate').val()">Class Material (<?php echo $classMaterialCount;?>)</a></li>
						<li <?php if(isset($_GET['filter']) && $_GET['filter'] == 2) echo 'class="active"';?>><a href="javascript:window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=test_assign&inner=popup&user_id=<?php echo $user_id;?>&filter=2&sdate='+$('.sdate').val()+'&edate='+$('.edate').val()">Preview (<?php echo $previewCount;?>)</a></li>
						<li <?php if(isset($_GET['filter']) && $_GET['filter'] == 3) echo 'class="active"';?>><a href="javascript:window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=test_assign&inner=popup&user_id=<?php echo $user_id;?>&filter=3&sdate='+$('.sdate').val()+'&edate='+$('.edate').val()">Homework (<?php echo $previewCount;?>)</a></li>
						<li <?php if(isset($_GET['filter']) && $_GET['filter'] == 4) echo 'class="active"';?>><a href="javascript:window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=test_assign&inner=popup&user_id=<?php echo $user_id;?>&filter=4&sdate='+$('.sdate').val()+'&edate='+$('.edate').val()">Level Test (<?php echo $levelTestPreviewCount;?>)</a></li>
						<li <?php if(isset($_GET['filter']) && $_GET['filter'] == 5) echo 'class="active"';?>><a href="javascript:window.location.href = common.getBaseUrl()+'/admin/ulearning/?action=test_assign&inner=popup&user_id=<?php echo $user_id;?>&filter=5&sdate='+$('.sdate').val()+'&edate='+$('.edate').val()">Level Test (Test) (<?php echo $levelTestPreviewCount;?>)</a></li>
					</ul>
					<div class="show_rows">
						Show Rows
						<select class="rows">
							<option <?php if($rows == 10) echo 'selected';?>>10</option>
							<option <?php if($rows == 20) echo 'selected';?>>20</option>
							<option <?php if($rows == 50) echo 'selected';?>>50</option>
						</select>
					</div>
				</div>
				<div class="test_assign">
					<p class="title">Assignment</p>
					<table cellspacing="0" class="post_table" border="0" cellpadding="0">
						<colgroup>
							<col width="20px" />
							<col width="50px" />
							<col  />
							<col  />
							<col width="150px" />	
							<col width="120px" />
							<col width="170px" />	
							<col width="170px" />
						</colgroup>
						<thead>
							<tr>
								<th><input type="checkbox" onclick="$('.assign_check').attr('checked', this.checked);"/></th>
								<th>No</th>
								<th>Class</th>
								<th>Category</th>
								<th>1 Depth</th>
								<th>2 Depth</th>
								<th>Unit Name</th>
								<th >Date</th>
							</tr>
						</thead>
						<tbody >
							<?php 
							if($assignment){
								foreach($assignment as $key => $val):
								echo "<tr >
									<td><input type='checkbox' class='assign_check' value='".$val['fassign_id']."' /></td>
									<td>".($key+1)."</td>
									<td>".$val['name']."</td>
									<td>".$val['category1']."</td>
									<td>".$val['category2']."</td>
									<td>".$val['category3']."</td>
									<td>".$val['ftitle']."</td>
									<td>".date("F d, Y",$val['fdate'])."</td>
								</tr>";
								endforeach;
							}else
								echo "<tr ><td colspan='8'>No Result Found</td></tr>";?>
						</tbody>
					</table>
					<?php echo Common::paginate($iCurrentPage, $iRowsPerPage, $iTotalRows); ?>
				</div> <!-- end of div test assign -->
			</div>
		</div>	
	</div>
</body>
</html>