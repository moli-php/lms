<?php
include($_SERVER['DOCUMENT_ROOT'] . '/__library/controller.php');
if(isset($_FILES)){
	$filename = strtolower($_FILES['mce_upload']['name']);
	$filename = USER_ID."_".time()."_".str_replace(" ", "", $filename);
	$fullImagePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/tinymce_fileuploads/'.$filename;
	$webFilename = "http://".$_SERVER['HTTP_HOST']."/uploads/tinymce_fileuploads/".$filename;
	if(move_uploaded_file($_FILES['mce_upload']['tmp_name'],$fullImagePath)){
	if(isset($_POST['temp_img']) && $_POST['temp_img']){unlink($_POST['temp_img']);}
	echo '<script language="JavaScript" type="text/javascript">'."\n";
	echo 'var parDoc = window.parent.document;';
	echo "parDoc.getElementById('prev').innerHTML = '<img src=\"$webFilename\" />';";
	echo "parDoc.getElementById('temp_img').value = '".$fullImagePath."';";
	echo "parDoc.getElementById('src').value = '".$webFilename."';";
	echo 'parDoc.getElementbyId("errorMsg").innerHTML = ""';
	echo "</script>";
	}else{
	echo '<script language="JavaScript" type="text/javascript">'."\n";
	echo 'var parDoc = window.parent.document;';
	echo 'parDoc.getElementbyId("errorMsg").innerHTML = "Error in Uploading, try again"';
	echo "</script>";
	}
}
?>
