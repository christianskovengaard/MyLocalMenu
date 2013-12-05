<?php

if(isset($_POST['username']) && isset($_POST['password']))
{
    //echo $_POST['username']. ' ' .$_POST['password'];
    require 'Controllers/UserController.php';
    $oUserController = new UserController();
    $loggedIn = $oUserController->LogInUser($_POST['username'], $_POST['password']);
    var_dump($loggedIn);
    
    echo 'Username '. $_SESSION['username'];
    echo '</br>userid '. $_SESSION['user_id'];
    echo '<br/>login string '. $_SESSION['login_string'];
}
else {
    echo "No";
}
?>
