<meta charset="utf-8">
<?php

$string = file_get_contents("http://varzesh3.ir");
libxml_use_internal_errors(true);
$dom = new DOMDocument();
$dom->loadHTML($string);
libxml_use_internal_errors(false);

$query = '//div[@id="footballnewsbox"]/div[@class="inbdata"]/div[@class="mCSB_2"]/div[@class="mCSB_2_container"]/ul/li/p/a[@class="small-news-link"]';
$xpath = new DOMXpath($dom);
$result = $xpath->query($query);
if($result->length > 0) {
    echo $result->item(0)->nodeValue;
}


?>