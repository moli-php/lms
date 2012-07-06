<?php
require("phpmailer/phpmailer.inc.php");


class my_phpmailer extends phpmailer {
	// Set default variables for all new objects
	var $From = "johnadriantan@gmail.com";
	var $FromName = "Mailer";
	var $Host = "localhost";
	var $Mailer = "smtp";
	var $WordWrap = 75;
	
	// Replace the default error_handler
	function error_handler($msg) {
		print("My Site Error");
		print("Description:");
		printf("%s", $msg);
		exit;
	}
	
	// Create an additional function
	function do_something($something) {
		// Place your new code here
	}
}


$mail = new my_phpmailer;

// Now you only need to add the necessary stuff
for($i = 1; $i < 10 ;$i++)
{
	$mail->AddAddress("johnadriantan@yahoo.com", "Josh Adams");
	$mail->Subject = "Here is the subject";
	$mail->Body = "John Adrian Tan";
	$mail->Send(); // send message
}
