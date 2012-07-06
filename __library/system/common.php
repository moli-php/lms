<?php
if (function_exists('get_config')) {
	function get_config($aReplace = array())
	{
		static $aNewConfig;

		if (isset($aNewConfig))
			return $aNewConfig[0];

		if (!file_exists($sFilePath = REAL_PATH . '/config/config.php'))
			$sFilePath = REAL_PATH . '/config/config.php';
			
		if ( ! file_exists($sFilePath))
			exit('The configuration file does not exist.');

		require($sFilePath);

		if ( ! isset($aConfig) OR ! is_array($aConfig))
			exit('Your config file does not appear to be formatted correctly.');

		if (count($aReplace) > 0) {
			foreach ($aReplace as $sKey => $sValue) {
				if (isset($aConfig[$sKey]))
					$aConfig[$sKey] = $sValue;
			}
		}

		return $aNewConfig[0] =& $aConfig;
	}
}

function checkContainerAdmin($sUrl = null)
{
	$sUrl = $sUrl === null ? "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] : $sUrl;
	preg_match('/admin/', $sUrl, $aMatches, PREG_OFFSET_CAPTURE);

	return count($aMatches) === 0 ? false : true;
}

function __include($sFile)
{
	$sPath = (checkContainerAdmin() === true) ? ADMIN_PATH : FRONT_PATH;
	if (!file_exists($sPath . '__include' . DS . $sFile . TPL)) 
	{
		exit("<br />File does not exists : " . $sPath . '__include' . DS . $sFile . TPL . "<br /> ");
		continue;
	} 
	else 
	{
		if (isset($GLOBALS['aData']) && $GLOBALS['aData'] !== null) 
			extract($GLOBALS['aData']);
			
		include_once ($sPath . '__include' . DS . $sFile . TPL);
		echo PHP_EOL;
		
	}	
}
function __loadCSS()
{
	// $sHTML = '<link rel="stylesheet" type="text/css" href="' . BASE_URL . 'css/jquery-ui.css" />' . PHP_EOL;
	$sHTML = '<link rel="stylesheet" type="text/css" href="' . BASE_URL . 'css/custom-theme/jquery-ui-1.8.20.custom.css" />' . PHP_EOL;

	if(preg_match('/admin/', $_SERVER['REQUEST_URI'], $amatch))
	{
		$sHTML .= '<link rel="stylesheet" type="text/css" href="' . BASE_URL . 'css/style.css" />' . PHP_EOL;
		$sHTML .= '<link rel="stylesheet" type="text/css" href="' . BASE_URL . 'css/superfish.css" />' . PHP_EOL;
		//$sHTML .= '<link rel="stylesheet" type="text/css" href="' . BASE_URL . 'css/menu/superfish-navbar.css" />' . PHP_EOL;
	}

	if(isset($GLOBALS["iCSS"]) && is_array($GLOBALS["iCSS"]))
	{
		foreach($GLOBALS["iCSS"] as $index => $sFiles)
		{
			$sHTML .= '<link rel="stylesheet" type="text/css" href="' . BASE_URL . 'css/' . $sFiles . '.css" />' . PHP_EOL;
		}
	}
	
	if(isset($GLOBALS["miCSS"]) && is_array($GLOBALS["miCSS"]))
	{
		foreach($GLOBALS["miCSS"] as $index => $sFiles)
		{
			$sHTML .= '<link rel="stylesheet" type="text/css" href="' . BASE_URL . 'modules/' . $sFiles . '.css" />' . PHP_EOL;
		}
	}
	
	if(isset($GLOBALS["eCSS"]) && is_array($GLOBALS["eCSS"]))
	{
		foreach($GLOBALS["eCSS"] as $index => $sFiles)
		{
			$sHTML .= '<link rel="stylesheet" type="text/css" href="' . $sFiles . '" />' . PHP_EOL;
		}
	}

	echo $sHTML; 
}

function __loadJS()
{
	$sHTML = '<script type="text/javascript" src="' . BASE_URL . 'js/jquery.js"></script>' . PHP_EOL;
	$sHTML .= '<script type="text/javascript" src="' . BASE_URL . 'js/jquery-ui-1.8.20.custom.min.js"></script>' . PHP_EOL;

	if(preg_match('/admin/', $_SERVER['REQUEST_URI'], $amatch))
	{
		$sHTML .= '<script type="text/javascript" src="' . BASE_URL . 'js/menu/superfish.js"></script>' . PHP_EOL;
		$sHTML .= '<script type="text/javascript" src="' . BASE_URL . 'js/menu/jquery.cookie.js"></script>' . PHP_EOL;
		$sHTML .= '<script type="text/javascript" src="' . BASE_URL . 'js/menu/menu.js"></script>' . PHP_EOL;
		$sHTML .= '<script type="text/javascript" src="' . BASE_URL . 'js/jquery.form.js"></script>' . PHP_EOL;
		$sHTML .= '<script type="text/javascript" src="' . BASE_URL . 'js/jquery.validate.js"></script>' . PHP_EOL;
		$sHTML .= '<script type="text/javascript" src="' . BASE_URL . 'js/jqueryShiftCheckbox.js"></script>' . PHP_EOL;
	}
	
	$sHTML .= ( isset($GLOBALS['tinyMce']) ? $GLOBALS['tinyMce'] : "") . PHP_EOL;
	$sHTML .= '<script type="text/javascript" src="' . BASE_URL . 'js/common.js"></script>' . PHP_EOL;
	if(isset($GLOBALS["iJS"]) && is_array($GLOBALS["iJS"]))
	{
		foreach($GLOBALS["iJS"] as $index => $sFiles)
		{
			$sHTML .= '<script type="text/javascript" src="' . BASE_URL . 'js/' . $sFiles . '.js"></script>' . PHP_EOL;
		}
	}
	
	if(isset($GLOBALS["eJS"]) && is_array($GLOBALS["eJS"]))
	{
		foreach($GLOBALS["eJS"] as $index => $sFiles)
		{
			$sHTML .= '<script type="text/javascript" src="' . $sFiles . '"></script>' . PHP_EOL;
		}
	}
	
	if(isset($GLOBALS["miJS"]) && is_array($GLOBALS["miJS"]))
	{
		foreach($GLOBALS["miJS"] as $index => $sFiles)
		{
			$sHTML .= '<script type="text/javascript" src="' . BASE_URL . 'modules/' . $sFiles . '.js"></script>' . PHP_EOL;
		}
	}
	
	if(isset($GLOBALS["wJS"]) && is_array($GLOBALS["wJS"]))
	{
		$sHTML .= '<script type="text/javascript">' . PHP_EOL;
		foreach($GLOBALS["wJS"] as $index => $sScripts)
		{
			$sHTML .= $sScripts . PHP_EOL;
		}
		$sHTML .= '</script>' . PHP_EOL;
	}
	echo $sHTML;
}

function __module($sModuleBlock)
{
	include_once(REAL_PATH . '/library/controller/front.php');
	include_once(REAL_PATH . DS . '/library/util/utilCommon.php');
	include_once(REAL_PATH . DS . '/library/util/utilParser.php');
	
	$aModuleBlock = explode('->', $sModuleBlock);
	$sModule = strtolower($aModuleBlock[0]);
	$GLOBALS["Modules"] = $sModule;
	$sBlock = strtolower($aModuleBlock[1]);
	$sFile = $_SERVER['DOCUMENT_ROOT'] . DS . '__include' . DS . 'modules' . DS . $sModule . DS . $sBlock . '.html';
	
	$oParser->sModule = $sModule;
	$oParser->parseModule($sModule, $sBlock ,$sFile);
}