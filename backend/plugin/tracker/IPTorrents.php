<?php

class IPTorrents
{
	public $config = array(
		"name" => "IPTorrents",
		"urlSearch" => "http://www.iptorrents.com/t?qf=&q=",
		"url" => "http://www.iptorrents.com"
	);

    /**
     * search a value
     * @param string $search
     * @return array
     */
	public function search($search)
	{
		$url = $this->config['urlSearch'].urlencode($search);

		$resultArray = array();

        $contentToParse = HTTP::get($url, Config::get("trackerIPTorrentsHeader"));

		if($contentToParse)
		{
			$domParser = str_get_html($contentToParse);


			foreach($domParser->find('table[id=torrents] tr') as $result)
			{
				$detailLink = !empty($result->find('a.t_title', 0)) ? $result->find('a.t_title', 0)->href : "";
				$title = !empty($result->find('a.t_title', 0)) ? $result->find('a.t_title', 0)->innertext : "";
				$downloadLink = !empty($result->find('a', 3)) ? $result->find('a', 3)->href : "";
				$size = !empty($result->find('td', 5)) ? $result->find('td', 5)->innertext : "";
				$files = !empty($result->find('td', 6)) ? $result->find('td', 6)->find('a', 0)->innertext : "";
				$completed = !empty($result->find('td', 7)) ? $result->find('td', 7)->innertext : "";
				$seeders = !empty($result->find('td.t_seeders', 0)) ? $result->find('td.t_seeders', 0)->innertext : "";
				$leechers = !empty($result->find('td.t_leechers', 0)) ? $result->find('td.t_leechers', 0)->innertext : "";

				if(!empty($title))
				{
					$resultArray[] = array(
						"title" => $title,
						"detailLink" => $this->config['url'].$detailLink,
						"downloadLink" => $this->config['url'].$downloadLink,
						"size" => $size,
						"completed" => $completed,
						"seeders" => $seeders,
						"leechers" => $leechers,
						"files" => $files
					);
				}
			}

			array_splice($resultArray, 0, 1);
		}
		else
		{
			Error::add("error get content of '".$url."'");
		}

		return $resultArray;
	}

    /**
     * download a torrent
     * @param string $fileToDownload
     * @return array
     */
	public function download($fileToDownload)
	{
		$url = str_replace(' ', '.', $fileToDownload);

        $torrentfile = HTTP::get($url, Config::get("trackerIPTorrentsHeader"));

		if(!empty($torrentfile))
		{
			$downloadFile = pathinfo($fileToDownload);

			return array($torrentfile, $downloadFile['basename']);
		}
		else
		{
			Error::add('Download failed, data are empty');
		}
	}
}
