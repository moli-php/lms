<?php
class adminExecSettings extends Controller_AdminExec
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        usbuilder()->init($this, $aArgs);
        $aOption['title'] = $aArgs['title'];

        $bResult = common()->modelSettings()->setTitle($aOption);

        if ($bResult !== false) {
            usbuilder()->message('Update Successful', 'success');
        } else {
            usbuilder()->message('Update failed', 'warning');
        }

        $sUrl = usbuilder()->getUrl('adminPageSettings');
        usbuilder()->jsMove($aArgs['return_url']);
    }
}
?>