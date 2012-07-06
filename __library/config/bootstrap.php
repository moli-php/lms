<?php

define ('SERVER_DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
define ('DS', DIRECTORY_SEPARATOR);
define ('PS', PATH_SEPARATOR);

define ('FULL_URL', "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

define ('ENVIRONMENT', $aConfig['environment']);

define ('COMMON_DB_TYPE', 'mysql');
define ('COMMON_DB_HOST', $aConfig['hostname']);
define ('COMMON_DB_USER', $aConfig['username']);
define ('COMMON_DB_PASSWD', $aConfig['password']);
define ('COMMON_DB_NAME', $aConfig['database']);
define ('COMMON_DB_PORT', '3306');

define ('LIBRARY_PATH', REAL_PATH . DS . $aConfig['library'] . DS);
define ('USBUILDER_PATH', REAL_PATH . DS . $aConfig['usbuilder'] . DS);
define ('SYSTEM_PATH', REAL_PATH . DS . $aConfig['system'] . DS);
define ('MODEL_PATH', SERVER_DOCUMENT_ROOT . DS . "model" . DS);
define ('FRONT_PATH', SERVER_DOCUMENT_ROOT . DS);
define ('CSS_PATH', REAL_PATH . DS . $aConfig['css'] . DS);
define ('JS_PATH', REAL_PATH . DS . $aConfig['js'] . DS);
define ('ADMIN_PATH', SERVER_DOCUMENT_ROOT . DS . $aConfig['admin'] . DS);
define ('EXT', '.' . $aConfig['extension']);
define ('TPL', '.' . $aConfig['template_extension']);

define ('ENCRYPTION_KEY', $aConfig['encryption_key']);

if (substr(PHP_OS, 0, 3) == 'WIN') {
    define ('PLUGIN_OS', 'WIN');
    define ('PLUGIN_OS_WIN', true);
    define ('PLUGIN_OS_UNIX', false);
} else {
    define ('PLUGIN_OS', 'UNIX');
    define ('PLUGIN_OS_WIN', false);
    define ('PLUGIN_OS_UNIX', true);
}

if(PLUGIN_OS_WIN === true) {
    define ('IS_TEST', true);
    define ('IS_LOCAL_SERVER', true);
    define ('IS_DEV_SERVER', false);
    define ('IS_QA_SERVER', false);
    define ('IS_LIVE_SERVER', false);
} 

define ('UTIL_DB_RESULT_ROW', 'row');
define ('UTIL_DB_RESULT_ROWS', 'rows');
define ('UTIL_DB_RESULT_EXEC', 'exec');

define ('UTIL_DB_ORDER_BY_ASC', 'asc');
define ('UTIL_DB_ORDER_BY_DESC', 'desc');

$GLOBALS["iCSS"] = array();
$GLOBALS["eCSS"] = array();
$GLOBALS["iJS"] = array();
$GLOBALS["eJS"] = array();
$GLOBALS["wJS"] = array();

$GLOBALS['sMessageType'] = '';
$GLOBALS['sMessage'] = '';

$GLOBALS["miCSS"] = array();
$GLOBALS["meCSS"] = array();
$GLOBALS["miJS"] = array();
$GLOBALS["meJS"] = array();
$GLOBALS["mwriteJS"] = array();
$GLOBALS["Module"] = array();

if (defined('ENVIRONMENT')) {
	switch (ENVIRONMENT) {
		case 'development':
			error_reporting(E_ALL);
			break;
		case 'testing':
		case 'production':
			error_reporting(0);
			break;
		default:
			exit('The application environment is not set correctly.');
	}
}

define ('USER_ID', 		(isset($_SESSION['idx'])) ? $_SESSION['idx'] : null);
define ('USERNAME', 	(isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : null);
define ('USER_GRADE', 	(isset($_SESSION['grade_idx'])) ? $_SESSION['grade_idx'] : null);

?>