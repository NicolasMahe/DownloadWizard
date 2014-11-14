<?php

class NetworkMonitorController
{
    public function get()
    {
        $data = NetworkMonitor::get();

        Response::setStatus('success');
        Response::setData($data);
    }
}