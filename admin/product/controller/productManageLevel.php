<?php
class productManageLevel extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library("common");
		$this->model("getmodel");
		$this->importJS("product/product_course");
		$this->onLoadManageLevel($aArgs);
	}
	
	private function onLoadManageLevel($aArgs)
	{
		if(isset($aArgs['id'])){
			$aOption = array(
				"where" => "idx = " . $aArgs['id']	
			);
			$aData['level'] = $this->db->getmodel->getData("tb_product_level", $aOption);
			$this->display("product/tpl/productManageLevel", $aData);
		}else{
			$aData['level'] = null;
			$this->display("product/tpl/productManageLevel", $aData);
		}
	}
	
}