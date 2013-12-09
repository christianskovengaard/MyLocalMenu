<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//require 'Controllers/UserController.php';
//$oUserController = new UserController();
//$oUserController->CreateUser('admin', 'admin', '1')
require 'Controllers/SecurityController.php';
$oSecurityController = new SecurityController();
$oSecurityController->sec_session_start(); // Our custom secure way of starting a php session.
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Fake login</title>
    </head>
    <body>
        <h3>Fake login and log out</h3>
        <?php if ($oSecurityController->login_check() == false) : ?>
        <form name="login" method="POST" action="login.php">
            <h3>Login</h3>
            <label for="username">Email</label>
            <input type="text" name="username">
            <label for="password">Kodeord</label>
            <input type="text" name="password">
            <input type="submit" value="login">
        </form>
        <?php else : ?>
        <form name="logout" method="POST" action="logout.php">
            <h3>Logout</h3>
            <input type="submit" value="logout">
        </form>
        <?php endif; ?>
    </body>
</html>
