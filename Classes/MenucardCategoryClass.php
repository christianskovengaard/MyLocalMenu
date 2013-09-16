<?php

class MenucardCategoryClass
{
    private $iMenucardCategoryId;
    private $sMenucardCategoryName;
    private $sMenucardCategoryDescription;
    private $iMenucardCategoryFK;

    public function __construct() {
        ;
    }
     
    public function SetMenucardCategory ($sMenucardCategoryName,$sMenucardCategoryDescription)
    {
        $this->sMenucardCategoryName = $sMenucardCategoryName;
        $this->sMenucardCategoryDescription = $sMenucardCategoryDescription;
    }
    
    public function GetMenucardCategory ()
    {
        $oMenucardCategory = new stdClass();
        $oMenucardCategory->sMenucardCategoryName = $this->sMenucardCategoryName;
        $oMenucardCategory->sMenucardCategoryDescription = $this->sMenucardCategoryDescription;
        
        return $oMenucardCategory;
    }
}
?>
