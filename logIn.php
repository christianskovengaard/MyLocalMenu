<?php

if(isset($_POST['username']) && isset($_POST['password']))
{
    echo $_POST['username']. ' ' .$_POST['password'];
    require 'Controllers/UserController.php';
    $oUserController = new UserController();
    $loggedIn = $oUserController->LogInUser($_POST['username'], $_POST['password']);
    var_dump($loggedIn);
}
else {
    echo "No";
}
?>
