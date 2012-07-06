<?php
class frontPageBookmarkwidget extends Controller_Front
{
    protected function run($aArgs)
    {
        $this->importJS('jquery-ui-1.8.16.custom.min');
        $this->importJS('jquery.jscrollpane.min');
        $this->importJS('jquery.easing.1.3');
        $this->importCSS('jquery-ui-1.8.16.custom');
        $this->importCSS('styles');

        //$this->importJS('DD_roundies_0.0.2a-min');
        $this->importJS('frontPageBookmarkwidget');


        $this->assign('wrap_container', 'fl_slider_wrap_con');
        $this->assign('wrap', 'fl_slider_wrap');
        $this->assign('slider', 'fl_slider');
        $this->assign('main', 'bookmark_main');
        $this->assign('url_search', 'bookmarkwidget_search');
        $this->assign('form_class', 'input_txt');
        $this->assign('form_class2', 'input_txt2');
        $this->assign('btn_class', 'input_btn');
        $this->assign('container', 'fl_container');
        $this->assign('url_list', 'bookmarkwidget_list');
        $this->assign('url_name', 'bookmarkwidget_name');
        $this->assign('url', 'bookmarkwidget_url');
        $this->assign('add_btn', 'bookmarkwidget_button');
        $this->assign('nav', 'bookmark_nav');
        $this->assign('bookmark_btn_image', '[IMG]/bookmark.gif');
    }
}