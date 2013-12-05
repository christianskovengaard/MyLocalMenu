<?php

class MenucardController
{
    private $oMenucard;
    private $oMenucardCategory;
    private $oMenucardItem;
    private $oMenucardInfo;
    
    private $oBcrypt;
    private $conPDO;

    public function __construct() 
    {
        
        require_once(ROOT_DIRECTORY . '/Classes/bcrypt.php');
        $this->oBcrypt = new Bcrypt();
        
        require_once(ROOT_DIRECTORY . '/Classes/MenucardClass.php');
        $this->oMenucard = new MenucardClass();
        
        require_once(ROOT_DIRECTORY . '/Classes/MenucardCategoryClass.php');
        $this->oMenucardCategory = new MenucardCategoryClass();
        
        require_once(ROOT_DIRECTORY . '/Classes/MenucardItemClass.php');
        $this->oMenucardItem = new MenucardItemClass();
        
        require_once(ROOT_DIRECTORY . '/Classes/MenucardInfoClass.php');
        $this->oMenucardInfo = new MenucardInfoClass();
        
        require 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
        
        if(!isset($_SESSION)) 
        { 
            session_start();            
        } 
    }
    //Add a Menucard If there are not previous menucards
    public function AddMenucard () 
    {                               
        if(isset($_GET['sJSONMenucard']))
        {
            
            //Get the iCompanyId based user logged in
            //$iCompanyId = $_SESSION['iCompanyId'];
            $iCompanyId = '1';
            
            //Get the $iRestuarentInfoId based on the $iCompanyId
            $sQuery = $this->conPDO->prepare("SELECT iRestuarentInfoId FROM restuarentinfo WHERE iFK_iCompanyInfoId = :iCompanyId LIMIT 1");
                
            $sQuery->bindValue(':iCompanyId', $iCompanyId);
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $iRestuarentInfoId = $aResult['iRestuarentInfoId'];
            
            try
            {
                $sQuery->execute();
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            
            //Get the JSON string
            $sJSONMenucard = $_GET['sJSONMenucard'];
            //Convert the JSON string into an array
            $aJSONMenucard = json_decode($sJSONMenucard);
            
            //Get MenucardIdHashed
            //$MenucardIdHashed = $aJSONMenucard->iMenucardIdHashed;
            //Get MenucardDescription
            $sMenucardDescription = $aJSONMenucard->sMenucarddescription;
            //Get MenucardName
            $sMenucardName = $aJSONMenucard->sMenucardname;
            
            //Set the MenucardClass
            $this->oMenucard->SetMenucard($sMenucardName, $sMenucardDescription);
            
            //Get user from database based on the iUserId remember to use PDO
            $sQuery = $this->conPDO->prepare("INSERT INTO menucard (sMenucardName,iFK_iRestuarentInfoId) VALUES (?,?)");
            
            //Get the menucard
            $oMenucard = $this->oMenucard->GetMenucard();
            

            //Bind the values to the ? signs
            $sQuery->bindValue(1, $oMenucard->sMenucardName);
            $sQuery->bindValue(2, $iRestuarentInfoId);
            
            //Execute the query
            try
            {
                $sQuery->execute();
                
                //Get the last inserted id
                $iMenucardId = $this->conPDO->lastInsertId();

                $iMenucardIdHashed = $this->oBcrypt->genHash($iMenucardId);

                $sQuery = $this->conPDO->prepare("UPDATE menucard SET iMenucardIdHashed = ? WHERE iMenucardId = ? LIMIT 1");
                
                $sQuery->bindValue(1, $iMenucardIdHashed);
                $sQuery->bindValue(2, $iMenucardId);
                
                try
                {
                    $sQuery->execute();
                }
                catch (PDOException $e)
                {
                   die($e->getMessage()); 
                }
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
            
            //Get the number of MenucardCategories
            $iNumberOfMenucardCategories = $aJSONMenucard->iLastIndexofMenucardCategories;
            
            //Get the first MenucardCategory from MenuCard
            for($iCategoryIndex=0;$iNumberOfMenucardCategories >= $iCategoryIndex;$iCategoryIndex++)
            {
                $sMenucardCategoryName = utf8_decode($aJSONMenucard->$iCategoryIndex->sMenucardCategoryName);
                //$sMenucardCategoryId = $aJSONMenucard[$iCategoryIndex][''];
                $sMenucardCategoryDescription = utf8_decode($aJSONMenucard->$iCategoryIndex->sMenucardCategoryDescription);
                
                //Set the MenucardCategoryClass
                $this->oMenucardCategory->SetMenucardCategory($sMenucardCategoryName, $sMenucardCategoryDescription);
                
                //Insert the new MenucardCategory
                $sQuery = $this->conPDO->prepare("INSERT INTO menucardcategory (sMenucardCategoryName,sMenucardCategoryDescription,iFK_iMenucardId) VALUES (?,?,?)");
                
                //Get the Menucard Category
                $oMenucardCategory = $this->oMenucardCategory->GetMenucardCategory();
                
                $sQuery->bindValue(1, $oMenucardCategory->sMenucardCategoryName);
                $sQuery->bindValue(2, $oMenucardCategory->sMenucardCategoryDescription);
                $sQuery->bindValue(3, $iMenucardId);
                
                try
                {
                    $sQuery->execute();
                    $iMenucardCategoryId = $this->conPDO->lastInsertId();                                                   
                }
                catch (PDOException $e)
                {
                   die($e->getMessage()); 
                }
                         
                
                //Get last index of MenucardItem from the MenucardCategory array
                $iLastMenucardItemIndex = $aJSONMenucard->$iCategoryIndex->iLastMenucardItemIndex;

                //Get all the MenucardItems
                for($i=0;$iLastMenucardItemIndex >= $i;$i++)
                { 
                    $sMenucardItemName = utf8_decode($aJSONMenucard->$iCategoryIndex->$i->sTitle);
                    //$iMenucardItemId = $aJSONMenucard[$iCategoryIndex][$i][''];
                    $sMenucardItemNumber = utf8_decode($aJSONMenucard->$iCategoryIndex->$i->iNumber);
                    $sMenucardItemDescription = utf8_decode($aJSONMenucard->$iCategoryIndex->$i->sDescription);                    
                    $iMenucardItemPrice = $aJSONMenucard->$iCategoryIndex->$i->iPrice;
                    
                    //Set the MenucardItemClass
                    $this->oMenucardItem->SetMenucardItem($sMenucardItemName, $sMenucardItemNumber, $iMenucardItemPrice, $sMenucardItemDescription);
                    
                    
                    //Get the menucarditem
                    $oMenucardItem = $this->oMenucardItem->GetMenucardItem();
                    
                    //Insert the menucarditem. remember to use the FK ffor menucardcetegory
                    $sQuery = $this->conPDO->prepare("INSERT INTO menucarditem (sMenucardItemName,sMenucardItemNumber,sMenucardItemDescription,iMenucardItemPrice,iFK_iMenucardCategoryId) VALUES (?,?,?,?,?)");
                    $sQuery->bindValue(1, $oMenucardItem->sMenucardItemName);
                    $sQuery->bindValue(2, $oMenucardItem->sMenucardItemNumber);               
                    $sQuery->bindValue(3, $oMenucardItem->sMenucardItemDescription);
                    $sQuery->bindValue(4, $oMenucardItem->iMenucardItemPrice);
                    $sQuery->bindValue(5, $iMenucardCategoryId);
                    
                    try
                    {
                        $sQuery->execute();                                                     
                    }
                    catch (PDOException $e)
                    {
                       die($e->getMessage()); 
                    }
                }
            
            }
            
            //Get last index of menucardinfo
            $iLastIndexOfmenucardinfo = $aJSONMenucard->menucardinfo->iLastIndexOfmenucardinfo;
            //Get all the MenucardInfo
            for($i=1;$iLastIndexOfmenucardinfo >= $i;$i++)
            {
                $sMenucardInfoHeadline = utf8_decode($aJSONMenucard->menucardinfo->$i->headline);
                $sMenucardInfoParagraph = utf8_decode($aJSONMenucard->menucardinfo->$i->text);

                //Set the MenucardInfoClass
                $this->oMenucardInfo->SetMenucardInfo($sMenucardInfoHeadline, $sMenucardInfoParagraph, $iMenucardId);


                //Get the menucardinfo
                $oMenucardInfo = $this->oMenucardInfo->GetMenucardInfo();

                //Insert the menucarditem. remember to use the FK ffor menucardcetegory
                $sQuery = $this->conPDO->prepare("INSERT INTO menucardinfo (sMenucardInfoHeadline,sMenucardInfoParagraph,iFK_iMenucardId) VALUES (:sMenucardInfoHeadline,:sMenucardInfoParagraph,:iFK_iMenucardId)");
                $sQuery->bindValue(':sMenucardInfoHeadline', $oMenucardInfo->sMenucardInfoHeadline);
                $sQuery->bindValue(':sMenucardInfoParagraph', $oMenucardInfo->sMenucardInfoParagraph);
                $sQuery->bindValue(':iFK_iMenucardId', $oMenucardInfo->iFK_iMenucardId);

                try
                {
                    $sQuery->execute();                                                     
                }
                catch (PDOException $e)
                {
                   die($e->getMessage()); 
                }
            }            
        }
        return true;
    }
    
    
    
    public function UpdateMenucard ()
    {
        
    }
    
    public function DeactivateMenucard ()
    {
       $aMenucard = array(
                'sFunction' => 'DeactivateMenucard',
                'result' => false
            );
        
        if(isset($_GET['iMenucardIdHashed'])) //API call http://localhost:8888/MyLocalMenu/API/api.php?sFunction=DeactivateMenucard&iMenucardIdHashed=$2y$12$03127701752701037b018OLdzfJhmmQVUwBNlzRfr8G4ajnfBR1MO
        {
            $aMenucard['result'] = true;
            $iMenucardIdHashed = $_GET['iMenucardIdHashed'];
            
            $sQuery = $this->conPDO->prepare("UPDATE `menucard` SET iMenucardActive = '0'
                                               WHERE `iMenucardIdHashed` = :iMenucardIdHashed
                                               AND `iMenucardActive` = '1' LIMIT 1");
            $sQuery->bindValue(':iMenucardIdHashed', $iMenucardIdHashed);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            
            return $aMenucard;
            
        }
    }
    
    public function ActivateMenucard ()
    {
       $aMenucard = array(
                'sFunction' => 'ActivateMenucard',
                'result' => false
            );
        
        if(isset($_GET['iMenucardIdHashed'])) //API call http://localhost:8888/MyLocalMenu/API/api.php?sFunction=ActivateMenucard&iMenucardIdHashed=$2y$12$03127701752701037b018OLdzfJhmmQVUwBNlzRfr8G4ajnfBR1MO
        {
            $aMenucard['result'] = true;
            $iMenucardIdHashed = $_GET['iMenucardIdHashed'];
            
            $sQuery = $this->conPDO->prepare("UPDATE `menucard` SET iMenucardActive = '1'
                                               WHERE `iMenucardIdHashed` = :iMenucardIdHashed
                                               AND `iMenucardActive` = '0' LIMIT 1");
            $sQuery->bindValue(':iMenucardIdHashed', $iMenucardIdHashed);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            
            return $aMenucard;
            
        }
    }
    
    public function GetMenucard ()
    {
        $aMenucard = array(
                'sFunction' => 'GetMenucard',
                'result' => false
            );
        
        if(isset($_GET['iMenucardIdHashed'])) //API call http://localhost:8888/MyLocalMenu/API/api.php?sFunction=GetMenucard&iMenucardIdHashed=$2y$12$03127701752701037b018OLdzfJhmmQVUwBNlzRfr8G4ajnfBR1MO
        {
            $aMenucard['result'] = true;
            $iMenucardIdHashed = $_GET['iMenucardIdHashed'];
            
            //First get the Menucard 
            $sQuery = $this->conPDO->prepare("SELECT * FROM `menucard`
                                               WHERE `iMenucardIdHashed` = :iMenucardIdHashed
                                               AND `iMenucardActive` = '1' LIMIT 1");
            $sQuery->bindValue(':iMenucardIdHashed', $iMenucardIdHashed);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            if($aResult == false): return false; endif;
            $aMenucard['sMenucardName'] = utf8_encode($aResult['sMenucardName']);
            $iMenucardId = $aResult['iMenucardId'];
            
            $iFK_RestuarentInfoId = $aResult['iFK_iRestuarentInfoId'];
            
            //Get all menucardinfo
            $sQuery = $this->conPDO->prepare("SELECT * FROM `menucardinfo`
                                               WHERE `iFK_iMenucardId` = :iFK_iMenucardInfoId
                                               AND `iMenucardInfoActive` = '1'");
            $sQuery->bindValue(':iFK_iMenucardInfoId', $iMenucardId);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            $i = 0;
            while ($row = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aMenucard['aMenucardInfo'][$i]['sMenucardInfoHeadline'] = utf8_encode($row['sMenucardInfoHeadline']);
                $aMenucard['aMenucardInfo'][$i]['sMenucardInfoParagraph'] = utf8_encode($row['sMenucardInfoParagraph']);
                $i++;
            }
            
            
            
            //Get openning hours
            $sQuery = $this->conPDO->prepare("SELECT `timeFrom`.iTime as iTimeFrom,`timeTo`.iTime as iTimeTo ,`day`.sDayName FROM `openinghours`
                                                LEFT JOIN `day`
                                                ON `day`.`iDayId` = `openinghours`.`iFK_iDayId`
                                                LEFT JOIN `time` as timeFrom
                                                ON `timeFrom`.`iTimeId` = `openinghours`.`iFK_iTimeFromId`
                                                LEFT JOIN `time` as timeTo
                                                ON `timeTo`.`iTimeId` = `openinghours`.`iFK_iTimeToId`
                                                WHERE `iFK_iMenucardId` = :iFK_iMenucardId");
            $sQuery->bindValue(':iFK_iMenucardId', $iMenucardId);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            $i = 0;
            while ($row = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aMenucard['aMenucardOpeningHours'][$i]['sDayName'] = utf8_encode($row['sDayName']);
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeFrom'] = $row['iTimeFrom'];
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeTo'] = $row['iTimeTo'];
                $i++;
            }
            
            //Get takeaway hours
            $sQuery = $this->conPDO->prepare("SELECT `timeFrom`.iTime as iTimeFrom,`timeTo`.iTime as iTimeTo ,`day`.sDayName FROM `takeaway`
                                                LEFT JOIN `day`
                                                ON `day`.`iDayId` = `takeaway`.`iFK_iDayId`
                                                LEFT JOIN `time` as timeFrom
                                                ON `timeFrom`.`iTimeId` = `takeaway`.`iFK_iTimeFromId`
                                                LEFT JOIN `time` as timeTo
                                                ON `timeTo`.`iTimeId` = `takeaway`.`iFK_iTimeToId`
                                                WHERE `iFK_iMenucardId` = :iFK_iMenucardId");
            $sQuery->bindValue(':iFK_iMenucardId', $iMenucardId);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            $i = 0;
            while ($row = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aMenucard['aMenucardTakeAwayHours'][$i]['sDayName'] = utf8_encode($row['sDayName']);
                $aMenucard['aMenucardTakeAwayHours'][$i]['iTimeFrom'] = $row['iTimeFrom'];
                $aMenucard['aMenucardTakeAwayHours'][$i]['iTimeTo'] = $row['iTimeTo'];
                $i++;
            }
           
            //Get all the categories for the menucard
            $sQuery = $this->conPDO->prepare("SELECT * FROM `menucardcategory`
                                                WHERE `iFK_iMenucardId` = :iFK_iMenucardId AND `iMenucardCategoryActive` = '1'");
            $sQuery->bindValue(':iFK_iMenucardId', $iMenucardId);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            $i = 0;
            while ($row = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aMenucard['aMenucardCategory'][$i]['sMenucardCategoryName'] = utf8_encode($row['sMenucardCategoryName']);
                $aMenucard['aMenucardCategory'][$i]['sMenucardCategoryDescription'] = utf8_encode($row['sMenucardCategoryDescription']);
                $iFK_iMenucardCategoryId = $row['iMenucardCategoryId'];

                
                 //Get all menucarditem for the category
                 $sQueryItem = $this->conPDO->prepare("SELECT * FROM `menucarditem`
                                                WHERE `iFK_iMenucardCategoryId` = :iFK_iMenucardCategoryId AND `iMenucardItemActive` = '1'");
                 $sQueryItem->bindValue(':iFK_iMenucardCategoryId', $iFK_iMenucardCategoryId);
                 
                 try
                 {
                    $x = 0;
                    $sQueryItem->execute(); 
                    
                    while ($rowItem = $sQueryItem->fetch(PDO::FETCH_ASSOC)) 
                    {
                        $aMenucard['aMenucardCategoryItems'.$i]['sMenucardItemName'][$x] = utf8_encode($rowItem['sMenucardItemName']);
                        $aMenucard['aMenucardCategoryItems'.$i]['sMenucardItemNumber'][$x] = utf8_encode($rowItem['sMenucardItemNumber']);
                        $aMenucard['aMenucardCategoryItems'.$i]['sMenucardItemDescription'][$x] = utf8_encode($rowItem['sMenucardItemDescription']);
                        $aMenucard['aMenucardCategoryItems'.$i]['iMenucardItemPrice'][$x] = $rowItem['iMenucardItemPrice'];
                        $x++;
                    }
                 }  
                 catch (PDOException $e)
                 {
                     die($e->getMessage()); 
                 }
                 
                 $i++;
            }
            
            //Get restuarent info for the menucard
            $sQuery = $this->conPDO->prepare("SELECT * FROM `restuarentinfo`
                                                WHERE `iRestuarentInfoId` = :iFK_RestuarentInfoId LIMIT 1");
            $sQuery->bindValue(':iFK_RestuarentInfoId', $iFK_RestuarentInfoId);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $aMenucard['sRestuarentName'] = utf8_encode($aResult['sRestuarentInfoName']);
            $aMenucard['sRestuarentPhone'] = $aResult['sRestuarentInfoPhone'];
            $aMenucard['sRestuarentAddress'] = utf8_encode($aResult['sRestuarentInfoAddress']);
            
            //var_dump($aMenucard);           
            return $aMenucard;
            
        }else{
            
            return $aMenucard;
            
        }
    }
    
    public function GetMenucardWithSerialNumber ()
    {
        //Allow all, NOT SAFE
        header('Access-Control-Allow-Origin: *');  
        
        /* Only allow trusted, MUCH more safe
        header('Access-Control-Allow-Origin: spjæl.dk');
        header('Access-Control-Allow-Origin: xn--spjl-xoa.sk');
        header('Access-Control-Allow-Origin: www.spjæl.dk');
        header('Access-Control-Allow-Origin: www.xn--spjl-xoa.dk');
        */
        $aMenucard = array(
                'sFunction' => 'GetMenucardWithSerialNumber',
                'result' => false
            );
        
        if(isset($_GET['iMenucardSerialNumber']))
        {
            
            $iMenucardSerialNumber = $_GET['iMenucardSerialNumber'];
            
            $aMenucard['result'] = true;
            
            //First get the Menucard 
            $sQuery = $this->conPDO->prepare("SELECT * FROM `menucard`
                                               WHERE `iMenucardSerialNumber` = :iMenucardSerialNumber
                                               AND `iMenucardActive` = '1' LIMIT 1");
            $sQuery->bindValue(':iMenucardSerialNumber', $iMenucardSerialNumber);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            if($aResult == false): return false; endif;
            $aMenucard['sMenucardName'] = utf8_encode($aResult['sMenucardName']);
            $iMenucardId = $aResult['iMenucardId'];
            $iFK_RestuarentInfoId = $aResult['iFK_iRestuarentInfoId'];
            
            //Get all menucardinfo
            $sQuery = $this->conPDO->prepare("SELECT * FROM `menucardinfo`
                                               WHERE `iFK_iMenucardId` = :iFK_iMenucardInfoId
                                               AND `iMenucardInfoActive` = '1'");
            $sQuery->bindValue(':iFK_iMenucardInfoId', $iMenucardId);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            $i = 0;
            while ($row = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aMenucard['aMenucardInfo'][$i]['sMenucardInfoHeadline'] = utf8_encode($row['sMenucardInfoHeadline']);
                $aMenucard['aMenucardInfo'][$i]['sMenucardInfoParagraph'] = utf8_encode($row['sMenucardInfoParagraph']);
                $i++;
            }
            
            
            
            //Get openning hours
            $sQuery = $this->conPDO->prepare("SELECT `timeFrom`.iTime as iTimeFrom,`timeTo`.iTime as iTimeTo ,`day`.sDayName FROM `openinghours`
                                                LEFT JOIN `day`
                                                ON `day`.`iDayId` = `openinghours`.`iFK_iDayId`
                                                LEFT JOIN `time` as timeFrom
                                                ON `timeFrom`.`iTimeId` = `openinghours`.`iFK_iTimeFromId`
                                                LEFT JOIN `time` as timeTo
                                                ON `timeTo`.`iTimeId` = `openinghours`.`iFK_iTimeToId`
                                                WHERE `iFK_iMenucardId` = :iFK_iMenucardId");
            $sQuery->bindValue(':iFK_iMenucardId', $iMenucardId);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            $i = 0;
            $TodayDayname = $today = date("l");
            $TodayDaynameDanish = $this->GetDanishDayname($TodayDayname);
            while ($row = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aMenucard['aMenucardOpeningHours'][$i]['sDayName'] = utf8_encode($row['sDayName']);
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeFrom'] = substr($row['iTimeFrom'], 0, -3);
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeTo'] = substr($row['iTimeTo'], 0, -3);
                
                //Check for Openinghours hour today               
                if($row['sDayName'] == $TodayDaynameDanish)
                {                  
                    $aMenucard['sRestuarentOpenningHoursToday'] = substr($row['iTimeFrom'], 0, -3)."-".substr($row['iTimeTo'], 0, -3);
                }
                $i++;
            }
            
            //Get takeaway hours
            $sQuery = $this->conPDO->prepare("SELECT `timeFrom`.iTime as iTimeFrom,`timeTo`.iTime as iTimeTo ,`day`.sDayName FROM `takeaway`
                                                LEFT JOIN `day`
                                                ON `day`.`iDayId` = `takeaway`.`iFK_iDayId`
                                                LEFT JOIN `time` as timeFrom
                                                ON `timeFrom`.`iTimeId` = `takeaway`.`iFK_iTimeFromId`
                                                LEFT JOIN `time` as timeTo
                                                ON `timeTo`.`iTimeId` = `takeaway`.`iFK_iTimeToId`
                                                WHERE `iFK_iMenucardId` = :iFK_iMenucardId");
            $sQuery->bindValue(':iFK_iMenucardId', $iMenucardId);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            $i = 0;
            while ($row = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aMenucard['aMenucardTakeAwayHours'][$i]['sDayName'] = utf8_encode($row['sDayName']);
                $aMenucard['aMenucardTakeAwayHours'][$i]['iTimeFrom'] = substr($row['iTimeFrom'], 0, -3);
                $aMenucard['aMenucardTakeAwayHours'][$i]['iTimeTo'] = substr($row['iTimeTo'], 0, -3);
                
                //Check for TakeAway hour today               
                if($row['sDayName'] == $TodayDaynameDanish)
                {                  
                    $aMenucard['sRestuarentTakeAwayHoursToday'] = substr($row['iTimeFrom'], 0, -3)."-".substr($row['iTimeTo'], 0, -3);
                }
                $i++;
            }
           
            //Get all the categories for the menucard
            $sQuery = $this->conPDO->prepare("SELECT * FROM `menucardcategory`
                                                WHERE `iFK_iMenucardId` = :iFK_iMenucardId AND `iMenucardCategoryActive` = '1'");
            $sQuery->bindValue(':iFK_iMenucardId', $iMenucardId);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            $i = 0;
            while ($row = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aMenucard['aMenucardCategory'][$i]['sMenucardCategoryName'] = utf8_encode($row['sMenucardCategoryName']);
                $aMenucard['aMenucardCategory'][$i]['sMenucardCategoryDescription'] = utf8_encode($row['sMenucardCategoryDescription']);
                $iFK_iMenucardCategoryId = $row['iMenucardCategoryId'];

                
                 //Get all menucarditem for the category
                 $sQueryItem = $this->conPDO->prepare("SELECT * FROM `menucarditem`
                                                WHERE `iFK_iMenucardCategoryId` = :iFK_iMenucardCategoryId AND `iMenucardItemActive` = '1'");
                 $sQueryItem->bindValue(':iFK_iMenucardCategoryId', $iFK_iMenucardCategoryId);
                 
                 try
                 {
                    $x = 0;
                    $sQueryItem->execute(); 
                    
                    while ($rowItem = $sQueryItem->fetch(PDO::FETCH_ASSOC)) 
                    {
                        $aMenucard['aMenucardCategoryItems'.$i]['sMenucardItemName'][$x] = utf8_encode($rowItem['sMenucardItemName']);
                        $aMenucard['aMenucardCategoryItems'.$i]['sMenucardItemNumber'][$x] = utf8_encode($rowItem['sMenucardItemNumber']);
                        $aMenucard['aMenucardCategoryItems'.$i]['sMenucardItemDescription'][$x] = utf8_encode($rowItem['sMenucardItemDescription']);
                        $aMenucard['aMenucardCategoryItems'.$i]['iMenucardItemPrice'][$x] = $rowItem['iMenucardItemPrice'];
                        $x++;
                    }
                 }  
                 catch (PDOException $e)
                 {
                     die($e->getMessage()); 
                 }
                 
                 $i++;
            }
            
            //Get restuarent info for the menucard
            $sQuery = $this->conPDO->prepare("SELECT * FROM `restuarentinfo`
                                                WHERE `iRestuarentInfoId` = :iFK_RestuarentInfoId LIMIT 1");
            $sQuery->bindValue(':iFK_RestuarentInfoId', $iFK_RestuarentInfoId);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $aMenucard['sRestuarentName'] = utf8_encode($aResult['sRestuarentInfoName']);
            $aMenucard['sRestuarentPhone'] = $aResult['sRestuarentInfoPhone'];
            $aMenucard['sRestuarentAddress'] = utf8_encode($aResult['sRestuarentInfoAddress']);             
            
            //var_dump($aMenucard);
            return $aMenucard;
        }
        else
        {
            return $aMenucard;
        }
        
    }
    
    public function AddMenucardInfo () 
    {
        //TODO: Insert menucard info into database
    }
    
    
    private function GetDanishDayname($sDayname)
    {
        if($sDayname == 'Monday') return 'Mandag';
        if($sDayname == 'Tuesday') return 'Tirsdag';
        if($sDayname == 'Wednesday') return 'Onsdag';
        if($sDayname == 'Thursday') return 'Torsdag';
        if($sDayname == 'Friday') return 'Fredag';
        if($sDayname == 'Saturday') return 'Lørdag';
        if($sDayname == 'Sunday') return 'Søndag';       
    }
}
?>
