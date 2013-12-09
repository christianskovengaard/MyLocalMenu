<?php

if(isset($_POST['username']) && isset($_POST['password']))
{
    //echo $_POST['username']. ' ' .$_POST['password'];
    require 'Controllers/UserController.php';
    $oUserController = new UserController();
    $loggedIn = $oUserController->LogInUser($_POST['username'], $_POST['password']);
    header('location: admin.php');
}
else {
    echo "Forkert brugernavn eller kodeord. Prøv igen!";
    echo "<a href='fakeLogin.php'>Login side</a>";
}
?>
