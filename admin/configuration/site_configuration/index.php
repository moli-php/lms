<?php
include('../../../__library/controller.php');

class site_configuration extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library("common");
		$this->model("execmodel");
		$this->model("getmodel");
		
		$sAction = "exec" . ucfirst($aArgs['exec']);
		unset($aArgs['exec']);
		unset($aArgs['action']);
		$this->$sAction($aArgs);
	}
	
	private function execGetSavedConfig($aArgs)
	{
		$sTableName = "tb_site_configuration";
		$sWhere = "branch_idx = " . $aArgs['id'];
		
		$aResults = $this->select($sTableName,null,$sWhere)->execute();
		echo json_encode($aResults[0]);
	}
	
	private function execFind_address($aArgs)
	{
		$sKeyword = $aArgs['keyword'];
		$sTableName = "tb_siteconf_address";
		$aFields = array(
				"idx",
				"fzipcode",
				"fcity",
				"farea",
				"fplace"
		);
		$sWhere = "fcity LIKE '%".$sKeyword."%' OR farea LIKE '%".$sKeyword."%'";
		$result = $this->select($sTableName,$aFields,$sWhere)->execute();
		echo json_encode($result);
	}

	public function execSaveConfig($aArgs)
	{
		$sTableName = "tb_site_configuration";
		$bEmpty = $this->query("SELECT COUNT(idx) as cId FROM tb_site_configuration WHERE branch_idx = ". USER_ID);
		
		if(isset($_FILES['ffile']['name'])){
			$ext = explode(".", $_FILES['ffile']['name']);
			$target_filepath = SERVER_DOCUMENT_ROOT. "/uploads/site_configuration/" . time()."_".$_FILES['ffile']['name'];
			$path = "site_configuration/" . time()."_".$_FILES['ffile']['name'];
			
			if(FILE_EXISTS($_POST['temp_img'])){
				unlink($_POST['temp_img']);
			}
			
			move_uploaded_file($_FILES['ffile']['tmp_name'], $target_filepath);
			
			$aFields = array(
					"branch_idx" => USER_ID,
					"fsite_url" => $_POST['fsite_url'],
					"fsite_owner" => $_POST['fsite_owner'],
					"fcompany_name" => $_POST['fcompany_name'],
					"fcompany_reg_number" => $_POST['fcompany_reg_number'],
					"fsecurity_manager" => $_POST['fsecurity_manager'],
					"fadmin_email" => $_POST['fadmin_email'],
					"faddress" => $_POST['faddress'],
					"fphone_number" => $_POST['fphone_number'],
					"finformation" => $_POST['finformation'],
					"ftime_zone" => $_POST['ftime_zone'],
					"ffile" => $path,
					"fpolicy" => $_POST['fpolicy']
			);
		}else{
			$aFields = array(
					"branch_idx" => USER_ID,
					"fsite_url" => $_POST['fsite_url'],
					"fsite_owner" => $_POST['fsite_owner'],
					"fcompany_name" => $_POST['fcompany_name'],
					"fcompany_reg_number" => $_POST['fcompany_reg_number'],
					"fsecurity_manager" => $_POST['fsecurity_manager'],
					"fadmin_email" => $_POST['fadmin_email'],
					"faddress" => $_POST['faddress'],
					"fphone_number" => $_POST['fphone_number'],
					"finformation" => $_POST['finformation'],
					"ftime_zone" => $_POST['ftime_zone'],
					"fpolicy" => $_POST['fpolicy']
			);
		}
		
		if($bEmpty[0]['cId'] == 0){
			$result = $this->insert($sTableName, $aFields)->execute();
		}else{
			$sWhere = " branch_idx = ". USER_ID;
			$result = $this->update($sTableName, $aFields, $sWhere)->execute();
		}
		echo $result;
	}
	
}

$oClass = new site_configuration();
$oClass->run($aArgs); #initialize here
