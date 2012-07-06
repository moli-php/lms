<?php
class adminPagePollResult extends Controller_Admin
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
        $iReplierCount = $oModelPollAdmin->getPollReplierCount($aOption);
        $sSettings = $oModelPollAdmin->getSettings();
        $aColors = array( "#fd93b5", "#c1aace", "#ff9c9b", "#9fdcf3", "#197487", "#f63785", "#4f8606", "#5f99e8", "#b659c6", "#5dd649", "#767676", "#73d3cc", "#aece61", "#ef3229", "#ffbc4a", "#b2b2b2", "#847152", "#3891b7", "#00a6ac", "#da8972");
        foreach($aForm as $key => $field){
            $aOption['qidx'] = $field['idx'];
            $aForm[$key]['choices'] = $oModelPollAdmin->getPollChoices($aOption);

            foreach($aForm[$key]['choices'] as $index => $value){
                $aOption['choice'] = $value['choice'];
                $aOption['choice_count'] = count($aForm[$key]['choices']);
                if($field['choice_type'] != 2){
                    $aForm[$key]['choices'][$index]['replier'] = $oModelPollAdmin->getPollChoiceReplier($aOption);
                    $aForm[$key]['choices'][$index]['opinions'] = $oModelPollAdmin->getPollOpinion($aOption);
                }
                else
                    $aForm[$key]['choices'][$index]['replier'] = $oModelPollAdmin->getPollChoiceRanks($aOption);

                if($field['choice_type'] == 3)
                    $aForm[$key]['desc'] = $oModelPollAdmin->getPollDesc($aOption);
            }
        }

        $sUrl = usbuilder()->getUrl('adminPagePollList');

        $this->assign('sUrl', $sUrl);
        $this->assign('aData', $aData);
        $this->assign('aForm', $aForm);
        $this->assign('iQuestionCount', $iQuestionCount);
        $this->assign('iReplierCount', $iReplierCount);
        $this->assign('aColors', $aColors);
        $this->assign('sSettings', $sSettings);

        $this->importCSS('jqueryCalendar');
        $this->importJS('jqueryCalendar');
    	$this->importJS(__CLASS__);
    	$this->importCSS('common');
    	$this->importCSS('style');

    	$this->view(__CLASS__);
    }
}
?>