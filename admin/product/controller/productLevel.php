<?php
class productLevel extends Simplexi_Controller
{
	public function run($aArgs)
	{
		$this->library("common");
		$this->model("getmodel");
		$this->importJS("product/product_course");
		$this->onLoadLevel($aArgs);
	}
	
	public function onLoadLevel($aArgs)
	{
		$aData['iPage'] = isset($aArgs['page']) ? $aArgs['page'] : 1;
		$aData['sOrder'] = isset($aArgs['order']) ? $aArgs['order'] : "name";
		$aData['sSort'] = isset($aArgs['sort']) ? $aArgs['sort'] : "desc";
		$aData['sKeyword'] = isset($aArgs['sKeyword']) ? $aArgs['sKeyword'] : null;
		$aData['iRows'] = isset($aArgs['row']) ? $aArgs['row'] : 10;
		$aData['sUrl'] = common::getClassUrl(__CLASS__);
		
		if(isset($aData['sKeyword'])){
			$aOptions = array(
					"order" => "idx " . $aData['sSort'],
					"limit" => $aData['iRows'],
					"offset" => ($aData['iPage'] * $aData['iRows']) - $aData['iRows'],
					"where" => "name LIKE '%" . $aData['sKeyword'] . "%'"
			);
		}else{
			$aOptions = array(
					"order" => "idx " . $aData['sSort'],
					"limit" => $aData['iRows'],
					"offset" => ($aData['iPage'] * $aData['iRows']) - $aData['iRows']
			);
		}
		
		
		$aData['list'] = $this->db->getmodel->getData("tb_product_level", $aOptions);
		$aData['totalRows'] = $this->db->getmodel->getTotalRows("tb_product_level");
		$this->display("product/tpl/productLevel", $aData);
	}

}