<?php
class adminPageSettings extends Controller_Admin
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        usbuilder()->init($this, $aArgs);

        usbuilder()->getFormAction('bookmark_title', 'adminExecSettings');

        $this->assign("returnUrl", common()->getFullUrl());
        $this->assign("sTitle", common()->modelSettings()->getTitle());
        $this->assign("bExtensionView", ($aArgs['etype'] ? 1 : 0));
    	$this->view(__CLASS__);
    }
}
?>