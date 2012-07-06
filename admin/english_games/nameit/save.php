<?php


define("UPLOAD_PATH", "../../uploads/english_games/");

if( isset( $_FILES ) && $_FILES )
{
	$aFile = $_FILES['file'];
	
	$aAllowedFile = array("image/gif","image/jpg","image/jpeg","image/png","image/pjpeg");
	
	if(is_uploaded_file($aFile['tmp_name']))
	{
		if( in_array( $aFile['type'] , $aAllowedFile ) )
		{
			$sRandom = UPLOAD_PATH . md5(time() + sha1( rand( 1000,20000 ) ) );
			
			$sExtension = pathinfo($aFile['name'],PATHINFO_EXTENSION);
			
			$sFileName = pathinfo($aFile['name'],PATHINFO_FILENAME);
			
			$sNewName = $sRandom . '_' . $sFileName . ".{$sExtension}";
			
			if(move_uploaded_file($aFile['tmp_name'],$sNewName))
			{
			
?>
<script type="text/javascript">
var parDoc = window.parent.document;
	// parDoc.getElementById('picture_error').innerHTML = 'asdfasdf';
	// parDoc.getElementById("picture_error").innerHTML =  "";
	parDoc.getElementById('picture_preview').innerHTML = '<img src="<?php echo $sNewName?>"/>';
	alert(123)
	
</script>

<?php
				// header("Location:?action=nameit&sub=frame");
				// echo"Saved Successfully!";
			}
		}
		else
		{
			exit("Your file is invalid format.");
		}	
	}
	else
	{
		exit("There is a problem uploading your file!");
	}
}
else
{
	exit("There is a problem uploading your file!");
}
