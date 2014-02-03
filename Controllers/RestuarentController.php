<?php

class RestuarentController 
{
    
    private $conPDO;
    private $oRestuarent;
    private $oSecurity;
    
    public function __construct()
    {

        require_once 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
        
        require_once(ROOT_DIRECTORY . '/Classes/RestuarentClass.php');
        $this->oRestuarent = new RestuarentClass();
        
        if(!class_exists('SecurityController') )
        {
            require 'SecurityController.php';
            $this->oSecurity = new SecurityController();
        }
    }
    
    public function GetRestuarentNames()
    {
        $aRestuarentNames = array(
                'sFunction' => 'GetRestuarentNames',
                'result' => false,
            );
        
        $sQuery = $this->conPDO->prepare('SELECT sRestuarentInfoName FROM restuarentinfo WHERE iRestuarentInfoActive = 1');
        
        try
        {
            $sQuery->execute();             
        }
        catch (PDOException $e)
        {
           die($e->getMessage()); 
        }
        if($sQuery->rowCount() > 0)
        {
            $aRestuarentNames['result'] = true;
            $i = 0;
            while ($aResult = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aRestuarentNames['sRestuarentNames'][$i] = $aResult['sRestuarentInfoName'];
                $i++;
            }
        }
        return $aRestuarentNames;
    }
    
