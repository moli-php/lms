<?php
class productClass extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$aData['sPageTitle'] = "Class List | Product";
		$this->model("getmodel");
		$this->importJS("product/global");

		$aData['iPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
		$aData['sOrder'] = isset($aArgs['order']) ? $aArgs['order'] : "datetime_create";
		$aData['sSort'] = isset($aArgs['sort']) ? $aArgs['sort'] : "desc";
		$aData['sKeyword'] = isset($aArgs['keyword']) ? $aArgs['keyword'] : null;
		$aData['iRows'] = isset($aArgs['rows']) ? $aArgs['rows'] : 10;
		$aData['sStatus'] = isset($aArgs['status']) ? $aArgs['status'] : null;
		$aData['iMonths'] = isset($aArgs['months']) ? $aArgs['months'] : null;
		$aData['iDays'] = isset($aArgs['days']) ? $aArgs['days'] : null;
		$aData['sType'] = isset($aArgs['type']) ? $aArgs['type'] : null;
		$aData['sCountry'] = isset($aArgs['country']) ? $aArgs['country'] : null;
		$sAddtionalQuery = (USER_GRADE == 9 ? "delete_flag = 0" : "delete_flag = 0 AND branch_idx = " . USER_ID);
		$aOption['where'] = $sAddtionalQuery;

		if ($aData['sKeyword'] != null)
			$aOption['where'] .= ($aOption['where'] != "" ? " AND " : "") . "name LIKE '%" . $aData['sKeyword'] . "%'";
		if ($aData['sStatus'] != null) {
			$iStatus = $aData['sStatus'] == "activated" ? 1 : 0;
			$aOption['where'] .= ($aOption['where'] != "" ? " AND " : "") . "status = " . $iStatus;
		}
		if ($aData['iMonths'] != null)
			$aOption['where'] .= ($aOption['where'] != "" ? " AND " : "") . "total_months = " . $aData['iMonths'];
		if ($aData['iDays'] != null)
			$aOption['where'] .= ($aOption['where'] != "" ? " AND " : "") . "total_days = " . $aData['iDays'];
		if ($aData['sType'] != null)
			$aOption['where'] .= ($aOption['where'] != "" ? " AND " : "") . "type = '" . strtolower($aData['sType']) . "'";
		if ($aData['sCountry'] != null)
			$aOption['where'] .= ($aOption['where'] != "" ? " AND " : "") . "country = '" . $aData['sCountry'] . "'";

		$aOption = array(
			"where" => $aOption['where'],
			"order" => $aData['sOrder'] . " " . strtoupper($aData['sSort']),
			"offset" => ($aData['iRows'] * ($aData['iPage'] - 1)),
			"limit" => $aData['iRows']
		);
		
		$_SESSION['adminProductFullUrl'] = FULL_URL;

		$aData['aClass'] = $this->db->getmodel->getData("tb_product_class", $aOption);
		$aData['iTotalData'] = $this->db->getmodel->getTotalRows("tb_product_class", $sAddtionalQuery);
		$aData['iTotalRows'] = $this->db->getmodel->getTotalRows("tb_product_class", $aOption['where']);
		$aData['iActivated'] = $this->db->getmodel->getTotalRows("tb_product_class", "status = 1 AND " . $sAddtionalQuery);
		$aData['iDeactivated'] = $this->db->getmodel->getTotalRows("tb_product_class", "status = 0 AND " . $sAddtionalQuery);
		$aData['sUrl'] = common::getClassUrl(__CLASS__);
		$aData['sPagination'] = common::paginate($aData['iPage'], $aData['iRows'], (count($aData['aClass']) > 0 ? $aData['iTotalRows'] : 0));

		$this->display("product/tpl/productClass", $aData);
	}
}