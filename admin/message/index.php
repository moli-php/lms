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
	        case'advise_mngt':
	            $sAction = "advise_mngt";
	        break;

	        case'email_mngt':
	            $sAction = "email_mngt";
	        break;
			
			case'email_template':
	            $sAction = "email_template";
	        break;

	        case'sms_mngt':
	            $sAction = "sms_mngt";
            break;

	        case"":
	           $sAction = "advise_mngt";
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