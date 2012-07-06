<?php

/**
  * Index Main Controller
  * John Adrian Tan john@simplexi.com.ph
  */
  
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT'] . '/');
include(DOCUMENT_ROOT . '/__library/controller.php');

$sClass = (isset($aArgs['action'])) ? $aArgs['action'] : "salesStat";
define('CURRENT_URL',BASE_URL . 'admin/statistics/?action=' . $sClass);
define("DIRECT_ACCESS", true);