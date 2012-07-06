<?php
class apiDelBookmark extends Controller_Api
{
    protected function post($aArgs)
    {
        $aOption['idx'] = $aArgs['idx'];
        $aBookmarks = common()->modelSettings()->delBookmark($aOption);

        return json_encode($aArgs);
    }
}
?>