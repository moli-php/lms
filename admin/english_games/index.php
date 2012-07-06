<?php

include('includes/environment.php');

class Index extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library("checkLogin");
	    $sAction = "";
        $sRequestAction = (isset($aArgs['action'])) ? $aArgs['action'] : "";
        $sPageAction = (isset($aArgs['sub'])) ? $aArgs['sub'] . '.php' : "index.php";
	    
		switch($sRequestAction)
	    {
	        case'sentence_perfection':
	            $sAction = "sentence_perfection";
	        break;

	        case"nameit":
	           $sAction = "nameit";
	        break;
			
	        case"":
	           $sAction = "sentence_perfection";
	        break;

	        default:
	            require_once('show404.php');
	            exit();
	    }
	   file_exists($sAction . '/' . $sPageAction) ? "" : exit('Page not found!');
	   require_once($sAction . '/' . $sPageAction);
	}
}

$oClass = new index();
$oClass->run($aArgs);