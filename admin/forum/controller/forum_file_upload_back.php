<?php

	// Rename file
	$ext	= explode('/', $_FILES['file']['type']);
	if($ext[1] == 'jpeg')
	{
		$ext	= 'jpg';
	}
	else
	{
		$ext	= explode('.', $_FILES['file']['name']);
		$ext	= $ext[count($ext) - 1];
	}
	if(isset($_POST['forum_section']) && $_POST['forum_section'] == 'topic')
	{
		move_uploaded_file($_FILES["file"]["tmp_name"], "../../../uploads/forum/topic/".$_POST['filename']);
	}
	else
	{
		move_uploaded_file($_FILES["file"]["tmp_name"], "../../../uploads/forum/category/".$_POST['filename'].".".$ext);
	}
	
	// echo '<pre>';
	// var_dump($_FILES['file']);

	// echo $_POST['filename'].".".$ext;
	
	// move_uploaded_file($_FILES['file']['tmp_name'], '../../../uploads/forum/category/'.$_FILES['file']['name']);
	// echo '<pre>';
	// print_r($_FILES['file']);
	// echo $_POST['filename'];
	// echo $_POST['filename'].".".$ext;
	