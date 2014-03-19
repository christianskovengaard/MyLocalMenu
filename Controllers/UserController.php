<?php

class UserController
{
    private $conPDO;
    private $oUser;
    private $oBcrypt;
    private $oSecurity;
    private $oCompany;
    private $oRestuarent;
    private $oMenucard;
    private $oEmail;
    private $oStampcard;
    private $oQrcode;
    
    public function __construct() 
    {

        //Connect to database
        require_once 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();

        
        //Initiate the UserClass     
        require_once(ROOT_DIRECTORY . '/Classes/UserClass.php');
        $this->oUser = new User();
        
        //Initiate the Bcrypt class
        require_once(ROOT_DIRECTORY . '/Classes/bcrypt.php');
        $this->oBcrypt = new Bcrypt();
        

        require_once 'SecurityController.php';
        $this->oSecurity = new SecurityController();

        
        require_once 'CompanyController.php';
        $this->oCompany = new CompanyController();
        
        require_once 'RestuarentController.php';
        $this->oRestuarent = new RestuarentController();
        
        require_once 'MenucardController.php';
        $this->oMenucard = new MenucardController();
        
        require_once 'EmailController.php';
        $this->oEmail = new EmailController();
        
        require_once 'StampcardController.php';
        $this->oStampcard = new StampcardController();
        
        require_once 'QRcodeController.php';
        $this->oQrcode = new QRcodeController();
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
        
        $aLogin = array(
            'result' => false
        );
        
        $sQuery = $this->conPDO->prepare("SELECT sUserPassword,iUserIdHashed,iUserId,sUsername FROM users WHERE sUsername = ? LIMIT 1");
	$sQuery->bindValue(1, $sUsername);
        
	$sQuery->execute();

	//Fetch the result as assoc array
        $aUser = $sQuery->fetch(PDO::FETCH_ASSOC);
	
        $sUserPasswordFromDatabase = $aUser['sUserPassword']; // stored hashed password
        $user_id_hashed = $aUser['iUserIdHashed']; // iUserId hashed
        $user_id =  $aUser['iUserId']; //iUserId
        $username = $aUser['sUsername']; // sUsername
        $password = hash('sha512', $sUserPasswordFromDatabase); // hash the password with the unique password from DB.
        
        
        
        //Check if num result is 1
        if($sQuery->rowCount() == 1)
        {
           // We check if the account is locked from too many login attempts
           if($this->oSecurity->checkbrute($user_id,$this->conPDO) == true)
           { 
               
                //Create user token for the user to reset there password
                $number = uniqid();
                $sUserToken = $this->oBcrypt->genHash($number);
                
               
                // Account is locked for 2 hours
                $sMessage = "Din konto er blevet spærret i 2 timer. Klik <a href='localhost/MyLocalMenu/user.php?sUserToken=$sUserToken'>her</a> for at genåbne din konto"; //TODO: Change this when in production mode
                $sTo = 'christianskovengaard@gmail.com'; //TODO: Change to $username when in production mode
                $sFrom = 'support@mylocalcafe.dk';
                $sSubject = 'Konto spærret';
                $this->oEmail->SendEmail($sTo, $sFrom, $sSubject, $sMessage);
                $aLogin['result'] = 'Account locked';
                return $aLogin;
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
                    //$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password.$ip_address.$user_browser);
                    // Login successful.
                    $aLogin['result'] = 'true';
                    return $aLogin;
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
                    $aLogin['result'] = 'false';
                    return $aLogin;	
                }  
           }
        }
        else 
        {
            // No user exists. 
            //echo 'No user';
            $aLogin['result'] = 'false';
            return $aLogin;
        }
        
     }
     
     /*
      * 
      * Function that add a new user in the register flow
      * 
      * 
      * 
     */
     public function AddNewUser()
     {
         $aUser = array(
                'sFunction' => 'AddNewUser',
                'result' => false
            );
         
         if(isset($_GET['Email']))
         {
            $mail = $_GET['Email'];
            
            //Check if user is allready created with that username
            $sQuery = $this->conPDO->prepare("SELECT sUsername FROM users WHERE sUsername = :email LIMIT 1");
            $sQuery->bindValue(":email", $mail);
            $sQuery->execute();
            
            if($sQuery->rowCount() == 0)
            {
            
                //Create the user token
                $number = uniqid();
                $sUserToken = $this->oBcrypt->genHash($number);

                //Opret en bruger med email som brugernavn, med med en token som skal sendes med email, og det er den token som identifisere hvem brugeren er 
                //Insert the user into the database, prepare statement runs the security
                $sQuery = $this->conPDO->prepare("INSERT INTO users (sUsername,iUserRole,sUserCreateToken) VALUES (:sUsername, :iUserRole, :sUserToken)");

                $sQuery->bindValue(':sUsername', $mail);
                $sQuery->bindValue(':iUserRole', '1');
                $sQuery->bindValue(':sUserToken', $sUserToken);


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

                $sMessage = "Ny bruger til MyLocal, Gå til dette <a href='localhost/MyLocalMenu/register.php?sUserToken=$sUserToken'>link</a> og opret et nyt menukort";
                $sTo = $mail;
                $sFrom = 'support@mylocalcafe.dk';
                $sSubject = 'Ny konto hos MyLocal';

                $this->oEmail->SendEmail($sTo, $sFrom, $sSubject, $sMessage);

                $aUser['result'] = true;
            }
            
            return $aUser;
         }
     }
     
     public function ChecksUserToken()
     {
        if(isset($_GET['sUserToken']))
        {
            $sQuery = $this->conPDO->prepare("SELECT * FROM users WHERE sUserCreateToken = :sUserToken LIMIT 1");
            $sQuery->bindValue('sUserToken', $_GET['sUserToken']);
            
            try
            {
                $sQuery->execute();
                
                if($sQuery->rowCount() == 1)
                {
                   return true;
                }else{
                    return false;
                }
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
     
        }
        else{
            return false;
        }
     }
     
     /* 
      * 
      * 
      * 
      * Function for adding a company and a restuarent for a new user in the register flow
      * 
      * 
      * 
      */
     public function RegisterNewUser()
     {
        
        $aUser = array(
                'sFunction' => 'RegisterNewUser',
                'result' => false
            ); 
         
        if(isset($_GET['sJSON']))
        {
            $aJSONInfo = json_decode($_GET['sJSON']);
            //var_dump($aJSONInfo);
                    
            $password = $aJSONInfo->sPassword;       
            $encrypted = base64_decode($password);

/* DO NOT INDENT THIS CODE */
        $privkey = '-----BEGIN RSA PRIVATE KEY-----
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
-----END RSA PRIVATE KEY-----';
/* DO NOT INDENT THIS CODE end */
        
            // Decrypt the data using the private key and store the results in $decrypted
            openssl_private_decrypt($encrypted, $decrypted, $privkey);
            
            $decryptedPassword = $decrypted;
            
            //Encrypt the password
            $sUserPassword = $this->oBcrypt->genHash($decryptedPassword);
        
            //Update the password for the user
            $sQuery = $this->conPDO->prepare("UPDATE users SET sUserPassword = :sUserPassword WHERE sUserCreateToken = :sUserToken");
        
            $sQuery->bindValue(':sUserPassword', $sUserPassword);
            $sQuery->bindValue('sUserToken', $aJSONInfo->sUserToken);
            
            $sQuery->execute();
            
            //Create the new company
            //Function returns iCompanyId
            //TODO: Missing payment info
            $iCompanyId = $this->oCompany->AddCompany($aJSONInfo->sCompanyName, $aJSONInfo->iCompanyTelefon,$aJSONInfo->sCompanyAddress, $aJSONInfo->iCompanyZipcode, $aJSONInfo->sCompanyCVR);
            
            //Create the new restuarent
            //Function returns the irestuarentInfoId           
            $iRestuarentInfoId = $this->oRestuarent->AddRestuarent($aJSONInfo->sRestuarentName, $aJSONInfo->sRestuarentSlogan ,$aJSONInfo->iRestuarentTel, $aJSONInfo->sRestuarentAddress, $aJSONInfo->iRestuarentZipcode, $iCompanyId);
            
            
            //Create Menucard
            //Function returns the iMenucardId
            $iMenucardId = $this->oMenucard->AddNewMenucard($aJSONInfo->sRestuarentName.' - menukort',$iRestuarentInfoId);
            
            
            //Create stampcard
            $this->oStampcard->CreateStampcard($iRestuarentInfoId);
            
            //Create Qrcode
            $this->oQrcode->CreateNewQrCode($iRestuarentInfoId);
            
            //Insert openinghours
            $aOpeningHours = array(
                0 => $aJSONInfo->iMondayTimeFrom,
                1 => $aJSONInfo->iMondayTimeTo,
                2 => $aJSONInfo->iThuesdayTimeFrom,
                3 => $aJSONInfo->iThuesdayTimeTo,
                4 => $aJSONInfo->iWednesdaysTimeFrom,
                5 => $aJSONInfo->iWednesdaysTimeTo,
                6 => $aJSONInfo->iThursdayTimeFrom,
                7 => $aJSONInfo->iThursdayTimeTo,
                8 => $aJSONInfo->iFridayTimeFrom,
                9 => $aJSONInfo->iFridayTimeTo,
                10 => $aJSONInfo->iSaturdayTimeFrom,
                11 => $aJSONInfo->iSaturdayTimeTo,
                12 => $aJSONInfo->iSundayTimeFrom,
                13 => $aJSONInfo->iSundayTimeTo
            );
            
            //Loop through array and insert all the values
            //Counter for the day id. 1=mandag,2=tirsdag,3=onsdag,4=torsdag,5=fredag,6=lørdag,7=søndag
            $iDay = 1;
            for($i=0;$i<13;$i+=2) {
                $sQuery = $this->conPDO->prepare("INSERT INTO openinghours (iFK_iMenucardId,iFK_iDayId,iFK_iTimeFromId,iFK_iTimeToId) VALUES (:iFK_iMenucardId,:iFK_iDayId,:iFK_iTimeFromId,:iFK_iTimeToId)");
                             
                $sQuery->bindValue(':iFK_iMenucardId', $iMenucardId);
                $sQuery->bindValue(':iFK_iDayId', $iDay);
                $sQuery->bindValue(':iFK_iTimeFromId', $aOpeningHours[$i]);
                $i++;
                $sQuery->bindValue(':iFK_iTimeToId', $aOpeningHours[$i]);
                $sQuery->execute();
                $i--;
                $iDay++;
                if($i == 12){
                    break;
                }
            }                               
            
            
            //Get the sUsername based on the sUserCreateToken
            $sQuery = $this->conPDO->prepare("SELECT sUsername FROM users WHERE sUserCreateToken = :sUserToken");
            $sQuery->bindValue(':sUserToken', $aJSONInfo->sUserToken);
            $sQuery->execute();
            $result = $sQuery->fetch(PDO::FETCH_ASSOC);
            $sUsername= $result['sUsername'];
            
            //Set iFK_iCompanyId for the user
            $sQuery = $this->conPDO->prepare("UPDATE users SET iFK_iCompanyId = :iCompanyId WHERE sUserCreateToken = :sUserToken");
            $sQuery->bindValue(':iCompanyId', $iCompanyId);
            $sQuery->bindValue(':sUserToken', $aJSONInfo->sUserToken);
            $sQuery->execute(); 
            
            //Remove sUserCreateToken
            $sQuery = $this->conPDO->prepare("UPDATE users SET sUserCreateToken = '' WHERE sUserCreateToken = :sUserToken");
            $sQuery->bindValue(':sUserToken', $aJSONInfo->sUserToken);
            $sQuery->execute();            
            
            //When data is inserted. log in the user and then redirect user to admin.php, where the user can start creating the menucard
            if($this->LogInUser($sUsername, $decryptedPassword) == true)
            {
                $aUser['result'] = true;
                return $aUser;
            }else{
                 $aUser['result'] = false;
            }

        }
        return $aUser;
     }
     
     public function ResetPasswordNoToken() {
         
         $aUser = array(
                'sFunction' => 'ResetPassword',
                'result' => false
            ); 
         
        if(isset($_GET['sJSON']))
        {
            $aJSONInfo = json_decode($_GET['sJSON']);
            //var_dump($aJSONInfo);
                    
            $password = $aJSONInfo->sPassword;       
            $encrypted = base64_decode($password);

/* DO NOT INDENT THIS CODE */
        $privkey = '-----BEGIN RSA PRIVATE KEY-----
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
-----END RSA PRIVATE KEY-----';
/* DO NOT INDENT THIS CODE end */
        
            // Decrypt the data using the private key and store the results in $decrypted
            openssl_private_decrypt($encrypted, $decrypted, $privkey);
            
            $decryptedPassword = $decrypted;

            //Encrypt the password
            $sUserPassword = $this->oBcrypt->genHash($decryptedPassword);
            
            $this->oSecurity->sec_session_start();
            
            //Get iUserIdHashed
            $iUserIdHashed = $_SESSION['user_id'];
            
            //Update the password for the user
            $sQuery = $this->conPDO->prepare("UPDATE users SET sUserPassword = :sUserPassword WHERE iUserIdHashed = :iUserIdHashed");
        
            $sQuery->bindValue(':sUserPassword', $sUserPassword);
            $sQuery->bindValue(':iUserIdHashed', $iUserIdHashed);            
            $sQuery->execute();
            
            //Get the sUsername based on the iUserIdHashed
            $sQuery = $this->conPDO->prepare("SELECT sUsername FROM users WHERE iUserIdHashed = :iUserIdHashed");
            $sQuery->bindValue(':iUserIdHashed', $iUserIdHashed);
            $sQuery->execute();
            $result = $sQuery->fetch(PDO::FETCH_ASSOC);
            $sUsername= $result['sUsername'];
            
            //When data is inserted. log in the user and then redirect user to admin.php, where the user can start creating the menucard
            if($this->LogInUser($sUsername, $decryptedPassword) == true)
            {
                $aUser['result'] = true;
                return $aUser;
            }else{
                 $aUser['result'] = false;
            }
            
        }
         
     }


     public function ResetPassword()
     {
         $aUser = array(
                'sFunction' => 'ResetPassword',
                'result' => false
            ); 
         
        if(isset($_GET['sJSON']))
        {
            $aJSONInfo = json_decode($_GET['sJSON']);
            //var_dump($aJSONInfo);
                    
            $password = $aJSONInfo->sPassword;       
            $encrypted = base64_decode($password);

/* DO NOT INDENT THIS CODE */
        $privkey = '-----BEGIN RSA PRIVATE KEY-----
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
-----END RSA PRIVATE KEY-----';
/* DO NOT INDENT THIS CODE end */
        
            // Decrypt the data using the private key and store the results in $decrypted
            openssl_private_decrypt($encrypted, $decrypted, $privkey);
            
            $decryptedPassword = $decrypted;

            //Encrypt the password
            $sUserPassword = $this->oBcrypt->genHash($decryptedPassword);
        
            //Update the password for the user
            $sQuery = $this->conPDO->prepare("UPDATE users SET sUserPassword = :sUserPassword WHERE sUserCreateToken = :sUserToken");
        
            $sQuery->bindValue(':sUserPassword', $sUserPassword);
            $sQuery->bindValue('sUserToken', $aJSONInfo->sUserToken);
            
            $sQuery->execute();
            
            //Get the sUsername based on the sUserCreateToken
            $sQuery = $this->conPDO->prepare("SELECT sUsername FROM users WHERE sUserCreateToken = :sUserToken");
            $sQuery->bindValue(':sUserToken', $aJSONInfo->sUserToken);
            $sQuery->execute();
            $result = $sQuery->fetch(PDO::FETCH_ASSOC);
            $sUsername= $result['sUsername'];
            
            //Remove sUserCreateToken
            $sQuery = $this->conPDO->prepare("UPDATE users SET sUserCreateToken = '' WHERE sUserCreateToken = :sUserToken");
            $sQuery->bindValue(':sUserToken', $aJSONInfo->sUserToken);
            $sQuery->execute();            
            
            //When data is inserted. log in the user and then redirect user to admin.php, where the user can start creating the menucard
            if($this->LogInUser($sUsername, $decryptedPassword) == true)
            {
                $aUser['result'] = true;
                return $aUser;
            }else{
                 $aUser['result'] = false;
            }
        }
     }
     
     public function GetUserinformation()
     {

         $aUser = array(
                'sFunction' => 'GetUserinformation',
                'result' => false
            );
         
         //Check if a session is NOT started
         if(!isset($_SESSION['sec_session_id']))
         { 
            $this->oSecurity->sec_session_start();
         }
        
         //Check if user is logged in
         if($this->oSecurity->login_check() == true)
         {
            $aUser['result'] = true;

            $sUsername = $_SESSION['username'];
           
            $aUser['sUsername'] = $sUsername;
                       
            //Get iFK_iCompanyId
            $sQuery = $this->conPDO->prepare("SELECT iFK_iCompanyId FROM users WHERE sUsername = :sUsername LIMIT 1");
            $sQuery->bindValue(":sUsername", $sUsername);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $iFK_iCompanyId = $aResult['iFK_iCompanyId'];
             
            //Get company info
            $sQuery = $this->conPDO->prepare("SELECT * FROM company WHERE iCompanyId = :iFK_iCompanyId");
            $sQuery->bindValue(":iFK_iCompanyId", $iFK_iCompanyId);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);

            $aUser['sCompanyName'] = utf8_encode($aResult['sCompanyName']);
            $aUser['sCompanyPhone'] = $aResult['sCompanyPhone'];
            $aUser['sCompanyAddress'] = utf8_encode($aResult['sCompanyAddress']);
            $aUser['sCompanyZipcode'] = $aResult['sCompanyZipcode'];
            $aUser['sCompanyCVR'] = $aResult['sCompanyCVR'];
         }
        
        return $aUser;
         
     }
     
     public function UpdateUserinformation()
     {

         $aUser = array(
                'sFunction' => 'UpdateUserinformation',
                'result' => false
            );
         
         //Check if a session is NOT started
        if(!isset($_SESSION['sec_session_id']))
        { 
            $this->oSecurity->sec_session_start();
        }
        
        //Check if user is logged in
        if($this->oSecurity->login_check() == true)
        {
            
            if(isset($_GET['sJSON']))
            {
                
                //Get the JSON string
                $sJSONUserinfo = $_GET['sJSON'];
                //Convert the JSON string into an array
                $aJSONUserinfo = json_decode($sJSONUserinfo);
                
                //Get iFK_iCompanyId
                $sQuery = $this->conPDO->prepare("SELECT iFK_iCompanyId FROM users WHERE sUsername = :sUsername LIMIT 1");
                $sQuery->bindValue(":sUsername", $_SESSION['username']);
                $sQuery->execute();
                $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                $iFK_iCompanyId = $aResult['iFK_iCompanyId'];

                
                //TODO: Find out if the user info should be updated to
                
//                //Update the userinfo and the company info
//                $sQuery = $this->conPDO->prepare("UPDATE users SET sUsername = :sUsername WHERE sUsername = :sessionsUsername LIMIT 1");
//                $sQuery->bindValue(":sUsername", urldecode($aJSONUserinfo->sUsername));
//                $sQuery->bindValue(":sessionsUsername", $_SESSION['username']);
//                $sQuery->execute();
                
                
                //Update company info
                $this->oCompany->UpdateCompany($aJSONUserinfo->sCompanyName, $aJSONUserinfo->sCompanyPhone, $aJSONUserinfo->sCompanyAddress, $aJSONUserinfo->sCompanyZipcode, $aJSONUserinfo->sCompanyCVR, $iFK_iCompanyId);
                
                //TODO: If user info is updated then set the new username in the session
                //Set the new username in the session
                //$_SESSION['username'] = $aJSONUserinfo->sUsername;
                
                $aUser['result'] = true;
            }
        }
        
        return $aUser;
        
     }
     
     
     public function SendResetPasswordRequest() {
         
         $aUser = array(
                'sFunction' => 'SendResetPasswordRequest',
                'result' => false
            );
         
         //Get the JSON string
         $sJSON = $_GET['sJSON'];
         //Convert the JSON string into an array
         $oJSON = json_decode($sJSON);
         
         
         //TODO: Check if email exsist in database
         $sQuery = $this->conPDO->prepare("SELECT sUsername FROM users WHERE sUsername = :sUsername");
         $sQuery->bindValue(":sUsername", $oJSON->email);
         $sQuery->execute();
         if($sQuery->rowCount() == 1) {
         
         //Create random hashed string
         $randomHash = $this->oBcrypt->genHash($oJSON->email);
         
         //Crete sUserToken based on the Email
         $sQuery = $this->conPDO->prepare("UPDATE users SET sUserCreateToken = :sUserCreateToken WHERE sUsername = :sUsername");
         $sQuery->bindValue(":sUserCreateToken", $randomHash);
         $sQuery->bindValue(":sUsername", $oJSON->email);
         $sQuery->execute();
         
         $sTo = $oJSON->email;
         $sFrom = 'support@mylocalcafe.dk';
         $sSubject = 'Nyt kodeord';
         $sMessage = "Reset dit kodeord til din bruger hos MyLocalCafé, Gå til dette <a href='localhost/MyLocalMenu/user.php?sUserToken=$randomHash'>link</a> og sæt dit nye kodeord";
         //Send email with link to reset password
         $this->oEmail->SendEmail($sTo, $sFrom, $sSubject, $sMessage);
         
         $aUser['result'] = 'true';
         
         }else{
             $aUser['result'] = 'false';
         }
         
         return $aUser;
     }
       
}
?>