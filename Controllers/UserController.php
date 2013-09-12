<?php

class UserController
{
    private $databaseConnection;
    private $oUser;
    
    public function __construct() 
    {
        require './Classes/UserClass.php';
        $this->oUser = new User();
    }


    public function GetUser($iUserId)
    {
       //Get user from database based on the iUserId
        
       //Set the user in the user class
        
       //Get the user from the user class
       $oUser = $this->oUser->GetUser();
       //Return the name of the user
       return $oUser;
       
    }
    
    public function CreateUser($sUsername,$sUserPassword,$sUserRole)
    {
        $this->oUser->SetUser($sUsername, $sUserPassword, $sUserRole);
    }
    
    public function UpdateUser()
    {
        $sUsername = 'Test fra POST';
        $sUserPassword = 'Test fra POST 2';
        
        //Set the new values in the user class
        $this->oUser->SetUser($sUsername, $sUserPassword);
        
        //Should return a user as an object
        $oUser = $this->oUser->GetUser();
        
        return $oUser;
        
        //Update the user in the database
    }
    
    
}


?>
