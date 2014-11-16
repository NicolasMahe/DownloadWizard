<?php

class qBittorrent
{
    /**
     * get header for authentification
     * @param string $uri
     * @param string $type
     * @return string header
     */
    private function getHeaderAuth($uri, $type='GET')
    {
        $nonce = md5(uniqid());
        $a1 = md5(Config::get("downloaderQBittorrentUsername") . ':' . Config::get("downloaderQBittorrentRealm") . ':' . Config::get("downloaderQBittorrentPassword"));
        $a2 = md5($type . ':' . $uri);
        $response = md5($a1 . ':' . $nonce . ':' . $a2);
        
        $header = 'Authorization: Digest'
                . ' username="'.Config::get("downloaderQBittorrentUsername").'",'
                . ' realm="'.Config::get("downloaderQBittorrentRealm").'",'
                . ' nonce="'.$nonce.'",'
                . ' uri="'.$uri.'",'
                . ' response="'.$response.'" \r\n';
        
        return $header;
    }
    
    /**
     * add a torrent
     * @param string $downloadLinks
     * @return true
     * @todo ajout de lien depuis IPT marche pas a cause de authentification
     */
    public function add($downloadLinks)
    {
        $uri = '/command/download';
        
        $postData = array(
            'urls' => "http://torcache.net/torrent/4CD7D9E2985AFB340B24A5266B368246823FB086.torrent?title=[kickass.to]need.for.speed.2014.1080p.brrip.x264.yify"
        );
        
        $content = HTTP::post(Config::get("downloaderQBittorrentURL").$uri, $postData, $this->getHeaderAuth($uri));
        
        return true;
    }
    
    /**
     * get torrents list
     * @return array data
     */
    public function torrentList()
    {
        $uri = '/json/torrents';
        
        $content = HTTP::get(Config::get("downloaderQBittorrentURL").$uri, $this->getHeaderAuth($uri), true);
        
        $torrentModel= new TorrentModel();
        $cpt = 0;
           
        $contentTransform = array();
        foreach ($content as $key => $torrent) {
            $status = "play";
            if($torrent['state'] == "pausedUP" || $torrent['state'] == "pausedDL") {
                $status = "pause";
            }
            
            $contentTransformTmp = array(
                "hash"=> $torrent['hash'],
                "name"=> $torrent['name'],
                "size"=> $torrent['size'],
                "progress"=> $torrent['progress'],
                "downloadSpeed"=> $torrent['dlspeed'],
                "uploadSpeed"=> $torrent['upspeed'],
                "priority"=> $torrent['priority'],
                "numberSeeders"=> $torrent['num_seeds'],
                "numberLeechers"=> $torrent['num_leechs'],
                "ratio"=> $torrent['ratio'],
                "eta"=> $torrent['eta'],
                "status"=> $status
            );
            
            //if($torrent['name'] == "Titanic.1997.Open.Matte.1080p.BluRay.3D.H-SBS.DTS.x264-z-man") {
                $torrentModel->addWithTorrentInfo($contentTransformTmp);
            //}
            $cpt++;
            //die();
            
            $contentTransform[] = $contentTransformTmp;
        }
        
        return $contentTransform;
    }
    
    /**
     * get torrent's info and data
     * @param string $hash
     * @return array data
     */
    public function torrentInfoData($hash)
    {
        $torrentList = $this->torrentList();
            
        $tor = null;

        foreach($torrentList as $torrent) {
            if($torrent['hash'] == $hash) {
                $tor = $torrent;
                break;
            }
        }

        $data = $this->torrentInfo($hash);
        
        $merged = array_merge($tor, $data);
        
        return $merged;
    }
    
    /**
     * get torrent's trackers
     * @param string $hash
     * @return array data
     */
    public function torrentTrackers($hash)
    {
        $uri = '/json/propertiesTrackers/'.$hash;
        
        $content = HTTP::get(Config::get("downloaderQBittorrentURL").$uri, $this->getHeaderAuth($uri), true);
        
        $contentTransform = array();
        foreach ($content as $key => $tracker) {
            $contentTransformTmp = array(
                "url"=> $tracker['url'],
                "status"=> $tracker['status'],
                "numberPeers"=> $tracker['num_peers'],
                "message"=> $tracker['msg']
            );
            $contentTransform[] = $contentTransformTmp;
        }
        
        return $contentTransform;
    }
    
    /**
     * get torrent's files
     * @param string $hash
     * @return array data
     */
    public function torrentFiles($hash)
    {
        $uri = '/json/propertiesFiles/'.$hash;
        
        $content = HTTP::get(Config::get("downloaderQBittorrentURL").$uri, $this->getHeaderAuth($uri), true);
        
        $contentTransform = array();
        foreach ($content as $key => $file) {
            $contentTransformTmp = array(
                "size"=> $file['size'],
                "name"=> $file['name'],
                "progress"=> $file['progress'],
                "priority"=> $file['priority']
            );
            $contentTransform[] = $contentTransformTmp;
        }
        
        return $contentTransform;
    }
    
