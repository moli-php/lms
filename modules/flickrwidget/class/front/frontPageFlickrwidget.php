<?php
include_once('phpFlickr-3.1/phpFlickr.php');
class frontPageFlickrwidget extends Controller_Front
{
    protected function run($aArgs)
    {
        $aResult = common()->modelFront()->getSettings($aOption);

        $sApiKey = $aResult[0]['api_key'] ? $aResult[0]['api_key'] : '';
        $sUserID = $aResult[0]['userid'] ? $aResult[0]['userid'] : '';
        $iDispType = $aResult[0]['display_type'] ? $aResult[0]['display_type'] : 0;
        $iDispTarget = $aResult[0]['display_target'] ? $aResult[0]['display_target'] : 0;
        $iDispNum = $aResult[0]['display_num'] ? $aResult[0]['display_num'] : 6;
        $iTemplate = $aResult[0]['template'] ? $aResult[0]['template'] : 0;

        $this->importJS('jquery.lightbox-0.5');
        $this->importJS('jcarousellite');
        $this->importJS('index');
        $sCssIndex = $iDispType == 0 ? "index" : "index.carousel";
        $iDispType == 0 ? $this->writeJs("$('.flickrwidget_prev').hide(); $('.flickrwidget_next').hide();") : '';
        $this->importCSS($sCssIndex);
        $this->importCSS('jquery.lightbox-0.5');

        if($iDispNum < 7) {
            $sCarouselBtnClass = $iDispNum < 5 ? "flick_no_display" : '';
            $sClassDiv = "pg_gallery_wrap1";
            $sClassUl =  "pg_gallery1";
        } else {
            $sClassDiv = "pg_gallery_wrap2";
            $sClassUl = "pg_gallery2";
            $sCarouselBtnClass = "";
        }

       $aPhoto = frontPageFlickrwidget::dataPhpflickr($sApiKey, $sUserID, $iDispNum, $iDispTarget, $iDispType);

       $sHtml .= '<div id="pg_flickr_wrap1">';

       if(count($aPhoto) > 0){
           if($iDispType == 0){
               $sHtml .= '<div class="'.$sClassDiv.'">
                                <ul class="'.$sClassUl.'">';

               foreach($aPhoto as $info){
                   $sHtml .= '<li';

                   if($info['no']%3 == 0 && count($aPhoto) < 7){
                       $sHtml .= ' style="margin-right:0 !important;"';
                   }

                   $sHtml .= '><a href="'.$info['href'].'"';

                   if($iDispTarget == 0){
                       $sHtml .= ' target="_blank"';
                   }
                   else{
                       $sHtml .= ' rel="'.$info['href'].'"';
                   }

                   $sHtml .= ' title="'.$info['title'].'"><img src="'.$info['src'].'" alt="'.$info['title'].'"/></img></a></li>';
               }

               $sHtml .= '</ul>';
           }
           else{
                if(count($aPhoto) != 0){
                   if(count($aPhoto) > 4){
                       $sHtml .= '<div class="pg_images_holder"><ul>';

                       foreach($aPhoto as $info){

                           $sHtml .= '<li';
                           $sHtml .= ' style="margin:2px !important;list-style:none;"><a href="'.$info['href'].'"';

                           if($iDispTarget == 0){
                               $sHtml .= ' target="_blank"';
                           }
                           else{
                               $sHtml .= ' rel="'.$info['href'].'"';
                           }

                           $sHtml .= ' title="'.$info['title'].'"><img src="'.$info['src'].'" alt="'.$info['title'].'"/></img></a></li>';

                       }

                       $sHtml .= '</ul>';
                   }
                   else{
                       $sHtml .= '<div class="pg_images_holder2"><ul>';

                       foreach($aPhoto as $info){

                           $sHtml .= '<li';
                           $sHtml .= ' style="margin:2px !important;list-style:none;"><a href="'.$info['href'].'"';

                           if($iDispTarget == 0){
                               $sHtml .= ' target="_blank"';
                           }
                           else{
                               $sHtml .= ' rel="'.$info['href'].'"';
                           }

                            $sHtml .= ' title="'.$info['title'].'"><img src="'.$info['src'].'" alt="'.$info['title'].'"/></img></a></li>';
                       }



                       $sHtml .= '</ul>';
                   }
               }
               else{

                   $sHtml .= '<div class="pg_gallery_wrap1">
                                   <ul class="pg_gallery1">
                                       <li>Flickr image is not ready.</li>
                                   </ul>
                              </div>';
               }
           }

           $sHtml .= '</div>';
       }
       else{

           $sHtml .= '<div class="pg_gallery_wrap1">
                          <ul class="pg_gallery1">
                              <li>Flickr image is not ready.</li>
                          </ul>
                      </div>';
       }

       $sHtml .= '</div>
                  <input type="hidden" id="flickr_disp_target_hidden" value="'.$iDispTarget.'" />
                  <input type="hidden" id="flickr_disp_type_hidden" value="'.$iDispType.'" />
                  <input type="hidden" id="flickr_plugin_dir_hidden" value="'.$sPgDir.'" />
                  <input type="hidden" id="flickr_plugin_dir_hidden2" value="'.$sPgDir.'" />

        ';
        //$this->assign('class_carouselbtn', $sCarouselBtnClass);
        $this->assign('image_display', $sHtml);
    }

    function dataPhpflickr($sFlickrKey, $sFlickrId, $iPhotoNum, $iDispTarget, $iDispType)
    {
        $phpFlickr = new phpFlickr($sFlickrKey);

        $aUser = $phpFlickr->people_findByUsername($sFlickrId);
        $sUserUrl = $phpFlickr->urls_getUserPhotos($aUser['id']);
        if($iDispType == 0)
            $aPhoto = $phpFlickr->people_getPublicPhotos($aUser['id'], NULL, NULL, $iPhotoNum);
        else
            $aPhoto = $phpFlickr->people_getPublicPhotos($aUser['id'], NULL, NULL);

        $aFlickr = array();
        if($aPhoto) {
            $iCount = 0;
            foreach($aPhoto['photos']['photo'] as $photo){
                $sHref = $iDispTarget == "0" ? $sUserUrl . $photo['id'] : $phpFlickr->buildPhotoURL($photo, "medium");
                $_sHref = $iDispTarget == "0" ? $sHref : "#";

                $aFlickr[] = array(
                        'no' => ++$iCount,
                        'href' => $sHref,
                        '_href' => $_sHref,
                        'title' => $photo['title'] . ' (on Flickr)',
                        'src' => $phpFlickr->buildPhotoURL($photo, "square")
                );
            }
        }
        return $aFlickr;
    }
}