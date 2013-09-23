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
        require '../Classes/MenucardClass.php';
        $this->oMenucard = new MenucardClass();
        
        require '../Classes/MenucardCategoryClass.php';
        $this->oMenucardCategory = new MenucardCategoryClass();
        
        require '../Classes/MenucardItemClass.php';
        $this->oMenucardItem = new MenucardItemClass();
        
        require 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
    }
    
    public function AddMenucard ()
    {
        if(isset($_GET['sJSONMenucard']))
        {
            //Get the JSON string
            $sJSONMenucard = $_GET['sJSONMenucard'];
            //Convert the JSON string into an array
            $aJSONMenucard = json_decode($sJSONMenucard);
            
            //Get MenucardDescription
            end($aJSONMenucard);
            $sMenucardDescription = prev($aJSONMenucard);
            //Get MenucardName
            end($aJSONMenucard);
            prev($aJSONMenucard);;
            $sMenucardName = prev($aJSONMenucard);
            
            echo "aMenucardName ".$sMenucardName."</br>";
            echo "sMenucardDescription ".$sMenucardDescription."</br>";
            
            //Set the MenucardClass
            $oMenucard = $this->oMenucard->SetMenucard($sMenucardName, $sMenucardDescription);
            
            //TODO: Inssert Menucard into database and get the FK for the menucard, and use the iCompanyId to which user created the menucard. Remember to create iMenuCardIdHashed with bCrypt
            
            //Get the number of MenucardCategories
            $iNumberOfMenucardCategories = end($aJSONMenucard);
            
            //Get the first MenucardCategory from MenuCard
            for($iCategoryIndex=0;$iNumberOfMenucardCategories >= $iCategoryIndex;$iCategoryIndex++)
            {
                $sMenucardCategoryName = $aJSONMenucard[$iCategoryIndex][0];
                $sMenucardCategoryId = $aJSONMenucard[$iCategoryIndex][1];
                $sMenucardCategoryDescription = $aJSONMenucard[$iCategoryIndex][2];
                echo "sMenucardCategoryName ".$sMenucardCategoryName."</br>";
                echo "sMenucardCategoryId: ".$sMenucardCategoryId."</br>";
                echo "sMenucardCategoryDescription: ".$sMenucardCategoryDescription."</br>";
                echo "</br>";
                
                //Set the MenucardCategoryClass
                $oMenucardCategory = $this->oMenucardCategory->SetMenucardCategory($sMenucardCategoryName, $sMenucardCategoryDescription);
                
                //TODO: Insert the new category remember to use the menucard FK
                
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
                    $oMenucardItem = $this->oMenucardItem->SetMenucardItem($sMenucardItemName, $sMenucardItemNumber, $iMenucardItemPrice, $sMenucardItemDescription);
                    
                    //TODO: Insert the menucarditem. remember to use the FK ffor menucardcetegory
                    
                    echo "MenucardItemName ".$sMenucardItemName."</br>";
                    echo "MenucardItemDesc ".$sMenucardItemDescription."</br>";
                    echo "MenucardItemPrice ".$iMenucardItemPrice."</br></br>";


                }
            
            }
            
            
            echo "<h1>Hele arrayet</h1>";
            echo '<pre>';
                print_r($aJSONMenucard);
            echo '</pre>';
            //TODO: Get all the data and save it in the database
            
            
            
        }
        return true;
    }
    
    public function UpdateMencard ()
    {
        
    }
}
?>
