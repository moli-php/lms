<?php
class Controller_Api
{
	public function initiateModule($oFrontController, $aArgs)
	{
		return $oFrontController::post($aArgs);
	}
}
?>