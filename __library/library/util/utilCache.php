<?php
class Caching
{
	var $cacheFileName;
	var $cacheFile;
	
	function pageCache($sPage)
	{
		$this->cacheFileName = FW_USER_CACHE . DS . $sPage .'.cache';
	}
	
	public function setCachePage($sContent)
	{
		$handle = fopen($this->cacheFileName, "w") or die("Couldn't find cache file");
		if ($handle) {
			$sContent = preg_replace("/[\r\t]/", "", $sContent);
			fwrite($handle, $sContent);
			fclose($handle);
		}
	}
	
	public function getCachedPage()
	{
		$sFile = '';
		$handle = fopen($this->cacheFileName, "r") or die("Couldn't find cache file");
		if ($handle) {
			while (!feof($handle)) {
				$sData = fgets($handle);
				$sFile .= $sData;
			}
			fclose($handle);
		}
		
		return $sFile;
	}
}
?>