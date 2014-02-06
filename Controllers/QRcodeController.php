<?php

class QRcodeController
{
    
    private $conPDO;
    
    public function __construct() {
        
        require_once 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
    }
    
    public function GenerateQRcode()
    {
        $oQRcode = array(
                'sFunction' => 'GenerateQRcode',
                'result' => false
            );
        
        $heightandwidth = '500';

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 30; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $data = $randomString;
        
        $errorcorrection = 'H'; //Handle 30% dataloss
        $url = 'https://chart.googleapis.com/chart?chs='.$heightandwidth.'x'.$heightandwidth.'&chld='.$errorcorrection.'&cht=qr&chl='.$data;

        
        $oQRcode['url'] = $url;
        
        $oQRcode['result'] = true;
        
        return $oQRcode;
    }


    public function __destruct() {
        ;
    }
}
?>
