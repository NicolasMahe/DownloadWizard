<?php

class PlayerController
{
    public function play()
    {
        $player = new Player();
        
        $filepath = Request::get('filepath');

        if(!empty($filepath)) {
            $data = $player->play($filepath);

            Response::setStatus('success');
        } else {
            ErrorPerso::add('filepath is empty');
            Response::setStatus('error');
        }
    }
}