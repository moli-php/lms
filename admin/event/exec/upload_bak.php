<?php
define('UPLOAD_FOLDER', $_SERVER['DOCUMENT_ROOT']."/uploads/event/temp/");
include($_SERVER['DOCUMENT_ROOT'] . '/__library/controller.php');
$filename= '';
$result = 'ERROR';
$result_msg = '';
$allowed_image = array ('image/gif', 'image/jpeg', 'image/png');
define('PICTURE_SIZE_ALLOWED', 2242880); // bytes

if (isset($aArgs['picture']))  // file was send from browser
{
	$time = time();
	$temp = $aArgs['picture']['tmp_name'];
	
	 if ($aArgs['picture']['error'] == UPLOAD_ERR_OK){
		 if (in_array($aArgs['picture']['type'], $allowed_image)) {
			 if(filesize($temp) <= PICTURE_SIZE_ALLOWED) {
				
				list($w,$h) = getimagesize($temp);
				
				if($w <= 1024 || $h <= 768){
					$f = strtolower($aArgs['picture']['name']);
					$f = str_replace(" ", "", $f);
					$img_file = $aArgs['user_id']."_".$time."_".$f;
					$img_thumb = $aArgs['user_id']."_thumb_".$time."_".$f;
					
					if($w == $h){
						$thumb_w = 150;
						$thumb_h = 150;
					}elseif($w > $h){
						$ratio = 150 / $h;
						$thumb_w = round($w * $ratio);
						$thumb_h = 150;
					}elseif($w < $h){
						$ratio = 150 / $w;
						$thumb_h = round($h * $ratio);
						$thumb_w = 150;
					}
					
					switch($aArgs['picture']['type'])
					{
						case  'image/jpeg' :
						$img = 		imagecreatefromjpeg($temp);
						$thumb = 	imagecreatetruecolor($thumb_w,$thumb_h);
									imagecopyresized($thumb,$img,0,0,0,0,$thumb_w,$thumb_h,$w,$h);
									imagejpeg($thumb,UPLOAD_FOLDER.$img_thumb);
						break;
						
						case  'image/gif' :
						$img = 		imagecreatefromgif($temp);
						$thumb = 	imagecreatetruecolor($thumb_w,$thumb_h);
									imagecopyresized($thumb,$img,0,0,0,0,$thumb_w,$thumb_h,$w,$h);
									imagegif($thumb,UPLOAD_FOLDER.$img_thumb);
						break;
						
						case  'image/png' :
						$img = 		imagecreatefrompng($temp);
						$thumb = 	imagecreatetruecolor($thumb_w,$thumb_h);
									imagecopyresized($thumb,$img,0,0,0,0,$thumb_w,$thumb_h,$w,$h);
									imagepng($thumb,UPLOAD_FOLDER.$img_thumb);
						break;			
					}
					
					move_uploaded_file($temp, UPLOAD_FOLDER.$img_file);
					
					if($aArgs['temp_img']){
						list($tmp_img,$tmp_thumb) = explode(":",$aArgs['temp_img']);
						unlink(UPLOAD_FOLDER.$tmp_img);
						unlink(UPLOAD_FOLDER.$tmp_thumb);
					}
				}else{
					$result_msg = '<span style="color:red;">Max dimension 1024x768<span>';
				}
			}else{
				$filesize = filesize($temp);// or $aArgs['picture']['size']
				$filetype = $aArgs['picture']['type'];
				$result_msg = '<span style="color:red;">The uploaded file exceeds the limit of 2MB<span>';
			}
		}else {
			$result_msg = '<span style="color:red;">Not an image file.<span>';
		}
	}elseif($aArgs['picture']['error'] == UPLOAD_ERR_INI_SIZE){
		$result_msg = '<span style="color:red;">Error in uploading, please try again.<span>';
	}else{
		$result_msg = '<span style="color:red;">Unknown error, please try again.</span>';
	}
}

//This is a PHP code outputing Javascript code.
echo '<script language="JavaScript" type="text/javascript">'."\n";
echo 'var parDoc = window.parent.document;';
echo "parDoc.getElementById('picture_error').innerHTML = '".$result_msg."';";

if(isset($img_file) && $img_file){
	echo 'parDoc.getElementById("temp_img").value = "'.$img_file.":".$img_thumb.'";';
	echo 'parDoc.getElementById("banner_image").value = "'.$img_file.":".$img_thumb.'";';
	echo 'parDoc.getElementById("picture_error").innerHTML =  "";';
	echo "parDoc.getElementById('picture_preview').innerHTML = '<img src=\'".BASE_URL."uploads/event/temp/".$img_file."\' id=\'preview_picture_tag\' width=\'400\' name=\'preview_picture_tag\' />';";
}

echo "\n".'</script>';
exit(); // do not go futher

?>