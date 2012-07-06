<?php
include('../__library/controller.php');
class logout extends Simplexi_Controller
{
	public function __construct()
	{
		unset($_SESSION['idx']);
		unset($_SESSION['user_id']);
		unset($_SESSION['grade_idx']);

		header("location:" . BASE_URL . "admin/");
	}
}

$oLogout = new logout();

?>