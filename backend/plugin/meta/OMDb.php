<?php

class OMDb
{
    private $url = "http://www.omdbapi.com/";
    private $urlIMDbDetail = "http://www.imdb.com/title/";
    
    private $cache = array();
    
    /**
     * search
     * 
     * @param string $search
     * @return array data
     */
    public function search($search)
    {
        $urlComplete = $this->url."?r=JSON&s=".urlencode($search);
        
        //check cache
        $md5 = md5($urlComplete);
        if(!empty($this->cache[$md5]))
        {
            return $this->cache[$md5];
        }
        else //no cache
        {
            $data = HTTP::get($urlComplete, "", true);
            $dataToReturn = array();

            if($data === false)
            {
                ErrorPerso::add('Error during decoding json from OMDb url "'.$urlComplete.'"');
            }
            else
            {
                if(!empty($data['Search']))
                {
                    foreach ($data['Search'] as $result)
                    {
                        if($result['Type'] == 'movie' || $result['Type'] == 'series')
                        {
                            $tmp = array(
                                'title'=> $result['Title'],
                                'year'=> $result['Year'],
                                'imdbID'=> $result['imdbID'],
                                'type'=> $result['Type'],
                                'imdbURL' => $this->urlIMDbDetail.$result['imdbID']
                            );

                            $dataToReturn[] = $tmp;
                        }
                    }
                }

                $this->cache[$md5] = $dataToReturn;
                return $dataToReturn;
            }
        }
        
    }
    
    /**
     * get info about a movie
     * 
     * @param type $config array(title, year, imdbId)
     * @return array info
     */
    public function get($config)
    {        
        $urlComplete = $this->url."?r=JSON";

        if(!empty($config['title']))
        {
            $urlComplete .= "&t=".urlencode($config['title']);
        }
        if(!empty($config['year']))
        {
            $urlComplete .= "&y=".$config['year'];
        }
        if(!empty($config['imdbId']))
        {
            $urlComplete .= "&i=".$config['imdbId'];
        }

        $md5 = md5($urlComplete);
        
        if(!empty($this->cache[$md5]))
        {
            return $this->cache[$md5];
        }
        else
        {
            $dataToReturn = array();
            $data = HTTP::get($urlComplete, "", true);

            if($data === false)
            {
                ErrorPerso::add('Error during decoding json from OMDb url "'.$urlComplete.'"');
            }
            else
            {
                if(!empty($data['Response']) && $data['Response'] == "True")
                {
                    $dataToReturn = array(
                        'title' => $data['Title'],
                        'year' => $data['Year'],
                        'runtime' => $data['Runtime'],
                        'genre' => $data['Genre'],
                        'director' => $data['Director'],
                        'writer' => $data['Writer'],
                        'actors' => $data['Actors'],
                        'plot' => $data['Plot'],
                        'country' => $data['Country'],
                        'language' => $data['Language'],
                        'poster' => $data['Poster'],
                        'metascore' => $data['Metascore'],
                        'imdbRating' => $data['imdbRating'],
                        'imdbVotes' => $data['imdbVotes'],
                        'imdbID' => $data['imdbID'],
                        'type' => $data['Type'],
                        'imdbUrl' => $this->urlIMDbDetail.$data['imdbID']
                    );
                }

                $this->cache[$md5] = $dataToReturn;
                return $dataToReturn;
            }
        }
        
    }
}