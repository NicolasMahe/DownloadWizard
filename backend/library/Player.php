<?php

class Player
{    
    public function play($filepath)
    {
        exec("vlc '".$filepath."'", $output, $vars);
        print_r($output);
    }
}