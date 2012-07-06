<?php
include('../../__library/controller.php');

class index extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library("common");
		$this->library("checkLogin");
		$this->importCSS('dashboard/dashboard');
		$this->importCSS('menu_management/menu_management');
		$this->importJS('site_configuration/site_configuration');

		if(@($aArgs['action']) == "dashboard_management"){
			$this->importJS('dashboard_management/dashboard_management');
		}else if(@($aArgs['action']) == "menu_management"){
			$this->importJS('menu_management/menu_management');
			
			$bChecker = $this->select("tb_menu","","branch_idx = ".USER_ID)->execute();
		
		if(!empty($bChecker)){
			$aMenu = $this->selectRow("tb_menu","menu"," branch_idx = ".USER_ID)->execute();
			$aData['aMenuData']  = json_decode($aMenu['menu'],true);
		}else if(empty($bChecker) || isset($_GET['default'])){
			$sMenu = '
				[{"idx":1,"label":"Dashboard","page":"dashboard","seq":1,"hidden_flag":0},
				{"idx":2,"label":"Message","page":"message","seq":2,"hidden_flag":0},
				{"idx":3,"label":"Class","page":"class","seq":3,"hidden_flag":0},
				{"idx":4,"label":"User","page":"user","seq":4,"hidden_flag":0},
				{"idx":5,"label":"Teacher","page":"teacher","seq":5,"hidden_flag":0},
				{"idx":6,"label":"Point","page":"point","seq":6,"hidden_flag":0},
				{"idx":7,"label":"Ulearning","page":"ulearning","seq":7,"hidden_flag":0},
				{"idx":8,"label":"Product","page":"product","seq":8,"hidden_flag":0},
				{"idx":9,"label":"Forum","page":"forum","seq":9,"hidden_flag":0},
				{"idx":10,"label":"Branch","page":"branch","seq":10,"hidden_flag":0},
				{"idx":11,"label":"Statistics","page":"statistics","seq":11,"hidden_flag":0},
				{"idx":12,"label":"Event","page":"event","seq":12,"hidden_flag":0},
				{"idx":13,"label":"Configuration","page":"configuration","seq":13,"hidden_flag":0},
				{"idx":14,"label":"English Games","page":"english_games","seq":14,"hidden_flag":0}]
			';
			$aData['aMenuData']  = json_decode($sMenu,true);
			}
			
		}



		$sAction = (isset($aArgs['action']))? $aArgs['action'] : 'site_configuration';
		$aData['sTimezone'] = isset($aArgs['timezone']) ? $aArgs['timezone'] : 'Asia/Seoul';
		$aData['dateTime'] = new DateTime("now", new DateTimeZone($aData['sTimezone']));
		$aData['fDateTime']  = $aData['dateTime']->format("m/d/Y H:i:s");

		$this->display("configuration/tpl/".$sAction, $aData);
	}
}

$oClass = new index();
$oClass->run($aArgs);
