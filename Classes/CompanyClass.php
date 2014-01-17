<?php

class CompanyClass {
    
    private $sCompanyName;
    private $sCompanyPhone;
    private $sCompanyAddress;
    private $sCompanyZipcode;
    private $sCompanyCVR;
    
    public function __construct() {
        ;
    }
    
    public function SetCompany($sCompanyName,$sCompanyPhone,$sCompanyAddress,$sCompanyZipcode,$sCompanyCVR)
    {
        $this->sCompanyName = $sCompanyName;
        $this->sCompanyPhone = $sCompanyPhone;
        $this->sCompanyAddress = $sCompanyAddress;
        $this->sCompanyZipcode = $sCompanyZipcode;
        $this->sCompanyCVR = $sCompanyCVR;
    }
    
    public function GetCompany()
    {
        $oCompany = new stdClass();
        $oCompany->sCompanyName = $this->sCompanyName;
        $oCompany->sCompanyPhone = $this->sCompanyPhone;
        $oCompany->sCompanyAddress = $this->sCompanyAddress;
        $oCompany->sCompanyZipcode = $this->sCompanyZipcode;
        $oCompany->sCompanyCVR = $this->sCompanyCVR;
        
        return $oCompany;
    }
}

?>
