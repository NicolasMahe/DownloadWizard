<?php

class NetworkMonitorController
{
    public function importFromCron()
    {
        $data = NetworkMonitor::importFromCron();

        Response::setStatus('success');
        Response::setData($data);
    }
    public function get()
    {
        $data = NetworkMonitor::get();

        Response::setStatus('success');
        Response::setData($data);
    }
}