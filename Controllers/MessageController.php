<?php

class MessageController 
{
    private $conPDO;
    
    private $oSecurityController;
    private $oStampcard;


    public function __construct() {
        
        require_once 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
        
        require_once 'SecurityController.php';
        $this->oSecurityController = new SecurityController();
        
        require_once 'StampcardController.php';
        $this->oStampcard = new StampcardController();
    }
    
    
    //GetMessage
    
    //GetMessages
    public function GetMessages()
    {
         $oMessages = array(
                'sFunction' => 'GetMessages',
                'result' => false,
                'Messages' => ''
            );
        
            //Check if session is started
            if(!isset($_SESSION['sec_session_id']))
            { 
                $this->oSecurityController->sec_session_start();
            }

            //Check if user is logged in
            if($this->oSecurityController->login_check() == true)
            {
                
                //Check if user logged in and get the iRestuarentId
                    $sQuery = $this->conPDO->prepare("SELECT iRestuarentInfoId FROM restuarentinfo                                                     
                                                        INNER JOIN company
                                                        ON company.iCompanyId = restuarentinfo.iFK_iCompanyInfoId
                                                        INNER JOIN users
                                                        ON users.iFK_iCompanyId = company.iCompanyId
                                                        WHERE users.sUsername = :sUsername");
                $sQuery->bindValue(':sUsername', $_SESSION['username']);
                $sQuery->execute();
                $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                $iRestuarentInfoId = $aResult['iRestuarentInfoId'];
         
                $sQuery = $this->conPDO->prepare("SELECT * FROM messages WHERE iFK_iRestuarentInfoId = :iRestuarentInfoId ORDER BY dtMessageDate DESC");
                $sQuery->bindValue(":iRestuarentInfoId", $iRestuarentInfoId);
                $sQuery->execute();
                $i = 0;
                while($aResult = $sQuery->fetch(PDO::FETCH_ASSOC)) {

                    $oMessages['Messages'][$i]['sMessageHeadline'] = utf8_encode($aResult['sMessageHeadline']);
                    $oMessages['Messages'][$i]['sMessageBodyText'] = utf8_encode($aResult['sMessageBodyText']);
                    $oMessages['Messages'][$i]['dtMessageDate'] = utf8_encode($aResult['dtMessageDate']);
                    $i++;
                }

                $oMessages['result'] = true;
                return $oMessages;
            }
        
    }
    
    //Get Messages And Stamps for each menucard in App 
    public function GetMessagesAndStampsApp()
    {
        
        
        //Allow all, NOT SAFE
        header('Access-Control-Allow-Origin: *');  
        
        /* Only allow trusted, MUCH more safe
        header('Access-Control-Allow-Origin: mylocalcafe.dk');
        header('Access-Control-Allow-Origin: www.mylocalcafe.dk');
        */
        
        
         $oMenucards = array(
                'sFunction' => 'GetMessagesAndStampsApp',
                'result' => false,
                'Menucards' => ''
            );
         
         
        //Get the menucards serialnumbers
        //Get the JSON string
        $sJSONMenucards = $_GET['sJSONMenucards'];
        //Convert the JSON string into an array
        $aJSONMenucards = json_decode($sJSONMenucards);
        
        
        foreach ($aJSONMenucards as $value) {
            
            $iMenucardSerialNumber =  $value;
        
            //Get the messages based on the menucard serialnumber 
            $sQuery = $this->conPDO->prepare("SELECT iFk_iRestuarentInfoId FROM menucard WHERE iMenucardSerialNumber = :iMenucardSerialNumber");
            $sQuery->bindValue(":iMenucardSerialNumber", $iMenucardSerialNumber);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $iRestuarentInfoId = $aResult['iFk_iRestuarentInfoId'];
            
            //Get stampcard text
            $sQuery = $this->conPDO->prepare("SELECT sStampcardText FROM stampcard WHERE iFk_iRestuarentInfoId = :iFk_iRestuarentInfoId");
            $sQuery->bindValue(":iFk_iRestuarentInfoId", $iRestuarentInfoId);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $oMenucards['Menucards'][$iMenucardSerialNumber]['sStampcardText'] = $aResult['sStampcardText']; 
            
            //Get all message that are active (fits the time span based on the time now)
            $sQuery = $this->conPDO->prepare("SELECT * FROM messages WHERE iFK_iRestuarentInfoId = :iRestuarentInfoId AND dMessageDateStart <=  CURDATE() AND dMessageDateEnd >= CURDATE() ORDER BY dtMessageDate DESC LIMIT 1");
            $sQuery->bindValue(":iRestuarentInfoId", $iRestuarentInfoId);
            $sQuery->execute();
            $i = 0;
            while($aResult = $sQuery->fetch(PDO::FETCH_ASSOC)) {

                $oMenucards['Menucards'][$iMenucardSerialNumber]['Messages'][$i]['sMessageHeadline'] = utf8_encode($aResult['sMessageHeadline']);
                $oMenucards['Menucards'][$iMenucardSerialNumber]['Messages'][$i]['sMessageBodyText'] = utf8_encode($aResult['sMessageBodyText']);
                $oMenucards['Menucards'][$iMenucardSerialNumber]['Messages'][$i]['dtMessageDate'] = utf8_encode($aResult['dtMessageDate']);
                $i++;
            }
            
            //Get all the stamps that are not used
            $sQuery = $this->conPDO->prepare("SELECT COUNT(*) as antal FROM stamp WHERE sCustomerId = :sCustomerId AND iFK_iMenucardSerialNumber = :iMenucardSerialNumber AND iStampUsed = '0'");
            $sQuery->bindValue(":sCustomerId", $aJSONMenucards->sCustomerId);
            $sQuery->bindValue(":iMenucardSerialNumber", $iMenucardSerialNumber);          
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $oMenucards['Menucards'][$iMenucardSerialNumber]['iNumberOfStamps'] = $aResult['antal']; 
        }
        
        //Remove the last place in the $oMenucards
        unset($oMenucards['Menucards'][$iMenucardSerialNumber]);
        
        $oMenucards['result'] = true;
        //var_dump($oMenucards);
        return $oMenucards;
            
        
    }
    
    //Get Message App together with a menucard 
    public function GetMessagesAppFromMenucard($iMenucardSerialNumber)
    {
        $oMessages = array();
        
        //Get iRestuarentInfoId based on the $iMenucardSerialNumber
        $sQuery = $this->conPDO->prepare("SELECT iFk_iRestuarentInfoId FROM menucard WHERE iMenucardSerialNumber = :iMenucardSerialNumber");
        $sQuery->bindValue(":iMenucardSerialNumber", $iMenucardSerialNumber);
        $sQuery->execute();
        $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
        $iRestuarentInfoId = $aResult['iFk_iRestuarentInfoId'];
        
        //Get all message that are active (fits the time span based on the time now)
        $sQuery = $this->conPDO->prepare("SELECT * FROM messages WHERE iFK_iRestuarentInfoId = :iRestuarentInfoId AND dMessageDateStart <=  CURDATE() AND dMessageDateEnd >= CURDATE() ORDER BY dtMessageDate DESC LIMIT 1");
        $sQuery->bindValue(":iRestuarentInfoId", $iRestuarentInfoId);
        $sQuery->execute();
        $i = 0;
        while($aResult = $sQuery->fetch(PDO::FETCH_ASSOC)) {
            $oMessages[$i]['headline'] = utf8_encode($aResult['sMessageHeadline']);
            $oMessages[$i]['bodytext'] = utf8_encode($aResult['sMessageBodyText']); 
            $oMessages[$i]['date'] = utf8_encode($aResult['dtMessageDate']); 
            $i++;
        }
       return $oMessages;
    }
    
    //SaveMessage
    public function SaveMessage()
    {
        $oMessage = array(
                'sFunction' => 'SaveMessage',
                'result' => false
            );
        
            //Check if session is started
            if(!isset($_SESSION['sec_session_id']))
            { 
                $this->oSecurityController->sec_session_start();
            }

            //Check if user is logged in
            if($this->oSecurityController->login_check() == true)
            {
        
                if(isset($_GET['sJSON'])) {

                    $aJSONMessage = json_decode($_GET['sJSON']);

                    //Check if user logged in and get the iRestuarentId
                    $sQuery = $this->conPDO->prepare("SELECT iRestuarentInfoId FROM restuarentinfo                                                     
                                                        INNER JOIN company
                                                        ON company.iCompanyId = restuarentinfo.iFK_iCompanyInfoId
                                                        INNER JOIN users
                                                        ON users.iFK_iCompanyId = company.iCompanyId
                                                        WHERE users.sUsername = :sUsername");
                    $sQuery->bindValue(':sUsername', $_SESSION['username']);
                    $sQuery->execute();
                    $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                    $iRestuarentInfoId = $aResult['iRestuarentInfoId'];
                                    
                    //Reverse date to fit datebase format
                    $dMessageStart = date('Y-m-d', strtotime(urldecode($aJSONMessage->dMessageStart)));
                    $dMessageEnd = date('Y-m-d', strtotime( urldecode($aJSONMessage->dMessageEnd)));
                    
                    //Save message
                    $sQuery = $this->conPDO->prepare("INSERT INTO messages (sMessageHeadline,sMessageBodyText,dtMessageDate,dMessageDateStart,dMessageDateEnd,iFK_iRestuarentInfoId) VALUES (:sMessageHeadline,:sMessageBodyText,NOW(),:dMessageDateStart,:dMessageDateEnd,:iFK_iRestuarentInfoId)");
                    $sQuery->bindValue(":sMessageHeadline", utf8_decode(urldecode($aJSONMessage->sMessageHeadnline)));
                    $sQuery->bindValue(":sMessageBodyText", utf8_decode(urldecode($aJSONMessage->sMessageBodyText)));
                    $sQuery->bindValue(":dMessageDateStart", $dMessageStart);
                    $sQuery->bindValue(":dMessageDateEnd", $dMessageEnd);
                    $sQuery->bindValue(":iFK_iRestuarentInfoId", $iRestuarentInfoId);
                    $sQuery->execute();

                    $oMessage['result'] = true;
                }
            }
        
        
        return $oMessage;
    }
    //UpdateMessage
    
    //DeleteMessage
    
    public function __destruct() {
        ;
    }
}

?>
