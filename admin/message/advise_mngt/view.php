<?php

require_once('models/advise_model.php');

class Advise_view extends Simplexi_Controller
{
	private $TB_MSG_ADV = 'tb_msg_adv';
	private $oModel;
		
	public function run($aArgs)
	{
		$this->library('common');
		$this->display('message/tpl/adv_mess_view');
	}
}

$oClass = new Advise_view();
$oClass->run($aArgs);