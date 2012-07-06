<?php

include('includes/environment.php');

class Index extends Simplexi_Controller
{
	public function run($aArgs)
	{
	   $sAction = "";
       $sRequestAction = (isset($aArgs['action'])) ? $aArgs['action'] : "";
       $sPageAction = (isset($aArgs['sub'])) ? $aArgs['sub'] . '.php' : "index.php";

	    switch($sRequestAction)
	    {
	        case'sentence_perfection':
	            $sAction = "sentence_perfection";
	        break;

	        case"":
	           $sAction = "sentence_perfection";
	        break;

	        default:
	            require_once('show404.php');
	            exit();
	    }
	   require_once($sAction . '/' . $sPageAction);
	}
}

$oClass = new index();
$oClass->run($aArgs);