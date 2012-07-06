<?php
class ModelBase
{
    protected $PG_FLICKR_MAIN;
    protected $PG_FLICKR_SETTING;
	protected $utilDb;

    public function init()
    {
        $this->PG_FLICKR_MAIN = 'PG_Flickr_main';
        $this->PG_FLICKR_SETTING = 'PG_Flickr_setting';
		$this->utilDb = new utilDb();
    }
}