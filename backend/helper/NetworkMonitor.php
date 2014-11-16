<?php

class Networkmonitor
{
    public static function importFromCron()
    {
        $download = 0;
        $upload = 0;
                            
        //$data = Storage::read(Config::get("storagePathNetworkMonitorCronExport"), false);
        
        $data = Storage::read("/proc/net/dev", false);
        
        $data = preg_replace('/( )+/',' ',$data);
        $arr = explode("\n", $data);
        foreach($arr as $line)
        {
            $process = explode(" ", $line);
            if(isset($process[2]) && isset($process[10]) && !empty($process[1])) {
                if($process[1] == "eth1:") {
                    $download = $process[2];
                    $upload = $process[10];
                }
            }
        }
        
        //get
        $tableCron = new Table("networkMonitorCron");
        $cronData = $tableCron->get(1);
        $downloadOld = $cronData['download'];
        $uploadOld = $cronData['upload'];
        
        //calculate
        $uploadConso = $upload - $uploadOld; //Bytes
        $downloadConso = $download - $downloadOld;
        
        if($uploadConso > 0 && $downloadConso > 0) {
            //add calculate date
            $table = new Table("networkMonitor");
            $table->add(array(
                "uploadConso" => $uploadConso,
                "downloadConso" => $downloadConso
            ));
        }
        
        //update
        $cronData['download'] = $download;
        $cronData['upload'] = $upload;
        $tableCron->update($cronData);
    }
    
    public static function get()
    {
        $table = new Table("networkMonitor");
        return $table->getAll();
    }
}