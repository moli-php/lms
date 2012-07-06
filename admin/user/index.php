<?php
include('../../__library/controller.php');
class index extends Simplexi_Controller
{
	/*add $aArgs parameter / change init to run*/
	public function run($aArgs){
	
		/*include common library*/
		$this->library("common");
		/*check if session start*/
		$this->library("checkLogin");
		
		/*tinymce*/
		$this->library('tinymce');
		Tinymce::init();
		/*send message*/
		$this->importJS('message/message');
		
		/*to import javascripts*/
		$this->importCSS("redactor/css/redactor");
		$this->importJS("redactor/redactor");
		$this->importJS("user/user");
		$this->importJS("tablesorter");
		
		/*for the exec functions*/
		$sAction = Common::getParam('action');
		$sAction = $sAction != "" ? "exec" . ucwords($sAction) : "execUser_list";
		$this->$sAction($aArgs);
		
	}

	/*for the user list*/
	public function execUser_list($aArgs){
	
		/*pagination*/
		$aData['sSearch'] = isset($aArgs['search']) ? trim($aArgs['search']) : ''; //search
		$aData['iCurPage'] = isset($aArgs['page'])?$aArgs['page']:1;
		$aData['iRowPerPage'] = isset($aArgs['rows']) ? $aArgs['rows'] : 10; //show rows
		
		/*seq*/
		if(USER_GRADE == 9){
			$sWhere = "  grade_idx != 9 AND quit_flag = 0";
		}else{
			$sWhere = "  branch_idx = '".USER_ID. "' AND grade_idx != 9 AND quit_flag = 0";
		}
		
		
		
		/*branch search*/
		if(isset($aArgs['branch_search'])){
			if($aArgs['branch_search'] == "none"){
				$sWhere .= '';
			}else{
				$sWhere .= ($aArgs['branch_search'] == '')? null: " AND branch_idx = ".$aArgs['branch_search'];
				$aData['sBranch_search'] = $aArgs['branch_search'];
			}
		}
		
		
		
		/*type search*/
		if(isset($aArgs['type_search'])){
			if($aArgs['type_search'] == "all"){
				$sWhere .= '';
			}else{
				$sWhere .= ($aArgs['type_search'] == '')? null: " AND grade_idx = ".$aArgs['type_search'];
			}
		}
		
		
		/*counts*/
		$aData['iRowTotRow'] = count($this->select("tb_user",null,$sWhere)->execute());
		$aData['iRowTotStud'] = count($this->select("tb_user",null,"grade_idx = 1 AND ".$sWhere)->execute());
		$aData['iRowTotTeac'] = count($this->select("tb_user",null,"grade_idx = 6 AND ".$sWhere)->execute());
		$aData['iRowTotHeadTeac'] = count($this->select("tb_user",null,"grade_idx = 7 AND ".$sWhere)->execute());
		
		$aData['iStatRowTotRow'] = (USER_GRADE == 9)?count($this->select("tb_user",null," quit_flag != 1 AND grade_idx != 9")->execute()):count($this->select("tb_user",null,"quit_flag != 1 AND grade_idx != 9  AND branch_idx =".USER_ID)->execute());
		$aData['iStatRowTotStud'] = (USER_GRADE == 9)?count($this->select("tb_user",null,"quit_flag != 1 AND grade_idx = 1")->execute()) : count($this->select("tb_user",null,"quit_flag != 1 AND grade_idx = 1 AND branch_idx =".USER_ID)->execute());
		$aData['iStatRowTotTeac'] = (USER_GRADE == 9)?count($this->select("tb_user",null,"quit_flag != 1 AND grade_idx = 6")->execute()) : count($this->select("tb_user",null,"quit_flag != 1 AND grade_idx = 6 AND branch_idx =".USER_ID)->execute());
		$aData['iStatRowTotHeadTeac'] = (USER_GRADE == 9)?count($this->select("tb_user",null,"quit_flag != 1 AND grade_idx = 7")->execute()) : count($this->select("tb_user",null,"quit_flag != 1 AND grade_idx = 7 AND branch_idx =".USER_ID)->execute());
		$aData['iStatRowTotBranch'] = (USER_GRADE == 9)?count($this->select("tb_user",null,"quit_flag != 1 AND grade_idx = 8")->execute()) : count($this->select("tb_user",null,"quit_flag != 1 AND grade_idx = 8 AND branch_idx =".USER_ID)->execute());
		
		
		
		
		
		/*search keyword*/
		$sWhere .= ($aData['sSearch'] == '')? null: " AND  user_id LIKE '%".$aData['sSearch']."%' OR phone_home LIKE '%".$aData['sSearch']."%' OR phone_mob LIKE '%".$aData['sSearch']."%'";
		
		$iOffset = ($aData['iCurPage'] - 1) * $aData['iRowPerPage'];
		
		/*query database*/
		
		$aData['aTbData'] = $this->select("tb_user",null,$sWhere)->orderBy('date_reg','desc')->limit($iOffset,$aData['iRowPerPage'])->execute();
		$aData['aTbGradeData'] = $this->select("tb_grade",null," grade_name != 'admin'")->orderBy('date_reg','asc')->execute();
		 
		 /*remove option to choose branch if not super admin*/
		 if(USER_GRADE != 9){
			    unset($aData['aTbGradeData'][0]);
		 }
		
		/*sub page*/
		$sSubPage = isset($aArgs['sub'])?$aArgs['sub']:'';
		
		/*if sub page exist*/
		if($sSubPage != ''){
			
			/*save if submitted*/
				if($sSubPage == "modify_user"){
				
					/*write js for the breadcrumbs*/
					$this->writeJS('$(function(){ $(".menu_curpage_breadcrumb").append("&nbsp;&gt;&nbsp;Modify User");});');
					$this->writeJS('$(function(){ $(".menu_title_breadcrumb").html("Modify User");});');
					$this->writeJS('$(function(){ $("#area_additional").show();});');
					
					$aData['aUserData'] = $this->select("tb_user",null," idx =".$aArgs['user_id'])->execute();
					
					if(isset($aArgs['submited'])){
					
						/*func to update/edit users*/
						self::_edit_submit($sSubPage,$aArgs,$aData);
					}
				}else{
				
					/*write js for the breadcrumbs*/
					$this->writeJS('$(function(){ $(".menu_curpage_breadcrumb").append("&nbsp;&gt;&nbsp;Add User");});');
					$this->writeJS('$(function(){ $(".menu_title_breadcrumb").html("Add User");});');
				
					if(isset($aArgs['submited'])){
					
						/*func to save users*/
						self::_save_submit($sSubPage,$aArgs,$aData);
					}
				}
			
			/*display sub page template*/
			$this->display("user/tpl/".$sSubPage, $aData);
			
		}else{
		
			/*else display user list template*/
			$this->display("user/tpl/user_list", $aData);
		}
		
	}
	
