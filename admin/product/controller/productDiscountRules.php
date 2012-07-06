<?php
class productDiscountRules extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$aData['sPageTitle'] = "Discount List | Product";
		$this->model("getmodel");
		
		$aData['iPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
		$aData['sOrder'] = isset($aArgs['order']) ? $aArgs['order'] : "datetime_create";
		$aData['sSort'] = isset($aArgs['sort']) ? $aArgs['sort'] : "desc";
		$aData['sKeyword'] = isset($aArgs['keyword']) ? $aArgs['keyword'] : null;
		$aData['iRows'] = isset($aArgs['rows']) ? $aArgs['rows'] : 10;
		$aData['sStatus'] = isset($aArgs['status']) ? $aArgs['status'] : null;
		$sAddtionalQuery = (USER_GRADE == 9 ? "delete_flag = 0" : "delete_flag = 0 AND branch_idx = " . USER_ID);
		$aOption['where'] = $sAddtionalQuery;
		
		$aOption = array(
			"where" => $aOption['where'],
			"order" => $aData['sOrder'] . " " . strtoupper($aData['sSort']),
			"offset" => ($aData['iRows'] * ($aData['iPage'] - 1)),
			"limit" => $aData['iRows']
		);
		
		$aData['sUrl'] = common::getClassUrl(__CLASS__);		
		$aData['aDiscount'] = $this->db->getmodel->getData("tb_product_discount", $aOption);
		$aData['iTotalRows'] = $this->db->getmodel->getTotalRows("tb_product_discount", $sAddtionalQuery);
		$aData['sPagination'] = common::paginate($aData['iPage'], $aData['iRows'], (count($aData['aDiscount']) > 0 ? $aData['iTotalRows'] : 0));
		
		$this->importJS("product/product_discount");
		$this->display("product/tpl/" . __CLASS__, $aData);
	}
}