<?php

class common
{
	/** This function gets all the parameters passed via JS AJAX to a php file **/

	public function getParams()
	{
		$aParam = array_merge($_REQUEST, $_FILES);
		return $aParam;
	}

	/** This function gets the action passed via JS AJAX to a php file **/

	public function getParam($sKey)
	{
		if( is_string($sKey) && trim($sKey) != '') {
			$aParam = common::getParams();
			return (array_key_exists($sKey, $aParam)) ? $aParam[$sKey] : '';
		}
	}

	/** This function gets the character(s) between two strings / words **/

	public function getStringBetween($sString, $sStart, $sEnd)
	{
		$sString = " " . $sString;
		$sTemp = strpos($sString, $sStart);

		if ($sTemp == 0){
			return "";
		}
		else {
			$sTemp += strlen($sStart);
			$sLength = strpos($sString, $sEnd, $sTemp) - $sTemp;
			return substr($sString, $sTemp, $sLength);
		}
	}

	/** This function gets content of a specific URL **/

	public function downloadContent($sPath, $iTimeout = 30)
	{
		$cUrl = curl_init();

		curl_setopt($cUrl, CURLOPT_URL, $sPath);
		curl_setopt($cUrl, CURLOPT_FAILONERROR, 1);
		//curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($cUrl, CURLOPT_TIMEOUT, $iTimeout);

		$retValue = curl_exec($cUrl);
		curl_close($cUrl);

		return $retValue;
	}

	/** This function gets content of a specific Folder **/

	public function getFolderContent($sFolder)
	{
		$aFiles = array();
		$aContent = dir($sFolder);

		while ($sFiles = $aContent->read()){
			$aFiles[] = $sFiles;
		}

		closedir($aContent->handle());

		return $aFiles;
	}

