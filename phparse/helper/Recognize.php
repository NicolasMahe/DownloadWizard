<?php

class Recognize
{
    public static function title($search)
    {
        $title = "";
        $year = "";
        $qualityFull = "";
        $hd = "";
        $rip = "";
        $is3d = "";
        $hosting = "";
        $serieSaison = "";
        $serieEpisode = "";
                
                
        $search = str_replace("." , " ", $search);
        
        preg_match( '/S([0-9]{2})E([0-9]{2})/i',
                    $search, $serie);
        if(!empty($serie)) {
            $serieSaison = $serie[1];
            $serieEpisode = $serie[2];
        }
        
        if($serieSaison)
        {
            preg_match( '/^(.+)S[0-9]{2}E[0-9]{2}(.+)$/i',
                    $search, $matches);
            
            if(!empty($matches)) {
                $title = trim(str_replace(" 3D ", "", $matches[1]));
                $year = "";
                $qualityFull = trim($matches[2]);
                $hosting = "";
            }
        }
        else
        {
            preg_match( '/^(\[.+\])?(.+)((19|20)[0-9]{2})(.+)$/i',
                    $search, $matches);
            if(!empty($matches)) {
                $title = trim(trim(str_replace(" 3D ", "", $matches[2])), '() ');
                $year = $matches[3];
                $qualityFull = trim(trim($matches[5]), '() ');
                $hosting = trim($matches[1]);
            }
        }
        
        preg_match( '/(1080p|720p)/i',
                    $search, $matchesHd);
        if(!empty($matchesHd)) {
            $hd = $matchesHd[1];
        }
        
        preg_match( '/(BluRay|WEB-DL|HDTV|WEBRIP|BDRIP|BRRIP)/i',
                    $search, $matchesRip);
        if(!empty($matchesRip)) {
            $rip = $matchesRip[1];
        }
        
        preg_match( '/(3D)/i',
                    $search, $matches3D);
        if(!empty($matches3D)) {
            $is3d = $matches3D[1];
        }
                
        return array(
            "title" => $title,
            "year" => $year,
            "qualityFull" => $qualityFull,
            "hd" => $hd,
            "rip" => $rip,
            "is3d" => $is3d,
            "hosting" => $hosting,
            "serieSaison" => $serieSaison,
            "serieEpisode" => $serieEpisode
        );
    }
    
    public static function pathToSave($name)
    {
        $recognize = self::title($name);

        $pathTo = Config::get('libraryOthers')."/";

        if(!empty($recognize['serieEpisode']) && !empty($recognize['serieSaison']) && !empty($recognize['title'])) {
            $title = ucwords($recognize['title']);
            $pathTo = Config::get('libraryTVShows')."/".$title."/";
        } else if(!empty($recognize['title'])) {
            $pathTo = Config::get('libraryMovies')."/";
        }
        
        return $pathTo;
    }
}
