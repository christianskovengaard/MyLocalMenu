<?php

class MenucardInfoClass
{
    private $sMenucardInfoHeadline;
    private $sMenucardInfoParagraph;
    private $iFK_iMenucardId;
    
    public function __construct() 
    {
        ;
    }
    
    public function SetMenucardInfo($sMenucardInfoHeadline,$sMenucardInfoParagraph,$iFK_iMenucardId)
    {
        $this->sMenucardInfoHeadline = $sMenucardInfoHeadline;
        $this->sMenucardInfoParagraph = $sMenucardInfoParagraph;
        $this->iFK_iMenucardId = $iFK_iMenucardId;
    }
    
    public function GetMenucardInfo()
    {
        $oMenucardInfo= new stdClass();
        $oMenucardInfo->sMenucardInfoHeadline = $this->sMenucardInfoHeadline;
        $oMenucardInfo->sMenucardInfoParagraph = $this->sMenucardInfoParagraph;
        $oMenucardInfo->iFK_iMenucardId = $this->iFK_iMenucardId;
        
        return $oMenucardInfo;
    }
    
}


?>