<?php
include('../../../__library/controller.php');

class dashboard_management extends Simplexi_Controller
{
	public function run($aArgs)
	{
	    $this->model("dashboard_management_model");

	    switch($_GET['action_mngt'])
	    {
	        case 'saveSettings' :
                $this->db->dashboard_management_model->deleteAllData();
	            $this->db->dashboard_management_model->saveSettings();
                break;
	        case 'showAll' :
	            $this->db->dashboard_management_model->getAllData("dash_mngt");
	        break;
	    }
	}
}
$oClass = new dashboard_management();
$oClass->run($aArgs);
?>