	public function cropImage($sFilepath, $sWidth = null, $sHeight = null, $sCropRatio = null, $sQuality = null, $sSharpen = false)
	{
		if (!file_exists($sFilepath)){
			echo "No files exist.";
			exit;
		}

		$sFileName = pathinfo($sFilepath,PATHINFO_FILENAME);
		$sFileExtension = strtolower(pathinfo($sFilepath, PATHINFO_EXTENSION));
		$aExtention = array("jpeg", "jpg", "png", "gif", "bmp");

		if (!in_array($sFileExtension, $aExtention)){
			exit;
		}

		$aSize = GetImageSize($sFilepath);
		$sMime = $aSize['mime'];
		$iWidth = $aSize[0];
		$iHeight = $aSize[1];
		$iQuality = $sQuality != null ? $sQuality : 100;
		$iNewHeight = $sHeight != null ? $sHeight : 0;
		$iNewWidth = $sWidth != null ? $sWidth : 0;

		if (!$iNewWidth && $iNewHeight){
			$iNewWidth	= 99999999999999;
		}
		elseif ($iNewWidth && !$iNewHeight){
			$iNewHeight	= 99999999999999;
		}
		elseif (!$iNewWidth && !$iNewHeight){
			$iNewWidth	= $iWidth;
			$iNewHeight	= $iHeight;
		}

		if ($iWidth <= $iNewWidth) $iNewWidth = $iWidth;
		if ($iHeight <= $iNewHeight) $iNewHeight = $iHeight;

		switch ($aSize['mime']){
			case 'image/png':
				$oImageFunction	= "imagecreatefrompng";
				$oOutputFunction = "imagepng";
				$sMime = "image/png";
				$sExtension = "png";
				$iQuality = round(10 - ($iQuality / 10));
			break;

			case 'image/gif':
				$oImageFunction	= "imagecreatefromgif";
				$oOutputFunction = "imagegif";
				$sMime = "image/gif";
				$sExtension = "gif";
				$iQuality = round(10 - ($iQuality / 10));
			break;

			default:
				$oImageFunction	= "imagecreatefromjpeg";
				$oOutputFunction = "imagejpeg";
				$sExtension = "jpeg";
				$mime = "image/jpeg";
			break;
		}

		$oImage = $oImageFunction($sFilepath);
		$iOffsetX = 0;
		$iOffsetY = 0;

		if ($sCropRatio != null){
			$aRatio = explode(':', (string) $sCropRatio);
			if (count($aRatio) == 2){
				$iRatio = $iWidth / $iHeight;
				$iCropRatio = (float) $aRatio[0] / (float) $aRatio[1];

				if ($iRatio < $iCropRatio){
					$iTempHeight = $iHeight;
					$iHeight = $iWidth / $iCropRatio;
					$iOffsetY = ($iTempHeight - $iHeight) / 2;
				}
				else if ($iRatio > $iCropRatio){
					$iTempWidth = $iWidth;
					$iWidth = $iHeight * $iCropRatio;
					$iOffsetX = ($iTempWidth - $iWidth) / 2;
				}
			}
		}

		$xRatio = $iNewWidth / $iWidth;
		$yRatio = $iNewHeight / $iHeight;

		if (($xRatio * $iHeight) < $iNewHeight){
			$iTargetHeight = ceil($xRatio * $iHeight);
			$iTargetWidth = $iNewWidth;
		}
		else {
			$iTargetWidth = ceil($yRatio * $iWidth);
			$iTargetHeight = $iNewHeight;
		}

		ini_set('memory_limit', '100M');

		$oNewImage = imagecreatetruecolor($iTargetWidth, $iTargetHeight);

		if (in_array($sMime, array('image/gif', 'image/png'))){
			imagealphablending($oNewImage, false);
			imagesavealpha($oNewImage, true);
		}

		imagecopyresized($oNewImage, $oImage, 0, 0, $iOffsetX, $iOffsetY, $iTargetWidth, $iTargetHeight, $iWidth, $iHeight);

		if ($sSharpen === true){
			$aSharpenMatrix = array (
				array(-1.2, -1, -1.2),
				array(-1, 20, -1),
				array(-1.2, -1, -1.2)
			);

			$iDivisor = array_sum(array_map('array_sum', $aSharpenMatrix));
			imageconvolution($oNewImage, $aSharpenMatrix, $iDivisor, 0);
		}

		$oOutputFunction($oNewImage, $sFilepath, $iQuality);

		ImageDestroy($oImage);
		ImageDestroy($oNewImage);
	}

	public function relativeTime($dDate){
		$iDifference = time() - $dDate;
		$sPeriods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
		$iLengths = array("60","60","24","7","4.35","12","10");

		if ($iDifference > 0) {
			$sEnding = "ago";
		}
		else {
			$iDifference = -$iDifference;
			$sEnding = "to go";
		}

		for($i = 0; $iDifference >= $iLengths[$i]; $i++) $iDifference /= $iLengths[$i];

		$iDifference = round($iDifference);

		if($iDifference != 1) $sPeriods[$i].= "s";

		if ($sPeriods[$i] == "second" || $sPeriods[$i] == "seconds") return "a few seconds ago";
		else if ($sPeriods[$i] == "minute") return "about a minute " . $sEnding;
		else return $iDifference . '&nbsp;' . $sPeriods[$i] . " " . $sEnding;
	}

	public function getTimeZoneTime($iTimeStamp, $sFormat, $sTimezone = "Asia/Manila")
	{
		date_default_timezone_set($sTimezone);
		return date($sFormat, $iTimeStamp);
	}

	public function makeClickableLinks($sString)
	{
		$sString = preg_replace("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2", $sString);
		$sString = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a target=\"_blank\" href=\"$1\">$1</A>", $sString);
		$sString = preg_replace("/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i","<a href=\"mailto:$1\">$1</a>", $sString);