	/*for the grade mngt*/
	public function execGrade_mngt($aArgs){
		
		/*query database*/
		$aData['aTbData'] = $this->select("tb_grade",null)->execute();
		
		if(isset($aArgs['submited'])){
		
			if($aArgs['submited'] == "add"){
				$aSubmitData = array(
					"idx" => "",
					"grade_name" => $aArgs['grade_name'],
					"grade_num" => $aArgs['grade_num'],
					"date_reg" => time()
				);
				
				/*insert checker*/
				$bChecker = $this->select("tb_grade",null, "grade_name = '".$aArgs['grade_name']."'")->execute();
				if(empty($bChecker)){
					if($this->insert("tb_grade",$aSubmitData)->execute()){
						$this->message("success","Saved successfully");
						
						$aData['aTbData'] = $this->select("tb_grade",null)->execute();
					}else{
						$this->message("warning","Error saving");
						$aData['aTbData'] = $this->select("tb_grade",null)->execute();
					}
				}else{
					$this->message("warning","Grade name already in use");
				}
			}else{
				$aSubmitData = array(
					"grade_name" => $aArgs['mod_grade_name'],
					"grade_num" => $aArgs['mod_grade_num'],
					"date_reg" => $aArgs['mod_grade_datereg']
				);
				
				/*insert checker*/
				$bChecker = $this->select("tb_grade",null, "grade_name = '".$aArgs['mod_grade_name']."' && idx != ".$aArgs['mod_grade_idx'])->execute();
				if(empty($bChecker)){
					if($this->update("tb_grade",$aSubmitData," idx =".$aArgs['mod_grade_idx'])->execute()){
						$this->message("success","Updated successfully");
						$aData['aTbData'] = $this->select("tb_grade",null)->execute();
					}else{
						$this->message("warning","Error updating / No changes");
						$aData['aTbData'] = $this->select("tb_grade",null)->execute();
					}
				}else{
					$this->message("warning","Grade name already in use");
				}
			
			}
		}
		
		/*display grade_mngt template*/
		$this->display("user/tpl/grade_mngt", $aData);
	}
	
	/*grade details*/
	public function execGrade_details(){
		$aParam = Common::getParams();
		$aData = $this->selectRow( 'tb_grade', ''," idx = ".$aParam['get_grade_id'])->execute(); 
		echo json_encode($aData);
	}
	
