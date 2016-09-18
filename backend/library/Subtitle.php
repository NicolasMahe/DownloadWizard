<?php

class Subtitle
{
    private $subtitle = null;

    function __construct($subtitle)
    {
        if(!empty($subtitle))
        {
            $subtitleFile = Config::get('subtitlePath').'/'.$subtitle.'.php';
            $fileExists = file_exists($subtitleFile);

            if($fileExists)
            {
                include_once($subtitleFile);
                $this->subtitle = new $subtitle();

                $methodExistsSearch = method_exists($this->subtitle, 'search');
                $methodExistsDownload = method_exists($this->subtitle, 'download');

                if(!$methodExistsSearch)
                {
                        ErrorPerso::add('subtitle method search do not exist');
                        $this->subtitle = null;
                        return;
                }
                if(!$methodExistsDownload)
                {
                        ErrorPerso::add('subtitle method download do not exist');
                        $this->subtitle = null;
                        return;
                }
            }
            else
            {
                ErrorPerso::add('subtitle "'.$subtitle.'" is unknown');
            }
        }
        else
        {
            ErrorPerso::add('subtitle is empty');
        }
    }


    public function search($search)
    {
        if($this->subtitle)
        {
            $data = $this->subtitle->search($search);
            
            return $data;
        }
    }
    
    public function download($name, $url)
    {
        if($this->subtitle)
        {
            $data = $this->subtitle->download($name, $url);
            
            return $data;
        }
    }
    
    public function downloadFirst($search)
    {
        if($this->subtitle)
        {
            $result = $this->subtitle->search($search);
            
            if(count($result) > 0) {
                $retour = $this->subtitle->download($search, $result[0]['downloadLink'], $search);
                
                if($retour) {
                    Log::add('subtitle', 'downloadFirst', 'success', 'Subtitle successfully downloaded: "'.$search.'"');
                }
                else {
                    Log::add('subtitle', 'downloadFirst', 'error', 'Subtitle is empty: "'.$search.'"');
                    ErrorPerso::add("subtitle download first failed: subtitle is empty: '".$search."'");
                }
                
                return $retour;
            } else {
                Log::add('subtitle', 'downloadFirst', 'error', 'No result for subtitle : "'.$search.'"');
                ErrorPerso::add("subtitle download first failed: no result for subtitle: '".$search."'");
            }
            
            return false;
        }
    }
}
