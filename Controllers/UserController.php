<?php

class UserController
{
    private $conPDO;
    private $oUser;
    
    public function __construct() 
    {
        //Connect to database
        require 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
        
        //Initiate the UserClass
        require './Classes/UserClass.php';
        $this->oUser = new User();
    }


    public function GetUser($iUserId)
    {
       //Get user from database based on the iUserId remember to use PDO
       $sQuery = $this->conPDO->prepare("SELECT sUsername,sUserPassword,iUserRole FROM users WHERE iUserId = ? LIMIT 1");
        
       //Bind the values to the ? signs
       $sQuery->bindValue(1, $iUserId); 
       //Execute the query
       $sQuery->execute();        
       //Fetch the result as assoc array
       $aUser = $sQuery->fetch(PDO::FETCH_ASSOC);
       
       
       //Set the user from the user class
       $this->oUser->SetUser($aUser['sUsername'], $aUser['sUserPassword'], $aUser['iUserRole']);
       
       $oUser = $this->oUser->GetUser();
       
       //Return the user
       return $oUser;
       
    }
    
    public function CreateUser($sUsername,$sUserPassword,$iUserRole)
    {
        //Set the user in the user class
        $this->oUser->SetUser($sUsername, $sUserPassword, $iUserRole);
        //Get the user back as a user object
        $oUser = $this->oUser->GetUser();  
        
        //Insert the user into the database, prepare statement runs the security
        $sQuery = $this->conPDO->prepare("INSERT INTO users (sUsername,sUserPassword,iUserRole) VALUES (?, ?, ?)");
        
        //Bind the values to the ? signs
	$sQuery->bindValue(1, $oUser->sUsername);
        $sQuery->bindValue(2, $oUser->sUserPassword);
	$sQuery->bindValue(3, $oUser->iUserRole);
        /*$sQuery->bindValue(4, $ip);
	$sQuery->bindValue(5, $time);
        $sQuery->bindValue(6, $date);
	$sQuery->bindValue(7, $user_id);*/

        try
        {
            $sQuery->execute();
	}
        catch(PDOException $e)
        {
            die($e->getMessage());
	}
        
    }
    
    public function UpdateUser()
    {
        $sUsername = 'Test fra POST';
        $sUserPassword = 'Test fra POST 2';
        
        //Set the new values in the user class
        $this->oUser->SetUser($sUsername, $sUserPassword);
        
        //Get the user
        $oUser = $this->oUser->GetUser();
        
        return $oUser;
        
        //Update the user in the database
    }
    
    
}


?>