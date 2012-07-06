<?php
include(FW_LIBRARY_UTIL . DS . 'utilCache.php');

class utilLoader extends utilCompiler
{
	public function init()
	{
		$sExt = strtolower(pathinfo(REQUESTED_PAGE, PATHINFO_EXTENSION));
		switch($sExt)
		{
			case 'jpg':
			case 'jpeg':
			case 'gif':
			case 'png':
				header('Content-type: image/' . $sExt);
				readfile(REQUESTED_PAGE);
				break;
			
			case 'html':
				echo $this->loadPage();
				break;
				
			default:
				header('location: index.html');
				break;
		}
	}
	
	public function pageError($iError)
	{
		$errorPage = FW_APP . DS . 'error' . DS . $iError . '.html';
		echo file_get_contents($errorPage);
	}
	
	private function loadPage()
	{
		$cachefilename = md5(REQUESTED_PAGE);
		Caching::pageCache($cachefilename);
 
		$cachefile = FW_USER_CACHE . DS . $cachefilename .'.cache';

		$cachetime = 60*5; 
		if(file_exists($cachefile) && time() - $cachetime < filemtime($cachefile))
			return Caching::getCachedPage($cachefile);  
		else 
		{
			Caching::setCachePage($this->compile());
			return Caching::getCachedPage($cachefile);  
		}
	}
}

$oLoader = new utilLoader();
?>