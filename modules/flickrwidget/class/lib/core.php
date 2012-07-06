<?php
class LibCore
{
	public function __construct() {}

	public function getParams()
    {
        $aParam = array_merge($_REQUEST, $_FILES, $_SESSION);
        return $aParam;
    }
    
    public function getParam($sKey)
    {
        if( is_string($sKey) && trim($sKey) != '') {
            $aParam = $this->getParams();
            return ( array_key_exists($sKey, $aParam) ) ? $aParam[$sKey] : '';
        }
    }
    
    public function jsonEncode($aReturn)
    {
        echo json_encode($aReturn);
    }

	public function redirect($string)
	{
		$url = sprintf("<script>window.location.href='%s%s'</script>", SERVER_BASE_URL. 'plugin' . DS. PLUGIN_NAME . DS. PLUGIN_VERSION . DS, $string);
		echo $url;
	}

	public function success($sMsg)
	{
		$string = "<script>alert('Settings successfully ".$sMsg.".');</script>";
		echo $string;
	}

	public function fail()
	{
		$string = "<script>alert('DB Error.');</script>";
		echo $string;
	}

	public function getCurrentUrl()
	{
		$siteUrl = 'http';
		$siteUrl .= $_SERVER["HTTPS"] == "on" ? 's': '';
		$siteUrl .= "://";
		$siteUrl .= $_SERVER["SERVER_PORT"] != "80" ? $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"] : $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		$idx = strrpos($siteUrl, '?') ? strrpos($siteUrl, '?') : strlen($siteUrl);
        $url = substr($siteUrl, 0, $idx);
		return array (
			'base' => $url, 
			'current' => $siteUrl
		);
	}

	public function setSearchDate($mode)
	{
		$iTime = time();
        return array(
            'sStartDate' => date('Y-m-d', strtotime($mode)),
            'sEndDate' => date('Y-m-d', $iTime)
        );
	}

	public function formatName($filename)
    {
        $aFile = explode('/', $filename);

        $iCount = count($aFile);

        $sFile = $aFile[$iCount-1];

        $sSeparator = '...';
        $iLenght = strlen($sSeparator) ;
        $iMaxlength = 25 - $iLenght;
        $iStart = $iMaxlength / 2;
        $iTrunc =  strlen($sFile) - $iMaxlength;

        return substr_replace($sFile, $sSeparator, $iStart, $iTrunc);
    }

	public function readDir($dirName, $filter='') 
    {
    	$filter = trim($filter);
        $result = array();

        $opendir = @opendir( @$dirName );
        while( $filelist = @readdir( $opendir ) ){

            if( preg_match("@^\.@", $filelist) !== 0 ) continue;
            
            $path = $dirName.'/'.$filelist;
            if(filetype($path) == 'dir'){
               
                $result = array_merge($result, $this->readDir($path, $filter));
                
            }else if(filetype($path) == 'file'){
                
                if($filter && (preg_match($filter, $filelist) === 0) ){
                    continue;
                }
            
                $result[] = $path;
            }
        }
        @closedir( @$opendir );
        return $result;	
    }

	public function getDate($aDate)
	{
		return date('Y-m-d', $aDate[0]);
	}
}