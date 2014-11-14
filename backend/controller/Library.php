<?php

class LibraryController
{
    public function listMovie()
    {
        $meta = new Library();

        $data = $meta->listMovie();

        Response::setStatus('success');
        Response::setData($data);
    }
    public function listTVShows()
    {
        $meta = new Library();

        $data = $meta->listTVShows();

        Response::setStatus('success');
        Response::setData($data);
    }
}