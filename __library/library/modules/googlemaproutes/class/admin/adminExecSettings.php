<?php
class adminExecSettings extends Controller_AdminExec
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);

        $sCenter = $aArgs['pg_googlemaproute_center'];
        $sMapSize = $aArgs['map_size'];
        $iMapCustWidth = $aArgs['map_custom_width'];
        $iMapCustHeight = $aArgs['map_custom_height'];
        $iMapZoom = $aArgs['map_zoom'];
        $iMapType = $aArgs['google_map_type'];
        $fZoomCtrl = $aArgs['zoom_control'];
        $iZoomSize = $aArgs['zoom_size'];
        $iZoomPos = $aArgs['zoom_position'];
        $fMapTypeCtrl = $aArgs['map_type_control'];
        $iMapTypeCtrl = $aArgs['map_type'];
        $iMapTypeCtrlPos = $aArgs['map_type_position'];
        $fScaleCtrl = $aArgs['scale_control'];
        $iScaleCtrlPos = $aArgs['scale_control_position'];
        $fStreetviewCtrl = $aArgs['street_view_control'];
        $iStreetviewCtrlPos = $aArgs['street_view_position'];
        $sCaption = $aArgs['pg_googlemaproute_caption'];
        $sCoordinates = $aArgs['pg_m_coords'];
        $aRouteLoc = $aArgs['pg_route_location'];

        $sMapSize = $sMapSize == "custom" ? $iMapCustWidth . "x" . $iMapCustHeight : $sMapSize;

        if($fZoomCtrl == "") {
            $iZoomSize = NULL;
            $iZoomPos = NULL;
        }

        if($fMapTypeCtrl == "") {
            $iMapTypeCtrl = NULL;
            $iMapTypeCtrlPos = NULL;
        }

        if($fScaleCtrl == "") $iScaleCtrlPos = NULL;
        if($fStreetviewCtrl == "") $iStreetviewCtrlPos = NULL;

        $aOption = array(
                'center' => $sCenter,
                'coordinates' => $sCoordinates,
                'size' => $sMapSize,
                'zoom' => $iMapZoom,
                'map_type' => $iMapType,
                'caption' => $sCaption,
                'zoomcontrol_size' => $iZoomSize,
                'zoomcontrol_position' => $iZoomPos,
                'maptypecontrol_type' => $iMapTypeCtrl,
                'maptypecontrol_position' => $iMapTypeCtrlPos,
                'scale_position' => $iScaleCtrlPos,
                'streetview_position' => $iStreetviewCtrlPos,
        );

        $oModelSettings = new modelSettings();
        $iCount = $oModelSettings->getCheckSettings();
        $bResult = $iCount > 0 ? $oModelSettings->setUpdateSettings($aOption) : $oModelSettings->setSaveSettings($aOption);
        $sMessage = $iCount > 0 ? "Updated Successfully" : "Saved Successfully";

        if ($bResult !== false) {
            $oModelSettings->setDeleteRoutes();

            $aRoutes = array();
            foreach($aRouteLoc as $val) {
                $aRoutes[] = array(
                        'route' => $val
                );
            }

            $bResults = $oModelSettings->setSaveRoutes($aRoutes);
            usbuilder()->message($sMessage, 'success');
        } else {
            usbuilder()->message('Updating failed', 'warning');
        }

        $sUrl = usbuilder()->getUrl('adminPageSettings');
        $sJsMove = usbuilder()->jsMove($sUrl);
        $this->writeJS($sJsMove);

    }
}
?>