<?php
//Use this class to defined what properties a user has
class User
{
    private $sUsername;
    private $sUserPassword;
    private $sUserRole;



    public function __construct() 
    {
        
    }

    public function SetUser($sUsername,$sUserPassword,$sUserRole)
    {
        $this->sUsername = $sUsername;
        $this->sUserPassword = $sUserPassword;
        $this->sUserRole = $sUserRole;
    }
    
    public function GetUser()
    {   
        //Create object user and return it
        
        $oUser = new stdClass();
        $oUser->sUsername = $this->sUsername;
        $oUser->sUserPassword = $this->sUserPassword;
        $oUser->sUserRole = $this->sUserRole;
        
        return $oUser;
    }
}
?>
