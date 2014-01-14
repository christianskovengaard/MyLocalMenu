<?php

if(isset($_POST['username']) && isset($_POST['password']))
{
    //echo $_POST['username']. ' ' .$_POST['password'];
    require 'Controllers/UserController.php';
    $oUserController = new UserController();
    $loggedIn = $oUserController->LogInUser($_POST['username'], $_POST['password']);
   if($loggedIn == true){
        header('location: admin.php');
   }else{echo "Kunne ikke logge ind! Prøv igen";
   echo "<a href='fakeLogin.php'>Login side</a>";
   }
}
else {
    echo "Indtast brugernavn og kodeord. Prøv igen!";
    echo "<a href='fakeLogin.php'>Login side</a>";
}
?>
