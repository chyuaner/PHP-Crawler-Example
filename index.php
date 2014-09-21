<?php
require 'vendor/autoload.php';
require 'lib/BankExchange/Fubon.php';
use \Curl\Curl;
use Parse\ParseClient;
use Parse\ParseObject;

//$fubon = new Fubon();
//$fubon->getRemoteData();
//$fubonData = $fubon->getData();
//
//
//foreach($fubonData as $key => $val) {
//    
//    $outputJsonArray = array();
//    $outputJsonArray = array(
//        'currency'        => $val['currencyId'],
//        'bankId'          => $fubon->getBankIdString(),
//        'bankName'        => $fubon->getBankName(),
//        'time'            => $fubon->getGetDate(),
//        'sellSpotRate'    => $val['sellSpotRate'],
//        'sellSorwardRate' => $val['sellSorwardRate'],
//        'buySpotRate'     => $val['buySpotRate'],
//        'buySorwardRate'  => $val['buySorwardRate']
//    );
//    
//    // 輸出結果
//    echo json_encode($outputJsonArray);
//    
//    
//    
//}

// 餵資料

//$data = '{ "currency": "1","bankId": "","bankName": "","time": "2014-01-10 10:00:00","sellSpotRate": "30.2700", "sellSorwardRate": "30.4150", "buySpotRate": "30.2700", "buySorwardRate": "30.4150"}';
//
//echo $data;
//
//$curl = new Curl();
//$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
//$curl->setOpt(CURLOPT_POSTFIELDS, $data);
//$curl->setHeader('Content-Type', 'application/json; charset=utf-8');
//
//$curl->setHeader('X-Parse-Application-Id', 'dIdNgGQH7JGnbkoYwZgFrve7m4zQd2elGoOBS89k');
//$curl->setHeader('X-Parse-REST-API-Key',   'DN90uVnGbPY5d8Vj60Ylb4ioyHw8ZZuOOy8KEhDO');
//$curl->post('https://api.parse.com/1/classes/exchangeRate');
//
//
//if ($curl->error) {
//    echo 'Error: ' . $curl->error_code . ': ' . $curl->error_message;
//}
//else {
//    echo $curl->response;
//}


ParseClient::initialize('dIdNgGQH7JGnbkoYwZgFrve7m4zQd2elGoOBS89k', 'DN90uVnGbPY5d8Vj60Ylb4ioyHw8ZZuOOy8KEhDO', '1l7jPI12pbBjVeCqKMmyBlGhqHYqJqPGekixEEsX');

$testObject = ParseObject::create("exchangeRate");
$testObject->set("currency", "1");
$testObject->set("bankId", "");
$testObject->set("bankName", "1");
$testObject->set("time", "2014-01-10 10:00:00");
$testObject->set("sellSpotRate", "123");
$testObject->set("sellSorwardRate", "123");
$testObject->set("buySpotRate", "123");
$testObject->set("buySorwardRate", "123");
$testObject->save();