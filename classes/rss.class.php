<?php
/*
Examples of use :
$addr1 = 'http://feeds.bbci.co.uk/sport/0/football/rss.xml';
$addr2 = 'http://feeds.howtogeek.com/HowToGeek';
$addr3 = 'http://feeds.feedburner.com/TheEdTechie';

$rss = new rss;
$rss->addFeed($addr1);
$rss->addFeed($addr2);
$rss->addFeed($addr3);

$arr = $rss->getFeed();
or
$arr = $rss->getFeed('video');
or
$searchArray = Array('pitches', 'dilemm');
$arr = $rss->getFeed($searchArray);

foreach($arr as $row)
{
	echo $row->title.'-'.$row->pubDate.'<br />';
}
*/
class rss
{
	public $addr = NULL;
	private $outArr = Array();
	function __construct($addr = NULL)
	{
		$this->addr = $addr != NULL ? $addr : $this->addr;
		if($this->addr)
		{
			return $this->addFeed();	
		}		
	}

	function addFeed($addr = NULL)
	{
		$this->addr = $addr != NULL ? $addr : $this->addr;
		$rss = simplexml_load_file($this->addr);
		$this->outArr = array_merge($this->outArr, $rss->xpath('/rss//item'));
	}	

	function getFeed($input = NULL)
	{
		usort($this->outArr, function ($x, $y)
		{
			if (strtotime($x->pubDate) == strtotime($y->pubDate)) return 0;
    		return (strtotime($x->pubDate) > strtotime($y->pubDate)) ? -1 : 1;		
		});

		if(is_array($input))
		{
			$this->outArr = $this->getArrayFilteredFeed($input);
		}
		elseif(is_string($input))
		{
			$this->outArr = $this->getStringFilteredFeed($input);
		}

		return $this->outArr;
	}

	private function getStringFilteredFeed($s)
	{
		$tempArr = Array();
		foreach($this->outArr as $row)
		{
			if(stristr($row->title,$s) || stristr($row->description,$s))
			{
				array_push($tempArr, $row);
			}
		}
		return $tempArr;
	}

	private function getArrayFilteredFeed($arr)
	{
		$tempArr = Array();
		foreach($this->outArr as $row)
		{
			foreach ($arr as $key) 
			{
				if(stristr($row->title,$key) || stristr($row->description,$key))
				{
					array_push($tempArr, $row);
				}
			}
		}
		return $tempArr;
	}
}
new rss;
?>