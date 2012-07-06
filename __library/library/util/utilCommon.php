<?php	
function getInstance($sClass)
{
	include_once('modelFront.php');
	
	return new $sClass;
}

function common()
{
	include_once('common.php');
	$commonClass = $GLOBALS["Module"].'_common';
	return new $commonClass;
}
?>