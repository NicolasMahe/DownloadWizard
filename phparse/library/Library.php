<?php

class Library extends Table
{
    function __construct()
    {
        parent::__construct("library");
    }
    
    
    public function listMovie()
    {
        $mediaExtension = Config::get('mediaExtension');
        $path = Config::get('libraryMovies');
        
        $data = array();
        foreach($mediaExtension as $extension) {
            foreach (glob($path."/*.".$extension) as $filepath) {
                $pathinfo = pathinfo($filepath);
                $recognize = Recognize::title($pathinfo['filename']);
                if(!empty($recognize['title'])) {
                    $data[] = array(
                        "filepath" => $filepath,
                        "extension" => $extension,
                        "path" => $path,
                        "name" => $pathinfo['filename'],
                        "recognize" => $recognize
                    );
                }
            }
        }
        
        return $data;
    }
    
    public function listTVShows()
    {
        $mediaExtension = Config::get('mediaExtension');
        $path = Config::get('libraryTVShows');
        
        $data = array();
        foreach (glob($path."/*") as $path) {
            $dataFolder = array();
            foreach($mediaExtension as $extension) {
                foreach (glob($path."/*.".$extension) as $filepath) {
                    $pathinfo = pathinfo($filepath);
                    $dataFolder[] = array(
                        "filepath" => $filepath,
                        "extension" => $extension,
                        "path" => $path,
                        "name" => $pathinfo['filename'],
                        "recognize" => Recognize::title($pathinfo['filename'])
                    );
                }
            }
            if(!empty($dataFolder)) {
                $pathinfo = pathinfo($path);
                $data[] = array(
                    "name" => $pathinfo['filename'],
                    "files" => $dataFolder
                );
            }
        }
        
        return $data;
    }
}
