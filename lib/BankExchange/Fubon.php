<?php
use \Curl\Curl;
use Symfony\Component\DomCrawler\Crawler;

class Fubon {
    
    private $bankId = 12;
    private $bankName = 'Fubon';
    private $url = 'https://ebank.taipeifubon.com.tw/ibank/servlet/HttpDispatcher/Accessibility/ExRateToday?newTxRequest=true';
    
    
    private $getDate;
    private $dataUpdateDate;
    private $rateData;
    
    public function getRemoteHtml() {
        $curl = new Curl();
        $curl->setOpt(CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1');
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $curl->get($this->url);
        
        $this->getDate = date('Y-m-d H:i:s');
        
        if ($curl->error) {
            return 'Error: ' . $curl->error_code . ': ' . $curl->error_message;
        }
        else {
            return $curl->response;
        }
    }
    
    public function getRemoteData() {
        $targetHtml = $this->getRemoteHtml();
        
        // 使用Symfony的DomCrawler，擷取HTML資料，原始編碼為BIG5
        $crawler = new Crawler();
        $crawler->addHtmlContent($targetHtml, 'BIG5');

        //擷取網頁的更新時間
        $crawlerUpdateDate = $crawler->filter('#___01 table tr:nth-child(2) table tr:nth-child(n+3) td');
        
        
        // 擷取網頁的表格匯率部分（條件為CSS選擇器寫法）
        $crawlerTable = $crawler->filter('#___01 table tr:nth-child(2) table tr:nth-child(n+3) td');
        
        // 分析表格內容，製作成陣列
        $data_pre = array();
        foreach ($crawlerTable as $domElement) {
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
            
            // 建立語意的ID名稱
            $data[$i]['currencyId'] = $this->fillCurrencyId($data[$i][0]);
            $data[$i]['name'] = $data[$i][0];
            $data[$i]['buySpotRate'] = $data[$i][1];
            $data[$i]['sellSpotRate'] = $data[$i][2];
            $data[$i]['buySorwardRate'] = $data[$i][3];
            $data[$i]['sellSorwardRate'] = $data[$i][4];
            
        }
        
        $this->rateData = $data;
        return $data;
    }
    
    private function fillCurrencyId($name) {
        switch($name) {
            case '美金(USD)':
                return 1;
                break;
            
            case '日圓(JPY)':
                return 4;
                break;
            case '英鎊(GBP)':
                return 3;
                break;
            /*case '瑞士法郎(CHF)':
                // TODO: id
                return 0;
                break;*/
            case '澳幣(AUD)':
                return 7;
                break;
            case '港幣(HKD)':
                return 2;
                break;
            /*case '新加坡幣(SGD)':
                return 1;
                break;*/
            /*case '加拿大幣(CAD)':
                return 1;
                break;*/
            case '歐元(EUR)':
                return 5;
                break;
            /*case '南非幣(ZAR)':
                return 1;
                break;*/
            /*case '瑞典幣(SEK)':
                return 1;
                break;*/
            /*case '紐西蘭幣(NZD)':
                return 1;
                break;*/
            case '泰國銖(THB)':
                return 8;
                break;
            case '人民幣(CNY)':
                return 6;
                break;
            default: 
                return null;
                break;
        }
    }
    
    // ------------------------------------------------------------------------
    
    public function getBankId() {
        return $this->bankId;
    }
    
    public function getBankIdString() {
        return str_pad($this->bankId, 3, '0', STR_PAD_LEFT);
    }
    
    public function getBankName() {
        return $this->bankName;
    }
    
    public function getGetDate() {
        return $this->getDate;
    }
    
    public function getDataUpdateDate() {
        return $this->dataUpdateDate;
    }
    
    public function getData() {
        return $this->rateData;
    }
}