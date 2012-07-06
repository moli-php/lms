<?php

class Frame extends Simplexi_Controller
{
    public function run($aArgs)
    {
		$aInfo = array();
		
		
        $this->library('common');
		
		$this->library("checkLogin");
		
		$this->importJs('english_games/nameit');
		
		$this->importCss('english_games/nameit');
        
		$aInfo['sAppPath'] = BASE_URL . 'admin/english_games/?action=nameit';

		$this->display("english_games/tpl/" . strtolower(__CLASS__),$aInfo,FALSE);
    }
}

$oClass = new Frame();
$oClass->run($aArgs);