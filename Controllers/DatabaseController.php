<?php

class DatabaseController
{
    
    private $oDatabase;
    
    function __construct() {
        require './Classes/DatabaseClass.php';
        $this->oDatabase = new Database();
    }
    
    function ConnectToDatabase()
    {
        //Get database from the database class
        $oDatabase = $this->oDatabase->GetDatabase();
        
        //Connect to database
        
        // Check connection
        if(mysqli_connect_errno($con))
        {
            return false;
        }
        else
        {
            mysqli_query($con, "SET NAMES utf8");
            return $con;
        }        
    }
    
    function __destruct() {
        ;
    }
}
?>
