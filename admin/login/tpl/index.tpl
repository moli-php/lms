<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>Admin | Login</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css" media="screen, projection" />
</head>
<body>
    <div id="wrap">
        <div id="login_wrap">
            <h1><a href="#"><img src="../images/login_logo.png" alt="Admin Logo" class="logo" /></a></h1>
            <div class="login_form">
                <h3>Login</h3>
                <form name="loginForm" method="post">
                    <label>Username</label>
                    <input type="text" value="" name="username" class="textbox" validate="required" />
                    <label>Password</label>
                    <input type="password" value="" name="password"  class="textbox" validate="required" />
                    <div class="rememberpassword">
                        <input type="checkbox" value="" name="rememberpassword" /><label>Remember Password</label>
                    </div>
                    <div class="submit_btn">
                        <input type="submit" name="loginBtn" value="Login" />
                    </div>
                </form>
            </div>
        </div>
    </div>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery-ui-1.8.20.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>js/menu/superfish.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>js/menu/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>js/menu/menu.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.form.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.validate.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>js/common.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>js/login/login.js"></script>
</body>
</html>