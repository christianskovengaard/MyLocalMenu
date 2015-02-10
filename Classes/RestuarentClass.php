<?php


class RestuarentClass {
    
    private $sRestuarentInfoName;
    private $sRestuarentInfoPhone;
    private $sRestuarentInfoAddress;
    private $iFK_iCompanyInfoId;
    private $dRestuarentLocationLat;
    private $dRestuarentLocationLng;
    
    public function __construct() {
        ;
    }

    public function SetRestaurent($sRestuarentInfoName,$sRestuarentInfoPhone,$sRestuarentInfoAddress,$iFK_iCompanyInfoId, $dRestuarentLocationLat, $dRestuarentLocationLng)
    {
        $this->sRestuarentInfoName = $sRestuarentInfoName;
        $this->sRestuarentInfoPhone = $sRestuarentInfoPhone;
        $this->sRestuarentInfoAddress = $sRestuarentInfoAddress;
        $this->iFK_iCompanyInfoId = $iFK_iCompanyInfoId;
        $this->dRestuarentLocationLat = $dRestuarentLocationLat;
        $this->dRestuarentLocationLng = $dRestuarentLocationLng;

    }
    
    public function GetRestuarent()
    {
        $oRestuarent = new stdClass();
        $oRestuarent->sRestuarentInfoName = $this->sRestuarentInfoName;
        $oRestuarent->sRestuarentInfoPhone = $this->sRestuarentInfoPhone;
        $oRestuarent->sRestuarentInfoAddress = $this->sRestuarentInfoAddress;
        $oRestuarent->iFK_iCompanyInfoId = $this->iFK_iCompanyInfoId;
        $oRestuarent->dRestuarentLocationLat = $this->dRestuarentLocationLat;
        $oRestuarent->dRestuarentLocationLng = $this->dRestuarentLocationLng;
        
        return $oRestuarent;
    }
}

?>
