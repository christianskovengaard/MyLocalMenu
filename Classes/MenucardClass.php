<?php

class MenucardClass
{
    private $iMenucardIdHashed;
    private $sMenucardName;
    private $iMenucardFK;
    
    public function __construct() 
    {
        ;
    }
    
    public function SetMenucard($sMenucardName)
    {
        $this->sMenucardName = $sMenucardName;
    }
    
    public function GetMenucard()
    {
        $oMenucard= new stdClass();
        $oMenucard->sMenucardName = $this->sMenucardName;
        
        return $oMenucard;
    }
    
}


?>