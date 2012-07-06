<?php
class productBookEdit extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->model("getmodel");
		$this->importJS("product/product_book");
		$aData['sPageTitle'] = "Add New Book | Product";

		$aData['aBook'] = $this->db->getmodel->getData("tb_product_book", array("where" => "idx = " . $aArgs['idx']),"row");
		$aData['iIdx'] = $aArgs['idx'];

		$this->display("product/tpl/productManageBook", $aData);
	}
}