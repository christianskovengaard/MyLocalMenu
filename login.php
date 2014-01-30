<?php

if(isset($_POST['username']) && isset($_POST['password']))
{
    //echo $_POST['username']. ' ' .$_POST['password'];
    require 'Controllers/UserController.php';
    $oUserController = new UserController();
    $loggedIn = $oUserController->LogInUser($_POST['username'], $_POST['password']);
   if($loggedIn['result'] == 'true'){
        header('location: admin.php');
   }else if($loggedIn['result'] == 'Account locked'){
       header("location: index.php?login=Account_locked");
   }else if($loggedIn['result'] == 'false'){
       header("location: index.php?login=false");
   }
}
else {
    header("location: index.php?login=false");
}
?>
