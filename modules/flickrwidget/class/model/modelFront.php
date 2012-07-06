<?php
class frontModelFlickrwidget extends Model
{
    function getRowCount($aOption)
    {
        $sQuery = "SELECT count(*) FROM Flickrwidget_settings";
        $mResult = $this->query($sQuery);

        return $mResult[0]['count(*)'];
    }

    function getSettings($aOption)
    {
		$sQuery = "SELECT * FROM Flickrwidget_settings";
		$mResult = $this->query($sQuery);

		return $mResult;
    }

    function setInsertSettings($aOption)
    {
        $sQuery = "INSERT INTO Flickrwidget_settings(idx, api_key, userid, display_type, display_target, display_num, template)
                                               values('".$aOption['idx']."'
                                                     ,'".$aOption['flickr_key']."'
                                                     ,'".$aOption['flickr_id']."'
                                                     ,'".$aOption['flickr_disp_type']."'
                                                     ,'".$aOption['flickr_target']."'
                                                     ,'".$aOption['flickr_photo_num']."'
                                                     ,'".$aOption['flickr_template']."')";

        $mResult = $this->query($sQuery);

        return $sQuery;
    }

    function setUpdateSettings($aOption)
    {
        $sQuery = "UPDATE Flickrwidget_settings set pm_idx = '".$aOption['idx']."'
                                            , api_key = '".$aOption['flickr_key']."'
                                            , userid = '".$aOption['flickr_id']."'
                                            , display_type = '".$aOption['flickr_disp_type']."'
                                            , display_target = '".$aOption['flickr_target']."'
                                            , display_num = '".$aOption['flickr_photo_num']."'
                                            , template = '".$aOption['flickr_template']."'";

        $mResult = $this->query($sQuery);

        return $sQuery;
    }
}