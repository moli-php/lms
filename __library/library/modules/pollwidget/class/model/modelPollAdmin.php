<?php
class modelPollAdmin extends Model
{
    function getPolls($aOption)
    {
		$sQuery = "SELECT * FROM Pollwidget_poll";

		if($aOption['search'] || $aOption['status'] || ($aOption['s'] && $aOption['e'])){
		    $sQuery .= " where ";
		    $and = 0;
		    if($aOption['status']){
		        if($aOption['status'] == "waiting")
		        $sQuery .= "period_start > '".date('Y-m-d')."'";
		        if($aOption['status'] == "ongoing")
		            $sQuery .= "period_start <= '".date('Y-m-d')."' and period_end >= '".date('Y-m-d')."'";
		        if($aOption['status'] == "done")
		            $sQuery .= "period_end < '".date('Y-m-d')."'";
		    }
		    if($aOption['search']){
		        $and += 1;
		        $sQuery .= "title like '%".$aOption['search']."%'";}
		    if($aOption['s'] && $aOption['e']){
		        if($and > 0)
		            $sQuery .= " and";
		        $sQuery .= " DATE_FORMAT(FROM_UNIXTIME(reg_date), '%Y-%m-%d' ) >= '".$aOption['s']."' and DATE_FORMAT(FROM_UNIXTIME(reg_date), '%Y-%m-%d' ) <= '".$aOption['e']."'";
		    }
		}

		if($aOption['sort'])
		    $sQuery .= " order by ".$aOption['sortby']." ".$aOption['sort'];

		if($aOption['row_limit'])
		    $sQuery .= " Limit ".$aOption['start'].", ".$aOption['row_limit'];

		$mResults = $this->query($sQuery);

        foreach($mResults as $key => $field){
            $sQuery = "Select count(*) as qstn_num from Pollwidget_question where pidx = '".$mResults[$key]['idx']."'";
            $mResult = $this->query($sQuery);
            $qstn_num = $mResult[0]['qstn_num'];

            $sQuery1 = "Select count(*) as rply_num from Pollwidget_user where pidx = '".$mResults[$key]['idx']."'";
            $mResult1 = $this->query($sQuery1);
            $rply_num = $mResult1[0]['rply_num'];

            if(date('Y-m-d') < $mResults[$key]['period_start'])
                $status = "Waiting";
            if(date('Y-m-d') >= $mResults[$key]['period_start'] && date('Y-m-d') <= $mResults[$key]['period_end'])
                $status = "OnGoing";
            if(date('Y-m-d') > $mResults[$key]['period_end'])
                $status = "Done";

            $mResults[$key]['qstn_num'] = $qstn_num;
            $mResults[$key]['rply_num'] = $rply_num;
            $mResults[$key]['status'] = $status;
        }

		return $mResults;
    }

    function getOnGoingPoll($aOption)
    {
        $sQuery = "SELECT * FROM Pollwidget_poll where period_start <= '".date('Y-m-d')."' and period_end >= '".date('Y-m-d')."'";
        $mResults = $this->query($sQuery);

        return $mResults;
    }

    function setEditSettings($aOption)
    {
        $sQuery = "Delete from Pollwidget_settings where idx = '0'";
        $mResults = $this->query($sQuery);

        $sQuery = "Insert into Pollwidget_settings values('','".$aOption['graph']."')";
        $mResults = $this->query($sQuery);

        return $mResults;
    }

    function getSettings()
    {
        $sQuery = "Select graph from Pollwidget_settings";
        $mResults = $this->query($sQuery);

        return $mResults[0]['graph'];
    }

    function getPollData($aOption)
    {
        $sQuery = "SELECT * FROM Pollwidget_poll where idx = '".$aOption['idx']."'";
        $mResults = $this->query($sQuery);

        return $mResults;
    }

    function getPollQuestions($aOption)
    {
        $sQuery = "SELECT * FROM Pollwidget_question where pidx = '".$aOption['idx']."' order by idx Asc";
        $mResults = $this->query($sQuery);

        return $mResults;
    }

