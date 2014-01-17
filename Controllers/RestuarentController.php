<?php

class RestuarentController 
{
    
    private $conPDO;
    private $oRestuarent;
    
    public function __construct() {
        
        if(!class_exists('Database') )
        {
            require 'DatabaseController.php';
            $oDatabaseController = new DatabaseController();
            $this->conPDO = $oDatabaseController->ConnectToDatabase();
        }
        require_once(ROOT_DIRECTORY . '/Classes/RestuarentClass.php');
        $this->oRestuarent = new RestuarentClass();
    }
    
    public function GetRestuarentNames()
    {
        $aRestuarentNames = array(
                'sFunction' => 'GetRestuarentNames',
                'result' => false,
            );
        
        $sQuery = $this->conPDO->prepare('SELECT sRestuarentInfoName FROM restuarentinfo WHERE iRestuarentInfoActive = 1');
        
        try
        {
            $sQuery->execute();             
        }
        catch (PDOException $e)
        {
           die($e->getMessage()); 
        }
        if($sQuery->rowCount() > 0)
        {
            $aRestuarentNames['result'] = true;
            $i = 0;
            while ($aResult = $sQuery->fetch(PDO::FETCH_ASSOC)) 
            {
                $aRestuarentNames['sRestuarentNames'][$i] = $aResult['sRestuarentInfoName'];
                $i++;
            }
        }
        return $aRestuarentNames;
    }
    
    public function AddRestuarent($sRestuarentInfoName, $sRestuarentInfoPhone, $sRestuarentInfoAddress, $iFK_iCompanyInfoId)
    {
        $this->oRestuarent->SetRestaurent($sRestuarentInfoName, $sRestuarentInfoPhone, $sRestuarentInfoAddress, $iFK_iCompanyInfoId);
        
        //Insert into database          
        $sQuery = $this->conPDO->prepare("INSERT INTO restuarentinfo (sRestuarentInfoName, sRestuarentInfoPhone, sRestuarentInfoAddress, iFK_iCompanyInfoId) VALUES (:sRestuarentInfoName, :sRestuarentInfoPhone, :sRestuarentInfoAddress, :iFK_iCompanyInfoId)");

        $oRestuarent = $this->oRestuarent->GetRestuarent();
        
        $sQuery->bindValue(':sRestuarentInfoName', $oRestuarent->sRestuarentInfoName);
        $sQuery->bindValue(':sRestuarentInfoPhone', $oRestuarent->sRestuarentInfoPhone);
        $sQuery->bindValue(':sRestuarentInfoAddress', $oRestuarent->sRestuarentInfoAddress);
        $sQuery->bindValue(':iFK_iCompanyInfoId', $oRestuarent->iFK_iCompanyInfoId);
        $sQuery->execute();
        
        //Get the last inserted id
        $iRestuarentInfoId = $this->conPDO->lastInsertId();
        
        return $iRestuarentInfoId;
    }
    

    public function __destruct() {
        ;
    }
    
}

?>
