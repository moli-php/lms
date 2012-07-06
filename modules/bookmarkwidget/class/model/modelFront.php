<?php
class frontModelBookmarkwidget extends Model
{
    function addBookmark($aOption)
    {
    	$sQuery = "Select count(*) as count from Bookmarkwidget_webpages where url = '".$aOption['url']."' and user_ip = '".$aOption['ip']."'";
    	$mResult = $this->query($sQuery);

    	if($mResult[0]['count'] == 0){
	    	$sQuery = "Insert into Bookmarkwidget_webpages values ('', '".$aOption['ip']."', '".$aOption['url']."', '".$aOption['name']."', '".$aOption['title']."')";
        	$mResult = $this->query($sQuery);
        	$mResult = true;
    	}
    	else{
    		$mResult = false;
    	}

        return $mResult;
    }

    function getBookmarks($aOption)
    {
    	$sQuery = "SELECT * FROM Bookmarkwidget_webpages where user_ip = '".$aOption['ip']."' order by idx Desc";
    	$mResult = $this->query($sQuery);

    	return $mResult;
    }

    function delBookmark($aOption){
        $sQuery = "DELETE FROM Bookmarkwidget_webpages where idx = '".$aOption['idx']."'";
        $mResult = $this->query($sQuery);

        return $mResult;
    }

    function setTitle($aOption){
        $sQuery = "TRUNCATE TABLE Bookmarkwidget_title";
        $mResult = $this->query($sQuery);

        $sQuery = "Insert into Bookmarkwidget_title values ('".$aOption['title']."')";
        $mResult = $this->query($sQuery);

        return $mResult;
    }

    function getTitle(){
        $sQuery = "Select * from Bookmarkwidget_title";
        $mResult = $this->query($sQuery);

        return $mResult[0]['title'];
    }
}