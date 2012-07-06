<?php
class apiPollDelete extends Controller_Api
{
    protected function post($aArgs)
    {
        require_once('builder/builderInterface.php');
        usbuilder()->init($this->Request->getAppID(), $aArgs);

        $aOption['idx'] = explode(',',$aArgs['adminPagePollid']);
        $oModelPollAdmin = new modelPollAdmin();
        $bResult = $oModelPollAdmin->setDeletePoll($aOption);

        if ($bResult !== false) {
            $sResult = 'true';
        } else {
            $sResult = 'false';
        }

        echo $sResult;
    }
}
?>