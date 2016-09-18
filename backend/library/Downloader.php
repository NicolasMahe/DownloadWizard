<?php

class Downloader
{
    private $downloader = null;

    function __construct($downloader)
    {
            if(!empty($downloader))
            {
                    $downloaderFile = Config::get('downloaderPath').'/'.$downloader.'.php';
                    $fileExists = file_exists($downloaderFile);

                    if($fileExists)
                    {
                            include_once($downloaderFile);
                            $this->downloader = new $downloader();

                            $methodExistsAdd = method_exists($this->downloader, 'add');

                            if(!$methodExistsAdd)
                            {
                                    ErrorPerso::add('downloader method add do not exist');
                                    $this->downloader = null;
                                    return;
                            }
                    }
                    else
                    {
                            ErrorPerso::add('downloader "'.$downloader.'" is unknown');
                    }
            }
            else
            {
                    ErrorPerso::add('downloader is empty');
            }
    }

    public function add($dl)
    {
        if($this->downloader)
        {
            $data = $this->downloader->add($dl);
            
            return $data;
        }
    }

    public function torrentList()
    {
        if($this->downloader)
        {
            $data = $this->downloader->torrentList();
            
            return $data;
        }
    }

    public function torrentInfo($hash)
    {
        if($this->downloader)
        {
            $data = $this->downloader->torrentInfo($hash);
            
            return $data;
        }
    }

    public function torrentPause($hash)
    {
        if($this->downloader)
        {
            $data = $this->downloader->torrentPause($hash);
            
            return $data;
        }
    }

    public function torrentResume($hash)
    {
        if($this->downloader)
        {
            $data = $this->downloader->torrentResume($hash);
            
            return $data;
        }
    }

    public function torrentDelete($hash)
    {
        if($this->downloader)
        {
            $data = $this->downloader->torrentDelete($hash);
            
            return $data;
        }
    }
    
    public function torrentExtractAndSubtitle($hash)
    {
        if($this->downloader)
        {
            Log::add('downloader', 'extraction', 'start', 'Torrent extraction and subtitle download start with hash "'.$hash.'"');
            $torrentData = $this->downloader->torrentInfoData($hash);
            
            //subtitle
            $subtitle = new Subtitle('OpenSubtitles');
            $subtitle->downloadFirst($torrentData['name']);
            
            //extraction
            Extract::archiveInPath($torrentData['path'].$torrentData['name'], Recognize::pathToSave($torrentData['name']));
            
            return true;
        }
    }
    
    public function torrentTrackers($hash)
    {
        if($this->downloader)
        {
            $data = $this->downloader->torrentTrackers($hash);
            
            return $data;
        }
    }
    
    public function torrentFiles($hash)
    {
        if($this->downloader)
        {
            $data = $this->downloader->torrentFiles($hash);
            
            return $data;
        }
    }
    
    public function speedLimit()
    {
        if($this->downloader)
        {
            $data = $this->downloader->speedLimit();
            
            return $data;
        }
    }
    
    public function speedLimitSet($download, $upload)
    {
        if($this->downloader)
        {
            $data = $this->downloader->speedLimitSet($download, $upload);
            
            return $data;
        }
    }
    
    public function globalSpeed()
    {
        if($this->downloader)
        {
            $data = $this->downloader->globalSpeed();
            
            return $data;
        }
    }
}