    public function AddRestuarent($sRestuarentInfoName, $sRestuarentSlogan,$sRestuarentInfoPhone, $sRestuarentInfoAddress, $iFK_iCompanyInfoId)
    {
        $this->oRestuarent->SetRestaurent($sRestuarentInfoName, $sRestuarentInfoPhone, $sRestuarentInfoAddress, $iFK_iCompanyInfoId);
        
        //Insert into database          
        $sQuery = $this->conPDO->prepare("INSERT INTO restuarentinfo (sRestuarentInfoName, sRestuarentInfoSlogan,sRestuarentInfoPhone, sRestuarentInfoAddress, iFK_iCompanyInfoId) VALUES (:sRestuarentInfoName, :sRestuarentSlogan, :sRestuarentInfoPhone, :sRestuarentInfoAddress, :iFK_iCompanyInfoId)");

        $oRestuarent = $this->oRestuarent->GetRestuarent();
        
        $sQuery->bindValue(':sRestuarentInfoName', utf8_decode(urldecode($oRestuarent->sRestuarentInfoName)));
        $sQuery->bindValue(':sRestuarentSlogan', utf8_decode(urldecode($sRestuarentSlogan)));
        $sQuery->bindValue(':sRestuarentInfoPhone', $oRestuarent->sRestuarentInfoPhone);
        $sQuery->bindValue(':sRestuarentInfoAddress', utf8_decode(urldecode($oRestuarent->sRestuarentInfoAddress)));
        $sQuery->bindValue(':iFK_iCompanyInfoId', $oRestuarent->iFK_iCompanyInfoId);
        $sQuery->execute();
        
        //Get the last inserted id
        $iRestuarentInfoId = $this->conPDO->lastInsertId();
        
        return $iRestuarentInfoId;
    }
    
    
    public function UpdateRestuarentInfo()
    {
        $aRestuarent = array(
                'sFunction' => 'UpdateRestuarentInfo',
                'result' => false,
            );
        
        if(isset($_GET['sJSON']))
        {
            //Get the JSON string
            $sJSON = $_GET['sJSON'];
            //Convert the JSON string into an array
            $aJSONRestuarent = json_decode($sJSON);
            
            if(!isset($_SESSION['sec_session_id']))
            { 
                $this->oSecurity->sec_session_start();
            }
        
            //Check if user is logged in
            if($this->oSecurity->login_check() == true)
            {
                $sUsername = $_SESSION['username'];
                       
                //Get iFK_iCompanyId
                $sQuery = $this->conPDO->prepare("SELECT iFK_iCompanyId FROM users WHERE sUsername = :sUsername LIMIT 1");
                $sQuery->bindValue(":sUsername", $sUsername);
                $sQuery->execute();
                $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                $iFK_iCompanyId = $aResult['iFK_iCompanyId'];


                $sQuery = $this->conPDO->prepare("UPDATE restuarentinfo SET sRestuarentInfoName = :sRestuarentInfoName, sRestuarentInfoSlogan = :sRestuarentInfoSlogan, sRestuarentInfoPhone = :sRestuarentInfoPhone, sRestuarentInfoAddress = :sRestuarentInfoAddress WHERE iFK_iCompanyInfoId = :iFK_iCompanyId LIMIT 1");
                $sQuery->bindValue(":sRestuarentInfoName", urldecode($aJSONRestuarent->sRestuarentName));
                $sQuery->bindValue(":sRestuarentInfoSlogan", utf8_decode(urldecode($aJSONRestuarent->sRestuarentSlogan)));      
                $sQuery->bindValue(":sRestuarentInfoPhone", urldecode($aJSONRestuarent->sRestuarentPhone));
                $sQuery->bindValue(":sRestuarentInfoAddress", urldecode($aJSONRestuarent->sRestuarentAddress));
                $sQuery->bindValue(":iFK_iCompanyId", $iFK_iCompanyId);
                $sQuery->execute();
                
                
                //Get iMenucardId based on the iCompanyId
                $sQuery = $this->conPDO->prepare("SELECT iMenucardId FROM menucard
                                                    INNER JOIN `restuarentinfo`
                                                    ON `iFK_iCompanyInfoId` = :iFK_iCompanyId
                                                    WHERE menucard.iFK_iRestuarentInfoId = restuarentinfo.`iRestuarentInfoId` LIMIT 1");
                $sQuery->bindValue(":iFK_iCompanyId", $iFK_iCompanyId);
                $sQuery->execute();
                $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                $iFK_iMenucardId = $aResult['iMenucardId'];

                
                //TODO: Update opening hours
                $aOpeningHours = array(
                    0 => $aJSONRestuarent->iMondayTimeFrom,
                    1 => $aJSONRestuarent->iMondayTimeTo,
                    2 => $aJSONRestuarent->iThuesdayTimeFrom,
                    3 => $aJSONRestuarent->iThuesdayTimeTo,
                    4 => $aJSONRestuarent->iWednesdaysTimeFrom,
                    5 => $aJSONRestuarent->iWednesdaysTimeTo,
                    6 => $aJSONRestuarent->iThursdayTimeFrom,
                    7 => $aJSONRestuarent->iThursdayTimeTo,
                    8 => $aJSONRestuarent->iFridayTimeFrom,
                    9 => $aJSONRestuarent->iFridayTimeTo,
                    10 => $aJSONRestuarent->iSaturdayTimeFrom,
                    11 => $aJSONRestuarent->iSaturdayTimeTo,
                    12 => $aJSONRestuarent->iSundayTimeFrom,
                    13 => $aJSONRestuarent->iSundayTimeTo
                );

                //Loop through array and insert all the values
                //Counter for the day id. 1=mandag,2=tirsdag,3=onsdag,4=torsdag,5=fredag,6=lørdag,7=søndag
                $iDay = 1;
                for($i=0;$i<13;$i+=2) {
                    $sQuery = $this->conPDO->prepare("UPDATE openinghours SET iFK_iTimeFromId = :iFK_iTimeFromId, iFK_iTimeToId = :iFK_iTimeToId WHERE iFK_iMenucardId = :iFK_iMenucardId AND iFK_iDayId = :iFK_iDayId");

                    $sQuery->bindValue(':iFK_iMenucardId', $iFK_iMenucardId);
                    $sQuery->bindValue(':iFK_iDayId', $iDay);
                    $sQuery->bindValue(':iFK_iTimeFromId', $aOpeningHours[$i]);
                    $i++;
                    $sQuery->bindValue(':iFK_iTimeToId', $aOpeningHours[$i]);
                    $sQuery->execute();
                    $i--;
                    $iDay++;
                    if($i == 12){
                        break;
                    }
                }  
                
                
                $aRestuarent['result'] = true;
            }
        }
        
        return $aRestuarent;
    }

    public function __destruct() {
        ;
    }
    
}

?>
