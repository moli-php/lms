<?php
class apiPollwidget extends Controller_Api
{
    protected function post($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);

        $oModelPollAdmin = new modelPollAdmin();
        $aOnGoingPoll = $oModelPollAdmin->getOnGoingPoll($aOption);
        $aOption['idx'] = $aOnGoingPoll[0]['idx'];
        $iQuestionCount = $oModelPollAdmin->getPollQuestionCount($aOption);
        $userVerify = $oModelPollAdmin->verifyPollUser($aOption);

        $oModelPollAdmin = new modelPollAdmin();
        $aForm = $oModelPollAdmin->getPollQuestions($aOption);
        $iQuestionCount = $oModelPollAdmin->getPollQuestionCount($aOption);

        $aPollData = array();
        $aPollData['Question_Count'] = $iQuestionCount;
        $aPollData['PID'] = $aOption['idx'];
        foreach($aForm as $key => $field){
            $aOption['qidx'] = $field['idx'];

            $aPollData['ID_'.$key] = $field['idx'];
            $aPollData['Number_'.$key] = $key+1;
            $aPollData['Question_'.$key] = $field['question'];
            $aPollData['Choice_type_'.$key] = $field['choice_type'];
            $aPollData['Limit_'.$key] = $field['limits'];
            $aPollData['Choices_'.$key] = $oModelPollAdmin->getPollChoices($aOption);
            $aPollData['Number_of_Choices_'.$key] = count($oModelPollAdmin->getPollChoices($aOption));
        }

        if($aOption['idx']){
            if($userVerify > 0)
                $aPollData['status'] = 'Done';
            else
                $aPollData['status'] = 'OnGoing';
        }
        else
            $aPollData['status'] = 'NoPoll';

        return $aPollData;
    }
}
?>