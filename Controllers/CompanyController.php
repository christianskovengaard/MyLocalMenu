<?php

class CompanyController 
{
    private $conPDO;
    private $oCompany;
    
    public function __construct() {
       
       if(!class_exists('Database') )
       { 
            
                     
       }
       require_once 'DatabaseController.php';
       $oDatabaseController = new DatabaseController();   
       $this->conPDO = $oDatabaseController->ConnectToDatabase(); 
       
       require_once(ROOT_DIRECTORY . '/Classes/CompanyClass.php');
       $this->oCompany = new CompanyClass();
    }
    
    public function AddCompany($sCompanyName, $sCompanyPhone, $sCompanyAddress, $sCompanyZipcode, $sCompanyCVR)
    {
        
        $this->oCompany->SetCompany($sCompanyName, $sCompanyPhone, $sCompanyAddress, $sCompanyZipcode, $sCompanyCVR);
        
        //Insert into database          
        $sQuery = $this->conPDO->prepare("INSERT INTO company (sCompanyName,sCompanyPhone,sCompanyAddress,sCompanyZipcode,sCompanyCVR) VALUES (:sCompanyName,:sCompanyPhone,:sCompanyAddress,:sCompanyZipcode,:sCompanyCVR)");

        $oCompany = $this->oCompany->GetCompany();
        
        $sQuery->bindValue(':sCompanyName', $oCompany->sCompanyName);
        $sQuery->bindValue(':sCompanyPhone', $oCompany->sCompanyPhone);
        $sQuery->bindValue(':sCompanyAddress', $oCompany->sCompanyAddress);
        $sQuery->bindValue(':sCompanyZipcode', $oCompany->sCompanyZipcode);
        $sQuery->bindValue(':sCompanyCVR', $oCompany->sCompanyCVR);
        $sQuery->execute();
        
        //Get the last inserted id
        $iCompanyId = $this->conPDO->lastInsertId();
        
        return $iCompanyId;
         
    }
    
    public function __destruct() {
        ;
    }
}
?>
