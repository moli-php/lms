<?php
class dashboard_management_model extends Model
{
    private $sTableName = 'tb_dashboard_mngt';

    public function getAllData($page){
        $sCheckDash = $this->select($this->sTableName,null,'branch_idx='.$_SESSION['idx'])->execute();
        if(count($sCheckDash)==0){
            $aDash[] = array(
                    'item_name' => 'user,class,message,product,event,ulearning,test_result,branch,point,absent_student,cancelled_class',
                    'branch_idx' => $_SESSION['idx']
            );
            $sInsert = $this->insert($this->sTableName, $aDash)->execute();
        }

	    $aResult = $this->select($this->sTableName,null,'branch_idx='.$_SESSION['idx'])->execute();
	    if($page == "dash_mngt"){
	        echo json_encode($aResult);
	    } else {
	        return $aResult;
	    }
	}

	public function saveSettings()
	{
	    session_start();
        $aInserfields[] = array(
                'item_name' => $_GET['item_name'],
                'branch_idx' => $_SESSION['idx']
        );

	    $sInsert = $this->insert($this->sTableName, $aInserfields)->execute();

	    if($_GET['page'] == "dash_mngt"){
	        $_SESSION['total_limit'] = null;
	        echo json_encode($sInsert);
	    } else {
    	    $_SESSION['total_limit'] = $_GET['total'];
	    }
	}

	public function deleteAllData()
	{
	    $this->query("DELETE FROM ".$this->sTableName." WHERE branch_idx=".$_SESSION['idx']);
	}
}
?>