<?php
class adminExecPollAdd extends Controller_AdminExec
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);

        //Poll
        $aOption['title'] = $aArgs['title'];
        $aOption['start'] = $aArgs['start'];
        $aOption['end'] = $aArgs['end'];
        $aOption['regdate'] = $aArgs['regdate'] = time();
        $aOption['autodelete'] = $aArgs['autodelete'];

        //Question
        $aOption['qnum'] = $aArgs['qnum'];
        foreach($aArgs['qnum'] as $key => $val){
            $aOption['question_'.$val.'_content'] = $aArgs['question_content'][$key];
            $aOption[$val.'_choice'] = $aArgs[$val.'_choice'];
            $aOption['choice_opinion_'.$val] = $aArgs['choice_opinion_'.$val];
            $aOption['desc_max_input_'.$val] = $aArgs['desc_max_input_'.$val];
            $aOption['quest_reqd_'.$val] = $aArgs['quest_reqd_'.$val];
            $aOption['question_choice_type_'.$val] = $aArgs['question_choice_type_'.$val];
        }

        //Choices
        foreach($aArgs['qnum'] as $key => $val){
            $ops = explode(',', $aArgs['choice_opinion_'.$val]);
            foreach($aOption[$val.'_choice'] as $index => $choice){
                $aOption[$val.'_choice_'.$index] = $choice;
                $aOption['choice_opinion_'.$val.'_'.$index] = $ops[$index];
            }
        }

        $oModelPollAdmin = new modelPollAdmin();
        $bResult = $oModelPollAdmin->setAddPoll($aOption);

        if ($bResult !== false) {
            usbuilder()->message('Poll has been Added Successfully', 'success');
        } else {
            usbuilder()->message('Add failed', 'warning');
        }

        $sUrl = usbuilder()->getUrl('adminPagePollList');
        $sJsMove = usbuilder()->jsMove($sUrl);
        $this->writeJS($sJsMove);

    }
}
?>