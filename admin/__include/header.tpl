<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo isset($sPageTitle) ? trim($sPageTitle) . " | LMS" : "LMS"; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php __loadCSS(); ?>
	
</head>
<body>
<div id="overflow_wrap">
	<div id="header">
		<div class="top">
			<h1 title="site logo" class="logo"><strong class="hidden">logo</strong></h1>
			<ul class="gnb">
				<li><a href="#" class="icon site">Site</a></li>
				<li>
					<a href="#" class="icon " >
					<span style="position:relative;top:-8px;margin:0 5px 0 0">
						<img  width="35px" height="35px" src="<?php echo BASE_URL . 'uploads/'.$_SESSION['profile_img'];?>" />
					</span><?php echo ucwords($_SESSION['user_id']);?>
					</a>
				</li>
				<li><a id="logout_btn" href="javascript:logout();" class="icon exit" >Logout</a></li>
			</ul>
		</div>	
		
	<!--hidden users session info roeldingle roeldingle roeldingle roeldingle roeldingle-->
	<input type="hidden" name="sess_idx" id="sess_idx" value="<?php echo $_SESSION['idx'];?>" />
	<input type="hidden" name="sess_user_id" id="sess_user_id" value="<?php echo $_SESSION['user_id'];?>" />
	<input type="hidden" name="sess_grade_idx" id="sess_grade_idx" value="<?php echo $_SESSION['grade_idx'];?>" />
	
	<div id="dialog-confirm-logout" style="display:none;" > 
		<b>Are you sure you want to logout?</b>
	</div>
	
<script>
	function logout(){
		$("#dialog-confirm-logout").dialog({
			title:'<p class="popup_title">Warning &raquo;</p>',
			resizable:false,width:300,height:150,modal: true,
			buttons: {
				"Ok": function() {
					$( this ).dialog( "close" );
					$(window.location).attr('href',"/admin/logout.php");
				},
				Cancel: function() {
					$( this ).dialog( "close" );
					return false;
				}
			}
		});
	}
</script>