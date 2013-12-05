<?php

class SecurityController 
{
    
    public function __construct() 
    {

    }
    
    //SECURE SESSION START FUNCTION - run this if you want to use session
    public function sec_session_start() 
    {
            $session_name = 'sec_session_id'; // Set a custom session name
            $secure = false; // Set to true if using https.
            $httponly = true; // This stops javascript being able to access the session id. 

            ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
            $cookieParams = session_get_cookie_params(); // Gets current cookies params.
            session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
            session_name($session_name); // Sets the session name to the one set above.
            session_start(); // Start the php session
            session_regenerate_id(true); // regenerated the session, delete the old one.     
    }
    
    // LOGIN CHECK FUNCTION - BRUTE FORCE
    public function checkbrute($user_id,$conPDO) 
    {
       // Get timestamp of current time
       $now = time();
       // All login attempts are counted from the past 2 hours. 
       $valid_attempts = $now - (2 * 60 * 60); 

       //TODO: change to PDO
       if ($sQuery = $conPDO->prepare("SELECT time FROM login_attempts WHERE iFK_iUserId = :iUserId AND time > '$valid_attempts'"))
       { 
          $sQuery->bindValue(':iUserId', $user_id); 
          // Execute the prepared query.
          $sQuery->execute();
          // If there has been more than 5 failed logins
          if($sQuery->rowCount() > 5) 
          {
             return true;
          } 
          else
          {
             return false;
          }
       }
    }
    
    
    //CREATE LOGIN CHECK FUNCTION - Logged Status, check if user is loggede in
    //TODO: Change to use PDO
    public function login_check($mysqli) 
    {
       // Check if all session variables are set
       if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
         $user_id = $_SESSION['user_id'];
         $login_string = $_SESSION['login_string'];
         $username = $_SESSION['username'];
         $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
         $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

         if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) { 
            $stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
            $stmt->execute(); // Execute the prepared query.
            $stmt->store_result();

            if($stmt->num_rows == 1) { // If the user exists
               $stmt->bind_result($password); // get variables from result.
               $stmt->fetch();
               $login_check = hash('sha512', $password.$ip_address.$user_browser);
               if($login_check == $login_string) {
                  // Logged In!!!!
                  return true;
               } else {
                  // Not logged in
                  return false;
               }
            } else {
                // Not logged in
                return false;
            }
         } else {
            // Not logged in
            return false;
         }
       } else {
         // Not logged in
         return false;
       }
    }
    
    public function __destruct() {
        ;
    }
}

?>
