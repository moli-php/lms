<?php
class apiAddBookmark extends Controller_Api
{
    protected function post($aArgs)
    {
        $aOption['url'] = $aArgs['url'];
        $aOption['name'] = strtolower($aArgs['name']);
        $aOption['title'] = str_replace("www.", "", parse_url($aOption['url'], PHP_URL_HOST));
        $aDomain = explode(".", $aOption['title']);
        $aOption['title'] = strtolower($aDomain[0]);
        $aOption['ip'] = $_SERVER['REMOTE_ADDR'];
        $bResult = common()->modelSettings()->addBookmark($aOption);

        return $bResult;
    }
}
?>