    function getPollChoices($aOption)
    {
        $sQuery = "SELECT * FROM Pollwidget_choices where qidx = '".$aOption['qidx']."' order by idx Asc";
        $mResults = $this->query($sQuery);

        return $mResults;
    }

    function verifyPollUser($aOption)
    {
        $sQuery = "Select count(*) as count from Pollwidget_user where pidx = '".$aOption['idx']."' and ip = '".$_SERVER['REMOTE_ADDR']."'";
        $mResults = $this->query($sQuery);

        return $mResults[0]['count'];
    }

    function getPollChoiceReplier($aOption)
    {
        $sQuery = "SELECT count(*) as count FROM Pollwidget_answer where qidx = '".$aOption['qidx']."' and answer = '".$aOption['choice']."'";
        $mResults = $this->query($sQuery);

        return $mResults[0]['count'];
    }

    function getPollDesc($aOption)
    {
        $sQuery = "SELECT answer FROM Pollwidget_answer where qidx = '".$aOption['qidx']."' order by idx Desc limit 0, 20";
        $mResult = $this->query($sQuery);

        return $mResult;
    }

    function getPollDescFront($aOption)
    {
        $sQuery = "SELECT answer FROM Pollwidget_answer where qidx = '".$aOption['qidx']."' and opinion = '".$_SERVER['REMOTE_ADDR']."'";
        $mResult = $this->query($sQuery);

        return $mResult;
    }

    function getPollOpinion($aOption)
    {
        $sQuery = "SELECT opinion FROM Pollwidget_answer where qidx = '".$aOption['qidx']."' and answer = '".$aOption['choice']."' and opinion != '' order by idx Desc limit 0, 20";
        $mResult = $this->query($sQuery);

        return $mResult;
    }

    function getPollChoiceRanks($aOption)
    {
        $ranks = array();
        for($i = 1; $i <= $aOption['choice_count']; $i++){
            $sQuery = "SELECT count(*) as count FROM Pollwidget_answer where qidx = '".$aOption['qidx']."' and answer = '".$aOption['choice']."' and rank = '".$i."'";
            $mResults = $this->query($sQuery);
            $ranks[$i] = $mResults[0]['count'];
        }
        return $ranks;
    }

    function getPollOverlap($aOption)
    {
        $sQuery = "SELECT * FROM Pollwidget_poll where period_start <= '".$aOption['start']."' and period_end >= '".$aOption['end']."'";
        $mResults = $this->query($sQuery);

        $poll = $mResults[0]['title'];

        return $poll;
    }

    function getPollQuestionCount($aOption)
    {
        $sQuery = "SELECT count(*) as count FROM Pollwidget_question where pidx = '".$aOption['idx']."'";
        $mResults = $this->query($sQuery);

        return $mResults[0]['count'];
    }

    function getPollCount($aOption)
    {
		$sQuery = "SELECT Count(*) as count FROM Pollwidget_poll";

		if($aOption['search'] || $aOption['status']){
		    $sQuery .= " where ";
		    if($aOption['status']){
		        if($aOption['status'] == "waiting")
		        $sQuery .= "period_start > '".date('Y-m-d')."'";
		        if($aOption['status'] == "ongoing")
		            $sQuery .= "period_start <= '".date('Y-m-d')."' and period_end >= '".date('Y-m-d')."'";
		        if($aOption['status'] == "done")
		            $sQuery .= "period_end < '".date('Y-m-d')."'";
		    }
		    if($aOption['search']){
		        $sQuery .= "title like '%".$aOption['search']."%'";}
		}

		$mResult = $this->query($sQuery);

		return $mResult[0]['count'];
    }

    function getPollReplierCount($aOption)
    {
        $sQuery = "SELECT Count(*) as count FROM Pollwidget_user where pidx = '".$aOption['idx']."'";
        $mResult = $this->query($sQuery);

        return $mResult[0]['count'];
    }

