<?php
class adminPagePollEdit extends Controller_Admin
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);

        $sFormScript = usbuilder()->getFormAction('pollwidget_edit', 'adminExecPollEdit');
        $this->writeJs($sFormScript);
        usbuilder()->validator(array('form' => 'pollwidget_edit'));

        $aOption['idx'] = $aArgs['idx'];

        $oModelPollAdmin = new modelPollAdmin();
        $aData = $oModelPollAdmin->getPollData($aOption);
        $aForm = $oModelPollAdmin->getPollQuestions($aOption);
        $iQuestionCount = $oModelPollAdmin->getPollQuestionCount($aOption);

        foreach($aForm as $key => $field){
            $aOption['qidx'] = $field['idx'];
            $aForm[$key]['choices'] = $oModelPollAdmin->getPollChoices($aOption);
        }

        $sUrl = usbuilder()->getUrl('adminPagePollList');

        $this->assign('sUrl', $sUrl);
        $this->assign('aData', $aData);
        $this->assign('aForm', $aForm);
        $this->assign('iQuestionCount', $iQuestionCount);

        $this->importCSS('jqueryCalendar');
        $this->importJS('jqueryCalendar');
    	$this->importJS(__CLASS__);
    	$this->importCSS('common');
    	$this->importCSS('style');

    	$this->view(__CLASS__);
    }
}
?>