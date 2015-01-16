<?php
require 'Controllers/SecurityController.php';
$oSecurityController = new SecurityController();
$oSecurityController->sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0" />
        <title>MyLocalCafé</title>
        <link rel="icon" href="img/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.16.custom.css" />
        <link rel="stylesheet" type="text/css" href="css/index.min.css" />          
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        
        <div class="header">
            <div class="wrapper">
                   
                <div class="left">
                  <img src="img/iphone.png">
                </div>
                <div class="rigth">
                  <p>Velkommen til</p>
                  <h1>MyLocal<span>Café</span></h1>
                  <h3>Her kan du følge dine favorit caféer. </h3>
                  <h3>Du kan se info om deres sted, se deres menukort, samt få aktuelle tilbud og beskeder direkte.</h3>
                  <h3>Søg blot på dine lokale favorit caféer i søgefeltet for at komme i gang!</h3>
                  <br><br>
                  <a href="https://itunes.apple.com/us/app/mylocalcafe/id877545381?mt=8" target="_blank"><img src="img/apple.svg"> Hent til Apple</a>
                  <a href="https://play.google.com/store/apps/details?id=com.mylocal.mylocalcafe&hl=da" target="_blank"><img src="img/android.svg"> Hent til Android</a>
                </div>
            </div>
        </div>
        
        
                <!-- Responsive TEST
                <div class="frame">
                    <div class="col-2"><img src="img/iphone.png"></div>
                    <div class="col-2"><p>Velkommen til</p>
                  <h1>MyLocal<span>Café</span></h1>
                  <h3>Her kan du følge dine favorit caféer. </h3>
                  <h3>Du kan se info om deres sted, se deres menukort, samt få aktuelle tilbud og beskeder direkte.</h3>
                  <h3>Søg blot på dine lokale favorit caféer i søgefeltet for at komme i gang!</h3>
                  <br><br>
                  <a href="https://itunes.apple.com/us/app/mylocalcafe/id877545381?mt=8" target="_blank"><img src="img/apple.svg"> Hent til Apple</a>
                  <a href="https://play.google.com/store/apps/details?id=com.mylocal.mylocalcafe&hl=da" target="_blank"><img src="img/android.svg"> Hent til Android</a></div>
                </div> 
                <!-- end --->
        
        
        <div class="body">
            <div class="wrapper">
                <div class="left">
                    <h1>Er du cafe ejer?</h1>
                    <a href="login-page.php#LogInd">Log ind</a>
                    <p>eller</p>
                    <a href="admin">læs mere</a>
                    <br>
                    <h3>og få oprettet din café med det samme, helt gratis!</h3>
                </div>
                <div class="rigth">
                    <img style="width:250px;" src="img/Iphone_CutA.png">
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script> <!-- migrate plugin for old jQuery-->  
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/general.js"></script>
        <script type="text/javascript">
        if (screen.width <= 720) {
            //window.location = "adminapp/index.php";
        }
        </script>
    </body>
</html>
