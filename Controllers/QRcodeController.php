<?php

class QRcodeController
{
    
    private $conPDO;
    private $oSecurityController;


    public function __construct() {
        
        require_once 'SecurityController.php';
        $this->oSecurityController = new SecurityController();
                
        require_once 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
    }
    
    

    public function GenerateQRcode() {
        
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
        
       
        
        if($this->UpdateQRcode($url) == true)
        {
            $oQRcode['result'] = true;
        }else{
            $oQRcode['result'] = false;
        }
        
        return $oQRcode;
    }
    
    /*
     * 
     * Update the restuarant/bar/shop current QRcode
     * 
     * 
     */
    
    private function UpdateQRcode($url) {
        
        //Check if session is started
        if(!isset($_SESSION['sec_session_id']))
        { 
            $this->oSecurityController->sec_session_start();
        }
        
        //Check if user is logged in
        if($this->oSecurityController->login_check() == true)
        {
            
            //Get iCompanyId
            $sQuery = $this->conPDO->prepare("SELECT iFK_iCompanyId FROM users WHERE sUsername = :sUsername");
            $sQuery->bindValue(':sUsername', $_SESSION['username']);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $iCompanyId = $aResult['iFK_iCompanyId'];
            
            $sQuery = $this->conPDO->prepare("UPDATE restuarentinfo SET sRestuarentInfoQRcode = :url WHERE iFK_iCompanyInfoId = :iCompanyId");
            $sQuery->bindValue(':url', $url);
            $sQuery->bindValue(':iCompanyId', $iCompanyId);
            $sQuery->execute();
            
            //TODO: Update the QRcode url for the stampcard
            
            return true;
        }else{
            return false;
        }
        
        
        
    }

    public function __destruct() {
        ;
    }
}
?>