	/*ajax function to check duplicate data*/
	public function execCheck_duplicate_id(){
		$aParam = Common::getParams();

		$sWhere = " user_id = '".$aParam['get_user_id']."'";
		$bChecker = count($this->select("tb_user",null,$sWhere)->execute());
		
		if($bChecker == 0){
			$sReturn = 'User id available';
		}else{
			$sReturn = 'User id already in use';
		}
		
		$aUser = $this->select("tb_user",null," idx = ".$aParam['get_user_idx'])->execute();
		
		if($aUser[0]['user_id'] == $aParam['get_user_id']){
			$sReturn = 'You already have this user id';
		}
		
		echo json_encode($sReturn);
	}
	
	/*ajax function to delete row data*/
	public function execDelete_list(){
		$aParam = Common::getParams();
		$bDelete = $this->query("UPDATE ".$aParam['get_from']." SET quit_flag = 1 WHERE idx IN (".$aParam['get_idx'].")");
		$bDeleteTbClass = $this->query("UPDATE tb_class SET class_status = 'deleted' WHERE student_idx IN (".$aParam['get_idx'].")");
		echo json_encode($bDelete);
	}
	
	/*ajax address finder*/
	public function execFind_address(){
		$aParam = Common::getParams();
		$sKeyword = $aParam['keyword'];
		$sTableName = "tb_siteconf_address";
		$aFields = array(
				"idx",
				"fzipcode",
				"fcity",
				"farea",
				"fplace"
		);
		$sWhere = "fcity LIKE '%".$sKeyword."%' OR farea LIKE '%".$sKeyword."%'";
		$result = $this->select($sTableName,$aFields,$sWhere)->execute();
		echo json_encode($result);
	}
	
	/*ajax grade chcker*/
	public function execGrade_checker(){
		$aParam = Common::getParams();
		$sAddWhere = ($aParam['get_grade_idx'] != "") ? " && idx != ".$aParam['get_grade_idx'] : "";
		$aData = $this->selectRow( "tb_grade", ""," grade_name = ".$aParam['get_grade_name'].$sAddWhere)->execute();
		$bValid = (count($aData) == 1) ? false : true;
		echo json_encode($bValid);
	}
	
	/*get the data from a db row*/
	public function execGet_dbdata_rows(){
		$aParam = Common::getParams();
		$sReturn =  $this->select( $aParam['get_tb'], $aParam['get_field'],$aParam['get_where'])->execute();
		echo json_encode($sReturn);
	}
	
	/*save submit*/
	public function _save_submit($sSubPage,$aArgs,$aData){
		/*check if username already exist*/
		$sWhere = " user_id = '".$aArgs['username']."'";
		
		if(isset($aArgs['user_id'])){
			$sWhere .= " && idx !=".$aArgs['user_id'];
		}
		$bChecker = count($this->select("tb_user",null,$sWhere)->execute());
		
		if($bChecker == 0){
			/*file to upload */
				if(!empty($_FILES['file']['name'])){
				
					/*file*/
					$file = $_FILES['file'];
					$name = $file['name'];
					$sFileName = "profile/".time()."_".$file['name'];
					$sPath = "../../uploads/" . $sFileName;
					
					/*move uploaded file*/
					if (move_uploaded_file($file['tmp_name'], $sPath)) {
						$sPath = "../../uploads/profile/" . $sFileName;
					} else {
						$this->message("warning","Error uploading file");
						$aData['aUserInfo'] = $aData;
					}
				
				}else{
					if($sSubPage == "modify_user"){
						$sFileName = $aArgs['prof_img_name'];
					}else{
						$sFileName = "profile/no_picture.png";
					}
				}
				
				/*for branch*/
				if(USER_GRADE == 9){
					$iBranch = (isset($aArgs['branch']))?$aArgs['branch']:'';
				}else{
					$iBranch = USER_ID;
				}
			
				/*data to insert in db*/
				$aData = array(
							"idx" => (isset($aArgs['user_id']))?$aArgs['user_id']:'',
							"user_id" => $aArgs['username'],
							"password" => $aArgs['password'],
							"name" => $aArgs['name'],
							"pass_ques" => $aArgs['pass_ques'],
							"pass_ans" => $aArgs['pass_ans'],
							"ssn" => $aArgs['ssn1'].'-'.$aArgs['ssn2'],
							"email" => $aArgs['email'],
							"nickname" => $aArgs['nickname'],
							"grade_idx" => $aArgs['grade'],
							"branch_idx" => ($aArgs['grade'] == 8)? 0 :$iBranch,
							"phone_home" => ($aArgs['phone_home1'] && $aArgs['phone_home2'] && $aArgs['phone_home3']) ? $aArgs['phone_home1']."-".$aArgs['phone_home2']."-".$aArgs['phone_home3']:'',
							"phone_mob" => ($aArgs['phone_mob1'] && $aArgs['phone_mob2'] && $aArgs['phone_mob3'])?$aArgs['phone_mob1']."-".$aArgs['phone_mob2']."-".$aArgs['phone_mob3']:'',
							"address" => $aArgs['faddress'],
							"profile_img" => $sFileName,
							"date_reg" => (isset($aArgs['date_reg']))?(int)$aArgs['date_reg']:time(),
							"point" => $aArgs['point'],
							"intro" => $aArgs['user_intro'],
							"teacher_type_idx" => (isset($aArgs['teacher_type'])) ? $aArgs['teacher_type'] : 0,
							"teacher_head_idx" => (isset($aArgs['head_teacher'])) ? $aArgs['head_teacher'] : 0,
							"quit_flag" => 0
							);
		
				/*insert checker*/
				if($sSubPage == "modify_user"){
					if($this->update("tb_user",$aData," idx =".$aData['idx'])->execute()){
						echo "<script>location.href='" . BASE_URL . "admin/user'</script>";
					}else{
						$this->message("warning","Error updating");
					}
				}else{
					if($this->insert("tb_user",$aData)->execute()){
					
						/*points*/
						$iReason = 1;
						$iPointInfo = $this->selectRow( "tb_points_reason", ""," idx= ".$iReason)->execute();
						$sStatus = 'get';
						
						$aData = array(
							"user_id" => $aArgs['username'],
							"amount_points" => $iPointInfo['amount'],
							"reason" => $iPointInfo['reason'],
							"status" => $sStatus,
							"branch_idx" => ($aArgs['grade'] == 8)? 1 :$iBranch,
							"date_registered" => time(),
							"isDeleted" => "no"
						);
						
						$this->insert("tb_points",$aData)->execute();
						
						
						echo "<script>location.href='" . BASE_URL . "admin/user'</script>";
					}else{
						$this->message("warning","Error saving");
					}
				}
			}else{
				$this->message("warning","User id alredy exist.");
			
			}
	}
		
