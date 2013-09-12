<?php

class Database
{
    private $sDatabaseName;
    private $sUsername;
    private $sPassword;
    private $sEncoding;
            
    
    public function __construct() {
        $this->sDatabaseName = 'mylocalmenu';
        $this->sUsername = 'root';
        $this->sPassword = '';
        $this->sEncoding = 'utf8';
    }
    
    public function SetDatabase($sDatabaseName,$sUsername,$sPassword,$sEncoding)
    {
        $this->sDatabaseName = $sDatabaseName;
        $this->sUsername = $sUsername;
        $this->sPassword = $sPassword;
        $this->sEncoding = $sEncoding;
    }
    
    public function GetDatabase()
    {
        $oDatabase = new stdClass();
        $oDatabase->sDatabaseName = $this->sDatabaseName;
        $oDatabase->sUsername = $this->sUsername;
        $oDatabase->sPassword = $this->sPassword;
        $oDatabase->sEncoding = $this->sEncoding;
        
        return $oDatabase;
    }
}
?>
