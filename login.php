<?php

if(isset($_POST['username']) && isset($_POST['password']))
{
    //echo $_POST['username']. ' ' .$_POST['password'];
    require_once 'Controllers/UserController.php';
    $oUserController = new UserController();
    $loggedIn = $oUserController->LogInUser($_POST['username'], $_POST['password']);
   if($loggedIn['result'] == 'true'){
        header('location: admin');
   }else if($loggedIn['result'] == 'Account locked'){
       header("location: login-page?login=Account_locked");
   }else if($loggedIn['result'] == 'false'){
       header("location: login-page?login=false");
   }else if($loggedIn['result'] == 'nocafe'){
       header("location: login-page?login=nocafe");
   }
   
}
else {
    header("location: login-page?login=false");
}
?>
