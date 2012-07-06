<?php
class management_model extends Model
{
    //private $sTableName = 'tb_dashboard_management';
    public function getAllData($sTableName){
	    $aFields = array(
            'idx',
            'item_name'
	    );
	    $aResult = $this->selectAll($sTableName,$aFields)->execute();
	    echo json_encode($aResult);
	}

	public function saveSettings($sTableName)
	{
	    session_start();
	    $aNames = explode(',', $_GET['item_name']);
	    for($iCount=0;$iCount<count($aNames);$iCount++){
	        $aInserfields[] = array(
	                'item_name' => $aNames[$iCount]
	        );
	    }
	    $sInsert = $this->insert($sTableName, $aInserfields)->execute();

	    if($_GET['page'] == "dash_mngt"){
	        $_SESSION['total_limit'] = null;
	        echo json_encode($sInsert);
	    } else {
    	    $_SESSION['total_limit'] = $_GET['total'];
	    }
	}

	public function deleteAllData($sTableName)
	{
	    $this->deleteAll($sTableName)->execute();
	}
	
	 public function getAllDataMenu($sTableName){
	    $aFields = array(
            'idx',
            'item_name',
			'hidden_flag'
	    );
	    $aResult = $this->selectAll($sTableName,$aFields)->orderBy('seq','ASC')->execute();
	    echo json_encode($aResult);
	}
	
	public function saveSettingsMenu($sTableName)
	{
		$aNames = explode(',', $_GET['item_name']);
		
		$this->update($sTableName,array('hidden_flag' => 1))->execute();
		
		foreach($aNames as $key=>$val){
			$aFields = array('hidden_flag' => 0, 'seq' => ($key+1));
			$sWhere = "idx = ".$val;
			$this->update($sTableName,$aFields,$sWhere)->execute();
		}

	}
}
?>