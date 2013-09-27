<?php

class MenucardClass
{
    private $iMenucardIdHashed;
    private $sMenucardName;
    private $sMenucardDescription;
    private $iMenucardFK;
    
    public function __construct() 
    {
        ;
    }
    
    public function SetMenucard($sMenucardName,$sMenucardDescription)
    {
        $this->sMenucardName = $sMenucardName;
        $this->sMenucardDescription = $sMenucardDescription;
    }
    
    public function GetMenucard()
    {
        $oMenucard= new stdClass();
        $oMenucard->sMenucardName = $this->sMenucardName;
        $oMenucard->sMenucardDescription = $this->sMenucardDescription;
        
        return $oMenucard;
    }
    
}


?>