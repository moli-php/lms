<?php
class frontPageGooglemaproutes extends Controller_Front
{
    protected function run($aArgs)
    {
        $this->importJS('index');
        $this->importJS('default');
        $this->externalJS('https://maps.googleapis.com/maps/api/js?v=3&sensor=true');

        $aSetting = common()->modelFront()->getSettings();

        $sCenter = $aSetting[0]['center'];
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
        $aRoutes = common()->modelFront()->getRoutes();
        $aRoute = array();
        foreach($aRoutes as $route) {
            $aRoute[] = $route['route'];
        }
        $sRoute = implode('|', $aRoute);

        $sHtml = '
        <div id="googlemaproute_canvas" style="width:100%; height:100%;"></div>
        <div id="googlemaproute_caption_cont"><div id="googlemaproute_text" style="text-align:center;"></div></div>
        <div id="directions_panel" style="background-color:#FFEE77;"></div>
        <input type="hidden" id="pg_googlemaproute_center" value="'.$sCenter.'" />
        <input type="hidden" id="pg_googlemaproute_size" value="'.$sMapSize.'" />
        <input type="hidden" id="pg_googlemaproute_zoom" value="'.$iMapZoom.'" />
        <input type="hidden" id="pg_googlemaproute_type" value="'.$iMapType.'" />
        <input type="hidden" id="pg_googlemaproute_zoomsize" value="'.$iZoomSize.'" />
        <input type="hidden" id="pg_googlemaproute_zoompos" value="'.$iZoomPos.'" />
        <input type="hidden" id="pg_googlemaproute_typectrl" value="'.$iMapTypeCtrl.'" />
        <input type="hidden" id="pg_googlemaproute_typectrlpos" value="'.$iMapTypeCtrlPos.'" />
        <input type="hidden" id="pg_googlemaproute_scalectrlpos" value="'.$iScaleCtrlPos.'" />
        <input type="hidden" id="pg_googlemaproute_strtviewctrlpos" value="'.$iStreetviewCtrlPos.'" />
        <input type="hidden" id="pg_googlemaproute_route" value="'.$sRoute.'" />
        <input type="hidden" id="pg_googlemaproute_caption" value="'.$sCaption.'" />';

        $this->assign('google_map_routes', $sHtml);
    }
}