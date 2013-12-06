<?php

class UserController
{
    private $conPDO;
    private $oUser;
    private $oBcrypt;
    private $oSecurity;
    
    public function __construct() 
    {
        //Connect to database
        require 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
        
        
        //Initiate the UserClass     
        require_once(ROOT_DIRECTORY . '/Classes/UserClass.php');
        $this->oUser = new User();
        
        //Initiate the Bcrypt class
        require_once(ROOT_DIRECTORY . '/Classes/bcrypt.php');
        $this->oBcrypt = new Bcrypt();
        
        require 'SecurityController.php';
        $this->oSecurity = new SecurityController();
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
        
        $sQuery = $this->conPDO->prepare("SELECT sUserPassword,iUserIdHashed,iUserId,sUsername FROM users WHERE sUsername = ? LIMIT 1");
	$sQuery->bindValue(1, $sUsername);
        
	$sQuery->execute();

	//Fetch the result as assoc array
        $aUser = $sQuery->fetch(PDO::FETCH_ASSOC);
	
        $sUserPasswordFromDatabase = $aUser['sUserPassword']; // stored hashed password
        $user_id_hashed = $aUser['iUserIdHashed']; // iUserId hashed
        $user_id =  $aUser['iUserId']; //iUserId
        $username = $aUser['sUsername']; // sUsername
        $password = hash('sha512', $sUserPassword.$sUserPasswordFromDatabase); // hash the password with the unique password from DB.
        
        
        
        //Check if num result is 1
        if($sQuery->rowCount() == 1)
        {
           // We check if the account is locked from too many login attempts
           if($this->oSecurity->checkbrute($user_id,$this->conPDO) == true)
           { 
                // Account is locked
                //TODO: Send an email to user saying their account is locked
                echo 'Account is locked for 2 hours';
                return false;
           }
           else
           {
                // using the verify method to compare the password with the stored hashed password.
                if($this->oBcrypt->verify($sUserPassword, $sUserPasswordFromDatabase) === true)
                { 
                    //Start a secure session
                    $this->oSecurity->sec_session_start();
                    
                    $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
                    $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

                    //$user_id_hashed = preg_replace("/[^0-9]+/", "", $user_id_hashed); // XSS protection as we might print this value
                    $_SESSION['user_id'] = $user_id_hashed; 
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password.$ip_address.$user_browser);
                    // Login successful.
                    return true;
                }
                else
                {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $sQuery = $this->conPDO->prepare("INSERT INTO login_attempts (iFK_iUserId, time) VALUES (:user_id,:now)");
                    $sQuery->bindValue(':user_id', $user_id);
                    $sQuery->bindValue(':now', $now);
                    $sQuery->execute();
                    echo 'Login attempt';
                    return false;	
                }  
           }
        }
        else 
        {
            // No user exists. 
            echo 'No user';
            return false;
        }
        
     }
    
}
?>