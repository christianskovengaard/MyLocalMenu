<?php

if(isset($_POST['newuser'])) {
require 'Controllers/UserController.php';
$oUserController = new UserController();
$oUserController->CreateUser('admin', 'admin', '1');
}
?>
<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <form method="POST">
            <input type='submit' name='newuser' value='Ny bruger'>
        </form>
    </body>
</html>