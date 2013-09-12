<?php

class Database
{
    private $sDatabaseName;
    private $sUsername;
    private $sPassword;
    private $sEncoding;
    private $sHost;
            
    
    public function __construct() {
        $this->sDatabaseName = 'mylocalmenu';
        $this->sUsername = 'root';
        $this->sPassword = 'root';
        $this->sEncoding = 'utf8';
        $this->sHost = 'localhost';
    }
    
    public function SetDatabase($sDatabaseName,$sUsername,$sPassword,$sEncoding,$sHost)
    {
        $this->sDatabaseName = $sDatabaseName;
        $this->sUsername = $sUsername;
        $this->sPassword = $sPassword;
        $this->sEncoding = $sEncoding;
        $this->sHost = $sHost;
    }
    
    public function GetDatabase()
    {
        $oDatabase = new stdClass();
        $oDatabase->sDatabaseName = $this->sDatabaseName;
        $oDatabase->sUsername = $this->sUsername;
        $oDatabase->sPassword = $this->sPassword;
        $oDatabase->sEncoding = $this->sEncoding;
        $oDatabase->sHost = $this->sHost;
        
        return $oDatabase;
    }
}
?>
