<?php

class CronController
{
    public function doit()
    {
        $cron = new Cron();
        $data = $cron->doIt();

        Response::setStatus('success');
        Response::setData($data);
    }
    
    public function getLastFetch()
    {
        $cron = new Cron();
        $data = $cron->getLastFetch();

        Response::setStatus('success');
        Response::setData($data);
    }

    public function extractFileAndDownloadSub()
    {
        $cron = new Cron();
        
        $filepath = Request::get('filepath');
        $name = Request::get('name');

        if(!empty($filepath) && !empty($name)) {
            $data = $cron->extractFileAndDownloadSub($filepath, $name);

            Response::setStatus('success');
            Response::setData($data);
        } else {
            Error::add('hash is empty');
            Response::setStatus('error');
        }
    }
}