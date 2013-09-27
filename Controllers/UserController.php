<?php

class UserController
{
    private $conPDO;
    private $oUser;
    private $oBcrypt;
    
    public function __construct() 
    {
        //Connect to database
        require 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
        
        //Initiate the UserClass
        require './Classes/UserClass.php';
        $this->oUser = new User();
        
        //Initiate the Bcrypt class
        require './Classes/bcrypt.php';
        $this->oBcrypt = new Bcrypt();
    }


    public function GetUser($iUserIdHashed)
    {
        
       //Get user from database based on the iUserId remember to use PDO
       $sQuery = $this->conPDO->prepare("SELECT sUsername,sUserPassword,iUserRole FROM users WHERE iUserIdHashed = ? LIMIT 1");
        
       //Bind the values to the ? signs
       $sQuery->bindValue(1, $iUserIdHashed);
       //Execute the query
       try
       {
           $sQuery->execute();
       }
       catch(PDOException $e)
       {
           die($e->getMessage());
       }       
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
        //Encrypt the password
        $sUserPassword = $this->oBcrypt->genHash($sUserPassword);
        
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

        try
        {
            $sQuery->execute();
            $iUserId = $this->conPDO->lastInsertId();
            //Get last inserted id and generate a hash of that to save in the database (the hash is generate with a random string and the iUserId)
            //The generated hash is the id to be passed with ajax
            $iUserIdHashed = $this->oBcrypt->genHash($iUserId);
            
            //Update the user
            $sQuery = $this->conPDO->prepare("UPDATE users SET iUserIdHashed = ? WHERE iUserId = ?");
        
            $sQuery->bindValue(1, $iUserIdHashed);
            $sQuery->bindValue(2, $iUserId);
            
            $sQuery->execute();            
	}
        catch(PDOException $e)
        {
            die($e->getMessage());
	}
        
    }
    
    public function UpdateUser($iUserIdHashed,$sUsername,$sUserPassword,$iUserRole)
    {
        
        //Encrypt the password
        $sUserPassword = $this->oBcrypt->genHash($sUserPassword);
        
        //Set the new values in the user class
        $this->oUser->SetUser($sUsername, $sUserPassword, $iUserRole);
        
        //Update the user
        $sQuery = $this->conPDO->prepare("UPDATE users SET sUsername = ?, sUserPassword = ?, iUserRole = ? WHERE iUserIdHashed = ?");
        
        //Get the user
        $oUser = $this->oUser->GetUser();
        
        //Bind the values to the ? signs
	$sQuery->bindValue(1, $oUser->sUsername);
        $sQuery->bindValue(2, $oUser->sUserPassword);
	$sQuery->bindValue(3, $oUser->iUserRole);
        
        $sQuery->bindValue(4, $iUserIdHashed);
        
        try
        {
            $sQuery->execute();
            return true;
	}
        catch(PDOException $e)
        {
            die($e->getMessage());
	}
    }
    
    
    public function LogInUser($sUsername,$sUserPassword)
    {
        
        $sQuery = $this->conPDO->prepare("SELECT sUserPassword FROM users WHERE sUsername = ? LIMIT 1");
	$sQuery->bindValue(1, $sUsername);
        
	$sQuery->execute();
        
	//Fetch the result as assoc array
        $aUser = $sQuery->fetch(PDO::FETCH_ASSOC);
	
        $sUserPasswordFromDatabase = $aUser['sUserPassword']; // stored hashed password
        
        if($this->oBcrypt->verify($sUserPassword, $sUserPasswordFromDatabase) === true)
        { // using the verify method to compare the password with the stored hashed password.
            return true;
	}
        else
        {
            return false;	
	}
    }
    
}


?>