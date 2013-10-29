<?php

class MenucardInfoClass
{
    private $sMenucardInfoHeadline;
    private $sMenucardInfoParagraph;
    private $iFK_iMenucard;
    
    public function __construct() 
    {
        ;
    }
    
    public function SetMenucardInfo($sMenucardInfoHeadline,$sMenucardInfoParagraph)
    {
        $this->sMenucardInfoHeadline = $sMenucardInfoHeadline;
        $this->sMenucardInfoParagraph = $sMenucardInfoParagraph;
    }
    
    public function GetMenucardInfo()
    {
        $oMenucardInfo= new stdClass();
        $oMenucardInfo->sMenucardInfoHeadline = $this->sMenucardInfoHeadline;
        $oMenucardInfo->sMenucardInfoParagraph = $this->sMenucardInfoParagraph;
        
        return $oMenucardInfo;
    }
    
}


?>