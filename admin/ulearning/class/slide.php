<?php
class Slide extends Simplexi_Controller{
	public function run($aArgs){
		$this->library("checkLogin");
		$this->model('ulearning_model');
		$this->importJS('ulearning/slide');
		
		$aTinymceOptions = array(
		"id" => "study_summary",
		"name" => "study_summary",
		"container" => ".tmce_con",
		"style" => "width:100%;", 
		"dialog" => "false", 
		"settings" => array( 
			"mode" => "none",
			"theme" => "advanced",
			"plugins" => "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			"theme_advanced_toolbar_align" => "left",
			"theme_advanced_toolbar_location" =>"top",
			"theme_advanced_buttons1" => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
			"theme_advanced_buttons2" => ",search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code"
			
			)
		);
		$aTinymceOptions2 = array(
		"id" => "todays_object",
		"name" => "todays_object",
		"container" => ".tmce_con2",
		"style" => "width:100%;", 
		"dialog" => "false", 
		"settings" => array( 
			"mode" => "none",
			"theme" => "advanced",
			"plugins" => "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			"theme_advanced_toolbar_align" => "left",
			"theme_advanced_toolbar_location" =>"top",
			"theme_advanced_buttons1" => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
			"theme_advanced_buttons2" => ",search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code"
			
			)
		);
		$aTinymceOptions3 = array(
		"id" => "related_article",
		"name" => "related_article",
		"container" => ".tmce_con3",
		"style" => "width:100%;", 
		"dialog" => "false", 
		"settings" => array( 
			"mode" => "none",
			"theme" => "advanced",
			"plugins" => "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			"theme_advanced_toolbar_align" => "left",
			"theme_advanced_toolbar_location" =>"top",
			"theme_advanced_buttons1" => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
			"theme_advanced_buttons2" => ",search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code"
			
			)
		);
		$this->tinymce_init($aTinymceOptions); 
		$this->tinymce_init($aTinymceOptions2); 
		$this->tinymce_init($aTinymceOptions3); 
		
		$aData['depth1'] = array(array('fcategory_id' => 1,'fcategory_name' => 'Class Material'),
								array('fcategory_id' => 2,'fcategory_name' => 'Preview'),
								array('fcategory_id' => 2,'fcategory_name' => 'Homework'),
								array('fcategory_id' => 4,'fcategory_name' => 'Level Test (Preview)'),
								array('fcategory_id' => 4,'fcategory_name' => 'Level Test (Test)'));
		
		$aData['aSlide'] = $this->db->ulearning_model->db_select("tb_ulearning_slide",null,array('funit_id' => $aArgs['funit_id']),array("ASC" => 4,"DESC" => 1));
		$aCategory = $this->db->ulearning_model->db_select("tb_ulearning_category",null,array('fcategory_id' => $aArgs['category_id']),null,1);
		$aData['category_name'] = $aCategory[0]['fcategory_name'];
		$aData['funit_id'] = $aArgs['funit_id'];
        foreach($aData['aSlide'] as $k => $v)
        	$aData['aSlide'][$k]['num'] = $k + 1;
			
		$aData['exam_type'] = $this->db->ulearning_model->db_select("tb_ulearning_exam_type",null,null,array("ASC" => 1));
        foreach($aData['exam_type'] as $k => $v)
        	$aData['exam_type'][$k]['num'] = $k + 1;
		$aData['cat1'] = $this->db->ulearning_model->db_select("tb_ulearning_movie_category");
		$this->display("ulearning/slide",$aData);
	}
}
?>