<?php


//Require the UserCOntroller
require './Controllers/UserController.php';
//Create usercontroller object
$oUserController = new UserController();

//Create new user
$oUserController->CreateUser('Ole', '123456', 'Admin');


//Get the new user
$oUser = $oUserController->GetUser();

var_dump($oUser);
?>
