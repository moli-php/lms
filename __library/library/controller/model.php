<?php
class Model extends PDO
{
	var $PDO;
	
	public function __construct()
	{
		$sServer  = "localhost";
		$sUsername = "root";
		$sPassword = "";
		$sDatabase = "bldph105";
		
		$this->PDO = new PDO("mysql:host=".$sServer.";dbname=".$sDatabase, $sUsername, $sPassword);
		
		if (!$this->PDO) {
			die ('Could not connect: ' . mysql_error());
		}
	}

	public function query($sSql, $sType = "rows")
    {
        //$sSql = self::T_dbQueryConvert($sSql);

        $sType = strtolower($sType);

        $dbResult = $this->PDO->query($sSql);

        if ($dbResult !== false) {
            $mResult = ($sType == "row")? $dbResult->fetch(PDO::FETCH_ASSOC) : $dbResult->fetchAll(PDO::FETCH_ASSOC);

            unset($dbResult);

            $mResult = self::T_dbDataConvert($mResult);
            return $mResult;
        } else {
            return false;
        }
    }
	
	/**
	 * Sql Query Hook
	 */
	private function T_dbQueryConvert(&$sSql)
	{
		return self::sqlInjectionAttackStringEncode($sSql);
	}

	/**
	 * Sql Injection Attack String Encoding
	 */
	private function sqlInjectionAttackStringEncode(&$sSql)
	{
		$f = create_function('&$aVal', '
			switch($aVal[0]) {
				case \'--\':
					$sResult = \'LS0=\';
					break;
				case \'/*\':
					$sResult = \'Lyo=\';
					break;
				case \'@@\':
					$sResult = \'QEA=\';
					break;
				case \'#\':
					$sResult = \'Iw==\';
					break;
			}
			return $sResult;
		');

		return preg_replace_callback('/\-\-|\/\*|\@\@|\#/', $f, $sSql);
	}

	/**
	 * Sql Query Result Hook
	 */
	private function T_dbDataConvert(&$mData)
	{
		if( $mData === false ) return false;
		return self::sqlInjectionAttackStringDecode($mData);

	}

	/**
	 * Sql Injection Attack String Decoding
	 */
	private function sqlInjectionAttackStringDecode(&$mData)
	{
		$fReplace = create_function('&$aVal', '
			switch($aVal[0]) {
				case \'LS0=\':
					$sResult = \'--\';
					break;
				case \'Lyo=\':
					$sResult = \'/*\';
					break;
				case \'QEA=\':
					$sResult = \'@@\';
					break;
				case \'Iw==\':
					$sResult = \'#\';
					break;
			}
			return $sResult;
		');

		$sDecodeRegex = '/LS0\=|Lyo\=|QEA\=|Iw\=\=/';

		if(empty($mData[0]) === false && is_array($mData[0]) === true) {
			foreach($mData as $iKey => &$aRows) {
				$mResult[$iKey] = preg_replace_callback($sDecodeRegex, $fReplace, $aRows);
			}
		} else if(is_array($mData) === true) {
			$mResult = preg_replace_callback($sDecodeRegex, $fReplace, $mData);
		}
		
		return $mResult;
	}
}
?>