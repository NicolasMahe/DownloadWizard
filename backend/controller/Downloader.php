<?php

class DownloaderController
{
    public function addLink()
    {
        $downloader = new Downloader('qBittorrent');
        
        $link = Request::post('link');

        if(!empty($link)) {
            $data = $downloader->add($link);

            Response::setStatus('success');
            Response::setData($data);
        } else {
            Error::add('hash is empty');
            Response::setStatus('error');
        }
    }
    
    public function torrentList()
    {
        $downloader = new Downloader('qBittorrent');

        $data = $downloader->torrentList();

        Response::setStatus('success');
        Response::setData($data);
    }
    
    public function torrentInfo()
    {
        $downloader = new Downloader('qBittorrent');

        $hash = Request::get('hash');

        if(!empty($hash)) {
            $data = $downloader->torrentInfo($hash);

            Response::setStatus('success');
            Response::setData($data);
        } else {
            Error::add('hash is empty');
            Response::setStatus('error');
        }
    }
    
    public function torrentTrackers()
    {
        $downloader = new Downloader('qBittorrent');

        $hash = Request::get('hash');

        if(!empty($hash)) {
            $data = $downloader->torrentTrackers($hash);

            Response::setStatus('success');
            Response::setData($data);
        } else {
            Error::add('hash is empty');
            Response::setStatus('error');
        }
    }
    
    public function torrentFiles()
    {
        $downloader = new Downloader('qBittorrent');

        $hash = Request::get('hash');

        if(!empty($hash)) {
            $data = $downloader->torrentFiles($hash);

            Response::setStatus('success');
            Response::setData($data);
        } else {
            Error::add('hash is empty');
            Response::setStatus('error');
        }
    }
    
    public function torrentPause()
    {
        $downloader = new Downloader('qBittorrent');
        
        $hash = Request::post('hash');

        if(!empty($hash)) {
            $data = $downloader->torrentPause($hash);

            Response::setStatus('success');
            Response::setData($data);
        } else {
            Error::add('hash is empty');
            Response::setStatus('error');
        }
    }
    
    public function torrentResume()
    {
        $downloader = new Downloader('qBittorrent');
        
        $hash = Request::post('hash');

        if(!empty($hash)) {
            $data = $downloader->torrentResume($hash);

            Response::setStatus('success');
            Response::setData($data);
        } else {
            Error::add('hash is empty');
            Response::setStatus('error');
        }
    }
    
    public function torrentDelete()
    {
        $downloader = new Downloader('qBittorrent');
        
        $hash = Request::post('hash');

        if(!empty($hash)) {
            $data = $downloader->torrentDelete($hash);

            Response::setStatus('success');
            Response::setData($data);
        } else {
            Error::add('hash is empty');
            Response::setStatus('error');
        }
    }
    
    public function torrentExtract()
    {
        $downloader = new Downloader('qBittorrent');
        
        $hash = Request::post('hash');

        if(!empty($hash)) {
            $data = $downloader->torrentExtractAndSubtitle($hash);

            Response::setStatus('success');
            Response::setData($data);
        } else {
            Error::add('hash is empty');
            Response::setStatus('error');
        }
    }
    
    public function speedLimit()
    {
        $downloader = new Downloader('qBittorrent');

        $data = $downloader->speedLimit();

        Response::setStatus('success');
        Response::setData($data);
    }
    
    public function speedLimitSet()
    {
        $downloader = new Downloader('qBittorrent');
        
        $download = Request::post('download');
        $upload = Request::post('upload');

        if(!empty($download) && !empty($upload)) {
            $data = $downloader->speedLimitSet($download, $upload);

            Response::setStatus('success');
            Response::setData($data);
        } else {
            Error::add('download or upload is empty');
            Response::setStatus('error');
        }
    }
    
    public function globalSpeed()
    {
        $downloader = new Downloader('qBittorrent');

        $data = $downloader->globalSpeed();

        Response::setStatus('success');
        Response::setData($data);
    }
}