    function getPollCountByDate($aOption)
    {
        switch($aOption){
            case 'All':
                $sQuery = "SELECT Count(*) as count FROM Pollwidget_poll";
                break;

            case 'Waiting':
                $sQuery = "SELECT Count(*) as count FROM Pollwidget_poll where period_start > '".date('Y-m-d')."'";
                break;

            case 'OnGoing':
                $sQuery = "SELECT Count(*) as count FROM Pollwidget_poll where period_start <= '".date('Y-m-d')."' and period_end >= '".date('Y-m-d')."'";
                break;

            case 'Done':
                $sQuery = "SELECT Count(*) as count FROM Pollwidget_poll where period_end < '".date('Y-m-d')."'";
                break;

            default:
                break;
        }

        $mResult = $this->query($sQuery);

        return $mResult[0]['count'];
    }

    function setAddPoll($aOption)
    {
        $sQuery = "INSERT into Pollwidget_poll(idx, title, period_start, period_end, reg_date, auto_delete) values ('', '".$aOption['title']."', '".$aOption['start']."','".$aOption['end']."', '".$aOption['regdate']."','".$aOption['autodelete']."')";
        $mResult = $this->query($sQuery);

        $sQuery = "Select max(idx) as pidx from Pollwidget_poll";
        $mResult = $this->query($sQuery);
        $pidx = $mResult[0]['pidx'];

        foreach($aOption['qnum'] as $key => $val){
            $sQuery = "INSERT into Pollwidget_question(idx, pidx, question, opinion, limits, required, choice_type) values ('', '".$pidx."', '".$aOption['question_'.$val.'_content']."','".$aOption['choice_opinion_'.$val]."', '".$aOption['desc_max_input_'.$val]."','".$aOption['quest_reqd_'.$val]."','".$aOption['question_choice_type_'.$val]."')";
            $mResult = $this->query($sQuery);

            $sQuery = "Select max(idx) as qidx from Pollwidget_question";
            $mResult = $this->query($sQuery);
            $qidx = $mResult[0]['qidx'];

            foreach($aOption[$val.'_choice'] as $index => $choice){
                $sQuery = "INSERT into Pollwidget_choices(idx, qidx, choice, opinion) values ('', '".$qidx."', '".$aOption[$val.'_choice_'.$index]."','".$aOption['choice_opinion_'.$val.'_'.$index]."')";
                $mResult = $this->query($sQuery);
            }
        }

        return $mResult;
    }

    function setPollAnswers($aOption)
    {
        for($i = 1; $i <= $aOption['Question_Count']; $i++){
            if($aOption[$i]['c_type'] != 2){
                if(is_array($aOption[$i]['q_answer'])){
                    foreach($aOption[$i]['q_answer'] as $key => $val){
                        $sQuery = "INSERT into Pollwidget_answer(idx, qidx, answer, rank, opinion) values ('', '".$aOption[$i]['q_id']."', '".$val."','','".$aOption[$i]['c_opinion'][$key]."')";
                        $mResults = $this->query($sQuery);
                    }
                }
                else{
                    if($aOption[$i]['c_type'] == 3)
                        $aOption[$i]['c_opinion'] = $_SERVER['REMOTE_ADDR'];
                    $sQuery = "INSERT into Pollwidget_answer(idx, qidx, answer, rank, opinion) values ('', '".$aOption[$i]['q_id']."', '".$aOption[$i]['q_answer']."','','".$aOption[$i]['c_opinion']."')";
                    $mResults = $this->query($sQuery);
                }
            }
            else{
                $answer = explode('||', $aOption[$i]['q_answer']);
                $rank = explode(',', $answer[0]);
                $value = explode(',', $answer[1]);
                foreach($rank as $key => $val){
                    $sQuery = "INSERT into Pollwidget_answer(idx, qidx, answer, rank, opinion) values ('', '".$aOption[$i]['q_id']."', '".$value[$key]."','".$rank[$key]."','')";
                    $mResult = $this->query($sQuery);
                }
            }
        }

        $sQuery = "INSERT into Pollwidget_user(idx, pidx, ip) values ('', '".$aOption['Poll']."', '".$aOption['IP']."')";
        $mResults = $this->query($sQuery);

        return $mResults;
    }

