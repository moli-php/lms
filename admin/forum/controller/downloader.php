<?php
$path 		= '../../../uploads/forum/topic/'; 
$fullPath 	= $path.$_GET['file'];

if ($fd = fopen ($fullPath, "r")) {
	$fsize 		= filesize($fullPath);
	$path_parts = pathinfo($fullPath);
	$ext 		= strtolower($path_parts["extension"]);
	switch ($ext) {
		case "pdf":
		header("Content-type: application/pdf"); 
		header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); 
		break;
		default;
		header("Content-type: application/octet-stream");
		header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
	}	
	
	header("Content-length: $fsize");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Pragma: public");
	
	while(!feof($fd)) {
		$buffer = fread($fd, 2048);
		$file	= $buffer;
	}
}
fclose ($fd);
exit;