<?php

class RestuarentController 
{
    
    private $conPDO;
    
    public function __construct() {
        
        require 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
        
        require_once(ROOT_DIRECTORY . '/Classes/RestuarentClass.php');
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

    public function __destruct() {
        ;
    }
    
}

?>
