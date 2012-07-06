<?php
class frontPagePollwidget extends Controller_Front
{
    protected function run($aArgs)
    {
        require_once('builder/builderInterface.php');
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);

        $oModelPollAdmin = new modelPollAdmin();
        $aOnGoingPoll = $oModelPollAdmin->getOnGoingPoll($aOption);
        $aOption['idx'] = $aOnGoingPoll[0]['idx'];
        $userVerify = $oModelPollAdmin->verifyPollUser($aOption);
        $iQuestionCount = $oModelPollAdmin->getPollQuestionCount($aOption);

        $aData = $oModelPollAdmin->getPollData($aOption);
        $aForm = $oModelPollAdmin->getPollQuestions($aOption);
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
                    $aForm[$key]['desc'] = $oModelPollAdmin->getPollDescFront($aOption);
            }
        }

        /* View All Question */
        $sHtml = '<div id="pollwidget_container_all" style="display: none;"><center>';
        $sHtml .= '
        <table border="0" cellpadding="5" cellspacing="0" class="table_hor_02" id="q_num_1" width="95%" style="border: 1px solid gray;">
            <tr id="disp_num_tr_'.($keys+1).'">
                <td colspan="2" style="text-align: center;padding-left: 2px;"><strong  class="question_title">'.$aOnGoingPoll[0]['title'].'</strong></td>
            </tr>
        </table>';
        $aPollData = array();
        $aPollData['Question_Count'] = $iQuestionCount;
        $aPollData['PID'] = $aOption['idx'];
        foreach($aForm as $keys => $field){
            $aOption['qidx'] = $field['idx'];

            $aChoices = $oModelPollAdmin->getPollChoices($aOption);
            $sHtml .= '
            <table border="0" cellpadding="5" cellspacing="0" class="table_hor_02" id="q_num_1" width="95%" style="border: 1px solid gray;">
                <thead>
                    <tr id="disp_num_tr_'.($keys+1).'">
                        <td colspan="2" style="text-align: left;padding-left: 2px;"><strong class="question_number">'.($keys+1).'.</strong> <strong  class="question_title">'.$field['question'].'</strong></td>
                    </tr>
                </thead>
                    <tr id="disp_num_tr_'.($keys+1).'">
                        <td colspan="2" style="text-align: left;padding-left: 2px;">
                            <div>';

            if($field['choice_type'] == 0){
                foreach($aChoices as $key => $value){
                    $sHtml .= '<input type="radio" class=\"input_radio\" onclick="frontPagePollwidget.radio_mask(\'2\',\''.$keys.'\');" name="all_pollwidget_'.$keys.'" value="'.$value['choice'].'" id="all_pollwidget_'.$keys.'" value="'.$value['choice'].'" onclick="frontPagePollwidget.radio_mask('.$keys.');"> '.$value['choice'];

                    if($value['opinion'] == 1)
                        $sHtml .= '<br />Opinion: <input type="text" id="all_opinion_'.$keys.'_'.(str_replace(" ","_",$value['choice'])).'" onkeyup="frontPagePollwidget.mask_opinion(\'2\',\''.$keys.'_'.(str_replace(" ","_",$value['choice'])).'\')"><br />';
                    else
                        $sHtml .= '<br />';

                    $sHtml .= '<br />';
                }
            }
            if($field['choice_type'] == 1){
                foreach($aChoices as $key => $value){
                    $sHtml .= '<input type="checkbox" class=\"input_checkbox\" name="all_pollwidget_'.$keys.'[]" value="'.$value['choice'].'" onclick="javascript: frontPagePollwidget.checkbox_mask(\'2\',\''.$keys.'\');"> '.$value['choice'];

                    if($value['opinion'] == 1)
                        $sHtml .= '<br />Opinion: <input type="text" id="all_opinion_'.$keys.'_'.(str_replace(" ","_",$value['choice'])).'" onkeyup="frontPagePollwidget.mask_opinion(\'2\',\''.$keys.'_'.(str_replace(" ","_",$value['choice'])).'\')"><br />';
                    else
                        $sHtml .= '<br />';

                    $sHtml .= '<br />';
                }
            }
            if($field['choice_type'] == 2){
                foreach($aChoices as $key => $value){
                    $sHtml .= '&nbsp; <select class=\"input_dropbox\" id="all_pollwidget_'.$keys.'_'.$key.'" onchange="frontPagePollwidget.ranking_mask(\''.$keys.'\',\''.$key.'\')">';

                    for($i = 1; $i<=count($aChoices); $i++){
                        $sHtml .= '<option';

                        if(($key+1) == $i)
                            $sHtml .= ' Selected';

                        $sHtml .= '>'.$i.'</option>';
                    }

                    $sHtml .= '</select>&nbsp; ';
                    $sHtml .= $value['choice'].'<br /><br />';
                }
            }
            if($field['choice_type'] == 3){
                $sHtml .= '<textarea id="all_pollwidget_'.$keys.'" onkeyup="javascript: frontPagePollwidget.desc_mask(\''.$keys.'\');" onkeydown="javascript: frontPagePollwidget.desc_mask(\''.$keys.'\');" style="width: 99%;height: 100px;"></textarea>';
                $sHtml .= '<input class=\"choice_texarea\" type="text" id="all_limit_'.$keys.'" value="'.$field['limits'].'" readonly size="4" style="float: right; margin-right: 3px;">';
            }
            $sHtml .= '
                        </div>
                    </td>
                </tr>
            </table><br>';
        }
        $sHtml .= '
            <div>
                <strong class="btn_poll_expand"><em><input type="button" id="all_pollwidget_event_join" value="Join"></em></strong>
                <strong class="btn_poll_expand"><em><input type="button" id="all_pollwidget_event_result" value="Result"></em></strong>
                <strong class="btn_poll_expand"><em><input type="button" id="all_pollwidget_event_result" value="close" onclick="javascript: $(\'#pollwidget_container_all\').dialog(\'close\');$(\'#pollwidget_container\').show();"></em></strong>
            </div>
            <br />
        </div>';

        $sHtmlDialogs = '
            <div id="check-form" style="display: none; margin-right: 5px;">
                <div>
                    <br /><br />
                    <center>Answer All Questions!</center>
                </div>
                <div>
                    <br /><br />
                    <strong class="btn_poll_expand" style="float: right;"><em><input type="button" onclick="javascript: $(\'#check-form\').dialog(\'close\');" value="close"></em></strong>
                </div>
            </div>
            <div id="submit-form" style="display: none; margin-right: 5px;">
                <div>
                    <br /><br />
                    <center>Thank you for the answers.</center>
                </div>
                <div>
                    <br /><br />
                    <strong class="btn_poll_expand" style="float: right;"><em><input type="button" onclick="javascript: $(\'#submit-form\').dialog(\'close\');" value="close"></em></strong>
                </div>
            </div>';


        /* View Result */
        $sHtmlResult = '<div id="all_pollwidget_result_container" style="display: none;width: 500px;"><center>';
        $sHtmlResult .= '
        <table border="0" cellpadding="5" cellspacing="0" class="table_hor_02" id="q_num_1" width="95%" style="border: 1px solid gray;">
        <tr id="disp_num_tr_'.($keys+1).'">
        <td colspan="2" style="text-align: center;padding-left: 2px;"><strong class="question_title">'.$aOnGoingPoll[0]['title'].'</strong></td>
        </tr>
        </table>';
        foreach($aForm as $keys => $field){
            $aOption['qidx'] = $field['idx'];
            $aChoices = $oModelPollAdmin->getPollChoices($aOption);

            if($field['choice_type'] == 0){
                if($sSettings == 1){
                    $sHtmlResult .= '
                    <table border="0" cellpadding="5" cellspacing="0" class="table_hor_02" id="q_num_1" width="95%" style="border: 1px solid gray;">
                        <thead>
                            <tr id="disp_num_tr_'.($keys+1).'">
                                <td colspan="2" style="text-align: left;padding-left: 2px;"><strong class="question_number">'.($keys+1).'.</strong> <strong class="question_title">'.$field['question'].'</strong></td>
                            </tr>
                        </thead>
                            <tr id="disp_num_tr_'.($keys+1).'">
                                <td colspan="2" style="text-align: left;padding-left: 2px;">';

                    foreach($aChoices as $index => $value){
                        $sHtmlResult .= '<div style="background: '.$aColors[$index].';width: 10px;height: 10px;display: inline-block;"></div> '.$value['choice'].'&nbsp;';
                    }

                    $sHtmlResult .= '
                                </td>
                            </tr>';

                    foreach($aChoices as $index => $value){
                        $sHtmlResult .= '
                            <tr id="disp_num_tr_'.($keys+1).'">
                                <td style="text-align: left;padding-left: 2px;padding-right: 2px;" colspan="2">';

                        if($field['choices'][$index]['replier'] == 0){
                            $sHtmlResult .= '0 Vote';
                        }
                        else{
                            if($field['choices'][$index]['replier'] > 0 && $iReplierCount > 0){
                                $width = ($field['choices'][$index]['replier'] / $iReplierCount) * 100;
                                $sHtmlResult .= '<div style="background: '.$aColors[$index].';width: '.$width.'%;height: 100%;">&nbsp;</div>';
                            }
                        }

                        $sHtmlResult .= '</td></tr>';
                    }

                    $sHtmlResult .= '</table><br>';
              }
              else{
                  $sHtmlResult .= '
                  <table border="0" cellpadding="5" cellspacing="0" class="table_hor_02" id="q_num_1" width="95%" style="border: 1px solid gray;">
                      <thead>
                          <tr id="disp_num_tr_'.($keys+1).'">
                              <td colspan="'.(count($field['choices'])).'" style="text-align: left;padding-left: 2px;"><strong class="question_number">'.($keys+1).'.</strong> <strong class="question_title">'.$field['question'].'</strong></td>
                          </tr>
                      </thead>
                          <tr id="disp_num_tr_'.($keys+1).'">
                              <td colspan="'.(count($field['choices'])).'" style="text-align: left;padding-left: 2px;">';

                  foreach($aChoices as $index => $value){
                      $sHtmlResult .= '<div style="background: '.$aColors[$index].';width: 10px;height: 10px;display: inline-block;"></div> '.$value['choice'];
                  }

                  $sHtmlResult .= '
                              </td>
                          </tr>
                          <tr id="disp_num_tr_'.($keys+1).'">';

                  foreach($aChoices as $index => $value){
                      $sHtmlResult .= '<td style="padding-left: 2px;padding-right: 2px; height: 150px;width: 50px;" valign="bottom">';

                      if($field['choices'][$index]['replier'] == 0){
                          $sHtmlResult .= '<center>0 Vote</center>';
                      }
                      else{
                          if($field['choices'][$index]['replier'] != 0 && $iReplierCount != 0){
                              $height = ($field['choices'][$index]['replier'] / $iReplierCount) * 100;
                              $sHtmlResult .= '<div style="background: '.$aColors[$index].';width: 100%;height: '.$height.'%;">&nbsp;</div>';
                          }
                      }

                     $sHtmlResult .= '</td>';
                   }
                    $sHtmlResult .= '
                            </tr>
                    </table><br>';
                }
            }
            if($field['choice_type'] == 1){
                if($sSettings == 1){
                    $sHtmlResult .= '
                    <table border="0" cellpadding="5" cellspacing="0" class="table_hor_02" id="q_num_1" width="95%" style="border: 1px solid gray;">
                        <thead>
                            <tr id="disp_num_tr_'.($keys+1).'">
                                <td colspan="2" style="text-align: left;padding-left: 2px;"><strong class="question_number">'.($keys+1).'.</strong> <strong class="question_title">'.$field['question'].'</strong></td>
                            </tr>
                        </thead>
                            <tr id="disp_num_tr_'.($keys+1).'">
                                <td colspan="2" style="text-align: left;padding-left: 2px;">';

                     foreach($aChoices as $index => $value){
                         $sHtmlResult .= '<div style="background: '.$aColors[$index].';width: 10px;height: 10px;display: inline-block;"></div> '.$value['choice'];
                     }

                     $sHtmlResult .= '
                                 </td>
                            </tr>';

                     foreach($aChoices as $index => $value){
                         $sHtmlResult .= '
                            <tr id="disp_num_tr_'.($keys+1).'">
                                <td style="text-align: left;padding-left: 2px;padding-right: 2px;" colspan="2">';

                            if($field['choices'][$index]['replier'] == 0){
                                $sHtmlResult .= '0 Vote';
                            }
                            else{
                                if($field['choices'][$index]['replier'] > 0 && $iReplierCount > 0){
                                    $width = ($field['choices'][$index]['replier'] / $iReplierCount) * 100;
                                    $sHtmlResult .= '<div style="background: '.$aColors[$index].';width: '.$width.'%;height: 100%;">&nbsp;</div>';
                                }
                            }

                          $sHtmlResult .= '</td></tr>';

                      }

                      $sHtmlResult .= '</table><br>';
                    }
                    else{
                        $sHtmlResult .= '
                        <table border="0" cellpadding="5" cellspacing="0" class="table_hor_02" id="q_num_1" width="95%" style="border: 1px solid gray;">
                            <thead>
                                <tr id="disp_num_tr_'.($keys+1).'">
                                    <td colspan="'.(count($field['choices'])).'" style="text-align: left;padding-left: 2px;"><strong class="question_number">'.($keys+1).'.</strong> <strong class="question_title">'.$field['question'].'</strong></td>
                                </tr>
                            </thead>
                                <tr id="disp_num_tr_'.($keys+1).'">
                                    <td colspan="'.(count($field['choices'])).'" style="text-align: left;padding-left: 2px;">';

                    foreach($aChoices as $index => $value){
                        $sHtmlResult .= '<div style="background: '.$aColors[$index].';width: 10px;height: 10px;display: inline-block;"></div> '.$value['choice'];
                    }

                    $sHtmlResult .= '
                                    </td>
                                </tr>
                            <tr id="disp_num_tr_'.($keys+1).'">';

                    foreach($aChoices as $index => $value){
                        $sHtmlResult .= '<td style="padding-left: 2px;padding-right: 2px; height: 150px;width: 50px;" valign="bottom">';
                        if($field['choices'][$index]['replier'] == 0){
                            $sHtmlResult .= '<center>0 Vote</center>';
                        }
                        else{
                            if($field['choices'][$index]['replier'][$i+1] != 0 && $iReplierCount != 0){
                                $height = ($field['choices'][$index]['replier'] / $iReplierCount) * 100;
                                    $sHtmlResult .= '<div style="background: '.$aColors[$index].';width: 100%;height: '.$height.'%;">&nbsp;</div>';
                            }
                         }

                         $sHtmlResult .= '</td>';

                     }

                     $sHtmlResult .= '
                             </tr>
                    </table><br>';
                }
            }
            if($field['choice_type'] == 2){
                if($sSettings == 1){
                    $sHtmlResult .= '
                    <table border="0" cellpadding="5" cellspacing="0" class="table_hor_02" id="q_num_1" width="95%" style="border: 1px solid gray;">
                        <colgroup>
                            <col width="80"/>
                            <col/>
                        </colgroup>
                        <thead>
                            <tr id="disp_num_tr_'.($keys+1).'">
                                <td colspan="2" style="text-align: left;padding-left: 2px;"><strong class="question_number">'.($keys+1).'.</strong> <strong class="question_title">'.$field['question'].'</strong></td>
                            </tr>
                        </thead>';

                    $sHtmlResult .= '
                            <tr id="disp_num_tr_'.($keys+1).'">
                                <td colspan="2" style="text-align: left;padding-left: 2px;">';

                    foreach($aChoices as $index => $value){
                        $sHtmlResult .= '<div style="background: '.$aColors[$index].';width: 10px;height: 10px;display: inline-block;"></div> '.$value['choice'];
                    }

                    $sHtmlResult .= '
                                </td>
                            </tr>';

                    foreach($aChoices as $index => $value){
                        $sHtmlResult .= '
                            <tr id="disp_num_tr_'.($keys+1).'">
                                <td style="text-align: left;padding-left: 10px;">
                                    Rank '.($index+1).'
                                </td>
                                <td style="text-align: left;padding-left: 2px;padding-right: 2px;">';
                        if($field['choices'][$index]['replier'] == 0){
                            $sHtmlResult .= '0 Vote';
                        }
                        else{
                            for($i = 0; $i < count($field['choices']); $i++){
                                if($field['choices'][$index]['replier'][$i+1] != 0 && $iReplierCount != 0){
                                    $width = ($field['choices'][$index]['replier'][$i+1] / $iReplierCount) * 100;
                                    $sHtmlResult .= '<div style="background: '.$aColors[$i].';width: '.$width.'%;height: 100%;display:inline-block;">&nbsp;</div>';

                                }
                            }
                        }

                        $sHtmlResult .= '</td></tr>';
                     }

                     $sHtmlResult .= '</table><br>';
                  }
                  else{
                     $sHtmlResult .= '
                     <table border="0" cellpadding="5" cellspacing="0" class="table_hor_02" id="q_num_1" width="95%" style="border: 1px solid gray;">
                         <thead>
                             <tr id="disp_num_tr_'.($keys+1).'">
                                 <td colspan="'.(count($field['choices'])).'" style="text-align: left;padding-left: 2px;"><strong class="question_number">'.($keys+1).'.</strong> <strong class="question_title">'.$field['question'].'</strong></td>
                             </tr>
                        </thead>
                            <tr id="disp_num_tr_'.($keys+1).'">
                                <td colspan="'.(count($field['choices'])).'" style="text-align: left;padding-left: 2px;">';

                      foreach($field['choices'] as $index => $value){
                          $sHtmlResult .= '<div style="background: '.$aColors[$index].';width: 10px;height: 10px;display: inline-block;"></div> '.$value['choice'];
                      }

                      $sHtmlResult .= '
                                </td>
                            </tr>
                            <tr id="disp_num_tr_'.($keys+1).'">';

                    foreach($aChoices as $index => $value){
                        $sHtmlResult .= '<td style="text-align: left;padding-left: 2px;padding-right: 2px; height: 150px;" valign="bottom">';

                        for($i = 0; $i < count($field['choices']); $i++){

                            if($field['choices'][$index]['replier'] == 0){
                                $sHtmlResult .= '0 Vote';
                            }
                            else{
                                if($field['choices'][$index]['replier'][$i+1] != 0 && $iReplierCount != 0){
                                    $height = ($field['choices'][$index]['replier'][$i+1] / $iReplierCount) * 100;
                                    $sHtmlResult .= '<div style="background: '.$aColors[$i].';width: 100%;height: '.$height.'%;">&nbsp;</div>';
                                }
                            }
                        }

                        $sHtmlResult .= '
                                    <center>Rank '.($index+1).'</center>
                                </td>';
                     }
                     $sHtmlResult .= '
                             </tr>
                        </table><br>';
                 }
            }
            if($field['choice_type'] == 3){
                $sHtmlResult .= '
                <table border="0" cellpadding="5" cellspacing="0" class="table_hor_02" id="q_num_1" width="95%" style="border: 1px solid gray;">
                    <thead>
                        <tr id="disp_num_tr_'.($keys+1).'">
                            <td colspan="'.(count($field['choices'])).'" style="text-align: left;padding-left: 2px;"><strong class="question_number">'.($keys+1).'.</strong> <strong class="question_title">'.$field['question'].'</strong></td>
                        </tr>
                    </thead>
                        <tr id="disp_num_tr_'.($keys+1).'">
                            <td colspan="'.(count($field['choices'])).'" style="text-align: left;padding-left: 2px;">
                                <textarea style="width: 99%;" readonly>'.$field['desc'][0]['answer'].'</textarea>
                            </td>
                        </tr>
                </table><br>';
            }
        }
        $sHtmlResult .= '
            <div>
                <strong class="btn_poll_expand"><em>
                    <input type="button" id="pollwidget_event_result_close" value="close" onclick="javascript: $(\'#all_pollwidget_result_container\').dialog(\'close\');">
                </em></strong>
            </div>
            <br />
        </div>';

        if($userVerify > 0){
            $sHtml = '';
        }

        $this->assign("pollwidget_show_all", $sHtml);
        $this->assign("pollwidget_show_result", $sHtmlResult);
        $this->assign("pollwidget_show_dialogs", $sHtmlDialogs);
        $this->assign("pollwidget_container", "pollwidget_container");
        $this->assign("pollwidget_top", "pollwidget_top");
        $this->assign("pollwidget_number", "pollwidget_number");
        $this->assign("pollwidget_question", "pollwidget_question");
        $this->assign("pollwidget_choices", "pollwidget_choices");
        $this->assign("pollwidget_choices_list", "pollwidget_choices_list");
        $this->assign("pollwidget_nav", "pollwidget_nav");
        $this->assign("pollwidget_event_prev", "pollwidget_event_prev");
        $this->assign("pollwidget_event_next", "pollwidget_event_next");
        $this->assign("pollwidget_event_join", "pollwidget_event_join");
        $this->assign("pollwidget_event_result", "pollwidget_event_result");
        $this->assign("pollwidget_event_all", "pollwidget_event_all");

        $this->writeJs("frontPagePollwidget.getForm();");
        $this->writeJs("frontPagePollwidget.loadStartQuestion(1);");
        $this->importJS('jquery-ui-1.8.16.custom.min');
    	$this->importJS(__CLASS__);
    	//$this->importCSS('common');
    	$this->importCSS('jquery-ui-1.8.16.custom');
    	$this->importCSS('style');
    }
}