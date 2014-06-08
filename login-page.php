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
        
        <img class="logo" src="img/logo_4.png">
        <h1>MyLocalCafé</h1>
        <div id="NewUser" class="inputFrame ligth">
           <h3>Opret en profil og få en app i dag, det er helt gratis.</h3>
           <input id="sEmailToSubmit" type="text" placeholder="Indtast din email">
           <input type="submit" onclick="HideShowSwitch('Email');" value="Opret en bruger" class="button"/>
        </div> 
        <?php if ($oSecurityController->login_check() == false) : ?>
        <form name="login" method="POST" action="login.php">
            <div id="LoginBox" class="inputFrame">
                <h2>Log Ind</h2>
                <input name="username" id="LoginEmail" type="text" placeholder="Email">
                <input name="password" type="Password" placeholder="Kodeord">
                <input id="loginButton" type="submit" value="Log Ind" class="button"/> 
                <div id='WrongPassword'><p>Skift kodeord</p>
                    <input type='text' placeholder='Email' id='forgotpassMail'>
                    <input type='button' value='Send nyt kodeord til email' class='button' onclick='SendResetPasswordRequest();'>
                </div>
            </div>
        </form>
        <?php else : ?>
        <h6>Du er logget ind</h6>
        <a href="admin">gå til redigering af menukort</a>
        <?php endif; ?>
        
        <script type="text/javascript">
           var url = window.location.search.substring(7);
           if (url === "false") {
               $("#loginButton").before("<div id='WrongPassword'><p>Email eller kodeord er forkert</p></div>");
               //$("#loginButton").after("<div id='WrongPassword'><p>Skift kodeord</p><input type='text' placeholder='Email' id='forgotpassMail'><input type='button' value='Skift koderord' class='button' onclick='SendResetPasswordRequest();' ></div>");
               //Scroll to WrongPassword
               $('html,body').animate({scrollTop: $("#WrongPassword").offset().top},'fast');
               $("#forgotpassMail").focus();
           }
           if(url === "nocafe"){
               $("#loginButton").before("<div id='WrongPassword'><p>Du har endnu ikke oprettet en café</p><p>Vi har sendt en registrerings mail til dig.</p></div>");             
               $('html,body').animate({scrollTop: $("#loginButton").offset().top},'fast');
           }
           if(url === "Account_locked"){
               $("#loginButton").before("<div id='WrongPassword'><p>Kontoen er blevet låst i 2 timer pga. for mange log ind forsøg</p></div>");             
               $('html,body').animate({scrollTop: $("#loginButton").offset().top},'fast');    
          }
        </script>       
    </body>
</html>
