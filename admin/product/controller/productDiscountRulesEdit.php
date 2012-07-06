<?php
class productDiscountRulesEdit extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->model("getmodel");
		$this->importJS("product/product_discount");
		$aData['sPageTitle'] = "Edit Discount | Product";
		
		$aData['aDiscount'] = $this->db->getmodel->getData("tb_product_discount", array("where" => "idx = " . $aArgs['idx']), "row");
		$aData['iIdx'] = $aArgs['idx'];

		$this->display("product/tpl/productManageDiscountRules", $aData);
	}
}