<?php

require 'Controllers/UserController.php';
$oUserController = new UserController();
$oUserController->CreateUser('admin', 'admin', '1');
?>
