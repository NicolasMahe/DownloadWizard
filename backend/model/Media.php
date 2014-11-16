<?php

class MediaModel
{
    protected $table;
    
    function __construct()
    {
        $this->table = new Table("media");
    }
    
    public function addWithReleaseName($name)
    {
        if(!empty($name)) {
            //recognize name
            $recognize = Recognize::title($name);
            
            if(!empty($recognize['title']) && !empty($recognize['year'])) {
                $media = $this->get($recognize['title'], $recognize['year']);
                if($media) {
                    return $media;
                } else {
                    //media doesn't exist
                    
                    //get meta
                    $metaO = new Meta('OMDb');
                    $meta = $metaO->get(array('title' => $recognize['title'], 'year' => $recognize['year']));

                    return $this->addWithMeta($meta);
                }
            }
        }
        
        return null;
    }
    
    public function addWithMeta($meta)
    {
        if(!empty($meta) && !empty($meta['title']) && !empty($meta['year'])) {
            $media = $this->get($meta['title'], $meta['year']);
            if($media) {
                return $media;
            } else {
                //media doesn't exist
                //download poster
                $metaO = new Meta('OMDb');
                $meta['posterLocal'] = $metaO->downloadPoster($meta);

                //add it
                return $this->table->add($meta);
            }
        }
        
        return null;
    }
    
    public function get($title, $year)
    {
        if(!empty($title)) {
            $libraryList = $this->table->getAll();
            foreach ($libraryList as $item) {
                if($item['title'] == $title && $item['year'] == $year) {
                    return $item;
                }
            }
        }
        return null;
    }
}