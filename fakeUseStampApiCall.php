<?php
    
    if(isset($_POST['usestamp'])) {
    require_once 'Controllers/StampcardController.php';
    $oStampcardController = new StampcardController();
    $oStampcardController->UseStamp();
    
    }



?>

<html>
    
    <head></head>
    <body>
        <form method="POST" action="">
        <input type="submit" name="usestamp" value="Use stamp"/>
        </form>
    </body>
</html>