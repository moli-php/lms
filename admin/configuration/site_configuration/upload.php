<?php
include('../../../__library/controller.php');

class site_config_upload extends Simplexi_Controller
{
	public function run ($aArgs)
	{
		if($_FILES["ffile"]["type"] == "image/gif" || $_FILES["ffile"]["type"] == "image/jpeg" || $_FILES["ffile"]["type"] == "image/pjpeg"){
			$ext = explode(".", $_FILES['ffile']['name']);
			$target_filepath = SERVER_DOCUMENT_ROOT. "/uploads/site_configuration/" . time()."_".$_FILES['ffile']['name'];
			$path = "site_configuration/" . time()."_".$_FILES['ffile']['name'];
			
			if(FILE_EXISTS($_POST['temp_img'])){
				unlink($_POST['temp_img']);
			}
			move_uploaded_file($_FILES['ffile']['tmp_name'], $target_filepath);
			
			$result = $target_filepath;
			
			echo $path;
		}else{
			echo "Invalid file type.";
		}
	}
}

$oClass = new site_config_upload();
$oClass->run($aArgs); #initialize here
	
?>