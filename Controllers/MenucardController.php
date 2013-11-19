<?php

class MenucardController
{
    private $oMenucard;
    private $oMenucardCategory;
    private $oMenucardItem;
    
    private $oBcrypt;
    private $conPDO;

    public function __construct() 
    {
        
        require '../Classes/bcrypt.php';
        $this->oBcrypt = new Bcrypt();
        
        require '../Classes/MenucardClass.php';
        $this->oMenucard = new MenucardClass();
        
        require '../Classes/MenucardCategoryClass.php';
        $this->oMenucardCategory = new MenucardCategoryClass();
        
        require '../Classes/MenucardItemClass.php';
        $this->oMenucardItem = new MenucardItemClass();
        
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
            
            //Get the JSON string
            $sJSONMenucard = $_GET['sJSONMenucard'];
            //Convert the JSON string into an array
            $aJSONMenucard = json_decode($sJSONMenucard);
        
            
            //Get MenucardID
            end($aJSONMenucard);
            $sMenucardID = prev($aJSONMenucard);
            //Get MenucardDescription
            $sMenucardDescription = prev($aJSONMenucard);
            //Get MenucardName
            $sMenucardName = prev($aJSONMenucard);
            
            //Set the MenucardClass
            $this->oMenucard->SetMenucard($sMenucardName, $sMenucardDescription);
            
            //TODO: Inssert Menucard into database and get the FK for the menucard, and use the iCompanyId to which user created the menucard. Remember to create iMenuCardIdHashed with bCrypt
            //Get user from database based on the iUserId remember to use PDO
            $sQuery = $this->conPDO->prepare("INSERT INTO menucard (sMenucardName,iFK_iCompanyId) VALUES (?,?)");
            
            //Get the menucard
            $oMenucard = $this->oMenucard->GetMenucard();
            

            //Bind the values to the ? signs
            $sQuery->bindValue(1, $oMenucard->sMenucardName);
            $sQuery->bindValue(2, $iCompanyId);
            
            //Execute the query
            try
            {
                $sQuery->execute();
                
                //Get the last inserted id
                $iMenucardId = $this->conPDO->lastInsertId();
                //echo "last id: ".$iMenucardId;
                $iMenucardIdHashed = $this->oBcrypt->genHash($iMenucardId);
                //echo "hashed: ".$iMenucardIdHashed;
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
            $iNumberOfMenucardCategories = end($aJSONMenucard);
            
            //Get the first MenucardCategory from MenuCard
            for($iCategoryIndex=1;$iNumberOfMenucardCategories >= $iCategoryIndex;$iCategoryIndex++)
            {
                $sMenucardCategoryName = utf8_decode($aJSONMenucard[$iCategoryIndex][0]);
                $sMenucardCategoryId = $aJSONMenucard[$iCategoryIndex][1];
                $sMenucardCategoryDescription = utf8_decode($aJSONMenucard[$iCategoryIndex][2]);
                /*echo "sMenucardCategoryName ".$sMenucardCategoryName."</br>";
                echo "sMenucardCategoryId: ".$sMenucardCategoryId."</br>";
                echo "sMenucardCategoryDescription: ".$sMenucardCategoryDescription."</br>";
                echo "</br>";*/
                
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
                         
                
                //Get last index of the MenucardCategory array
                $iLastMenucardItemIndex = end($aJSONMenucard[$iCategoryIndex]);

                //Get all the MenucardItems
                for($i=3;$iLastMenucardItemIndex >= $i;$i++)
                { 
                    $sMenucardItemName = utf8_decode($aJSONMenucard[$iCategoryIndex][$i][0]);
                    $iMenucardItemId = $aJSONMenucard[$iCategoryIndex][$i][1];
                    $sMenucardItemNumber = $aJSONMenucard[$iCategoryIndex][$i][4];
                    $sMenucardItemDescription = utf8_decode($aJSONMenucard[$iCategoryIndex][$i][2]);
                    
                    $iMenucardItemPrice = $aJSONMenucard[$iCategoryIndex][$i][3];
                    
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
                    
                    /*echo "MenucardItemName ".$sMenucardItemName."</br>";
                    echo "MenucardItemDesc ".$sMenucardItemDescription."</br>";
                    echo "MenucardItemPrice ".$iMenucardItemPrice."</br></br>";
                    echo "sMenucardItemNumber ".$sMenucardItemNumber."</br></br>";*/

                }
            
            }
            
            
            /*echo "<h1>Hele arrayet</h1>";
            echo '<pre>';
                print_r($aJSONMenucard);
            echo '</pre>';*/
                        
        }
        return true;
    }
    
    public function UpdateMencard ()
    {
        
    }
    
    public function GetMenucardWithSerialNumber ()
    {
        
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
            $aMenucard['sMenucardName'] = $aResult['sMenucardName'];
            $iFK_iMenucardInfoId = $aResult['iFK_iMenucardInfoId'];
            $iMenucardId = $aResult['iMenucardId'];
            
            
            //Get all menucardinfo
            $sQuery = $this->conPDO->prepare("SELECT * FROM `menucardinfo`
                                               WHERE `iFK_iMenucardId` = :iFK_iMenucardInfoId
                                               AND `iMenucardInfoActive` = '1'");
            $sQuery->bindValue(':iFK_iMenucardInfoId', $iFK_iMenucardInfoId);
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
                $aMenucard['aMenucardInfo'][$i]['sMenucardInfoHeadline'] = $row['sMenucardInfoHeadline'];
                $aMenucard['aMenucardInfo'][$i]['sMenucardInfoParagraph'] = $row['sMenucardInfoParagraph'];
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
                $aMenucard['aMenucardOpeningHours'][$i]['sDayName'] = $row['sDayName'];
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
                $aMenucard['aMenucardTakeAwayHours'][$i]['sDayName'] = $row['sDayName'];
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
                $aMenucard['aMenucardCategory'][$i]['sMenucardCategoryName'] = $row['sMenucardCategoryName'];
                $aMenucard['aMenucardCategory'][$i]['sMenucardCategoryDescription'] = $row['sMenucardCategoryDescription'];
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
                        $aMenucard['aMenucardCategoryItems'.$i]['sMenucardItemName'][$x] = $rowItem['sMenucardItemName'];
                        $aMenucard['aMenucardCategoryItems'.$i]['sMenucardItemNumber'][$x] = $rowItem['sMenucardItemNumber'];
                        $aMenucard['aMenucardCategoryItems'.$i]['sMenucardItemDescription'][$x] = $rowItem['sMenucardItemDescription'];
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
                                                WHERE `iFK_iMenucardId` = :iFK_iMenucardId LIMIT 1");
            $sQuery->bindValue(':iFK_iMenucardId', $iMenucardId);
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $aMenucard['sRestuarentName'] = $aResult['sRestuarentInfoName'];
            $aMenucard['sRestuarentPhone'] = $aResult['sRestuarentInfoPhone'];
            $aMenucard['sRestuarentAddress'] = $aResult['sRestuarentInfoAddress'];
            
            
            //var_dump($aMenucard);
            return $aMenucard;
            
            
   
        }
        else
        {
            return $aMenucard;
        }
        
    }
    
    public function DeleteMenucard ()
    {
        
    }
    
    public function AddMenucardInfo () 
    {
        //TODO: Insert menucard info into database
    }  
}
?>
