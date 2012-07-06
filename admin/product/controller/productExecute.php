<?php

class productExecute extends Simplexi_Controller
{
	public function run($aArgs)
	{
	    $this->library(array("checkLogin", "common"));
	    $this->model("execmodel");
		$sAction = "exec" . ucfirst($aArgs['exec']);
		unset($aArgs['exec']);
		unset($aArgs['action']);
		$this->$sAction($aArgs);
	}

	private function execSaveClass($aArgs)
	{
		$aData = array(
			"status" => $aArgs['status'],
			"teacher_type" => $aArgs['country'],
			"type" => $aArgs['type'],
			"total_months" => $aArgs['total_months'],
			"total_days" => $aArgs['total_days'],
			"total_time" => $aArgs['total_time'],
			"name" => $aArgs['name'],
			"price" => $aArgs['price'],
			"point" => $aArgs['point'],
			"description" => $aArgs['description'],
			"start_time" => $aArgs['starttime_hours'] . ":" . $aArgs['starttime_minutes'],
			"end_time" => $aArgs['endtime_hours'] . ":" . $aArgs['endtime_minutes'],
			"datetime_create" => time(),
			"datetime_update" => time()
		);
	
		$aData['discount'] = "";
		
		if (isset($aArgs['discountList'])) {
			foreach ($aArgs['discountList'] as $sValue)
				$aData['discount'] .= $sValue . ",";
				
			$aData['discount'] = substr($aData['discount'], 0, -1);
		}
		
		$aData['branch_idx'] = USER_ID;

		$aResult = $this->db->execmodel->insertData("tb_product_class", $aData);
		
		if ($aResult === false)
			echo false;
		else {
			$this->message("success", "Successfully saved.");
			echo true;
		}
			
	}
	
	private function execDeleteClass($aArgs)
	{
		$aData = array(
			"delete_flag" => 1
		);
	
		foreach ($aArgs['idxArrayList'] as $iValue)
			$this->db->execmodel->updateData("tb_product_class", $aData, "idx = " . $iValue);
	}
	
	private function execDeleteDiscount($aArgs)
	{
		$aData = array(
			"delete_flag" => 1
		);

		foreach ($aArgs['idxArrayList'] as $iValue)
			$this->db->execmodel->updateData("tb_product_discount", $aData, "idx = " . $iValue);
	}
	
	private function execSaveDiscount($aArgs)
	{
		$aData = array(
			"branch_idx" => USER_ID,
			"name" => $aArgs['discount_name'],
			"amount" => ($aArgs['discount_class'] == "0" ? $aArgs['discount_amount'] * -1 : $aArgs['discount_amount']),
			"type" => $aArgs['discount_type'],
			"datetime_create" => time()
		);
		
		
		$aResult = $this->db->execmodel->insertData("tb_product_discount", $aData);
		
		if ($aResult === false) {
			$this->message("warning", "Saving failed.");
			echo false;
		} else {
			$this->message("success", "Successfully saved.");
			echo true;
		}
	}
	
	private function execEditDiscount($aArgs)
	{
		$aData = array(
			"name" => $aArgs['discount_name'],
			"amount" => ($aArgs['discount_class'] == "0" ? $aArgs['discount_amount'] * -1 : $aArgs['discount_amount']),
			"type" => $aArgs['discount_type'],
			"datetime_update" => time()
		);
		
		$aResult = $this->db->execmodel->updateData("tb_product_discount", $aData, "idx = " . $aArgs['idx']);
		
		if ($aResult === false)
			$this->message("warning", "Saving failed.");
		else
			$this->message("success", "Successfully saved.");
	}
	
	private function execSaveBook($aArgs)
	{
		$aData = array(
			"status" => $aArgs['book_status'],
			"name" => $aArgs['book_name'],
			"description" => $aArgs['book_description'],
			"price" => $aArgs['book_price'],
			"datetime_create" => time()
		);
		
		if (isset($aArgs['file_upload']) && $aArgs['file_upload'] != "") {
			$bResult = $this->execUploadImage($aArgs['file_upload'], "files", true);
			
			if ($bResult["result"] === true) {
				$aData['file_path'] = $bResult["path"];
			} else {
				echo "Uploading file failed.";
	
			}
		} 
		
		if (isset($aArgs['image_upload']) && $aArgs['image_upload'] != "") {
			$bResult = $this->execUploadImage($aArgs['image_upload'], "book", true);
			
			if ($bResult["result"] === true){
				$aData['image_path'] = $bResult["path"];
				unlink(SERVER_DOCUMENT_ROOT . "/uploads/" . $aArgs['image_path']);
			} else {
				echo "Uploading image failed.";
	
			}
		} 

		$aResult = $this->db->execmodel->insertData("tb_product_book", $aData);

		echo SERVER_DOCUMENT_ROOT . "/uploads/" . $aArgs['image_path'];
	}
	
