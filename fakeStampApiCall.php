<?php
    


    if(isset($_POST['redemestampcard'])) {
        
    require_once 'Controllers/StampcardController.php';
    $oStampcardController = new StampcardController();
    $oStampcardController->RedemeStampcard();
    
    }

?>

<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
         <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
         <script type="text/javascript" src="GetMessagesApp.js"></script>
    </head>
    <body>
        <p>API call for Use stamp</p>
        <p>http://www.spjæl.dk/MyLocalMenu/API/api.php?sFunction=UseStamp&sCustomerId=abc123&QRcodeData=LGi9Cv7imHvjZzOH3Z2bm4QDqs9EnN</p>
        <a href="http://localhost/MyLocalMenu/API/api.php?sFunction=UseStamp&sCustomerId=abc123&QRcodeData=LGi9Cv7imHvjZzOH3Z2bm4QDqs9EnN">Use stamp</a>
        
        <p>API call for redeme stampcard</p>
        <p>http://www.spjæl.dk/MylocalMenu?sFunction=RedemeStampcard&iMenucardSerialNumber=AA0000&sCustomerId=abc123</p>
        <a href="http://localhost/MyLocalMenu/API/api.php?sFunction=RedemeStampcard&iMenucardSerialNumber=AA0000&sCustomerId=abc123">Redeme stampcard</a>
        
        
        <input type="button" onclick="GetMessagesAndStampsApp();" value="GetMessagesApp">
        
    </body>
</html>