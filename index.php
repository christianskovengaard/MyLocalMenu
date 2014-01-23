<?php
require 'Controllers/SecurityController.php';
$oSecurityController = new SecurityController();
$oSecurityController->sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimun-scale=1.0, initial-scale=1.0" />
        <title>My Local Menu</title>
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
                <div class="logoWrapper">                        
                    <img src="img/logo.png">
                    <div class="logoText">
                         <h5>MyLocalMenu</h5>
                         <h6>Menukort på mobile</h6>
                    </div>
                </div>
                <?php if ($oSecurityController->login_check() == false) : ?>
                <div onclick="HideShowSwitch('Login');" class="button01">Log ind</div>
                <form name="login" method="POST" action="login.php">
                    <div id="LoginBox" class="inputFrame">                   
                        <input name="username" id="LoginEmail" type="text" placeholder="Email">
                        <input name="password" type="Password" placeholder="Kodeord">
                        <input type="submit" value="Log ind" class="button02"/> 
                        <div onclick="HideShowSwitch('Login');" class="button02">Luk</div>
                    </div>
                </form>
                <?php else : ?>
                <!--<div onclick="" class="button01">Rediger brugerprofil</div>-->
                <form name="logout" method="POST" action="logout.php">
                    <input type="submit" value="Log ud" class="button01"/>
                </form>
                <?php endif; ?>
            </div>
        </div> 
        
        <div class="info01">
            <div class="wrapper">
                <div class="Info01Img">
                    <img src="img/info01.png">
<!--                    <h2 class="Info01Txt01">Første gang tastes det unikke nummer ind på mobilen</h2>
                    <h2 class="Info01Txt02">Så er menukortet altid på mobilen</h2>
                    <h2 class="Info01Txt03">Alle ændringer på menukorten kommer med det sammen ud på mobilen</h2>  -->
                </div>
                <div class="inputFrame">
                    <form method="GET" action="viewmenucard.php" id="FindMenucardForm">
                        <input type="text" name="iMenucardSerialNumber" placeholder="Find Menukort" class="autocomplete">                   
                        <div onclick="SubmitForm('FindMenucardForm');" class="FindMenuImg"><img src="img/search.JPG"></div>
                    </form>
                </div>
            </div>
        </div> 
        
        <div class="info02">
            <div class="wrapper">
                <h1>Opret et menukort</h1>
                <h3>...det er helt gratis</h3>
                <div class="inputFrame" id="EmailSubmission">
                    <input id="sEmailToSubmit" type="text" placeholder="Indtast din email">
<!--                    <input type="Password" placeholder="Indtast et kodeord">
                    <input type="Password" placeholder="Gentag kodeorden">-->
                    <div onclick="HideShowSwitch('Email');" class="button01">Opret</div>
                </div>           
            </div>
        </div> 
        
        <div class="info03">
            <div class="wrapper">
                <div class="Info03Img">
                    <img src="img/info02.png">
                </div>                   
            </div>
        </div>
        
        <div class="footer">
            <div class="wrapper">
                Firma info kontakt ect
                <h2>Du kan altid opdater dit menukort</h2>
                <p>jggbga asdjkgau askdgjbad askjasdb </p>
                <h2>Virker på det hele</h2>
                <p>[logoer]</p>
            </div>
        </div> 
        
    </body>
</html>
