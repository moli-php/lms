<?php
class adminPagePollAdd extends Controller_Admin
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);

        $sFormScript = usbuilder()->getFormAction('pollwidget_add', 'adminExecPollAdd');
        $this->writeJs($sFormScript);
        usbuilder()->validator(array('form' => 'pollwidget_add'));

        $sUrl = usbuilder()->getUrl('adminPagePollList');

        $this->assign('sUrl', $sUrl);


        $this->importCSS('jqueryCalendar');
        $this->importJS('jqueryCalendar');
    	$this->importJS(__CLASS__);
    	$this->importCSS('common');
    	$this->importCSS('style');

    	$this->view(__CLASS__);
    }
}
