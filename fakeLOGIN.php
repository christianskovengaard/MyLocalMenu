<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//require 'Controllers/UserController.php';
//$oUserController = new UserController();
//$oUserController->CreateUser('admin', 'admin', '1')
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Fake login</title>
    </head>
    <body>
        <h3>Fake login</h3>
        <form name="login" method="POST" action="login.php">
            <label for="username">Email</label>
            <input type="text" name="username">
            <label for="password">Kodeord</label>
            <input type="text" name="password">
            <input type="submit" value="login">
        </form>
    </body>
</html>