<?php
class apiPollCheckOverlap extends Controller_Api
{
    protected function post($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);

        $aOption['start'] = $aArgs['start'];
        $aOption['end'] = $aArgs['end'];
        $oModelPollAdmin = new modelPollAdmin();
        $bResult = $oModelPollAdmin->getPollOverlap($aOption);

        return $bResult;
    }
}
?>