<?php

include('includes/environment.php');
require_once("includes/helpers.php");

$sClass = (isset($aArgs['action'])) ? $aArgs['action'] : "salesStat";

$sControllerFile = 'controllers/' . $sClass . '.php';

$sClassMethod = isset($aArgs['m']) ? $aArgs['m'] : 'run';

if($sClassMethod=='view' || 
$sClassMethod=='query' || 
$sClassMethod=='display'||
$sClassMethod=='library'||
$sClassMethod=='importCSS'||
$sClassMethod=='importJs'
)  exit("Page not found!");

if(!file_exists($sControllerFile)) exit("Page not found!");

require_once($sControllerFile);

if( !class_exists($sClass) || !method_exists($sClass,$sClassMethod) ) exit("Page not found!");

$oInit = new $sClass;

$oInit->library('checkLogin');

$oInit->$sClassMethod($aArgs);
