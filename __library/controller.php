<?php

define ('REAL_PATH', realpath(dirname(__FILE__)));

$aArgs = array_merge($_REQUEST, $_FILES);
$GLOBALS['aArgs'] = array_merge($_REQUEST, $_FILES);

require_once REAL_PATH . '/system/core.php';
require_once SYSTEM_PATH . 'controller.php';

