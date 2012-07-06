<?php
class adminExecSettings extends Controller_AdminExec
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);

        $aOption['idx'] = $aArgs['idx'];
        $aOption['flickr_key'] = $aArgs['flickr_key'];
        $aOption['flickr_id'] = $aArgs['flickr_id'];
        $aOption['flickr_template'] = $aArgs['flickr_template'];
        $aOption['flickr_target'] = $aArgs['flickr_target'];
        $aOption['flickr_disp_type'] = $aArgs['flickr_disp_type'];
        $aOption['flickr_photo_num'] =  $aArgs['flickr_disp_type'] == "0" ? $aArgs['flickr_photo_num'] : 6;

        $oModelSettings = new modelSettings();
        $iCount = $oModelSettings->getRowCount($aOption);
        $bResult = $iCount > 0 ? $oModelSettings->setUpdateSettings($aOption) : $oModelSettings->setInsertSettings($aOption);

        if ($bResult !== false) {
            usbuilder()->message('Settings has been Updated', 'success');
        } else {
            usbuilder()->message('Updating failed', 'warning');
        }

        $sUrl = usbuilder()->getUrl('adminPageSettings');
        $sJsMove = usbuilder()->jsMove($sUrl);
        $this->writeJS($sJsMove);
    }
}
?>