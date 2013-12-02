<?php

class DatabaseController
{
    
    private $oDatabase;
    
    function __construct() 
    {
        require './Classes/DatabaseClass.php';
        $this->oDatabase = new Database();
    }
    
    function ConnectToDatabase()
    {
        //Get database from the database class
        $oDatabase = $this->oDatabase->GetDatabase();
        
        //Connect to database
        $sDatabasename = $oDatabase->sDatabaseName;
        $sUsername = $oDatabase->sUsername;
        $sPassword = $oDatabase->sPassword;
        $sEncoding = $oDatabase->sEncoding;
        $sHost = $oDatabase->sHost;
        
        // PDO
        $conPDO = new PDO("mysql:host=$sHost;dbname=$sDatabasename",$sUsername,$sPassword);
        if($conPDO)
        {
            $conPDO->exec("set names '.$sEncoding.'");
            $conPDO->exec("SET CHARACTER SET '.$sEncoding.'");
            //Prevent MySQL injection attacks
            $conPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            //Enables errormode
            $conPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conPDO;    
        }
        else{
            return false;
        }       
    }
    
    function __destruct() 
    {
        
    }
}
?>
