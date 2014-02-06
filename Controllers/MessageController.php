<?php

class MessageController 
{
    private $conPDO;


    public function __construct() {
        
        require_once 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
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
        
        //TODO: Check if user is logged in
        
         
        $sQuery = $this->conPDO->prepare("SELECT * FROM messages WHERE iFK_iRestuarentInfoId = :iRestuarentInfoId");
        $sQuery->bindValue(":iRestuarentInfoId", '1');
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
    
    //SaveMessage
    public function SaveMessage()
    {
        $oMessage = array(
                'sFunction' => 'SaveMessage',
                'result' => false
            );
        
        if(isset($_GET['sJSON'])) {
            
            $aJSONMessage = json_decode($_GET['sJSON']);
            
            //TODO: Check if user logged in and get the iRestuarentId
            
            //Save message
            $sQuery = $this->conPDO->prepare("INSERT INTO messages (sMessageHeadline,sMessageBodyText,dtMessageDate,iFK_iRestuarentInfoId) VALUES (:sMessageHeadline,:sMessageBodyText,NOW(),:iFK_iRestuarentInfoId)");
            $sQuery->bindValue(":sMessageHeadline", utf8_decode(urldecode($aJSONMessage->sMessageHeadnline)));
            $sQuery->bindValue(":sMessageBodyText", utf8_decode(urldecode($aJSONMessage->sMessageBodyText)));
            $sQuery->bindValue(":iFK_iRestuarentInfoId", "1");
            $sQuery->execute();
            
            $oMessage['result'] = true;
            
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
