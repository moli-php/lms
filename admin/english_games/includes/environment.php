<?php

define('SITE_URL','http://' . $_SERVER['HTTP_HOST']);
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT'] . '/');
define('CURRENT_URL','http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
include(DOCUMENT_ROOT . '/__library/controller.php');


// define("APP_URL",SITE_URL . '/admin/message/?action=' . $aArgs['action']);

function vd($var)
{
    echo"<pre>";
    var_dump($var);
    echo"</pre>";
}

function contentsSorter($sField,$sVal)
{
	$sFirstParam = ($_SERVER['QUERY_STRING']!= "" && strpos($_SERVER['QUERY_STRING'],$sField .'=' . $sVal)==false) ? '&' : "?";

	$sSortDef = (isset($_GET['sort'])) ? $_GET['sort'] : "asc";
	
	$sSort = ( $sSortDef=='desc' ) ? "asc" : "desc";
	
	$sQryString = str_replace("{$sFirstParam}$sField=" . $sVal, '',$_SERVER['QUERY_STRING']);
	
	$sQryString = str_replace("&sort=" . $sSort, '',$sQryString);
	
	$sQryString = $sQryString."{$sFirstParam}{$sField}={$sVal}&sort={$sSort}";
	
	return $sQryString;
}
