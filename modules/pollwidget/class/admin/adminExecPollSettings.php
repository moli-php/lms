<?php
class adminExecPollSettings extends Controller_AdminExec
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);

        $aOption['graph'] = $aArgs['graph'];

        $oModelPollAdmin = new modelPollAdmin();
        $bResult = $oModelPollAdmin->setEditSettings($aOption);

        if ($bResult !== false) {
            usbuilder()->message($aOption['question_1_content'], 'success');
        } else {
            usbuilder()->message('Update failed', 'warning');
        }

        $sUrl = usbuilder()->getUrl('adminPagePollList');
        $sJsMove = usbuilder()->jsMove($sUrl);
        $this->writeJS($sJsMove);

    }
}
?>