<?php

class MetaController
{
    public function get()
    {
        $title = Request::get('title');
        $year = Request::get('year');
        $imdbId = Request::get('imdbID');
        //$serieSaison = Request::get('serieSaison');
        //$serieEpisode = Request::get('serieEpisode');
        
        $dataSearch = array();
        $omdbResult = array();
        
        if(!empty($title)) {
            $dataSearch['title'] = $title;
        }
        if(!empty($year)) {
            $dataSearch['year'] = $year;
        }
        if(!empty($imdbId)) {
            $dataSearch['imdbId'] = $imdbId;
        }
        
        if(!empty($dataSearch)) {
            //check OMDb info
            $meta = new Meta('OMDb');
            
            $omdbResult = $meta->get($dataSearch);
        }
        
        if(!empty($omdbResult))
        {
            Response::setStatus('success');
            Response::setData($omdbResult);
        }
        else
        {
            Response::setStatus('error');
        }
    }
    
    public function search()
    {
        $search = Request::get('search');
        
        $omdbResult = array();
        
        if(!empty($search)) {
            //check OMDb info
            $meta = new Meta('OMDb');
            
            $omdbResult = $meta->search($search);
        }
        
        Response::setStatus('success');
        Response::setData($omdbResult);
    }
}