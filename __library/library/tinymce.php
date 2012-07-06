<?php

class Tinymce extends Simplexi_Controller
{
	private $aElement = array();
	
	public function __construct()
	{
		Tinymce::init();
	}
	
	public function init()
	{
		$GLOBALS['tinyMce'] = '';
		$GLOBALS['tinyMce'] .= '<script type="text/javascript" src="' . BASE_URL . 'js/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>';
		$GLOBALS['tinyMce'] .= '<script type="text/javascript" src="' . BASE_URL . 'js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>';
		
	}
	
	private function generate()
	{
		




	}

}

$Tinymce = new Tinymce;