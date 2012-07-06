<?php

class Sentence_perfection_model extends Simplexi_controller
{
	private $TB_GAMES = 'tb_game_sentence';

	public function __construct()
	{
		parent::__construct();
		$this->library('common');
		$this->common->getParams();
	}
	
	public function saveDatas()
	{
			$sQuestion = $this->common->getParam('question');
			$sAnswer = $this->common->getParam('answer');
			$sPoint = $this->common->getParam('point');
			$sLevel = $this->common->getParam('level');
			$sStatus = $this->common->getParam('status');
			$iId = $this->common->getParam('idx');
			
		if($iId!="add"){
		
			$aFields = array('question' => $sQuestion,'answer' => $sAnswer,'level' => $sLevel,'point' => $sPoint,'status' => $sStatus);
			$sWhere = "idx  = ".$iId;
			$this->update($this->TB_GAMES,$aFields,$sWhere )->execute();
			return 'update';
		
		}else{
	
			$aFields[] = array('question' => $sQuestion,'answer' => $sAnswer,'level' => $sLevel,'point' => $sPoint,'status' => $sStatus,'branch' => USER_ID);
			$this->insert($this->TB_GAMES, $aFields)->execute();
			return 'save';
		}
	
	}
	public function dels()
	{
	     $aContents = $this->selectAll($this->TB_GAMES)->execute();
	     $list_count = count($aContents);

	    $idxs = $this->common->getParam('idx');
	    foreach ($idxs as $item){
            $sWhere = "idx  = ".$item;
            $this->deleteBy($this->TB_GAMES,$sWhere )->execute();
	    }

	    $aContents1 = $this->selectAll($this->TB_GAMES)->execute();

	    if(count($aContents1)!=$list_count){
	        return 'delete';
	    }else{
	        return 'error';
	    }
	
	}
	public function updatestats()
	{
	     $aContents = $this->selectAll($this->TB_GAMES)->execute();
	     $list_count = count($aContents);

	    $idxs = $this->common->getParam('idx');
	    foreach ($idxs as $item){

			$sStatus = $this->common->getParam('status')=='Publish' ? 'Published' : 'Unpublished';
			$aFields = array('status' => $sStatus);
			 $sWhere = "idx  = ".$item;
			$this->update($this->TB_GAMES,$aFields,$sWhere )->execute();
			
	    }

	}
	public function getDatas()
	{
		$sWhere = ' WHERE idx ='.$this->common->getParam('idx');
		$aContents = $this->selectAll($this->TB_GAMES . $sWhere)->execute();
		return $aContents;
	}

}