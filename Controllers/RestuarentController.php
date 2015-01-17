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
    
    public function AddRestuarent($sRestuarentInfoName, $sRestuarentSlogan,$sRestuarentInfoPhone, $sRestuarentInfoAddress, $iRestuarentZipcode, $iFK_iCompanyInfoId, $dRestuarentLocationLat, $dRestuarentLocationLng)
    {
        $this->oRestuarent->SetRestaurent($sRestuarentInfoName, $sRestuarentInfoPhone, $sRestuarentInfoAddress, $iFK_iCompanyInfoId, $dRestuarentLocationLat, $dRestuarentLocationLng);
        
        //Insert into database          
        $sQuery = $this->conPDO->prepare("INSERT INTO restuarentinfo (sRestuarentInfoName, sRestuarentInfoSlogan,sRestuarentInfoPhone, sRestuarentInfoAddress, iRestuarentInfoZipcode ,iFK_iCompanyInfoId, sRestuarentInfoLat, sRestuarentInfoLng) VALUES (:sRestuarentInfoName, :sRestuarentSlogan, :sRestuarentInfoPhone, :sRestuarentInfoAddress, :iRestuarentInfoZipcode, :iFK_iCompanyInfoId, :sRestuarentInfoLat, :sRestuarentInfoLng)");

        $oRestuarent = $this->oRestuarent->GetRestuarent();
        
        $sQuery->bindValue(':sRestuarentInfoName', utf8_decode(urldecode($oRestuarent->sRestuarentInfoName)));
        $sQuery->bindValue(':sRestuarentSlogan', utf8_decode(urldecode($sRestuarentSlogan)));
        $sQuery->bindValue(':sRestuarentInfoPhone', $oRestuarent->sRestuarentInfoPhone);
        $sQuery->bindValue(':sRestuarentInfoAddress', utf8_decode(urldecode($oRestuarent->sRestuarentInfoAddress)));
        $sQuery->bindValue(':iRestuarentInfoZipcode', $iRestuarentZipcode);     
        $sQuery->bindValue(':iFK_iCompanyInfoId', $oRestuarent->iFK_iCompanyInfoId);
        $sQuery->bindValue(':sRestuarentInfoLat', $oRestuarent->dRestuarentLocationLat);
        $sQuery->bindValue(':sRestuarentInfoLng', $oRestuarent->dRestuarentLocationLng);
        $sQuery->execute();
        
        //Get the last inserted id
        $iRestuarentInfoId = $this->conPDO->lastInsertId();

        require_once __DIR__.'/../Classes/MapController.php';
        MapController::UpdateJSON($this->conPDO);

        
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


                $sQuery = $this->conPDO->prepare("UPDATE restuarentinfo SET sRestuarentInfoName = :sRestuarentInfoName, sRestuarentInfoSlogan = :sRestuarentInfoSlogan, sRestuarentInfoPhone = :sRestuarentInfoPhone, sRestuarentInfoAddress = :sRestuarentInfoAddress, iRestuarentInfoZipcode = :iRestuarentInfoZipcode, sRestuarentInfoLat = :sRestuarentInfoLat, sRestuarentInfoLng = :sRestuarentInfoLng WHERE iFK_iCompanyInfoId = :iFK_iCompanyId LIMIT 1");
                $sQuery->bindValue(":sRestuarentInfoName", utf8_decode(urldecode($aJSONRestuarent->sRestuarentName)));
                $sQuery->bindValue(":sRestuarentInfoSlogan", utf8_decode(urldecode($aJSONRestuarent->sRestuarentSlogan)));      
                $sQuery->bindValue(":sRestuarentInfoPhone", urldecode($aJSONRestuarent->sRestuarentPhone));
                $sQuery->bindValue(":sRestuarentInfoAddress", utf8_decode(urldecode($aJSONRestuarent->sRestuarentAddress)));
                $sQuery->bindValue(':iRestuarentInfoZipcode', $aJSONRestuarent->sRestuarentZipcode); 
                $sQuery->bindValue(':sRestuarentInfoLat', $aJSONRestuarent->dRestuarentLocationLat);
                $sQuery->bindValue(':sRestuarentInfoLng', $aJSONRestuarent->dRestuarentLocationLng);
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

                
                //Update opening hours
                $aOpeningHours = array(
                    0 => $aJSONRestuarent->iMondayTimeFrom,
                    1 => $aJSONRestuarent->iMondayTimeTo,
                    2 => $aJSONRestuarent->iMondayClosed,
                    3 => $aJSONRestuarent->iThuesdayTimeFrom,
                    4 => $aJSONRestuarent->iThuesdayTimeTo,
                    5 => $aJSONRestuarent->iThuesdayClosed,
                    6 => $aJSONRestuarent->iWednesdaysTimeFrom,
                    7 => $aJSONRestuarent->iWednesdaysTimeTo,
                    8 => $aJSONRestuarent->iWednesdaysClosed,
                    9 => $aJSONRestuarent->iThursdayTimeFrom,
                    10 => $aJSONRestuarent->iThursdayTimeTo,
                    11 => $aJSONRestuarent->iThursdayClosed,
                    12 => $aJSONRestuarent->iFridayTimeFrom,
                    13 => $aJSONRestuarent->iFridayTimeTo,
                    14 => $aJSONRestuarent->iFridayClosed,
                    15 => $aJSONRestuarent->iSaturdayTimeFrom,
                    16 => $aJSONRestuarent->iSaturdayTimeTo,
                    17 => $aJSONRestuarent->iSaturdayClosed,
                    18 => $aJSONRestuarent->iSundayTimeFrom,
                    19 => $aJSONRestuarent->iSundayTimeTo,
                    20 => $aJSONRestuarent->iSundayClosed,
                );

                //Loop through array and insert all the values
                //Counter for the day id. 1=mandag,2=tirsdag,3=onsdag,4=torsdag,5=fredag,6=lørdag,7=søndag
                $iDay = 1;
                for($i=0;$i<20;$i+=3) {
                    $sQuery = $this->conPDO->prepare("UPDATE openinghours SET iFK_iTimeFromId = :iFK_iTimeFromId, iFK_iTimeToId = :iFK_iTimeToId, iClosed = :iClosed WHERE iFK_iMenucardId = :iFK_iMenucardId AND iFK_iDayId = :iFK_iDayId");

                    $sQuery->bindValue(':iFK_iMenucardId', $iFK_iMenucardId);
                    $sQuery->bindValue(':iFK_iDayId', $iDay);
                    $sQuery->bindValue(':iFK_iTimeFromId', $aOpeningHours[$i]);
                    $i++;
                    $sQuery->bindValue(':iFK_iTimeToId', $aOpeningHours[$i]);
                    $i++;
                    $sQuery->bindValue("iClosed", $aOpeningHours[$i]);
                    $sQuery->execute();
                    $i--;
                    $i--;
                    $iDay++;
                    if($i == 19){
                        break;
                    }
                }  

                require_once __DIR__.'/../Classes/MapController.php';
                MapController::UpdateJSON($this->conPDO);
                
                $aRestuarent['result'] = true;
            }
        }
        
        return $aRestuarent;
    }

    
    public function SearchForRestuarentname() {
        
        
        header('Access-Control-Allow-Origin: *');  
        
        
        // Only allow trusted, MUCH more safe
        //header('Access-Control-Allow-Origin: mylocalcafe.dk');
        //header('Access-Control-Allow-Origin: www.mylocalcafe.dk');
        
        
        $aRestuarent = array(
                'sFunction' => 'SearchForRestuarentname',
                'result' => 'false',
                'cafe' => ''
            );
        
        if(isset($_GET['sCafename']) && isset($_GET['iCafeId'])) {
        
            $sCafename = utf8_decode($_GET['sCafename']);
            
     //Get Restuarentnames,adress and id that match the search string and where the id is greater than the one passed from the ajax call from app
            $sQuery = $this->conPDO->prepare("SELECT iRestuarentInfoId,sRestuarentInfoName,sRestuarentInfoAddress FROM restuarentinfo WHERE sRestuarentInfoName LIKE :sCafename AND iRestuarentInfoId > :iRestuarentInfoId LIMIT 10");
            $sQuery->bindValue(":sCafename", '%'.$sCafename.'%');
            $sQuery->bindValue(":iRestuarentInfoId", $_GET['iCafeId']);
            $sQuery->execute();
            
            //Count number of results
            if($sQuery->rowCount() >= 1){
            
                $i = 0;
                while ($result = $sQuery->fetch(PDO::FETCH_ASSOC)) {
                    $aRestuarent['cafe'][$i]['id'] = $result['iRestuarentInfoId'];
                    $aRestuarent['cafe'][$i]['name'] = utf8_encode($result['sRestuarentInfoName']);
                    $aRestuarent['cafe'][$i]['address'] = utf8_encode($result['sRestuarentInfoAddress']);
                    $i++;
                }
                $aRestuarent['result'] = 'true';
            }else{
                $aRestuarent['result'] = 'done';
            }
        }
        
        return $aRestuarent;
    }
    
    
    public function __destruct() {
        ;
    }
    
}

?>
