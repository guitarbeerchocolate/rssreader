<?php
require_once 'classes/autoload.php';

$addr1 = 'http://feeds.bbci.co.uk/sport/0/football/rss.xml';
$addr2 = 'http://feeds.howtogeek.com/HowToGeek';
$addr3 = 'http://feeds.feedburner.com/TheEdTechie';

$rss = new rss;
$rss->addFeed($addr1);
$rss->addFeed($addr2);
$rss->addFeed($addr3);
// $arr = $rss->getFeed();

// $arr = $rss->getStringFilteredFeed('video');
$arr = $rss->getFeed('video');

// $searchArray = Array('pitches', 'dilemm');

// $arr = $rss->getArrayFilteredFeed($searchArray);
// $arr = $rss->getFeed($searchArray);

foreach($arr as $row)
{
	echo $row->title.'-'.$row->pubDate.'<br />';
}
?>