<?php

class JDownloader
{
    /**
     * add files from links
     * @param type $downloadLinks
     * @return boolean
     */
    public function add($downloadLinks)
    {
        $urlTo = Config::get("downloaderJDownloaderURL")."/action/add/links/grabber1/start0/".$downloadLinks;
        
        $contentToParse = HTTP::get($urlTo, "");
        //$contentToParse = file_get_contents($urlTo);
        
        if($contentToParse)
        {
            Log::add('jDownloader', 'download', 'success', 'Links successfully added to JDownloader : "'.$downloadLinks.'" : "'.$contentToParse.'" : "'.$urlTo.'"');

            return true;
        }
        else
        {
            Error::add('JDownloader Download failed, data are empty');
            return false;
        }
    }
}