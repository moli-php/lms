<?php 
	foreach($unit as $key => $val){
		if(empty($val['status']))
		echo '<div><span>'. $val['ftitle'] .'</span> <input type="button" value="Take Exam" onclick="exam_list.open_popup('. $val['fassign_id'] .')" /></div>';
		else if($val['status'] == "Assigned")
		echo '<div><span>'. $val['ftitle'] .'</span> <input type="button" value="Continue Exam" onclick="exam_list.open_popup('. $val['fassign_id'] .')" /></div>';
		else if($val['status'] == "Finished" || $val['status'] == "Evaluated")
		echo '<div><span>'. $val['ftitle'] .'</span> <input type="button" value="View Result" onclick="exam_list.open_popup('. $val['fassign_id'] .')" /><input type="button" value="Review Exam" onclick="" /></div>';
	} 
?>