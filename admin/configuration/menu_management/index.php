<?php
include('../../../__library/controller.php');

class menu_management extends Simplexi_Controller
{
	public function run($aArgs)
	{
		/*include common library*/
		$this->library("common");
	    $this->model("management_model");
		
		$sAction = Common::getParam('action');
		$sAction = $sAction != "" ? "exec" . ucwords($sAction) : "execDisplay";
		$this->$sAction($aArgs);
		
		
		
	}
	
	public function execDisplay(){
	
		$bChecker = $this->select("tb_menu","","branch_idx = ".USER_ID)->execute();
		
		if(!empty($bChecker)){
			$aMenu = $this->selectRow("tb_menu","menu"," branch_idx = ".USER_ID)->execute();
			echo json_encode($aMenu['menu']);
		}else{
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
				{"idx":13,"label":"Configuration","page":"configuration","seq":13,"hidden_flag":0}]
			';
			echo json_encode($sMenu);
		}
		
		
	}
	
	public function execSave(){
		$aParam = Common::getParams();
		
		$sTableName = "tb_menu";
		 $bChecker = $this->select($sTableName,"","branch_idx = ".USER_ID)->execute();
		
		$sMenu = json_encode($aParam['data']);
		
		 if(empty($bChecker)){
			$aData = array(
				"branch_idx" => USER_ID,
				"menu" => $sMenu
			);
			$bProcess = $this->insert($sTableName,$aData)->execute();
			
		}else{
			
			 $bProcess = $this->update($sTableName,array("menu" => $sMenu)," branch_idx = ".USER_ID)->execute();
			 
		 }
		
		echo json_encode($sMenu);
	}
}
$oClass = new menu_management();
$oClass->run($aArgs);
?>
