<?php


class ZipcodeCityController {
    
    private $conPDO;
    
    public function __construct() {
        
        require_once 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
        
    }
    
    public function GetZipcodesAndCities() {
        
        $sQuery = $this->conPDO->prepare("SELECT sCityname,iZipcode  FROM zipcodecity GROUP BY sCityname");
        $sQuery->execute();
        
        while($aResult = $sQuery->fetch(PDO::FETCH_ASSOC)) {
             $iZipcodesAndCity['iZipcode'][] = $aResult['iZipcode'];
             $iZipcodesAndCity['sCityname'][] = utf8_encode($aResult['sCityname']);
        }
        //var_dump($iZipcodesAndCity);
        return $iZipcodesAndCity;
        
    }
    
    public function GetCityname() {
        $sQuery = $this->conPDO->prepare("SELECT sCityname FROM zipcodecity WHERE iZipcode = :iZipcode");
        $sQuery->bindValue(":iZipcode", $_GET['iZipcode']);
        $sQuery->execute();
        $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
        return $aResult['sCityname'];
    }
    
    public function GetZipcode() {
        $sQuery = $this->conPDO->prepare("SELECT iZipcode FROM zipcodecity WHERE sCityname = :sCityname");
        $sQuery->bindValue(":sCityname", utf8_decode($_GET['sCityname']));
        $sQuery->execute();
        $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
        return $aResult['iZipcode']; 
    }
    
    public function GetCitynamePriv($iZipcode) {
        $sQuery = $this->conPDO->prepare("SELECT sCityname FROM zipcodecity WHERE iZipcode = :iZipcode");
        $sQuery->bindValue(":iZipcode", $iZipcode);
        $sQuery->execute();
        $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
        return utf8_encode($aResult['sCityname']);
    }
    
    public function __destruct() {
        ;
    }
}
