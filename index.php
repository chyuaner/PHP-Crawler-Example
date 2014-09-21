<?php
require 'vendor/autoload.php';
require 'lib/BankExchange/Fubon.php';

$fubon = new Fubon();
$fubon->getRemoteData();
$fubonData = $fubon->getData();


foreach($fubonData as $key => $val) {
    
    $outputJsonArray = array();
    $outputJsonArray = array(
        'currency'        => $val['currencyId'],
        'bankId'          => $fubon->getBankIdString(),
        'bankName'        => $fubon->getBankName(),
        'time'            => $fubon->getGetDate(),
        'sellSpotRate'    => $val['sellSpotRate'],
        'sellSorwardRate' => $val['sellSorwardRate'],
        'buySpotRate'     => $val['buySpotRate'],
        'buySorwardRate'  => $val['buySorwardRate']
    );
    
    echo '<pre>'.json_encode($outputJsonArray).'</pre>';
}