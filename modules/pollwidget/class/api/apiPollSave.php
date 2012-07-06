<?php
class apiPollSave extends Controller_Api
{
    protected function post($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);

        $aOption['Question_Count'] = $aArgs['answers'][0]['q_count'];
        $aOption['Poll'] = $aArgs['answers'][0]['poll'];
        $aOption['IP'] = $_SERVER['REMOTE_ADDR'];
        for($i = 1; $i <= $aOption['Question_Count']; $i++){
            $aOption[$i]['q_id'] = $aArgs['answers'][$i]['q_id'];
            $aOption[$i]['q_answer'] = $aArgs['answers'][$i]['q_answer'];
            $aOption[$i]['c_type'] = $aArgs['answers'][$i]['c_type'];
            $aOption[$i]['c_opinion'] = $aArgs['answers'][$i]['c_opinion'];
        }

        $oModelPollAdmin = new modelPollAdmin();
        $aData = $oModelPollAdmin->setPollAnswers($aOption);

        return $aData;
    }
}
?>