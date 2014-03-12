<?php

class MenucardController
{
    private $oMenucard;
    private $oMenucardCategory;
    private $oMenucardItem;
    private $oMenucardInfo;
    private $oSecurityController;
    private $oStampcardController;
    private $oMessageController;
    
    private $oBcrypt;
    private $conPDO;

    public function __construct() 
    {

        require_once 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
        
        
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
        
        if(!class_exists('SecurityController') )
        {
            require 'SecurityController.php';
            $this->oSecurityController = new SecurityController();
        }
        
        require_once 'StampcardController.php';
        $this->oStampcardController = new StampcardController();
        
        require_once 'MessageController.php';
        $this->oMessageController = new MessageController();
    }
    
    //Add menucard when registreting a new user 
    public function AddNewMenucard($sMenucardName,$iFK_iRestuarentInfoId)
    {
        $sQuery = $this->conPDO->prepare("INSERT INTO menucard (sMenucardName,iMenucardSerialNumber,iFK_iRestuarentInfoId) VALUES (:sMenucardName,:iMenucardSerialNumber,:iFK_iRestuarentInfoId)");
        $sQuery->bindValue(":sMenucardName", utf8_decode(urldecode($sMenucardName)));
        $sQuery->bindValue(':iFK_iRestuarentInfoId', $iFK_iRestuarentInfoId);
        $sQuery->bindValue(':iMenucardSerialNumber', $this->CreateSerialNumber($iFK_iRestuarentInfoId));
        $sQuery->execute();
        
        //Get the last inserted id
        $iMenucardId = $this->conPDO->lastInsertId();
        

        $iMenucardIdHashed = $this->oBcrypt->genHash($iMenucardId);

        $sQuery = $this->conPDO->prepare("UPDATE menucard SET iMenucardIdHashed = :iMenucardIdHashed WHERE iMenucardId = :iMenucardId LIMIT 1");
        $sQuery->bindValue(':iMenucardIdHashed', $iMenucardIdHashed);
        $sQuery->bindValue(':iMenucardId', $iMenucardId);
        $sQuery->execute();
        
        
        //Create Default menucardinfo
        $sQuery = $this->conPDO->prepare("INSERT INTO menucardinfo (sMenucardInfoHeadline,sMenucardInfoParagraph,iFK_iMenucardId) VALUES (:Headline,:Text,:iMenucardId)");
        $sQuery->bindValue(':Headline', "Overskift");
        $sQuery->bindValue(':Text', "Her kan du skrive oplysninger om dit sted!");
        $sQuery->bindValue(':iMenucardId', $iMenucardId);
        $sQuery->execute();
        
        //Create Default menucardcategory 
        $sQuery = $this->conPDO->prepare("INSERT INTO menucardcategory (sMenucardCategoryName,sMenucardCategoryDescription,iFK_iMenucardId) VALUES (:Categoryname,:CategoryDesc,:iMenucardId)");
        $sQuery->bindValue(':Categoryname', "Kategori overskift");
        $sQuery->bindValue(':CategoryDesc', "Beskrivelse af kategorien");
        $sQuery->bindValue(':iMenucardId', $iMenucardId);
        $sQuery->execute();
       
        //Create hashed id for Category
        $iMenucardCategoryId = $this->conPDO->lastInsertId();                   
        $iMenucardCategoryHashedId = $this->oBcrypt->genRandId($iMenucardCategoryId);
        $sQuery = $this->conPDO->prepare("UPDATE menucardcategory SET iMenucardCategoryIdHashed = :iMenucardCategoryHashedId WHERE iMenucardCategoryId = :iMenucardCategoryId LIMIT 1");
        $sQuery->bindValue(':iMenucardCategoryHashedId', $iMenucardCategoryHashedId);
        $sQuery->bindValue(':iMenucardCategoryId', $iMenucardCategoryId);
        $sQuery->execute();
        
        
        //Create items (3) for the category
        $sQuery = $this->conPDO->prepare("INSERT INTO menucarditem (sMenucardItemName,sMenucardItemNumber,sMenucardItemDescription,iMenucardItemPrice,iMenucardItemPlaceInList,iFK_iMenucardCategoryId) 
                                            VALUES (:sMenucardItemName,:sMenucardItemNumber,:sMenucardItemDescription,:iMenucardItemPrice,:iMenucardItemPlaceInList,:iFK_iMenucardCategoryId)");
        $sQuery->bindValue(':sMenucardItemName', "Produkt navn");
        $sQuery->bindValue(':sMenucardItemNumber', "1");
        $sQuery->bindValue(':sMenucardItemDescription', "Beskrivelse");
        $sQuery->bindValue(':iMenucardItemPrice', 1);
        $sQuery->bindValue(':iMenucardItemPlaceInList', 1);
        $sQuery->bindValue(':iFK_iMenucardCategoryId', $iMenucardCategoryId);
        $sQuery->execute();
        
        //Create hashed id for item
        $iMenucardItemId = $this->conPDO->lastInsertId();
        $iMenucardItemIdHashed = $this->oBcrypt->genRandId($iMenucardItemId);
        $sQuery = $this->conPDO->prepare("UPDATE menucarditem SET iMenucardItemIdHashed = :iMenucardItemIdHashed WHERE iMenucardItemId = :iMenucardItemId LIMIT 1");
        $sQuery->bindValue(':iMenucardItemIdHashed', $iMenucardItemIdHashed);
        $sQuery->bindValue(':iMenucardItemId', $iMenucardItemId);
        $sQuery->execute();
        
        
        return $iMenucardId;
    }
    
    //Add a Menucard If there are not previous menucards //TODO: Maybe delete this function if it is not used anymore
    public function AddMenucard () 
    {  
        $aMenucard = array(
                'sFunction' => 'AddMenucard',
                'result' => false
            );
        
        if(isset($_GET['sJSONMenucard']))
        {
            $aMenucard['result'] = true;
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
                    
                    $iMenucardCategoryHashedId = $this->oBcrypt->genRandId($iMenucardCategoryId);

                    $sQuery = $this->conPDO->prepare("UPDATE menucardcategory SET iMenucardCategoryIdHashed = ? WHERE iMenucardCategoryId = ? LIMIT 1");

                    $sQuery->bindValue(1, $iMenucardCategoryHashedId);
                    $sQuery->bindValue(2, $iMenucardCategoryId);

                    try
                    {
                        $sQuery->execute();
                    }
                    catch (PDOException $e)
                    {
                       die($e->getMessage()); 
                    }
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
                        
                        //Generate new hashedId and update the new item
                        $iMenucardItemId = $this->conPDO->lastInsertId();

                        $iMenucardItemIdHashed = $this->oBcrypt->genRandId($iMenucardItemId);

                        $sQuery = $this->conPDO->prepare("UPDATE menucarditem SET iMenucardItemIdHashed = :iMenucardItemIdHashed WHERE iMenucardItemId = :iMenucardItemId LIMIT 1");

                        $sQuery->bindValue(':iMenucardItemIdHashed', $iMenucardItemIdHashed);
                        $sQuery->bindValue(':iMenucardItemId', $iMenucardItemId);
                        
                        try
                        {
                            $sQuery->execute();
                        }
                        catch (PDOException $e)
                        {
                           die($e->getMessage()); 
                        }
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
        return $aMenucard;
    }
    
    
    
    public function UpdateMenucard ()
    {
        $aMenucard = array(
                'sFunction' => 'UpdateMenucard',
                'result' => false
            );
        
        if(isset($_GET['sJSONMenucard']))
        {   
            //Check if a session is NOT started
            if(!isset($_SESSION['sec_session_id']))
            { 
                $this->oSecurityController->sec_session_start();
            }

            //Check if user is logged in
            if($this->oSecurityController->login_check() == true)
            {
                $aMenucard['result'] = true;
            
            
            
            
                //Get the JSON string
                $sJSONMenucard = $_GET['sJSONMenucard'];
                //Convert the JSON string into an array
                $aJSONMenucard = json_decode($sJSONMenucard);

                //var_dump($aJSONMenucard);

                //Get MenucardIdHashed
                $MenucardIdHashed = $aJSONMenucard->iMenucardIdHashed;
                //Get MenucardName
                $sMenucardName = $aJSONMenucard->sMenucardname;

                //Set the MenucardClass
                $this->oMenucard->SetMenucard($sMenucardName);

                //Update menucard name and description
                $sQuery = $this->conPDO->prepare("UPDATE menucard SET sMenucardName = :sMenucardName WHERE iMenucardIdHashed = :iMenucardIdHashed");

                //Get the menucard
                $oMenucard = $this->oMenucard->GetMenucard();


                $sQuery->bindValue(':sMenucardName', $oMenucard->sMenucardName);
                $sQuery->bindValue(':iMenucardIdHashed', $MenucardIdHashed);

                //Execute the query
                try
                {
                    $sQuery->execute();
                }
                catch(PDOException $e)
                {
                    die($e->getMessage());
                }


                //Check for which Categories should be deleted, if a category is deleted then delete all the items from that category
                //Get all categories from database
                $MenucardCategoriesFromDB = array();
                $sQuery = $this->conPDO->prepare("SELECT menucardcategory.iMenucardCategoryIdHashed FROM menucardcategory
                                                    INNER JOIN menucard
                                                    ON menucard.iMenucardId = menucardcategory.iFK_iMenucardId
                                                    WHERE menucard.iMenucardIdHashed = :iMenucardIdHashed");
                $sQuery->bindValue(':iMenucardIdHashed', $MenucardIdHashed);

                try
                {
                    $sQuery->execute();
                }
                catch(PDOException $e)
                {
                    die($e->getMessage());
                }

                while( $aResult = $sQuery->fetch(PDO::FETCH_ASSOC))
                {
                    $MenucardCategoriesFromDB[] = $aResult['iMenucardCategoryIdHashed'];
                }
                //echo "Categoris from DB";
                //var_dump($MenucardCategoriesFromDB);

                //Get all categories from $aJSONMenucard. If the category has value new if should be inseted into the database, as a new category
                 //Get the number of MenucardCategories
                $iNumberOfMenucardCategories = $aJSONMenucard->iLastIndexofMenucardCategories;

                //Get the first MenucardCategory from MenuCard
                for($iCategoryIndex=0;$iNumberOfMenucardCategories >= $iCategoryIndex;$iCategoryIndex++)
                {              
                    $MenucardCategoriesFromaJSONMenucard[] = $aJSONMenucard->$iCategoryIndex->iId;
                }

                //echo "<br>Categoris from sJSONMenucard";
                //var_dump($MenucardCategoriesFromaJSONMenucard);

                //Compare the two arrays
                $diff = array_merge(array_diff($MenucardCategoriesFromaJSONMenucard, $MenucardCategoriesFromDB), array_diff($MenucardCategoriesFromDB, $MenucardCategoriesFromaJSONMenucard));

                //echo "<br>Delete all these Categories";
                //var_dump($diff);

                //Delete all the categories that are in the diff array, if there is as value with new then insert that into the database
                foreach ($diff as $sMenucardCategoryIdHashed)
                {
                    //Delete all categories that are not new categories
                    if($sMenucardCategoryIdHashed != 'new')
                    {
                        //The the iMenucardCategoryId
                        $sQuery = $this->conPDO->prepare("SELECT iMenucardCategoryId FROM menucardcategory WHERE iMenucardCategoryIdHashed = :iMenucardCategoryIdHashed LIMIT 1");
                        $sQuery->bindValue(':iMenucardCategoryIdHashed', $sMenucardCategoryIdHashed);
                        try
                        {
                            //Delete the items related to the category
                            $sQuery->execute();
                            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                            $iMenucardCategoryId = $aResult['iMenucardCategoryId'];

                            $sQuery = $this->conPDO->prepare("DELETE FROM menucarditem WHERE iFK_iMenucardCategoryId = :iFK_iMenucardCategoryId");
                            $sQuery->bindValue(':iFK_iMenucardCategoryId', $iMenucardCategoryId);

                            try
                            {
                                $sQuery->execute();

                                //Delete the category
                                $sQuery = $this->conPDO->prepare("DELETE FROM menucardcategory WHERE iMenucardCategoryId = :iMenucardCategoryId");
                                $sQuery->bindValue(':iMenucardCategoryId', $iMenucardCategoryId);

                                try
                                {
                                    $sQuery->execute();
                                }
                                catch (PDOException $e)
                                {
                                    die($e->getMessage());
                                }
                            }
                            catch (PDOException $e)
                            {
                                die($e->getMessage());
                            }
                        }
                        catch (PDOException $e)
                        {
                            die($e->getMessage());
                        }      
                    }
                }



                //Update all categories from the sJSONMenucard array                    

                //Array for getting all the items
                $aMenucardItemsFromsJSON = array();
                //Array for checking item not to be deleted
                $aNotToBeDeletedItem = array();
                //Get the first MenucardCategory from MenuCard
                for($iCategoryIndex=0;$iNumberOfMenucardCategories >= $iCategoryIndex;$iCategoryIndex++)
                {
                    //Check for new category
                    $bNewCategory = false;

                    $sMenucardCategoryIdHashed = $aJSONMenucard->$iCategoryIndex->iId;
                    $sMenucardCategoryName = utf8_decode($aJSONMenucard->$iCategoryIndex->sMenucardCategoryName);              
                    $sMenucardCategoryDescription = utf8_decode($aJSONMenucard->$iCategoryIndex->sMenucardCategoryDescription);

                    //Set the MenucardCategoryClass
                    $this->oMenucardCategory->SetMenucardCategory($sMenucardCategoryName, $sMenucardCategoryDescription);
                    if($sMenucardCategoryIdHashed == 'new')
                    {   
                        $bNewCategory = true;
                        //Get the iMenucardId based on the iMenucardIdHashed
                        $sQuery = $this->conPDO->prepare("SELECT iMenucardId FROM menucard WHERE iMenucardIdHashed = :iMenucardIdHashed LIMIT 1");
                        $sQuery->bindValue(':iMenucardIdHashed', $MenucardIdHashed);
                        $sQuery->execute();

                        $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                        $iMenucardId = $aResult['iMenucardId'];

                        //Insert the new MenucardCategory
                        $sQuery = $this->conPDO->prepare("INSERT INTO menucardcategory (sMenucardCategoryName,sMenucardCategoryDescription,iFK_iMenucardId) VALUES (:sMenucardCategoryName,:sMenucardCategoryDescription,:iMenucardId)");

                        //Get the Menucard Category
                        $oMenucardCategory = $this->oMenucardCategory->GetMenucardCategory();

                        $sQuery->bindValue(':sMenucardCategoryName', $sMenucardCategoryName);
                        $sQuery->bindValue(':sMenucardCategoryDescription', $sMenucardCategoryDescription);
                        $sQuery->bindValue(':iMenucardId', $iMenucardId);

                        try
                        {
                            $sQuery->execute();

                            //Generate new hashedId and update the new category
                            $iMenucardCategoryId = $this->conPDO->lastInsertId();

                            $iMenucardCategoryHashedId = $this->oBcrypt->genRandId($iMenucardCategoryId);

                            $sQuery = $this->conPDO->prepare("UPDATE menucardcategory SET iMenucardCategoryIdHashed = ? WHERE iMenucardCategoryId = ? LIMIT 1");

                            $sQuery->bindValue(1, $iMenucardCategoryHashedId);
                            $sQuery->bindValue(2, $iMenucardCategoryId);

                            try
                            {
                                $sQuery->execute();
                            }
                            catch (PDOException $e)
                            {
                               die($e->getMessage()); 
                            }                       
                        }
                        catch (PDOException $e)
                        {
                           die($e->getMessage()); 
                        }   
                    }
                    else
                    {
                        //Update the MenucardCategory
                        $sQuery = $this->conPDO->prepare("UPDATE menucardcategory SET sMenucardCategoryName = :sMenucardCategoryName, sMenucardCategoryDescription = :sMenucardCategoryDescription WHERE iMenucardCategoryIdHashed = :sMenucardCategoryIdHashed LIMIT 1");

                        //Get the Menucard Category
                        $oMenucardCategory = $this->oMenucardCategory->GetMenucardCategory();

                        $sQuery->bindValue(':sMenucardCategoryName', $oMenucardCategory->sMenucardCategoryName);
                        $sQuery->bindValue(':sMenucardCategoryDescription', $oMenucardCategory->sMenucardCategoryDescription);
                        $sQuery->bindValue(3, $sMenucardCategoryIdHashed);

                        try
                        {
                            $sQuery->execute();

                            //Get iMenucardCategorId which is used when updating the items
                            $sQuery = $this->conPDO->prepare("SELECT iMenucardCategoryId FROM menucardcategory WHERE iMenucardCategoryIdHashed = :iMenucardCategoryIdHashed LIMIT 1");
                            $sQuery->bindValue(":iMenucardCategoryIdHashed", $sMenucardCategoryIdHashed);
                            try
                            {
                                $sQuery->execute();
                                $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                                $iMenucardCategoryId = $aResult['iMenucardCategoryId'];
                            }
                            catch (PDOException $e)
                            {
                               die($e->getMessage()); 
                            }

                        }
                        catch (PDOException $e)
                        {
                           die($e->getMessage()); 
                        }
                    }


                    //Get last index of MenucardItem from the MenucardCategory array
                    $iLastMenucardItemIndex = $aJSONMenucard->$iCategoryIndex->iLastMenucardItemIndex;

                    //Get all the MenucardItem
                    //Insert the new item for the new category
                    for($i=0;$iLastMenucardItemIndex >= $i;$i++)
                    {   
                        //Check if the object is not empty
                        if(isset($aJSONMenucard->$iCategoryIndex->$i->sTitle))
                        {
                            $sMenucardItemName = utf8_decode($aJSONMenucard->$iCategoryIndex->$i->sTitle);
                            $iMenucardItemIdHashed = $aJSONMenucard->$iCategoryIndex->$i->iId;
                            //Save the item to see which item should be deleted later
                            $aMenucardItemsFromsJSON[] = $aJSONMenucard->$iCategoryIndex->$i->iId;
                            $sMenucardItemNumber = utf8_decode($aJSONMenucard->$iCategoryIndex->$i->iNumber);
                            $sMenucardItemDescription = utf8_decode($aJSONMenucard->$iCategoryIndex->$i->sDescription);                    
                            $iMenucardItemPrice = $aJSONMenucard->$iCategoryIndex->$i->iPrice;
                            $iMenucardItemPlaceInList = $aJSONMenucard->$iCategoryIndex->$i->iPlaceInList; 

                            //Set the MenucardItemClass
                            $this->oMenucardItem->SetMenucardItem($sMenucardItemName, $sMenucardItemNumber, $iMenucardItemPrice, $sMenucardItemDescription);

                            //Check if the item is new 
                            if($iMenucardItemIdHashed == '')
                            {

                                //Insert the new items
                                //Insert the menucarditem. remember to use the FK for menucardcetegory
                                $sQuery = $this->conPDO->prepare("INSERT INTO menucarditem (sMenucardItemName,sMenucardItemNumber,sMenucardItemDescription,iMenucardItemPrice,iMenucardItemPlaceInList,iFK_iMenucardCategoryId) VALUES (?,?,?,?,?,?)");

                                //Get the menucarditem
                                $oMenucardItem = $this->oMenucardItem->GetMenucardItem();

                                $sQuery->bindValue(1, $oMenucardItem->sMenucardItemName);
                                $sQuery->bindValue(2, $oMenucardItem->sMenucardItemNumber);               
                                $sQuery->bindValue(3, $oMenucardItem->sMenucardItemDescription);
                                $sQuery->bindValue(4, $oMenucardItem->iMenucardItemPrice);
                                $sQuery->bindValue(5, $iMenucardItemPlaceInList); 
                                $sQuery->bindValue(6, $iMenucardCategoryId);
                                
                                try
                                {
                                    $sQuery->execute();

                                    //Generate new hashedId and update the new item
                                    $iMenucardItemId = $this->conPDO->lastInsertId();

                                    $iMenucardItemIdHashed = $this->oBcrypt->genRandId($iMenucardItemId);
                                    $aNotToBeDeletedItem[] = $iMenucardItemIdHashed;
                                    $sQuery = $this->conPDO->prepare("UPDATE menucarditem SET iMenucardItemIdHashed = :iMenucardItemIdHashed WHERE iMenucardItemId = :iMenucardItemId LIMIT 1");

                                    $sQuery->bindValue(':iMenucardItemIdHashed', $iMenucardItemIdHashed);
                                    $sQuery->bindValue(':iMenucardItemId', $iMenucardItemId);

                                    try
                                    {
                                        $sQuery->execute();
                                    }
                                    catch (PDOException $e)
                                    {
                                       die($e->getMessage()); 
                                    }
                                }
                                catch (PDOException $e)
                                {
                                   die($e->getMessage()); 
                                }
                            }
                            else
                            {

                                //Update all the item from sJSONMenucard
                                $sQuery = $this->conPDO->prepare("UPDATE menucarditem SET sMenucardItemName = :sMenucardItemName , sMenucardItemNumber = :sMenucardItemNumber , sMenucardItemDescription = :sMenucardItemDescription , iMenucardItemPrice = :iMenucardItemPrice , iMenucardItemPlaceInList = :iMenucardItemPlaceInList , iFK_iMenucardCategoryId = :iFK_iMenucardCategoryId WHERE iMenucardItemIdHashed = :iMenucardItemIdHashed LIMIT 1");

                                //Get the menucarditem
                                $oMenucardItem = $this->oMenucardItem->GetMenucardItem();                                              

                                $sQuery->bindValue(':sMenucardItemName', $oMenucardItem->sMenucardItemName);
                                $sQuery->bindValue(':sMenucardItemNumber', $oMenucardItem->sMenucardItemNumber);               
                                $sQuery->bindValue(':sMenucardItemDescription', $oMenucardItem->sMenucardItemDescription);
                                $sQuery->bindValue(':iMenucardItemPrice', $oMenucardItem->iMenucardItemPrice);
                                $sQuery->bindValue(':iMenucardItemPlaceInList', $iMenucardItemPlaceInList);                               
                                $sQuery->bindValue(':iFK_iMenucardCategoryId', $iMenucardCategoryId);
                                $sQuery->bindValue(':iMenucardItemIdHashed', $iMenucardItemIdHashed);

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
                    }

                }

                //Delete all item to be deleted
                //Get iMenucardId
                $sQuery = $this->conPDO->prepare("SELECT iMenucardId FROM menucard WHERE iMenucardIdHashed = :iMenucardIdHashed LIMIT 1");
                $sQuery->bindValue(':iMenucardIdHashed', $MenucardIdHashed);

                try
                {
                    $sQuery->execute();

                    $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                    $iMenucardId = $aResult['iMenucardId'];
                }
                catch(PDOException $e)
                {
                    die($e->getMessage());
                }



                //Get ALL iMenucardCategoryId based on iMenucardIdHased               
                $sQuery = $this->conPDO->prepare("SELECT iMenucardCategoryId 
                                                    FROM menucardcategory
                                                    WHERE iFK_iMenucardId = :iMenucardId");
                $sQuery->bindValue(':iMenucardId', $iMenucardId);

                try
                {
                    $sQuery->execute();
                    $sCategoriesFromDB = '';
                    while( $aResult = $sQuery->fetch(PDO::FETCH_ASSOC))
                    {

                        $sCategoriesFromDB .= $aResult['iMenucardCategoryId'];
                        $sCategoriesFromDB .= ','; 
                    }
                    //remove last ,
                    $sCategoriesFromDB = substr($sCategoriesFromDB, 0, -1);          
                }
                catch(PDOException $e)
                {
                    die($e->getMessage());
                }

                $sQuery = "SELECT iMenucardItemIdHashed
                            FROM menucarditem
                            WHERE iFK_iMenucardCategoryId IN (".$sCategoriesFromDB.")";
                //Get all item from database for ALL categories     
                $aMenucardItemsFromDB = array();
                $sQuery = $this->conPDO->prepare($sQuery);

                try
                {
                    $sQuery->execute();
                }
                catch(PDOException $e)
                {
                    die($e->getMessage());
                }

                while( $aResult = $sQuery->fetch(PDO::FETCH_ASSOC))
                {
                    $aMenucardItemsFromDB[] = $aResult['iMenucardItemIdHashed'];
                }

                //echo "All Items from DB";
                //var_dump($aMenucardItemsFromDB);

                //Get ALL items from sJSONMenucard 
                //echo "Items from sJSONMenucard";
                //var_dump($aMenucardItemsFromsJSON);

                //Delete item to be deleted
                //Compare the two arrays
                $diff = array_merge(array_diff($aMenucardItemsFromsJSON, $aMenucardItemsFromDB), array_diff($aMenucardItemsFromDB, $aMenucardItemsFromsJSON));
                //echo "Delete all these items";
                //var_dump($diff); 


                //echo "NOT TO DELETE";
                //var_dump($aNotToBeDeletedItem);

                foreach ($diff as $iMenucardItemIdHashed)
                {
                    if($iMenucardItemIdHashed != '')
                    {
                        //Check if the item is not a new item
                        if(!in_array($iMenucardItemIdHashed, $aNotToBeDeletedItem))
                        {
                            $sQuery = $this->conPDO->prepare("DELETE FROM menucarditem WHERE iMenucardItemIdHashed = :iMenucardItemIdHashed");
                            $sQuery->bindValue(':iMenucardItemIdHashed', $iMenucardItemIdHashed);

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
                } 


                //Delete all menucardinfo
                $sQuery = $this->conPDO->prepare("DELETE FROM menucardinfo WHERE iFK_iMenucardId");
                $sQuery->bindValue(":iMenucardId", $iMenucardId);

                try
                {
                    $sQuery->execute();
                }
                catch (PDOException $e)
                {
                    die($e->getMessage());
                }

                //Get last index of menucardinfo
                $iLastIndexOfmenucardinfo = $aJSONMenucard->menucardinfo->iLastIndexOfmenucardinfo;
                //Get all the MenucardInfo
                for($i=1;$iLastIndexOfmenucardinfo >= $i;$i++)
                {
                    if(isset($aJSONMenucard->menucardinfo->$i->headline))
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
            }           
        }
        return $aMenucard;
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
                   
        }
        return $aMenucard;
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
 
        }
        return $aMenucard;
    }
    
    /* TODO: Check if this function is used anywhere maybe delete it*/
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
    
    /* TODO: check allow origin */
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
                                                WHERE `iFK_iMenucardId` = :iFK_iMenucardId
                                                ORDER BY iFK_iDayId ASC");
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
            $current_time = date('H:i:s');
            while ($row = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aMenucard['aMenucardOpeningHours'][$i]['sDayName'] = utf8_encode(substr($row['sDayName'],0,3));
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeFrom'] = substr($row['iTimeFrom'], 0, -3);
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeTo'] = substr($row['iTimeTo'], 0, -3);
                
                //Check for Openinghours hour today               
                if($row['sDayName'] == $TodayDaynameDanish)
                {                  
                    $aMenucard['sRestuarentOpenningHoursToday'] = substr($row['iTimeFrom'], 0, -3)."-".substr($row['iTimeTo'], 0, -3);                  

                    $date1 = DateTime::createFromFormat('H:i:s', $current_time);
                    $date2 = DateTime::createFromFormat('H:i:s', $row['iTimeFrom']);
                    $date3 = DateTime::createFromFormat('H:i:s', $row['iTimeTo']);

                    if ($date1 > $date2 && $date1 < $date3)
                    {
                      $aMenucard['openNow'] = 'open';
                    }
                    else{$aMenucard['openNow'] = 'closed';}
                    
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
                                                WHERE `iFK_iMenucardId` = :iFK_iMenucardId
                                                ORDER BY iFK_iDayId ASC");
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
                $aMenucard['aMenucardTakeAwayHours'][$i]['sDayName'] = utf8_encode(substr($row['sDayName'],0,3));
                $aMenucard['aMenucardTakeAwayHours'][$i]['iTimeFrom'] = substr($row['iTimeFrom'], 0, -3);
                $aMenucard['aMenucardTakeAwayHours'][$i]['iTimeTo'] = substr($row['iTimeTo'], 0, -3);
                
                //Check for TakeAway hour today               
                if($row['sDayName'] == $TodayDaynameDanish)
                {                  
                    $aMenucard['sRestuarentTakeAwayHoursToday'] = substr($row['iTimeFrom'], 0, -3)."-".substr($row['iTimeTo'], 0, -3);
                
                    $date1 = DateTime::createFromFormat('H:i:s', $current_time);
                    $date2 = DateTime::createFromFormat('H:i:s', $row['iTimeFrom']);
                    $date3 = DateTime::createFromFormat('H:i:s', $row['iTimeTo']);

                    if ($date1 > $date2 && $date1 < $date3)
                    {
                      $aMenucard['takeOutNow'] = 'open';
                    }
                    else{$aMenucard['takeOutNow'] = 'closed';}
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
                                                WHERE `iFK_iMenucardCategoryId` = :iFK_iMenucardCategoryId AND `iMenucardItemActive` = '1'
                                                ORDER BY iMenucardItemPlaceInList ASC");
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
            $aMenucard['sRestuarentSlogan'] = utf8_encode($aResult['sRestuarentInfoSlogan']);
            $aMenucard['sRestuarentPhone'] = $aResult['sRestuarentInfoPhone'];
            $aMenucard['sRestuarentAddress'] = utf8_encode($aResult['sRestuarentInfoAddress']);             
            
            
            //TODO: Get messages for the menucard
            $oMessage = $this->oMessageController->GetMessagesAppFromMenucard($iMenucardSerialNumber);
            $aMenucard['oMessages'] = $oMessage;
            
            //Get the stampcard
            $aStampcard = $this->oStampcardController->GetStampcardApp($iMenucardSerialNumber);
            $aMenucard['oStampcard'] = $aStampcard;
                  
            //var_dump($aMenucard);
            return $aMenucard;
        }
        else
        {
            return $aMenucard;
        }
        
    }
    
    public function GetMenucardAdmin()
    {
        //Get menucard for the user logged in
        
        $aMenucard = array(
                'sFunction' => 'GetMenucardAdmin',
                'result' => false
            );
        //return $aMenucard;
        //Check if a session is NOT started
        if(!isset($_SESSION['sec_session_id']))
        { 
            $this->oSecurityController->sec_session_start();
        }
        
        //Check if user is logged in
        if($this->oSecurityController->login_check() == true)
        {
            $aMenucard['result'] = true;
           
            //Get the user id
            $user_id =  $_SESSION['user_id'];
            
            //Get the $iMenucardSerialNumber from the $user_id
           
            //Get iRestuarenInfoId based on iFK_iCompanyId
            $sQuery = $this->conPDO->prepare('SELECT iMenucardSerialNumber FROM menucard
                                            INNER JOIN users
                                            ON users.iUserIdHashed = :iUserId
                                            INNER JOIN restuarentinfo
                                            ON restuarentinfo.`iFK_iCompanyInfoId` = users.`iFK_iCompanyId`
                                            WHERE menucard.`iFK_iRestuarentInfoId` = restuarentinfo.`iFK_iCompanyInfoId`');
            $sQuery->bindValue(':iUserId', $user_id);
            
            try
            {
                $sQuery->execute();             
            }
            catch (PDOException $e)
            {
               die($e->getMessage()); 
            }
            
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $iMenucardSerialNumber = $aResult['iMenucardSerialNumber'];
            
            //Get menucard based on the $iMenucardSerialNumber
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
            $aMenucard['iMenucardIdHashed'] = $aResult['iMenucardIdHashed'];
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
            $sQuery = $this->conPDO->prepare("SELECT `timeFrom`.iTime as iTimeFrom,`timeTo`.iTime as iTimeTo ,`day`.sDayName,`openinghours`.`iFK_iTimeFromId`,`openinghours`.`iFK_iTimeToId` FROM `openinghours`
                                                LEFT JOIN `day`
                                                ON `day`.`iDayId` = `openinghours`.`iFK_iDayId`
                                                LEFT JOIN `time` as timeFrom
                                                ON `timeFrom`.`iTimeId` = `openinghours`.`iFK_iTimeFromId`
                                                LEFT JOIN `time` as timeTo
                                                ON `timeTo`.`iTimeId` = `openinghours`.`iFK_iTimeToId`
                                                WHERE `iFK_iMenucardId` = :iFK_iMenucardId
                                                ORDER BY iFK_iDayId ASC");
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
            //Counter used for seeting the day and time front-end
            $x = 1;
            $TodayDayname = $today = date("l");
            $TodayDaynameDanish = $this->GetDanishDayname($TodayDayname);
            $current_time = date('H:i:s');
            while ($row = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aMenucard['aMenucardOpeningHours'][$i]['sDayName'] = utf8_encode(substr($row['sDayName'],0,3));
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeFrom'] = substr($row['iTimeFrom'], 0, -3);
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeTo'] = substr($row['iTimeTo'], 0, -3);
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeFromId'] = $row['iFK_iTimeFromId'];
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeToId'] = $row['iFK_iTimeToId'];
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeCounter'] = $x;
                //Check for Openinghours hour today               
                if($row['sDayName'] == $TodayDaynameDanish)
                {                  
                    $aMenucard['sRestuarentOpenningHoursToday'] = substr($row['iTimeFrom'], 0, -3)."-".substr($row['iTimeTo'], 0, -3);                  

                    $date1 = DateTime::createFromFormat('H:i:s', $current_time);
                    $date2 = DateTime::createFromFormat('H:i:s', $row['iTimeFrom']);
                    $date3 = DateTime::createFromFormat('H:i:s', $row['iTimeTo']);

                    if ($date1 > $date2 && $date1 < $date3)
                    {
                      $aMenucard['openNow'] = 'open';
                    }
                    else{$aMenucard['openNow'] = 'closed';}
                    
                }
                $i++;
                $x++;
            }
            
            //Get takeaway hours
            $sQuery = $this->conPDO->prepare("SELECT `timeFrom`.iTime as iTimeFrom,`timeTo`.iTime as iTimeTo ,`day`.sDayName FROM `takeaway`
                                                LEFT JOIN `day`
                                                ON `day`.`iDayId` = `takeaway`.`iFK_iDayId`
                                                LEFT JOIN `time` as timeFrom
                                                ON `timeFrom`.`iTimeId` = `takeaway`.`iFK_iTimeFromId`
                                                LEFT JOIN `time` as timeTo
                                                ON `timeTo`.`iTimeId` = `takeaway`.`iFK_iTimeToId`
                                                WHERE `iFK_iMenucardId` = :iFK_iMenucardId
                                                ORDER BY iFK_iDayId ASC");
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
                $aMenucard['aMenucardTakeAwayHours'][$i]['sDayName'] = utf8_encode(substr($row['sDayName'],0,3));
                $aMenucard['aMenucardTakeAwayHours'][$i]['iTimeFrom'] = substr($row['iTimeFrom'], 0, -3);
                $aMenucard['aMenucardTakeAwayHours'][$i]['iTimeTo'] = substr($row['iTimeTo'], 0, -3);
                
                //Check for TakeAway hour today               
                if($row['sDayName'] == $TodayDaynameDanish)
                {                  
                    $aMenucard['sRestuarentTakeAwayHoursToday'] = substr($row['iTimeFrom'], 0, -3)."-".substr($row['iTimeTo'], 0, -3);
                
                    $date1 = DateTime::createFromFormat('H:i:s', $current_time);
                    $date2 = DateTime::createFromFormat('H:i:s', $row['iTimeFrom']);
                    $date3 = DateTime::createFromFormat('H:i:s', $row['iTimeTo']);

                    if ($date1 > $date2 && $date1 < $date3)
                    {
                      $aMenucard['takeOutNow'] = 'open';
                    }
                    else{$aMenucard['takeOutNow'] = 'closed';}
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
                $aMenucard['aMenucardCategory'][$i]['iMenucardCategoryIdHashed'] = $row['iMenucardCategoryIdHashed'];
                $iFK_iMenucardCategoryId = $row['iMenucardCategoryId'];

                
                 //Get all menucarditem for the category
                 $sQueryItem = $this->conPDO->prepare("SELECT * FROM `menucarditem`
                                                WHERE `iFK_iMenucardCategoryId` = :iFK_iMenucardCategoryId AND `iMenucardItemActive` = '1'
                                                ORDER BY iMenucardItemPlaceInList ASC");
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
                        $aMenucard['aMenucardCategoryItems'.$i]['iMenucardItemIdHashed'][$x] = $rowItem['iMenucardItemIdHashed'];
                        $aMenucard['aMenucardCategoryItems'.$i]['iMenucardItemPlaceInList'][$x] = $rowItem['iMenucardItemPlaceInList'];
                        $x++;
                    }
                 }  
                 catch (PDOException $e)
                 {
                     die($e->getMessage()); 
                 }
                 
                 $i++;
            }
            
            //TODO: Move this function to the RestuarentController
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
            $aMenucard['sRestuarentInfoSlogan'] = utf8_encode($aResult['sRestuarentInfoSlogan']);
            $aMenucard['sRestuarentPhone'] = $aResult['sRestuarentInfoPhone'];
            $aMenucard['sRestuarentAddress'] = utf8_encode($aResult['sRestuarentInfoAddress']); 
            $aMenucard['iRestuarentZipcode'] = utf8_encode($aResult['iRestuarentInfoZipcode']); 
            $aMenucard['sRestuarentInfoQRcode'] = $aResult['sRestuarentInfoQRcode']; 
            
        } 
        
        return $aMenucard;
    }
    
    public function GetMenucardWithRestuarentName ()
    {
        
        $aMenucard = array(
                'sFunction' => 'GetMenucardWithRestuarentName',
                'result' => false
            );
        
        if(isset($_GET['sRestuarentName']))
        {
            
            $sRestuarentName = $_GET['sRestuarentName'];
            $sRestuarentName = str_replace("+", " ", $sRestuarentName);

            //Get the $iMenucardSerialNumber from the $sRestuarentName
            //First get the Menucard 
            $sQuery = $this->conPDO->prepare("SELECT iMenucardSerialNumber FROM menucard
                                                INNER JOIN restuarentinfo
                                                ON restuarentinfo.iRestuarentInfoId = menucard.iFK_iRestuarentInfoId
                                                WHERE sRestuarentInfoName = :sRestuarentName LIMIT 1");
            $sQuery->bindValue(':sRestuarentName', $sRestuarentName);
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
            $iMenucardSerialNumber = $aResult['iMenucardSerialNumber'];
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
            $current_time = date('H:i:s');
            while ($row = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aMenucard['aMenucardOpeningHours'][$i]['sDayName'] = utf8_encode($row['sDayName']);
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeFrom'] = substr($row['iTimeFrom'], 0, -3);
                $aMenucard['aMenucardOpeningHours'][$i]['iTimeTo'] = substr($row['iTimeTo'], 0, -3);
                
                //Check for Openinghours hour today               
                if($row['sDayName'] == $TodayDaynameDanish)
                {                  
                    $aMenucard['sRestuarentOpenningHoursToday'] = substr($row['iTimeFrom'], 0, -3)."-".substr($row['iTimeTo'], 0, -3);                  

                    $date1 = DateTime::createFromFormat('H:i:s', $current_time);
                    $date2 = DateTime::createFromFormat('H:i:s', $row['iTimeFrom']);
                    $date3 = DateTime::createFromFormat('H:i:s', $row['iTimeTo']);

                    if ($date1 > $date2 && $date1 < $date3)
                    {
                      $aMenucard['openNow'] = 'open';
                    }
                    else{$aMenucard['openNow'] = 'closed';}
                    
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
                
                    $date1 = DateTime::createFromFormat('H:i:s', $current_time);
                    $date2 = DateTime::createFromFormat('H:i:s', $row['iTimeFrom']);
                    $date3 = DateTime::createFromFormat('H:i:s', $row['iTimeTo']);

                    if ($date1 > $date2 && $date1 < $date3)
                    {
                      $aMenucard['takeOutNow'] = 'open';
                    }
                    else{$aMenucard['takeOutNow'] = 'closed';}
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
                                                WHERE `iFK_iMenucardCategoryId` = :iFK_iMenucardCategoryId AND `iMenucardItemActive` = '1'
                                                ORDER BY iMenucardItemPlaceInList ASC");
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
    
    private function CreateSerialNumber ($iFK_iRestuarentInfoId)
    {
        //Serialnumber format AA0000 (2 letter and 4 numbers)
        //In the table serialnumbers are 10.000 serialnumbers from AA0000 - AA9999
        
        //Get serialnumber
        $sQuery = $this->conPDO->prepare("SELECT sSerialnumber FROM serialnumbers WHERE iSerialnumberActive = 1 LIMIT 1");
        $sQuery->execute();
        $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
        $sSerialnumber = $aResult['sSerialnumber'];
        
        //Set serialnumber Deactive and set the reference to the menucard        
        $sQuery = $this->conPDO->prepare("UPDATE serialnumbers SET iFK_iRestuarentInfoId = :iFK_iRestuarentInfoId, iSerialnumberActive = 0 WHERE sSerialnumber = :sSerialnumber LIMIT 1");
        $sQuery->bindValue(":sSerialnumber", $sSerialnumber);
        $sQuery->bindValue(":iFK_iRestuarentInfoId", $iFK_iRestuarentInfoId);
        $sQuery->execute();
        
        //Return serialnumber
        return $sSerialnumber;
    }   
}
?>
