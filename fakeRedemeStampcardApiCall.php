<?php

    
    if(isset($_POST['redemestampcard'])) {
        
    require_once 'Controllers/StampcardController.php';
    $oStampcardController = new StampcardController();
    $oStampcardController->RedemeStampcard();
    
    }



?>

<html>
    
    <head></head>
    <body>
        <form method="POST" action="">
        <input type="submit" name="redemestampcard" value="Redeme stamp"/>
        </form>
    </body>
</html>