	private function execUploadImage($aArgs, $sPath = "temp", $sReturn = false)
	{
		$sFile = $sReturn === false ? $aArgs['image_upload'] : $aArgs;
		$sFilename = pathinfo($sFile['name'], PATHINFO_FILENAME);
		$sExtension = pathinfo($sFile['name'], PATHINFO_EXTENSION);
			
		$sFilename = md5($sFile['name'] . time() . sha1($sFilename)) . "." . $sExtension;
		$sReturnPath = $sPath . "/" . $sFilename;
		$sFilePath = SERVER_DOCUMENT_ROOT . "/uploads/" . $sReturnPath;

		$sImageResult = move_uploaded_file($sFile['tmp_name'], $sFilePath);

		if (!$sImageResult){
			$sResponse = array(
				"result" => "failed",
				"data" => "Unable to upload image file. Please try again."
			);
		} else {
			$sResponse = array(
				"result" => "success",
				"data" => $sReturnPath
			);
		}
		
		if ($sReturn === false)
			echo json_encode($sResponse);
		else
			return array(
				"result" => $sImageResult, 
				"path" => $sReturnPath
			);
	}
	
	private function execEditClass($aArgs)
	{
		$iIdx = $aArgs['idx'];
		
		$aData = array(
			"status" => $aArgs['status'],
			"teacher_type" => $aArgs['country'],
			"type" => $aArgs['type'],
			"total_months" => $aArgs['total_months'],
			"total_days" => $aArgs['total_days'],
			"total_time" => $aArgs['total_time'],
			"name" => $aArgs['name'],
			"price" => $aArgs['price'],
			"point" => $aArgs['point'],
			"description" => $aArgs['description'],
			"start_time" => $aArgs['starttime_hours'] . ":" . $aArgs['starttime_minutes'],
			"end_time" => $aArgs['endtime_hours'] . ":" . $aArgs['endtime_minutes'],
			"datetime_create" => time(),
			"datetime_update" => time()
		);
	
		$aData['discount'] = "";
		
		if (isset($aArgs['discountList'])) {
			foreach ($aArgs['discountList'] as $sValue)
				$aData['discount'] .= $sValue . ",";
				
			$aData['discount'] = substr($aData['discount'], 0, -1);
		}
		
		$aResult = $this->db->execmodel->updateData("tb_product_class", $aData, "idx = " . $iIdx);

		if ($aResult === false)
			echo false;
		else
			echo true;
	}

	private function execSaveCourse($aArgs)
	{
	    $aData = array(
	            "name" => addslashes(ucwords(strtolower($aArgs['name']))),
	            "description" => $aArgs['description']
	    );
	    if($aArgs['idx']=="none"){
	        $aData["datetime_added"] = time();
	        $aResult = $this->insert("tb_product_course", $aData)->execute();
	    }
	    else {
	        $aResult = $this->update("tb_product_course", $aData, "idx=".$aArgs['idx'])->execute();
	    }
	    echo json_encode($aResult);
	}

	private function execDeleteCourse($aArgs)
	{
	    $sWhere = "idx IN(".$aArgs['idx'].")";
	    $sQuery = "DELETE FROM tb_product_course WHERE ". $sWhere;
	    $aResult = $this->query($sQuery);
	    echo json_encode($aResult);
	}

	private function execShowAllLevel($aArgs)
	{
		$sTblName = "tb_product_level";
		$aFields = array(
			"name",
			"description"
		);
		$aResult = $this->select($sTblName, $aFields)->execute();
		echo json_encode($aResult);
	}

	private function execSaveLevel($aArgs)
	{
		$aData = array(
			"name" => $aArgs['name'],
			"description" => $aArgs['description']	
		);
		
		if($aArgs['id'] != null){
			$aResult = $this->update("tb_product_level", $aData, "idx=" . $aArgs['id'])->execute();
		}else{
			$aResult = $this->db->execmodel->insertData("tb_product_level", $aData);
		}
		
		echo $aResult;
	}
	
	private function execDeleteLevel($aArgs)
	{
		$ids = explode(",", $aArgs['id']);
		foreach($ids as $val){
			$this->db->execmodel->delete("tb_product_level", "idx = " . $val);
		}
	}
	
}