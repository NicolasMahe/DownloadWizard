<?php

class ImageController {
    public function getBase64() {
        $url = Request::get('url');
        
        if(!empty($url)) {
            $data = file_get_contents($url);
            
            header("Content-type: image/jpeg");
            echo $data;
            die();
        }
        else
        {
            ErrorPerso::add('url is empty');
        }
    }
}
