<?php
class Controller_Front
{
	public $sModule;
	public $aModules = array();
	public $aVars = array();
	public $aCSS = array();
	public $aJS = array();
	public $aExJS = array();
	public $aScriptCODE = array();
	public $aCSSCODE = array();
	
	public function initiateModule($oFrontController)
	{
		$oFrontController::run($GLOBALS['aArgs']);
	}
	
	public function assign($sVariable, $sValue = '')
	{
		$this->aVars[$sVariable] = $sValue;
	}
	
	public function importCSS($sCSSFile)
	{
		if(isset($GLOBALS["miCSS"]) && !in_array($sCSSFile, $GLOBALS["miCSS"]))
			$GLOBALS["miCSS"][] = $this->sModule . '/resource/css/' . $sCSSFile;
	}
	
	public function importJS($sJSFile)
	{
		if(isset($GLOBALS["miJS"]) && !in_array($sJSFile, $GLOBALS["miJS"]))
			$GLOBALS["miJS"][] = $this->sModule . '/resource/js/' . $sJSFile;
	}
	
	public function externalJS($sJSFile)
	{
		if(isset($GLOBALS["eJS"]) && !in_array($sJSFile, $GLOBALS["eJS"]))
			$GLOBALS["eJS"][] = $sJSFile;
	}
	
	public function writeJS($sScript)
	{
		if(isset($GLOBALS["mwriteJS"]) && !in_array($sScript, $GLOBALS["mwriteJS"]))
			$GLOBALS["mwriteJS"][] = $sScript;
	}
	
	public function writeCSS($sCSS)
	{
		$this->aCSSCODE[$this->sModule][] = $sJSFile;
	}
	
	public function getSequence(){}
	public function getOption(){}
	public function getLangCode(){}
}
?>