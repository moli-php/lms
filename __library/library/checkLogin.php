<?php

class checkLogin
{
	public function __construct()
	{
		if (!isset($_SESSION['idx']))
			header("location:" . BASE_URL . "admin/logout.php");
	}
}

?>