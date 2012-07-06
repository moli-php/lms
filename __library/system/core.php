<?php
session_start();
class Core
{
	var $aConfig;
	
	/**
	* Initiate BASE_URL Constant and necessary Files
	*/
	
	public function __construct()
	{
		$this->_loadFiles();

		if ($this->aConfig['base_url'] == '') {
			$sBaseUrl = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
			$sBaseUrl .= '://'. $_SERVER['HTTP_HOST'] . "/";

			define('BASE_URL', $sBaseUrl);
		} else {
			define('BASE_URL', $this->aConfig['base_url']);
		}
	}
	
	/**
	* Load necessary Files
	*/
	
	private function _loadFiles()
	{
		include_once REAL_PATH . '/config/config.php';
		include_once REAL_PATH . '/config/bootstrap.php';
		include_once SYSTEM_PATH . 'common.php';
		include_once SYSTEM_PATH . 'Database/model.php';

		$this->aConfig = $aConfig;
	}
}

$oCore = new Core();

?>