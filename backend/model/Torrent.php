<?php

class TorrentModel
{
    protected $table;
    
    function __construct()
    {
        $this->table = new Table("torrent");
    }
    
    
    public function addWithFilename($filename)
    {
        $mediaModel = new MediaModel();
            
        $pathinfo = pathinfo($filename);
        $name = $pathinfo['filename'];
        
        if(!$this->get(null, $name)) {
            //add
            $dataToAdd = array(
                "name" => $name
            );
            
            //get media
            $media = $mediaModel->addWithReleaseName($name);
            if($media) {
                $dataToAdd['idMedia'] = $media['id'];
            }
            
            $this->table->add($dataToAdd);
        }
    }
    
    public function addWithTorrentInfo($torrentInfo)
    {
        $mediaModel = new MediaModel();
            
        $torrent = null;
        if(!empty($torrentInfo['hash'])) {
            $torrent = $this->get($torrentInfo['hash'], null);
        }
        if(!$torrent && !empty($torrentInfo['name'])) {
            $torrent = $this->get(null, $torrentInfo['name']);
        }
        
        if($torrent) {
            //update
            $torrentNew = array_merge($torrent, $torrentInfo);
            $this->table->update($torrentNew);
        } else {
            //add
            $dataToAdd = $torrentInfo;
            
            //get media
            $media = $mediaModel->addWithReleaseName($torrentInfo['name']);
            if($media) {
                $dataToAdd['idMedia'] = $media['id'];
            }
            
            $this->table->add($dataToAdd);
        }
    }
    
    protected function get($hash=null, $name=null)
    {
        if(!empty($hash)) {
            $libraryList = $this->table->getAll();
            foreach ($libraryList as $torrent) {
                if(!empty($torrent['hash']) && $torrent['hash'] == $hash) {
                    return $torrent;
                }
            }
        }
        else if(!empty($name)) {
            $libraryList = $this->table->getAll();
            foreach ($libraryList as $torrent) {
                if(!empty($torrent['name']) && $torrent['name'] == $name) {
                    return $torrent;
                }
            }
        }
        return null;
    }
}