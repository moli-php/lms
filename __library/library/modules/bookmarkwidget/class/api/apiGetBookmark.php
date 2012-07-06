<?php
class apiGetBookmark extends Controller_Api
{
    public function post($aArgs)
    {
        $aOption['ip'] = $_SERVER['REMOTE_ADDR'];
        $aBookmarks = common()->modelSettings()->getBookmarks($aOption);

        return $aBookmarks;
    }
}
?>