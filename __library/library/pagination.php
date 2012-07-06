<?php

class pagination
{
	public function create($sUrl, $sUri, $iPage, $iItemsPerPage, $iTotalItem, $iInterval = 2)
	{
		if (substr($sUrl, -1) == "/") $sUrl = substr($sUrl, 0, -1);
		if (substr($sUri, 0, 1) == "/") $sUri = substr($sUri, 1, strlen($sUri));
	
		$sDefault = ($iPage - 1) != 1 ? 'href="' . $sUrl . '/page/' . ($iPage - 1) . '/' . $sUri . '"' : 'href="' . $sUrl . '/' . $sUri . '"';
		$sNavigation = '<ul class="product_nav"><li class="first"><a ' . ($iPage != 1 ? $sDefault : "") . '>prev</a></li>';
		$iOptionlength = ceil($iTotalItem / $iItemsPerPage);  
		
		if ($iOptionlength == 0) $iOptionlength = 1;
		
		if ($iPage > $iOptionlength){
			$iPage = $iOptionlength;
		}
	
		for ($iLink = 1; $iLink <= $iOptionlength; $iLink++){
			if ($iLink == 2 && $iPage >= ($iInterval + 3)){
				$sNavigation .= '<li><a href="' . $sUrl . '/' . $sUri . '">1</a></li><li>&hellip;</li>';
			}
			else if($iLink == 1 && $iPage == ($iInterval + 2)){
				$sNavigation .= '<li><a href="' . $sUrl . '/' . $sUri . '">1</a></li>';
			}
			if ($iLink == $iPage){
				$sNavigation .= '<li><strong>' .$iPage. '</strong></li>';
			}
			else if ($iLink >= ($iPage - $iInterval)){
				if ($iLink == 1){
					$sNavigation .= '<li><a href="' . $sUrl . '/' . $sUri . '">' . $iLink . '</a></li>';
				}
				else {
					$sNavigation .= '<li><a href="' . $sUrl . '/page/' . $iLink . '/' . $sUri . '">' . $iLink . '</a></li>';
				}	
			}
			if ($iLink >= ($iPage + $iInterval) && ($iOptionlength - ($iInterval + 2)) >= $iPage){
				$sNavigation .= '<li>&hellip;</li><li><a href="' . $sUrl . '/page/' . $iOptionlength . '/' . $sUri . '">' . $iOptionlength . '</a></li>';
				break;
			}	
		}
		
		$sNextDefault = 'href="' . $sUrl . '/page/' . ($iPage + 1) . '/' . $sUri . '"';
		$sNavigation .= '<li><a ' . ($iPage != $iOptionlength ? $sNextDefault : "") . '">next</a></li></ul>';

		return $sNavigation;
	}
}