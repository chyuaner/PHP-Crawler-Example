<?php
require 'vendor/autoload.php';
use Symfony\Component\DomCrawler\Crawler;

// 取得網頁資料
function getHtml($url) {
    // http://stackoverflow.com/questions/14105471/php-curl-crawler-doesnt-fetch-all-data

    $ch = curl_init ();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)'); 
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

$targetHtml = getHtml('https://ebank.taipeifubon.com.tw/ibank/servlet/HttpDispatcher/Accessibility/ExRateToday?newTxRequest=true');

// 使用Symfony的DomCrawler，擷取HTML資料，原始編碼為BIG5
$crawler = new Crawler();
$crawler->addHtmlContent($targetHtml, 'BIG5');

// 擷取網頁的其中部分（條件為CSS選擇器寫法）
$crawlerF = $crawler->filter('#___01 table tr:nth-child(2) table tr:nth-child(n+3) td');

// 分析表格內容，製作成陣列
$data_pre = array();
foreach ($crawlerF as $domElement) {
    array_push($data_pre, trim($domElement->nodeValue));
}
//echo '<pre>'; print_r( $data_pre ); echo '</pre>';

$data = array();
for($i=0; $i<count($data_pre)/5; $i++) {
    $data[$i] = array();
    
    for($j=0; $j<5; $j++) {
        if( $data_pre[$i*5 +$j] == '---' ) {
            $data[$i][$j] = null;
        }
        else {
            $data[$i][$j] = $data_pre[$i*5 +$j];
        }
    }
}
echo '<pre>'; print_r( $data ); echo '</pre>';
