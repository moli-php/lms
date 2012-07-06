<?php
class adminPageSettings extends Controller_Admin
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);

        $sFormScript = usbuilder()->getFormAction('flickr_setup_form', 'adminExecSettings');
        $this->writeJs($sFormScript);

        usbuilder()->validator(array('form' => 'flickr_setup_form'));

        $oModelSettings = new modelSettings();
        $aResult = $oModelSettings->getSettings($aOption);

        $sApiKey = $aResult[0]['api_key'] ? $aResult[0]['api_key'] : '';
        $sUserID = $aResult[0]['userid'] ? $aResult[0]['userid'] : '';
        $sDispType = $aResult[0]['display_type'] ? $aResult[0]['display_type'] : 0;
        $sDispTarget = $aResult[0]['display_target'] ? $aResult[0]['display_target'] : 0;
        $sDispNum = $aResult[0]['display_num'] ? $aResult[0]['display_num'] : 6;
        $sTemplate = $aResult[0]['template'] ? $aResult[0]['template'] : 0;

        $this->assign('sApiKey', $sApiKey);
        $this->assign('sUserID', $sUserID);
        $this->assign('sDispType', $sDispType);
        $this->assign('sDispTarget', $sDispTarget);
        $this->assign('sDispNum', $sDispNum);
        $this->assign('sTemplate', $sTemplate);

    	$this->importJS(__CLASS__);
    	$this->importJS('setup');

    	$this->importJS(__CLASS__);
    	$this->importCSS('flickr_common');

    	$this->view(__CLASS__);
    }
}
?>