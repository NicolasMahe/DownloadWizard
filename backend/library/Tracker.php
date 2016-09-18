<?php

class Tracker
{
	private $tracker = null;

	function __construct($tracker)
	{
		if(!empty($tracker))
		{
			$trackerFile = Config::get('trackerPath').'/'.$tracker.'.php';
			$fileExists = file_exists($trackerFile);
			
			if($fileExists)
			{
				include_once($trackerFile);
				$this->tracker = new $tracker();
				
				$methodExistsSearch = method_exists($this->tracker, 'search');
				$methodExistsDownload = method_exists($this->tracker, 'download');
			
				if(!$methodExistsSearch)
				{
					ErrorPerso::add('tracker method search do not exist');
					$this->tracker = null;
					return;
				}
				else if(!$methodExistsDownload)
				{
					ErrorPerso::add('tracker method download do not exist');
					$this->tracker = null;
					return;
				}
			}
			else
			{
				ErrorPerso::add('tracker "'.$tracker.'" is unknown');
			}
		}
		else
		{
			ErrorPerso::add('tracker is empty');
		}
	}
	
	function search($search)
	{
		if($this->tracker)
		{
			$data = $this->tracker->search($search);
                        
                        foreach ($data as &$result) {
                            //recognize title
                            $result['recognize'] = Recognize::title($result['title']);
                        }
				
			return $data;
		}
		
		return;
	}
	
	function download($url)
	{
		if($this->tracker)
		{
			list($data, $filename) = $this->tracker->download($url);
			
			if(!empty($data))
			{
				$resultFilePutContent = Storage::write(Config::get('trackerDownloadPath').'/'.$filename, $data, false);
		
				if($resultFilePutContent)
				{
                    $torrent = new TorrentModel();
                    $torrent->addWithFilename($filename);

					Log::add('tracker', 'download', 'success', 'Torrent successfully added: "'.$filename.'"');
					
					return true;
				}
				else
				{
					Log::add('tracker', 'download', 'error', 'Error during writing torrent: "'.$filename.'"');
					ErrorPerso::add('Error during writing torrent: "'.$filename.'"');
				}
			}
			else
			{
				Log::add('tracker', 'download', 'error', 'Download failed data are empty for torrent: "'.$filename.'"');
				ErrorPerso::add('Download failed, data are empty');
			}
		}
					
		return false;
		
	}
}
