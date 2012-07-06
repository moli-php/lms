<?php
class frontModelGooglemaproutes extends Model
{
    function getSettings()
    {
		$sQuery = "SELECT * FROM Googlemaproutes_settings";
		$mResult = $this->query($sQuery);

		return $mResult;
    }

    function getCheckSettings()
    {
        $sQuery = "SELECT Count(*) as first FROM Googlemaproutes_settings";
        $mResult = $this->query($sQuery);

        return $mResult[0]['first'];
    }

    function setSaveSettings($aOption)
    {
        $sQuery = "INSERT INTO Googlemaproutes_settings(center, coordinates, size, zoom, map_type, caption, zoomcontrol_size, zoomcontrol_position, maptypecontrol_type, maptypecontrol_position, scale_position, streetview_position)
                                               values('".$aOption['center']."'
                                                     ,'".$aOption['coordinates']."'
                                                     ,'".$aOption['size']."'
                                                     ,'".$aOption['zoom']."'
                                                     ,'".$aOption['map_type']."'
                                                     ,'".$aOption['caption']."'
                                                     ,'".$aOption['zoomcontrol_size']."'
                                                     ,'".$aOption['zoomcontrol_position']."'
                                                     ,'".$aOption['maptypecontrol_type']."'
                                                     ,'".$aOption['maptypecontrol_position']."'
                                                     ,'".$aOption['scale_position']."'
                                                     ,'".$aOption['streetview_position']."')";

        $mResult = $this->query($sQuery);

        return $sQuery;
    }

    function setUpdateSettings($aOption)
    {
        $sQuery = "UPDATE Googlemaproutes_settings set center = '".$aOption['center']."'
                                            , coordinates = '".$aOption['coordinates']."'
                                            , size = '".$aOption['size']."'
                                            , zoom = '".$aOption['zoom']."'
                                            , map_type = '".$aOption['map_type']."'
                                            , caption = '".$aOption['caption']."'
                                            , zoomcontrol_size = '".$aOption['zoomcontrol_size']."'
                                            , zoomcontrol_position = '".$aOption['zoomcontrol_position']."'
                                            , maptypecontrol_type = '".$aOption['maptypecontrol_type']."'
                                            , maptypecontrol_position = '".$aOption['maptypecontrol_position']."'
                                            , scale_position = '".$aOption['scale_position']."'
                                            , streetview_position = '".$aOption['streetview_position']."'";

        $mResult = $this->query($sQuery);

        return $sQuery;
    }

    function getRoutes()
    {
        $sQuery = "SELECT * FROM Googlemaproutes_routes";
        $mResult = $this->query($sQuery);

        return $mResult;
    }

    function setSaveRoutes($aRoutes)
    {
        foreach($aRoutes as $key => $val){
            $sQuery = "Insert into Googlemaproutes_routes values('".$val['route']."')";
            $mResult = $this->query($sQuery);
        }

        return $mResult;
    }

    function setDeleteRoutes()
    {
        $sQuery = "Delete from Googlemaproutes_routes";
        $mResult = $this->query($sQuery);

        return $mResult;
    }
}