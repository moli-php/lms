<?php
class productCourse extends Simplexi_Controller
{
	public function run($aArgs)
	{
	    $this->library("common");
	    $this->importJS("product/product_course");
	    $this->model("getmodel");
	    $this->mainProductCourse($aArgs);
    }

    public function mainProductCourse($aArgs)
    {
	    $aData['keyword'] = isset($aArgs['keyword'])? $aArgs['keyword'] : "";
	    $aData['iCurPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
	    $aData['iRowPerPage'] = isset($aArgs['rows']) ? $aArgs['rows'] : 10;
	    $iOffset = $aData['iRowPerPage'] * ($aData['iCurPage']-1);
	    $aData['sUrl'] = common::getClassUrl(__CLASS__);
	    $aData['sOrder'] = isset($aArgs['order']) ? $aArgs['order'] : "idx";
	    $aData['sSort'] = isset($aArgs['sort']) ? $aArgs['sort'] : "desc";

	    $aOption = array(
	            "order" => $aData['sOrder'] ." ". $aData['sSort'],
	            "offset" => $iOffset,
	            "limit" =>	$aData['iRowPerPage'],
	            "where" => "name LIKE '%".$aData['keyword']."%'"
        );

	    $aData['aCourseList'] = $this->db->getmodel->getData("tb_product_course", $aOption);
	    $aData['iRowTotRow'] =  $this->db->getmodel->getTotalRows("tb_product_course", "name LIKE '%".$aData['keyword']."%'");

	    $i = 0;
	    if($aData['iRowTotRow'] >=1){
    	    foreach($aData['aCourseList'] as $key=>$val)
    	    {
    	        $aData['aCourseList'][$key]['iCount'] = $aData['iRowTotRow'] - $iOffset - $i;
    	        ++$i;
    	    }
	    }
	    $this->display("product/tpl/productCourse", $aData);
	}

}