		return $sString;
	}

	function getSecurityCode($aData)
	{
		$sData = "";

		if (is_array($aData)) foreach ($aData as $sValue) $sData .= $sValue;
		else $sData = $aData;

		return sha1($sData . sha1(md5(ENCRYPTION_KEY)));
	}

	function checkSecurityCode($sCode, $aData)
	{
		$sData = "";

		if (is_array($aData)) foreach ($aData as $sValue) $sData .= $sValue;
		else $sData = $aData;

		$sRealCode = sha1($sData . sha1(md5(ENCRYPTION_KEY)));

		if ($sCode === $sRealCode) return TRUE;
		else return FALSE;
	}

	function parseHtmlJson($aData){
		$sString = "";

		foreach ($aData as $sKey => $sValue){
			$sString .= '&quot;' . $sKey . '&quot;:' . checkValue($sValue) . ",";
		}

		return "{" . substr($sString, 0, -1) . "}";
	}

	function checkValue($sValue){
		if($sValue == "null" || strtolower($sValue) == "now()"){
			return $sValue;
		}

		switch (strtolower(gettype($sValue))){
			case 'string':
				settype($sValue, 'string');
				$sValue = '&quot;' . mysql_escape_string($sValue) . '&quot;';
				break;
			case 'integer':
				settype($sValue, 'integer');
				break;
			case 'double' :
			case 'float' :
				settype($sValue, 'float');
				break;
			case 'boolean':
				settype($sValue, 'boolean');
				break;
			case 'array':
				$sValue = '&quot;' . mysql_escape_string(implode(',', $sValue)) . '&quot;';
				break;
			case 'null' :
				$sValue = 'null';
				break;
		}

		return $sValue;
	}

		/*download xml file*/
	function curlXml($sPath)
	{
		$sDataEJson = json_encode(simplexml_load_file($sPath));

		return json_decode($sDataEJson,true);
	}

	/*search the curl*/
	function search_arr($aArrData,$sSearch){

		$pattern = '/^'.$sSearch.'/i';
		$aReturn = array();

		foreach($aArrData as $key => $val){
			if(preg_match($pattern, $val['page'], $matches, PREG_OFFSET_CAPTURE)){
				array_push($aReturn,$val);
			}
		}
		return $aReturn;

	}

	/*give display the menu via xml*/
	function displayMenu($bSideMenu = true, $aMostButton = null){

		$bChecker = $this->select("tb_menu","","branch_idx = ".USER_ID)->execute();
//var_dump($bChecker);

		if(!empty($bChecker)){
			$aMenu =$this->selectRow("tb_menu","menu"," branch_idx = ".USER_ID)->execute();
			$aMenu =json_decode($aMenu['menu'],true);
		}else if(USER_GRADE == 7 && USER_GRADE == 6){
			$sMenu = '';
		}else{
			$sMenu = '
				[{"idx":1,"label":"Dashboard","page":"dashboard","seq":1,"hidden_flag":0},
				{"idx":2,"label":"Message","page":"message","seq":2,"hidden_flag":0},
				{"idx":3,"label":"Class","page":"class","seq":3,"hidden_flag":0},
				{"idx":4,"label":"User","page":"user","seq":4,"hidden_flag":0},
				{"idx":5,"label":"Teacher","page":"teacher","seq":5,"hidden_flag":0},
				{"idx":6,"label":"Point","page":"point","seq":6,"hidden_flag":0},
				{"idx":7,"label":"Ulearning","page":"ulearning","seq":7,"hidden_flag":0},
				{"idx":8,"label":"Product","page":"product","seq":8,"hidden_flag":0},
				{"idx":9,"label":"Forum","page":"forum","seq":9,"hidden_flag":0},
				{"idx":10,"label":"Branch","page":"branch","seq":10,"hidden_flag":0},
				{"idx":11,"label":"Statistics","page":"statistics","seq":11,"hidden_flag":0},
				{"idx":12,"label":"Event","page":"event","seq":12,"hidden_flag":0},
				{"idx":13,"label":"Configuration","page":"configuration","seq":13,"hidden_flag":0}]
			';
			$aMenu = json_decode($sMenu,true);
		}
		
		//var_dump($aMenu);
		/*check user (give menu list)*/
		if(USER_GRADE == 8 || USER_GRADE == 9){
			$aData = $this->select("tb_menu")->execute();
		}

		$sCurPage = explode('/',$_SERVER['REQUEST_URI']);

		$sReturn = '';

		$sReturn .= '<div class="bottom">';
		if(USER_GRADE == 8 || USER_GRADE == 9){
			$sReturn .= '<div class="btn_prev"><a href="#" class="btn_nav prev"><strong><span class="hidden">Previous</span></strong></a></div>';
			$sReturn .= '<div class="btn_next"><a href="#" class="btn_nav next"><strong><span class="hidden">Next</span></strong></a></div>';
		}
		$sReturn .= '<div class="menu_container">';
		$sReturn .= '<div class="overflow_wrap _tmenuwrap">';

		/*top menu*/
			if(isset($aMenu)){

				#level 1 ul
				$sReturn .= '<ul id="main_nav" class="sf-menu _tmenuarea_lv1">';

					foreach($aMenu as $key=>$val){
						#main menu
						$sReturn .= '<li class="_tmenuitem_lv1 _first_menu_item"><a href="'.BASE_URL."admin/".$val["page"].'" class="_tmenuitem_lv1_btn">'.$val['label'].'</a>';
							$aSubMenu = $this->selectRow("tb_submenu",""," menu_idx = ".$val["idx"])->execute();
							$aSubmenu = json_decode($aSubMenu['submenu'],true);

							if(is_array($aSubmenu)){

								#level 2 ul
								$sReturn .= '<ul class="_tmenuarea_lv2"  >';

								 foreach($aSubmenu as $key2=>$val2){

								 /*remove grade management if not admin*/
									if(USER_GRADE != 9 && $val2['label'] == "Grade Management"){
										$sReturn .= '';
									}else if(USER_GRADE != 9 && ($val2['label'] == "Category Management" || $val2['label'] == "Movie Category")){
										$sReturn .= '';
									}else{
										// #submenu 1
										 $sReturn .= '<li><a href="'.BASE_URL.'admin/'.$val['page'].'?action='.$val2["page"].'">'.$val2['label'].'</a>';

										 $sReturn .= '</li>';
									}
								 }
								$sReturn .= '</ul>';
							}
						$sReturn .= '</li>';
					}
				$sReturn .= '</ul>';
			}

			$sReturn .= '</div></div></div></div>';

			/*side menu*/
			if($bSideMenu == true){
				$sMenuTitlte = $sCurPage[2];

				$aSubMenu = common::search_arr($aMenu,$sMenuTitlte);
				$aSubMenu = $this->selectRow("tb_submenu",""," menu_idx = ".$aSubMenu[0]["idx"])->execute();
				$aSubMenu = json_decode($aSubMenu['submenu'],true);

				$sAction = isset($GLOBALS['aArgs']['action'])?$GLOBALS['aArgs']['action']:'';
				$sReturn .= '<input type="hidden" id="menu_action" value="'.$sAction.'" />';
				$sReturn .= '<div id="container">';
				$sReturn .= '<div class="container_wrap">';
				$sReturn .= '<div id="side_opener" class="side_opener" style="display: block;">';
				$sReturn .= '<img src="'.BASE_URL.'images/side_handler.gif" alt="Side Handler" />';
				$sReturn .= '</div>';
				$sReturn .= '<div id="side_closer" class="side_opener2" style="display: none;">';
				$sReturn .= '<img src="'.BASE_URL.'images/side_handler2.gif" alt="Side Handler 2" />';
				$sReturn .= '</div>';
				$sReturn .= '<div class="aside">';

				$sReturn .= '<div class="title">'.$sMenuTitlte.'</div>';
				$sReturn .= '<ul class="side_menu">';

				if(is_array($aSubMenu)){

					foreach($aSubMenu as $key=>$val){

						/*remove grade management if not id*/
						if(USER_GRADE != 9 && $val['label'] == "Grade Management"){
							$sReturn .= '';
						}else{
							$sReturn .= '<li class="lv_1 '.$val["page"].'">';
							$sReturn .= '<a  title="'.$val["label"].'" href="'.BASE_URL.'admin/'.$sMenuTitlte.'?action='.$val["page"].'">'.$val["label"].'</a>';
							$sReturn .= '</li>';
						}

					}
				}

			/*breadcrumbs*/
			$sReturn .= '</ul>';
			$sReturn .= '</div>';
			$sReturn .= '<div class="wrap">';
			$sReturn .= '<ul class="breadcrumb">';

			if(is_array($aSubMenu)){
				$sReturn .= '<li><a href="'.BASE_URL.'admin/'.$sMenuTitlte.'">'.ucwords($sMenuTitlte).'</a></li>';
				$sReturn .= '<li class="menu_curpage_breadcrumb" >'.ucwords($sAction).'</li>';
				$sReturn .= '</ul>';
				$sReturn .= '<div class="top">';
				$sReturn .= '<h3 class="title menu_title_breadcrumb"></h3>';

			}else{
				$sReturn .= '<li><a href="'.BASE_URL.'admin/'.$sMenuTitlte.'">'.ucwords($sMenuTitlte).'</a></li>';
				$sReturn .= '</ul>';
				$sReturn .= '<div class="top">';
				$sReturn .= '<h3 class="title">'.ucwords($sMenuTitlte).'</h3>';
			}

			/*most button*/
			if($aMostButton){
			$sReturn .= '<a href="javascript:'.$aMostButton['most_action'].'();" class="new_post">'.$aMostButton['label'].'</a>';
			}

			$sReturn .= '</div>';

			}

			$sReturn .= '<div id="message_wrap_con">';

			if(isset($_SESSION['sMessageType']) && $_SESSION['sMessageType'] != '' && $_SESSION['sMessageType'] == 'success')
			{
				$sReturn .= '
				<div id="message_con" class="ui-widget" style="margin-bottom:20px;">
					<div class="ui-state-highlight ui-corner-all" style="padding: 7px;text-align:center;">
						<p style="display:inline-block;"><span class="ui-icon ui-icon-info" style="float: left;margin-right:5px;"></span>
						' . $_SESSION['sMessage'] . '</p>
					</div>
				</div>' . PHP_EOL;
			}

			if(isset($_SESSION['sMessageType']) && $_SESSION['sMessageType'] != '' && $_SESSION['sMessageType'] == 'warning')
			{
				$sReturn .= '
				<div id="message_con" class="ui-widget" style="margin-bottom:20px;">
					<div class="ui-state-error ui-corner-all" style="padding: 7px;text-align:center;">
						<p style="display:inline-block;"><span class="ui-icon ui-icon-alert" style="float: left;margin-right:5px;"></span>
						' . $_SESSION['sMessage'] . '</p>
					</div>
				</div>' . PHP_EOL;
			}

			$sReturn .= '</div>';

			$_SESSION['sMessageType'] = '';
			$_SESSION['sMessage'] = '';
			
			
			return $sReturn;
	}

	public function urlInclude($sParam,$sRemoveParam = null)
    {
        $href = preg_match('/'.$sParam.'=[^?&]*/', $_SERVER["REQUEST_URI"]) ? preg_replace('/[?&]'.$sParam.'=[^?&]*/', '', $_SERVER["REQUEST_URI"]) : $_SERVER["REQUEST_URI"];
        $sConnector = preg_match('/\?/', $_SERVER["REQUEST_URI"]) ? '&' : '?';
        $href = $href . $sConnector . $sParam . '=';
        $href = preg_replace('/\/\&/', '/?', $href);
        $href = preg_replace('/[?&]page=[1-9][^&]*/', '', $href);
        echo $href;
    }
	
	public function getClassUrl($sClass)
	{
		$sUri = str_replace(BASE_URL, "", "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		$sUrl = preg_replace('/\?(.*)/', '', BASE_URL . $sUri);
		return $sUrl . "?action=" . $sClass;
	}

	public function paginate($iCurrentPage, $iRowsPerPage, $iTotalRows){
		if ($iTotalRows == 0 || $iTotalRows == false)
			return false;

		$sPageURL = $_SERVER['REQUEST_URI'];
		$iTotalPages = ceil($iTotalRows / $iRowsPerPage);
		$sConnector = preg_match('/\?/', $sPageURL) ? '&' : '?';
		$sPages = '<div class="bottom_2">' . PHP_EOL;
		$sPages .= '<div class="pagination">' . PHP_EOL;
		$sPages .= '<ul>' . PHP_EOL;
		$bef = $iCurrentPage - 2;
		$aft = $iCurrentPage + 2;

		$sPaginateURL = preg_match('/page=.[0-9]*/', $sPageURL) ? preg_replace('/page=[1-9][^&]*/', 'page='.($iCurrentPage-1), $sPageURL) : $sPageURL.$sConnector.'page='.($iCurrentPage-1);
		$sPages .= ($iCurrentPage > 1 ? '<li><a class="next" href="'.$sPaginateURL.'">prev</a></li>' : '<li class="disable"><span>prev</span></li>') . PHP_EOL;

		if(1 < $bef){
			$sPaginateURL = preg_match('/page=.[0-9]*/', $sPageURL) ? preg_replace('/page=[1-9][^&]*/', 'page=1', $sPageURL) : $sPageURL.$sConnector.'page=1';
			$sPages .= '<li><a class="num" href="'.$sPaginateURL.'">1</a></li>' . PHP_EOL;
			if(2 < $bef){
				$sPages .= '<li><span>...</span></li>' . PHP_EOL;
			}
		}

		for($iPage = 1; $iPage <= $iTotalPages; $iPage++){
			if($iPage == $iCurrentPage){
				$sPages .= '<li><a class="current" href="javascript: void(0);">'.$iPage.'</a></li>' . PHP_EOL;
			}
			else{
				$sPaginateURL = preg_match('/page=.[0-9]*/', $sPageURL) ? preg_replace('/page=[1-9][^&]*/', 'page='.$iPage, $sPageURL) : $sPageURL.$sConnector.'page='.$iPage;
				if($iPage >= $bef && $iPage <= $aft)
					$sPages .= '<li><a class="num" href="'.$sPaginateURL.'">'.$iPage.'</a></li>' . PHP_EOL;
			}
		}
		$lim = $iTotalPages - 1;
		if($iTotalPages > $aft){
			if($lim > $aft){
				$sPages .= '<li><span>...</span></li>' . PHP_EOL;
			}
			$sPaginateURL = preg_match('/page=.[0-9]*/', $sPageURL) ? preg_replace('/page=[1-9][^&]*/', 'page='.$iTotalPages, $sPageURL) : $sPageURL.$sConnector.'page='.$iTotalPages;
			$sPages .= '<li><a class="num" href="'.$sPaginateURL.'">'.$iTotalPages.'</a></li>' . PHP_EOL;
		}

		$sPaginateURL = preg_match('/page=.[0-9]*/', $sPageURL) ? preg_replace('/page=[1-9][^&]*/', 'page='.($iCurrentPage+1), $sPageURL) : $sPageURL.$sConnector.'page='.($iCurrentPage+1);
		$sPages .= ($iCurrentPage < $iTotalPages ? '<li><a class="next" href="'.$sPaginateURL.'">next</a></li>' : '<li class="disable"><span>next</span></li>'). PHP_EOL;

		$sPages .= '</ul>' . PHP_EOL;
		$sPages .= '</div>' . PHP_EOL;
		$sPages .= '</div>' . PHP_EOL;

		return $sPages;
	}
}

?>