	/*edit submit*/
	public function _edit_submit($sSubPage,$aArgs,$aData){
		/*check if username already exist*/
		$aUser = $this->select("tb_user",null," idx = ".$aArgs['user_id'])->execute();
		$sWhere = " user_id = '".$aArgs['username']."'";
		$bChecker = count($this->select("tb_user",null,$sWhere)->execute());
	
	
		if($aUser[0]['user_id'] != $aArgs['username'] && $bChecker != 0){
			$this->message("warning","User id alredy exist.");
		}else{
			self::_save_submit($sSubPage,$aArgs,$aData);
		}
	}
	
	/*ajax get count of data from db*/
	public function _getCount($sType = null){
	
		/*extra data*/
		if(USER_GRADE == 9){
			if($sType == null){
				$sWhereSeq = " grade_idx != 9";
			}else{
				$sWhereSeq = " AND grade_idx != 9";
			}
		}else{
			if($sType == null){
				$sWhereSeq = " branch_idx = ".USER_ID." AND  grade_idx != 9";
			}else{
				$sWhereSeq = "AND branch_idx = ".USER_ID." AND  grade_idx != 9";
			}
		}
		
		if($sType == null){
			$iReturn = count($this->select("tb_user",null,$sWhereSeq)->execute());
		}else{
			$iReturn = count($this->select("tb_user",null," grade_idx = '".$sType."' ".$sWhereSeq)->execute());
		}
		return $iReturn;
	
	}
	
	/*ajax data getter*/
	public function _getDataBy($sTb, $sField,$sWhere = '',$bRow = false){
		if($bRow == false){
			$sReturn =  $this->selectRow( $sTb, $sField,$sWhere)->execute();
			return  $sReturn[$sField];
		}else{
			$sReturn =  $this->select( $sTb,$sField,$sWhere)->execute();
			return  $sReturn;
		}
	}
	
	/*get the data from a db row*/
	public function execRedactor(){
		$sPath = "../../uploads/test/";
		$this->redactor_init($sPath);
	}
	
	public function urlIncluded($sParam,$sRemoveParam = null)
    {
        $href = preg_match('/'.$sParam.'=[^?&]*/', $_SERVER["REQUEST_URI"]) ? preg_replace('/[?&]'.$sParam.'=[^?&]*/', '', $_SERVER["REQUEST_URI"]) : $_SERVER["REQUEST_URI"];
        $sConnector = preg_match('/\?/', $_SERVER["REQUEST_URI"]) ? '&' : '?';
        $href = $href . $sConnector . $sParam . '=';
        $href = preg_replace('/\/\&/', '/?', $href);
		
		if($sRemoveParam != null){
			$href = preg_replace('/[?&]'.$sRemoveParam.'=[^&]*/', '', $href);
		}
        echo $href;
    }
	
}

$oClass = new index();
$oClass->run($aArgs); #initialize here

