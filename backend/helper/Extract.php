<?php

class Extract
{
    static private $fileExtensionToCopy = array('mkv', 'avi', 'mp4');
    
    static public function archiveInPath($path, $to)
    {
        Log::add('extact', 'archiveInPath', 'start', 'Extraction start from "'.$path.'" to "'.$to.'"');
        foreach (glob($path."/*.rar") as $filename) {
            exec("7z e '".$filename."' -o'".$to."'");
        }
        foreach(self::$fileExtensionToCopy as $extension) {
            foreach (glob($path."/*.".$extension) as $filename) {
                exec("cp '".$filename."' '".$to."'");
            }
        }
        Log::add('extact', 'archiveInPath', 'success', 'Extraction finish');
    }
}