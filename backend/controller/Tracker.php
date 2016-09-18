<?php

class TrackerController
{
	public function getall()
	{
		$scandir = scandir(Config::get('trackerPath'));
		
		$data = array();
		foreach($scandir as $trackerFile)
		{
			$file = Config::get('trackerPath').'/'.$trackerFile;
			$pathinfo = pathinfo($file);
			
			if($pathinfo['extension'] == 'php' && strpos($pathinfo['basename'], '.') > 1)
			{
				include_once($file);
				
				$trackerName = $pathinfo['filename'];
				
				$tracker = new $trackerName();
				
				$data[] = $tracker->config;
			}
		}
	
		Response::setStatus('success');
		Response::setData($data);
	}
    
    public function search()
	{
		$search = Request::get('search');
		$tracker = Request::get('tracker');
		
		if(!empty($search) && !empty($tracker))
		{
            $tracker = new Tracker($tracker);

            $data = $tracker->search($search);
                    
            Response::setStatus('success');
            Response::setData($data);
		}
		else
		{
			ErrorPerso::add('search and/or tracker is empty');
		}
	}
	
	public function download()
	{
            $url = Request::get('url');
            $tracker = Request::get('tracker');

            if(!empty($url) && !empty($tracker))
            {
                $tracker = new Tracker($tracker);
                $retour = $tracker->download($url);

                if($retour)
                    Response::setStatus('success');
                else
                    Response::setStatus('error');
            }
            else
            {
                ErrorPerso::add('url and/or filename and/or tracker is empty');
            }
	}
}