    /**
     * get info about a torrent
     * @param string $hash
     * @return array data
     */
    public function torrentInfo($hash)
    {
        $uri = '/json/propertiesGeneral/'.$hash;
        
        $content = HTTP::get(Config::get("downloaderQBittorrentURL").$uri, $this->getHeaderAuth($uri), true);
        
        $contentTransform = array(
            "path"=> $content['save_path'],
            "creationDate"=> $content['creation_date'],
            "totalWasted"=> $content['total_wasted'],
            "totalUploaded"=> $content['total_uploaded'],
            "totalDownloaded"=> $content['total_downloaded'],
            "timeElapsed"=> $content['time_elapsed'],
            "shareRatio"=> $content['share_ratio'],
        );
        
        return $contentTransform;
    }
    
    /**
     * pause a torrent
     * @param string $hash
     * @return true
     */
    public function torrentPause($hash)
    {
        $uri = '/command/pause';
        
        $postData = array(
            'hash' => $hash
        );
        
        $content = HTTP::post(Config::get("downloaderQBittorrentURL").$uri, $postData, $this->getHeaderAuth($uri, 'POST'));
        
        return true;
    }
    
    /**
     * resume a torrent
     * @param string $hash
     * @return true
     */
    public function torrentResume($hash)
    {
        $uri = '/command/resume';
        
        $postData = array(
            'hash' => $hash
        );
        
        $content = HTTP::post(Config::get("downloaderQBittorrentURL").$uri, $postData, $this->getHeaderAuth($uri, 'POST'));
        
        return true;
    }
    
    /**
     * delete a torrent
     * @param string $hash
     * @return true
     */
    public function torrentDelete($hash)
    {
        $uri = '/command/deletePerm';
        
        $postData = array(
            'hashes' => $hash
        );
        
        $content = HTTP::post(Config::get("downloaderQBittorrentURL").$uri, $postData, $this->getHeaderAuth($uri, 'POST'));
        
        return true;
    }
    
    /**
     * globalSpeed
     * 
     * @return array data
     */
    public function globalSpeed()
    {
        $uri = '/json/transferInfo';
        
        $content = HTTP::get(Config::get("downloaderQBittorrentURL").$uri, $this->getHeaderAuth($uri), true);
        
        $contentTransform = array(
            "download"=> $content['dl_info'],
            "upload"=> $content['up_info']
        );
        
        return $contentTransform;
    }
    
    /**
     * preferences
     * 
     * @return array data
     */
    public function preferences()
    {
        $uri = '/json/preferences';
        
        $content = HTTP::get(Config::get("downloaderQBittorrentURL").$uri, $this->getHeaderAuth($uri), true);
        
        $contentTransform = array(
            "autorunEnabled"=> $content['autorun_enabled'],
            "autorunProgram"=> $content['autorun_program'],
            "downloadLimit"=> $content['dl_limit'],
            "uploadLimit"=> $content['up_limit']
        );
        
        return $contentTransform;
    }
    
    /**
     * set preferences
     * 
     * @param type $data
     * @return boolean
     * @todo ajouter encodage json de data
     */
    public function preferencesSet($data)
    {
        $uri = '/command/setPreferences';
        
        $postData = array(
            'json' => $data
        );
        
        $content = HTTP::post(Config::get("downloaderQBittorrentURL").$uri, $postData, $this->getHeaderAuth($uri, 'POST'));
        
        return true;
    }
    
    /**
     * get speed limits
     * 
     * @return array data
     */
    public function speedLimit()
    {
        $uri = '/command/getGlobalDlLimit';
        $contentDl = HTTP::post(Config::get("downloaderQBittorrentURL").$uri, array(), $this->getHeaderAuth($uri, 'POST'), false, false, true);
        
        $uri = '/command/getGlobalUpLimit';
        $contentUp = HTTP::post(Config::get("downloaderQBittorrentURL").$uri, array(), $this->getHeaderAuth($uri, 'POST'), false, false, true);
        
        $contentTransform = array(
            "upload"=> $contentUp,
            "download"=> $contentDl
        );
        
        return $contentTransform;
    }
    
    /**
     * set speed limits
     * 
     * @param type $download
     * @param type $upload
     * @return true
     */
    public function speedLimitSet($download, $upload)
    {
        if(!empty($download)) { 
            $uri = '/command/setGlobalDlLimit';
            $postData = array('limit' => $download);
            $content = HTTP::post(Config::get("downloaderQBittorrentURL").$uri, $postData, $this->getHeaderAuth($uri, 'POST'));
        }
        
        if(!empty($upload)) { 
            $uri = '/command/setGlobalUpLimit';
            $postData = array('limit' => $upload);
            $content = HTTP::post(Config::get("downloaderQBittorrentURL").$uri, $postData, $this->getHeaderAuth($uri, 'POST'));
        }
        
        return true;
    }
    
    
}