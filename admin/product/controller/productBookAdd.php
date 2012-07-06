<?php
class productBookAdd extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->importJS("product/product_book");
		$aData['sPageTitle'] = "Add New Book | Product";
		$this->display("product/tpl/productManageBook", $aData);
	}
}