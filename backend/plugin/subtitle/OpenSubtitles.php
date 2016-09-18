<?php

class OpenSubtitles
{
    const API_URL = 'http://api.opensubtitles.org/xml-rpc';
    
    private $token = null;
    
    /**
     * get token
     * @return string token
     */
    private function getToken()
    {
        if(!empty($this->token)) {
            return $this->token;
        }
        
        $response = HTTP::post(self::API_URL, array("", "", "", 'OS Test User Agent'), "", false, "LogIn");
        
        if (empty($response['status']) || $response['status'] != '200 OK') {
            ErrorPerso::add("OpenSubtitles: login failed");
        } else {
            $this->token = $response['token'];
            return $this->token;
        }
    }
    
    /**
     * search subtitles
     * @param string $searchValue
     * @return array data
     */
    public function search($searchValue)
    {
        $response = HTTP::post(self::API_URL,
                array(
                    $this->getToken(),
                    array(
                        array('query' => $searchValue, 'sublanguageid'=>'eng') //, 'season' => 1, 'episode' => 1, )
                    )
                ),
                "", false, "SearchSubtitles");
        
        if($response['status'] != '200 OK') {
            ErrorPerso::add("OpenSubtitles: search failed");
        }
        else {
            if(!empty($response['data'])) {
                
                $retour = array();
                
                foreach ($response['data'] as $key => $data) {
                    $retourTmp = array(
                        'filename' => $data['SubFileName'],
                        'movie' => $data['MovieName'],
                        'downloadLink' => $data['SubDownloadLink'],
                        'detailLink' => $data['SubtitlesLink'],
                        'language' => $data['SubLanguageID'],
                    );
                    $retour[] = $retourTmp;
                }
                
                return $retour;
            }
        }
        
        return array();
    }
    
    /**
     * download a subtitle
     * @param string $name
     * @param string $url
     * @param string $releaseName
     * @return boolean success
     */
    public function download($name, $url, $releaseName)
    {
        if($releaseName) {
            $pathinfo = pathinfo($filepath);
            $pathToFile = Recognize::pathToSave($name).$releaseName.".srt";
        } else {
            $pathToFile = Recognize::pathToSave($name).$name.".srt";
        }
        
        $subtitleContent = HTTP::get($url, null, false, true);
        
        if(!empty($subtitleContent)) {
            Storage::write($pathToFile, $subtitleContent, false);
            
            return true;
        }
        else {
            ErrorPerso::add("OpenSubtitles download failed: file is empty");
        }
        
        return false;
    }
}