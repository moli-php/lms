<?php

class Send_sms extends Simplexi_controller
{
	private $TB_MSG_SMS = 'tb_msg_sms_log';

	public function __construct()
	{
		parent::__construct();
		$this->library('common');
		$this->common->getParams();
	}

	public function sendsms()
	{
		
		$user = "simplex.marvin";
		$password = "SJTfdACSBDZBHT";
		$api_id = "3378426";
		$baseurl ="http://api.clickatell.com";
	 
		// $text = urlencode($this->common->getParam('mesg'));
		$text = $this->common->getParam('mesg');
		$to1 = implode(',',$this->common->getParam('to'));
		$to = str_replace('-','',$to1);
	 
		// auth call
		$url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id";
	 
		// do auth call
		$ret = file($url);
	 
		// explode our response. return string is on first line of the data returned
		$sess = explode(":",$ret[0]);

			if ($sess[0] == "OK") {
		 
				$sess_id = trim($sess[1]); // remove any whitespace
				$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";
		 
				// do sendmsg call
				$ret = file($url);
				$send = explode(":",$ret[0]);
		 
				if ($send[0] == "ID") {
				
					$ifrom = $this->common->getParam('resc');
					$iSent_Count = count($this->common->getParam('to'));
					$sDate = date("m-d-y h:m:s A");

					$aFields[] = array('message' => $text,'sent_count' => $iSent_Count,'sms_to' => $to1,'sms_from' => $ifrom,'reg_date' => $sDate,'branch' => USER_ID);
					$this->insert($this->TB_MSG_SMS, $aFields)->execute();

					return "sucess";
					
				} else {
					$ifrom = $this->common->getParam('resc');
					$iSent_Count = count($this->common->getParam('to'));
					$sDate = date("m-d-y h:m:s A");

					$aFields[] = array('message' => $text,'sent_count' => $iSent_Count,'sms_to' => $to1,'sms_from' => $ifrom,'reg_date' => $sDate,'branch' => USER_ID);
					$this->insert($this->TB_MSG_SMS, $aFields)->execute();
					return "failed";
				}
			} else {
					return "authenfailed";
			}


	}
	
}