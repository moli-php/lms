<?php
class productClassAdd extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->model("getmodel");
		$this->importJS("product/global");
		$aData['sPageTitle'] = "Add New Class | Product";
		$aData['aDiscount'] = $this->db->getmodel->getData("tb_product_discount", array("where" => "branch_idx = " . USER_ID . " AND delete_flag = 0"));
		$this->display("product/tpl/productManageClass", $aData);
	}
}