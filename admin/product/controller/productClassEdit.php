<?php
class productClassEdit extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->model("getmodel");
		$this->importJS("product/global");
		$aData['aClass'] = $this->db->getmodel->getData("tb_product_class", array("where" => "idx = " . $aArgs['idx']), "row");
		$aData['aDiscount'] = $this->db->getmodel->getData("tb_product_discount", array("where" => "branch_idx = " . USER_ID . " AND delete_flag = 0"));
		$aData['sPageTitle'] = "Edit - " . $aData['aClass']['name'] . " Class List | Product";
		$aData['iIdx'] = $aArgs['idx'];

		$this->display("product/tpl/productManageClass", $aData);
	}
}