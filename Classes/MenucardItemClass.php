<?php

class MenucardItemClass
{
    
    private $iMenucardItemId;
    private $sMenucardItemName;
    private $sMenucardItemNumber;
    private $iMenucardItemPrice;
    private $sMenucardItemDescription;


    public function __construct() {
        ;
    }
    /* 
  
 
  
  Hvert punkt i en kategori have et id, nummer, navn, tekst og pris */
    public function SetMenucardItem ($sMenucardItemName,$sMenucardItemNumber,$iMenucardItemPrice,$sMenucardItemDescription)
    {
        $this->sMenucardItemName = $sMenucardItemName;
        $this->sMenucardItemNumber = $sMenucardItemNumber;
        $this->iMenucardItemPrice = $iMenucardItemPrice;
        $this->sMenucardItemDescription = $sMenucardItemDescription;
    }
    
    public function GetMenucardItem ()
    {
        $oMenucardItem = new stdClass();
        $oMenucardItem->sMenucardItemName = $this->sMenucardItemName;
        $oMenucardItem->sMenucardItemNumber = $this->sMenucardItemNumber;
        $oMenucardItem->iMenucardItemPrice = $this->iMenucardItemPrice;
        $oMenucardItem->sMenucardItemDescription = $this->sMenucardItemDescription;
        
        return $oMenucardItem;
    }
}
?>
