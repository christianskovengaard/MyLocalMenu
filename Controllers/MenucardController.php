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
    
    public function AddMenucard () //TODO: remove all functions where it uses tables between tables (it add the same thinks many times WHY!)
    {                               //TODO: Update table menucardinfo
                                    //TODO: Update table openinghours
                                    //TODO: Opdate table takeaway
        if(isset($_GET['sJSONMenucard']))
        {
            
            //Get the iCompanyId based user logged in
            //$iCompanyId = $_SESSION['iCompanyId'];
            $iCompanyId = '1';
            
            //Get the JSON string
            $sJSONMenucard = $_GET['sJSONMenucard'];
            //Convert the JSON string into an array
            $aJSONMenucard = json_decode($sJSONMenucard);
            
       
            var_dump($aJSONMenucard);
        
            
            //Get MenucardDescription
            end($aJSONMenucard);
            $sMenucardDescription = prev($aJSONMenucard);
            //Get MenucardName
            end($aJSONMenucard);
            prev($aJSONMenucard);;
            $sMenucardName = prev($aJSONMenucard);
            
            /*echo "aMenucardName ".$sMenucardName."</br>";
            echo "sMenucardDescription ".$sMenucardDescription."</br>";*/
            
            //Set the MenucardClass
            $this->oMenucard->SetMenucard($sMenucardName, $sMenucardDescription);
            
            //TODO: Inssert Menucard into database and get the FK for the menucard, and use the iCompanyId to which user created the menucard. Remember to create iMenuCardIdHashed with bCrypt
            //Get user from database based on the iUserId remember to use PDO
            $sQuery = $this->conPDO->prepare("INSERT INTO menucard (sMenucardName,sMenucardDescription,iFK_iCompanyId) VALUES (?,?,?)");
            
            //Get the menucard
            $oMenucard = $this->oMenucard->GetMenucard();
            
            //Bind the values to the ? signs
            $sQuery->bindValue(1, $oMenucard->sMenucardName);
            $sQuery->bindValue(2, $oMenucard->sMenucardDescription);
            $sQuery->bindValue(3, $iCompanyId);
            
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
            $iNumberOfMenucardCategories = end($aJSONMenucard);
            
            //Get the first MenucardCategory from MenuCard
            for($iCategoryIndex=0;$iNumberOfMenucardCategories >= $iCategoryIndex;$iCategoryIndex++)
            {
                $sMenucardCategoryName = $aJSONMenucard[$iCategoryIndex][0];
                $sMenucardCategoryId = $aJSONMenucard[$iCategoryIndex][1];
                $sMenucardCategoryDescription = $aJSONMenucard[$iCategoryIndex][2];
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
                         
                
                //Get last index of the MenucardCategory array
                $iLastMenucardItemIndex = end($aJSONMenucard[$iCategoryIndex]);

                //Get all the MenucardItems
                for($i=3;$iLastMenucardItemIndex >= $i;$i++)
                { 
                    $sMenucardItemName = $aJSONMenucard[$iCategoryIndex][$i][0];
                    $iMenucardItemId = $aJSONMenucard[$iCategoryIndex][$i][1];
                    $sMenucardItemNumber = '';
                    $sMenucardItemDescription = $aJSONMenucard[$iCategoryIndex][$i][2];
                    $iMenucardItemPrice = $aJSONMenucard[$iCategoryIndex][$i][3];
                    
                    //Set the MenucardItemClass
                    $this->oMenucardItem->SetMenucardItem($sMenucardItemName, $sMenucardItemNumber, $iMenucardItemPrice, $sMenucardItemDescription);
                    
                    
                    //Get the menucarditem
                    $oMenucardItem = $this->oMenucardItem->GetMenucardItem();
                    
                    //TODO: Insert the menucarditem. remember to use the FK ffor menucardcetegory
                    $sQuery = $this->conPDO->prepare("INSERT INTO menucarditem (sMenucardItemName,sMenucardItemNumber,sMenucardItemDescription,iMenucardItemPrice,iFK_iMenucardCategoryId) VALUES (?,?,?,?,?)");
                    $sQuery->bindValue(1, $oMenucardItem->sMenucardItemName);
                    $sQuery->bindValue(2, $oMenucardItem->sMenucardItemNumber);               
                    $sQuery->bindValue(3, $oMenucardItem->sMenucardItemDescription);
                    $sQuery->bindValue(4, $oMenucardItem->iMenucardItemPrice);
                    $sQuery->bindValue(5, $iMenucardCategoryId);
                    
                    try
                    {
                        $sQuery->execute();
                        
                        //Update the menucardcategory_menucarditem
                        //$iMenucardItemId = $this->conPDO->lastInsertId();             

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
                    
                    /*echo "MenucardItemName ".$sMenucardItemName."</br>";
                    echo "MenucardItemDesc ".$sMenucardItemDescription."</br>";
                    echo "MenucardItemPrice ".$iMenucardItemPrice."</br></br>";*/


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
    
    public function GetMenucard ()
    {
        
    }
    
    public function DeleteMenucard ()
    {
        
    }
}
?>
