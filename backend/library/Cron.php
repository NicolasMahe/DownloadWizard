<?php

class Cron
{
	public function doIt()
	{
		function cmp($a, $b) {
		    if ($a['completed'] == $b['completed']) {
		        return 0;
		    }
		    return ($a['completed'] > $b['completed']) ? -1 : 1;
		}

        $returnArray = array();

        $watchlist = new Table('watchlist');
        $watchlistData = $watchlist->getAll();

		foreach($watchlistData as $watch)
		{

			if(((!$watch['isDownloaded'] || (!empty($watch['nextSeason']) && !empty($watch['nextEpisode']))) && !empty($watch['tracker'])) && (isset($watch['isActive']) && $watch['isActive']))
			{
				//construct search
				$search = $watch['name'];

				if(!empty($watch['nextSeason']) && !empty($watch['nextEpisode']))
					$search .= " S".sprintf("%02s", $watch['nextSeason'])."E".sprintf("%02s", $watch['nextEpisode']);

				if(!empty($watch['quality']))
					$search .= " ".$watch['quality'];

				if(!empty($watch['ripType']))
					$search .= " ".$watch['ripType'];



				//do search on appropriate tracker
				$tracker = new Tracker($watch['tracker']);
				$data = $tracker->search($search);

				//sort array by completed
				usort($data, 'cmp');

				if(count($data) > 0)
				{
					$itemToDl = null;
					//check for files number
					if (isset($watch['files']) && $watch['files'] > 0) {
						foreach ($data as $item) {
							if ($item['files'] <= $watch['files']) {
								//ok
								$itemToDl = $item;
								break;
							}
						}
					}
					else {
						//take the first
						$itemToDl = $data[0];
					}

					if ($itemToDl != null) {
						//found


						$returnArray[] = 'Match for "'.$search.'"';

						Log::add('cron', 'match', 'A torrent match the search: "'.$search.'", torrent: "'.$itemToDl['title'].'"');

						$result = $tracker->download($itemToDl['downloadLink']);

						if($result)
						{
							//delete from watchlistCopy
							$watch['isDownloaded'] = true;
							$watch['dateDownloaded'] = date("Y-m-d H:i:s");

							if(!empty($watch['nextSeason']) && !empty($watch['nextEpisode']))
							{
								$watch['nextEpisode']++;
							}

	                        $retour = $watchlist->update($watch);

	                        if(!$retour)
	                        {
	                            Error::add('error during update cron watchlist item');
	                            Response::setStatus('error');
	                        }

							Log::add("cron", "fetch", "success", "New torrent add : '".$itemToDl['title']."'");
							//send a mail to notify
							/*mail(
								'nicolas@mahe.me',
								'Caprica Download Wizard - Download added',
								'Hello Nicolas,\n\r\n\ra new torrent has been added to your torrent client.\n\r\n\rSearch: "'.$search.'"\n\r\n\rTorrent: "'.$itemToDl['title'].'"'
							);*/
						}

					}
				}
				else
				{
					//no match
					$returnArray[] = 'No match for "'.$search.'"';
				}
			}
		}

		$writeData['lastFetch'] = date("Y-m-d H:i:s");

		Storage::write(Config::get('storagePathCron'), $writeData, true);

		return $returnArray;
	}

    public function getLastFetch()
    {
        $data = Storage::read(Config::get('storagePathCron'), true);

        if($data['lastFetch'])
        {
            return $data['lastFetch'];
        }
    }

    public function extractFileAndDownloadSub($filepath, $name)
    {
        $pathTo = Recognize::pathToSave($name);


        $subtitle = new Subtitle('OpenSubtitles');
        $retourSub = $subtitle->downloadFirst($name);

        Extract::archiveInPath($filepath.'/'.$name, $pathTo);

        if($retourSub == true) {
            Log::add("cron", "extract", "success", "Cron extract for file '".$name."' success");
        } else {
            Log::add("cron", "extract", "error", "Cron extract error during downloading subtitle for file '".$name."' but extraction is okay :)");
        }
    }
}
