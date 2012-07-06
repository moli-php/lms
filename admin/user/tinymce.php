<?php
//if(isset($_FILES)){
//$filename = $_SERVER['DOCUMENT_ROOT'].'/test/dummy/mce_fileupload_test/'.$_FILES['mce_upload']['name'];
$webFilename = "http://".$_SERVER['HTTP_HOST']."/test/dummy/mce_fileupload_test/".$_FILES['mce_upload']['name'];
if(move_uploaded_file($_FILES['mce_upload']['tmp_name'],$filename)){
echo '<script language="JavaScript" type="text/javascript">'."\n";
echo 'var parDoc = window.parent.document;';
echo "parDoc.getElementById('prev').innerHTML = '<img src=\"$webFilename\" width=\"300\" />';";
echo "parDoc.getElementById('src').value = '".$webFilename."';";
echo "</script>";
}else{
echo "Error, try again.";
//}
//}
?>