<?php
class productBook extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$aData['sPageTitle'] = "Book List | Product";
		$this->model("getmodel");
		$this->importJS("product/product_book");
		
		$aData['iPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
		$aData['sOrder'] = isset($aArgs['order']) ? $aArgs['order'] : "name";
		$aData['sSort'] = isset($aArgs['sort']) ? $aArgs['sort'] : "desc";
		$aData['sKeyword'] = isset($aArgs['keyword']) ? $aArgs['keyword'] : null;
		$aData['iRows'] = isset($aArgs['rows']) ? $aArgs['rows'] : 10;
		$aData['sStatus'] = isset($aArgs['status']) ? $aArgs['status'] : null;
				
		$aData['aBook'] = $this->db->getmodel->getData("tb_product_book");
		$aData['iTotalRows'] = $this->db->getmodel->getTotalRows("tb_product_book");
		$aData['sPagination'] = common::paginate($aData['iPage'], $aData['iRows'], (count($aData['aBook']) > 0 ? $aData['iTotalRows'] : 0));

		$this->display("product/tpl/" . __CLASS__, $aData);
	}
}