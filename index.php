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
        <link rel="stylesheet" type="text/css" href="css/general_index.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 500px)" href="css/general_index_small.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width: 850px)" href="css/general_index_medium.css" />
                
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/general.js"></script>

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
        <div class="body">
            <div class="wrapper">
                <div class="left">
                    <h1>Er du cafe ejer?</h1>
                    <a href="admin.php#LogInd">Log ind</a>
                    <p>eller</p>
                    <a href="admin">læs mere</a>
                    <br>
                    <h3>og få oprettet din café med det samme, helt gratis!</h3>
                </div>
                <div class="rigth">
                    <img class="logo" src="img/logo_4.png">
                </div>
            </div>
        </div>
    </body>
</html>
