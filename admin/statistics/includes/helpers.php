<?php

function ymdDate($sDate,$return = "")
{
	if($sDate != "")
	{
		$aExplode = explode('/',$sDate);
		$sDate = $aExplode[2] . '-' . $aExplode[0] . '-' . $aExplode[1];
		
		if($return=='array')
		{
			return $aExplode;
		}
		return $sDate;
	}
	return false;
}

function splitSsnInfo($sSsn)
{
	$aSsn = array();
	
	$iYearTwo = date('y',time());	
	
	$aSsn['year_digit'] = substr($sSsn,0,2);
	
	$aSsn['year'] = ( ( $aSsn['year_digit'] > $iYearTwo ) ? '19' : '20' ) . $aSsn['year_digit'];
	
	$aSsn['month'] = substr($sSsn,2,2);
	
	$aSsn['day'] = substr($sSsn,4,2);
	
	$aSsn['gender'] = substr($sSsn,7,1);
	
	return $aSsn;
}

function vd($var)
{
    echo"<pre>";
    var_dump($var);
    echo"</pre>";
}