    function setEditPoll($aOption)
    {
        $sQuery = "Select * from Pollwidget_question where pidx = '".$aOption['pidx']."'";
        $mResult = $this->query($sQuery);

        foreach($mResult as $key => $value){
             $sQuery = "Delete from Pollwidget_choices where qidx = '".$mResult['idx']."'";
             $this->query($sQuery);
        }
        $sQuery = "Delete from Pollwidget_question where pidx = '".$aOption['pidx']."'";
        $mResult = $this->query($sQuery);

        $sQuery = "Update Pollwidget_poll set title = '".$aOption['title']."', period_start = '".$aOption['start']."', period_end = '".$aOption['end']."', auto_delete = '".$aOption['autodelete']."' where idx = '".$aOption['pidx']."'";
        $mResult = $this->query($sQuery);

        $pidx = $aOption['pidx'];

        foreach($aOption['qnum'] as $key => $val){
            $sQuery = "INSERT into Pollwidget_question(idx, pidx, question, opinion, limits, required, choice_type) values ('', '".$pidx."', '".$aOption['question_'.$val.'_content']."','".$aOption['choice_opinion_'.$val]."', '".$aOption['desc_max_input_'.$val]."','".$aOption['quest_reqd_'.$val]."','".$aOption['question_choice_type_'.$val]."')";
            $mResult = $this->query($sQuery);

            $sQuery = "Select max(idx) as qidx from Pollwidget_question";
            $mResult = $this->query($sQuery);
            $qidx = $mResult[0]['qidx'];

            foreach($aOption[$val.'_choice'] as $index => $choice){
                $sQuery = "INSERT into Pollwidget_choices(idx, qidx, choice, opinion) values ('', '".$qidx."', '".$aOption[$val.'_choice_'.$index]."','".$aOption['choice_opinion_'.$val.'_'.$index]."')";
                $mResult = $this->query($sQuery);
            }
        }

        return $sQuery;
    }

    function setDeletePoll($aOption)
    {
        foreach($aOption['idx'] as $key => $val)
        {
            $sQuery = "Select * from Pollwidget_question where pidx = '".$val."'";
            $mResult = $this->query($sQuery);

            foreach($mResult as $key => $value){
                $sQuery = "Delete from Pollwidget_choices where qidx = '".$mResult['idx']."'";
                $this->query($sQuery);

                $sQuery = "Delete from Pollwidget_answer where qidx = '".$mResult['idx']."'";
                $this->query($sQuery);
            }
            $sQuery = "Delete from Pollwidget_question where pidx = '".$val."'";
            $mResult = $this->query($sQuery);

            $sQuery = "DELETE from Pollwidget_poll where idx = '".$val."'";
            $mResult = $this->query($sQuery);
        }
    }

    function setDeleteFinishedPolls()
    {

        $sQuery = "Select * from Pollwidget_poll where period_end < '".date('Y-m-d')."' and auto_delete = '1'";
        $mResult = $this->query($sQuery);

        foreach($mResult as $key => $field)
        {
            $sQuery = "Select * from Pollwidget_question where pidx = '".$field['idx']."'";
            $mResult = $this->query($sQuery);

            foreach($mResult as $key => $value){
                $sQuery = "Delete from Pollwidget_choices where qidx = '".$mResult['idx']."'";
                $this->query($sQuery);

                $sQuery = "Delete from Pollwidget_answer where qidx = '".$mResult['idx']."'";
                $this->query($sQuery);
            }
            $sQuery = "Delete from Pollwidget_question where pidx = '".$field['idx']."'";
            $mResult = $this->query($sQuery);
        }

        $sQuery = "DELETE from Pollwidget_poll where period_end < '".date('Y-m-d')."' and auto_delete = '1'";
        $mResult = $this->query($sQuery);
    }
}