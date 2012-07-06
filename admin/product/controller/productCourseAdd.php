<?php
class productCourseAdd extends Simplexi_Controller
{
	public function run($aArgs)
	{
	    $this->model("getmodel");
	    $aData['aDetails']="";
	    if(isset($aArgs['idx'])!=null){
    	    $sWhere="idx=". $aArgs['idx'];
    	    $aFields = array(
    	            "idx",
    	            "name",
    	            "description"
    	    );
    	    $aData['aDetails'] = $this->select("tb_product_course", $aFields, $sWhere)->execute();
	    }
		$this->display("product/tpl/productManageCourse", $aData);
	}
}


