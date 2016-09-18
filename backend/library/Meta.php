<?php

class Meta
{
    private $meta = null;

    function __construct($meta)
    {
            if(!empty($meta))
            {
                    $metaFile = Config::get('metaPath').'/'.$meta.'.php';
                    $fileExists = file_exists($metaFile);

                    if($fileExists)
                    {
                            include_once($metaFile);
                            $this->meta = new $meta();

                            $methodExistsGet = method_exists($this->meta, 'get');
                            $methodExistsSearch = method_exists($this->meta, 'search');

                            if(!$methodExistsGet)
                            {
                                    ErrorPerso::add('meta method get do not exist');
                                    $this->meta = null;
                                    return;
                            }
                            if(!$methodExistsSearch)
                            {
                                    ErrorPerso::add('meta method search do not exist');
                                    $this->meta = null;
                                    return;
                            }
                    }
                    else
                    {
                            ErrorPerso::add('meta "'.$meta.'" is unknown');
                    }
            }
            else
            {
                    ErrorPerso::add('meta is empty');
            }
    }


    public function get($config)
    {
        if($this->meta)
        {
            $data = $this->meta->get($config);
            
            return $data;
        }
    }
    
    public function search($search)
    {
        if($this->meta)
        {
            $data = $this->meta->search($search);
            
            return $data;
        }
    }
    
    public function downloadPoster($meta)
    {
        if(!empty($meta) && $meta['poster'] != "N/A")
        {
            $pathInfo = pathinfo($meta['poster']);
            $data = file_get_contents($meta['poster']);
            
            if(sizeof($data) > 0) {
                Storage::write(Config::get("storagePosterPath")."/".$meta['title']." - ".$meta['year'].".".$pathInfo['extension'], $data, false);

                return Config::get("storagePosterPathLocal")."/".$meta['title']." - ".$meta['year'].".".$pathInfo['extension'];
            }
        }
        
        return null;
    }
}