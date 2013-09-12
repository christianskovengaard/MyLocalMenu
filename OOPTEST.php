<?php
error_reporting(E_ALL);
//phpinfo();

//Require the UserCOntroller
require './Controllers/UserController.php';
//Create usercontroller object
$oUserController = new UserController();

//Create new user
$oUserController->CreateUser('OleBole', '123456', 1);


$iUserId = 1;

//Get the new user
$oUser = $oUserController->GetUser($iUserId);


echo "Brugernavn er: ".$oUser->sUsername;

echo "<pre>";
    var_dump($oUser);
echo "</pre>";



?>
