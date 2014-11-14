<?php

class SubtitleController
{
    public function search()
    {
        $search = Request::get('search');
        
        $result = array();
        
        if(!empty($search)) {
            $subtitle = new Subtitle('OpenSubtitles');
            
            $result = $subtitle->search($search);
            
            Response::setStatus('success');
            Response::setData($result);
        } else {
            Error::add("search is empty");
            Response::setStatus('error');
        }
        
    }
    
    public function downloadFirst()
    {
        $search = Request::get('search');
        
        $result = array();
        
        if(!empty($search)) {
            $subtitle = new Subtitle('OpenSubtitles');
            
            $result = $subtitle->downloadFirst($search);
            
            if($result == true) {
                Response::setStatus('success');
            } else {
                Response::setStatus('error');
            }
        } else {
            Error::add("search is empty");
            Response::setStatus('error');
        }
    }
}