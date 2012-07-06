<?php
class productDiscountRulesAdd extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->importJS("product/product_discount");
		$aData['sPageTitle'] = "Add New Discount | Product";
		$this->display("product/tpl/productManageDiscountRules", $aData);
	}
}