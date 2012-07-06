<?php
class adminPageSettings extends Controller_Admin
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);

        $sFormScript = usbuilder()->getFormAction('googlemaproute_form', 'adminExecSettings');
        $this->writeJs($sFormScript);

        $oModelSettings = new modelSettings();
        $iCount = $oModelSettings->getCheckSettings();
        $sAction = $iCount == 0 ? "New" : "Update";

        usbuilder()->validator(array('form' => 'googlemaproute_form'));

        if($sAction == "New"){
            $sCenter = "";
            $sMapSize = "640x480";
            $iMapCustWidth = "";
            $iMapCustHeight = "";
            $iMapZoom = 8;
            $iMapType = 0;
            $iZoomSize = NULL;
            $iZoomPos = NULL;
            $iMapTypeCtrl = NULL;
            $iMapTypeCtrlPos = NULL;
            $iScaleCtrlPos = NULL;
            $iStreetviewCtrlPos = NULL;
            $sCaption = NULL;
            $sCoordinates = NULL;
            $aRoute = NULL;
        }
        else{
            $aSetting = $oModelSettings->getSettings();

			$sCenter = $aSetting[0]['center'];
			$sCoordinates = $aSetting[0]['coordinates'];
			$sMapSize = $aSetting[0]['size'];
			$iMapZoom = $aSetting[0]['zoom'];
			$iMapType = $aSetting[0]['map_type'];
			$sCaption = $aSetting[0]['caption'];
			$iZoomSize = $aSetting[0]['zoomcontrol_size'];
			$iZoomPos = $aSetting[0]['zoomcontrol_position'];
			$iMapTypeCtrl = $aSetting[0]['maptypecontrol_type'];
			$iMapTypeCtrlPos = $aSetting[0]['maptypecontrol_position'];
			$iScaleCtrlPos = $aSetting[0]['scale_position'];
			$iStreetviewCtrlPos = $aSetting[0]['streetview_position'];

			if($sMapSize != "300x300" && $sMapSize != "425x350" && $sMapSize != "640x480") {
				$aMapSize = explode('x', $sMapSize);
				$iMapCustWidth = $aMapSize[0];
				$iMapCustHeight = $aMapSize[1];
			} else {
				$iMapCustWidth = "";
				$iMapCustHeight = "";
			}

			$aRoutes = $oModelSettings->getRoutes();
            $aRoute = array();
			foreach($aRoutes as $route) {
				$aRoute[] = array(
					'route' => $route['route']
				);
			}
        }

        $this->assign('sCenter', $sCenter);
        $this->assign('sMapSize', $sMapSize);
        $this->assign('iMapCustWidth', $iMapCustWidth);
        $this->assign('iMapCustHeight', $iMapCustHeight);
        $this->assign('iMapZoom', $iMapZoom);
        $this->assign('iMapType', $iMapType);
        $this->assign('iZoomSize', $iZoomSize);
        $this->assign('iZoomPos', $iZoomPos);
        $this->assign('iMapTypeCtrl', $iMapTypeCtrl);
        $this->assign('iMapTypeCtrlPos', $iMapTypeCtrlPos);
        $this->assign('iScaleCtrlPos', $iScaleCtrlPos);
        $this->assign('iStreetviewCtrlPos', $iStreetviewCtrlPos);
        $this->assign('sCaption', $sCaption);
        $this->assign('sCoordinates', $sCoordinates);
        $this->assign('aRoute', $aRoute);
        $this->assign('sAction', $sAction);

    	//$this->importJS('popup');
    	$this->importJS('GooglemaproutesSettings');
    	$this->externalJS('https://maps.googleapis.com/maps/api/js?v=3&sensor=true');
    	$this->importCSS('gmaproutescommon');
    	$this->importCSS('plugin');

    	$this->view(__CLASS__);
    }
}
?>