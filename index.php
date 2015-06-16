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
        <title>MyLocal</title>
        <link rel="icon" href="img/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.16.custom.css" />
        <link rel="stylesheet" type="text/css" href="css/index.min.css" />     
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="header">
           <!-- <a class="logindtop" href="login-page#LogInd">log ind</a>-->
            <div class="wrapper">
                <!--<h1>MyLocal - Din egen personlige App</h1>-->
                <h1>Har du en café, bar eller restaurant?</h1>
              <div class="left">
                  <img class="logo" src="img/logo_4.png"> 
                  <img src="img/IphoneB.png">
              </div>
                
              <div class="rigth">
                
                
                <h3>Få din helt egen app til Android og iPhone.</h3>
                <h3>Promovér dit sted, og kommunikér direkte med dine kunder.</h3>

                <h3>Du får bl.a:</h3>
                <ul>
                    <li>- Eget logo</li>
                    <li>- Eget visuelt udtryk</li>
                    <li>- Besked & tilbudsfunktion</li>
                    <li>- Billedegalleri</li>
                    <li>- Kort & GPS funktionalitet</li>
                    <li>- Online stempelkort</li>
                    <li>- Menukort funktion</li>
                    <li>- Eget CMS system til styring af indholdet på App'en</li>
                </ul>

                <p>Oprettelse: 3.999,- eksl. moms.</p>
                <p>Månedligt abonnement inkl. service: 349,- eksl. moms</p>
                  <br>
                <p>Kontakt os og få et uforpligtende tilbud.</p>
                <div class="contact_index">
                    <a href="mailto: mylocal@mail.com">mylocal@mail.com</a>
                    <a href="tel:+4531658739">Tlf: +45 31 65 87 39</a>
                </div>
                  
              </div>
           </div>
        </div> 
        <div class="body">
            <div class="wrapper">
                <div class="left login-page">
                    <h3>Med din egen App kan du bl.a:</h3>
                      <ul>
                          <li>- Promovere tilbud direkte til dine kunder</li>
                          <li>- Få flere nye kunder</li>
                          <li>- Få flere loyale kunder</li>
                          <li>- Måle løbende på dine salg</li>
                          <li>- Skabe mere omtale og kenskabsgrad til dit sted</li>
                          <li>- Forøge din omsætning</li>
                      </ul>

                      <img style="width:300px;" src="img/Iphone_CutB.png"> 

                    <div class="app-links-index">
                    <h3>Prøv vores test App nu!</h3>
                  <a href="https://itunes.apple.com/us/app/mylocalcafe/id877545381?mt=8" target="_blank"><img src="img/apple.svg"> Hent til Apple</a>
                  <a href="https://play.google.com/store/apps/details?id=com.mylocal.mylocalcafe&hl=da" target="_blank"><img src="img/android.svg"> Hent til Android</a>
                    </div>
                </div>
                
                
                
                <div class="rigth login-page">
                    <img style="width:300px;" src="img/Iphone_CutA.png"> 
                    <h3>Med din egen App er det muligt, at tilføje oplysninger om dit sted.</h3>
                    <h3>Disse oplysninger kan bl.a være:</h3>
                     <ul>
                         <li>- Åbningstider</li>
                         <li>- Menukort</li>
                         <li>- Tilbud</li>
                         <li>- Service info</li>
                         <li>- Wi-fi adgang</li>
                         <li>- Beliggenhed med kort & GPS</li>
                         <li>- Mærkedage</li>
                         <li>- Konkurrencer</li>
                         <li>- Beskeder</li>
                         <li>- Online stempelkort</li>
                     </ul>
                 </div>
                <br><br><br>
            </div>
        </div>

        <div class="loginBlock">
            <div class="wrapper">
              <a name="LogInd"></a> <!-- Anchor for link to logind on page -->
             <?php if ($oSecurityController->login_check() == false) : ?>
                  <form name="login" method="POST" action="login.php">
                      <div id="LoginBox" class="inputFrame">
                      <img class="logo" src="img/logo_4.png"> 
                      <h1>MyLocal</h1>
                        <h3>Igennem dit eget CMS system kan du redigere <br> & opdatere oplysinger på din App.</h3>
                        <h2>Log ind med din e-mail og dit kodeord nedenfor:</h2>
                        <input name="username" id="LoginEmail" type="text" placeholder="Email">
                        <input name="password" id="LoginPassword" type="Password" placeholder="Kodeord">
                        <input id="loginButton" type="submit" value="Log Ind" class="btn"/>
                        <p class="forgotpassword" style='display: inline-block; margin: 0;'>Har du glemt dit kodeord </p>
                        <a class="forgotpassword" style='background: none; color:#FCA041; padding:0 3px; display: inline-block;' href='login-page?login=newCode#LogInd'> Klik her</a>
                      </div>
                  </form>
              <?php else : ?>
                <div id="LoginBox" class="inputFrame">
                      <img class="logo" src="img/logo_4.png"> 
                      <h1>MyLocal</h1>
                      <h2>Du er logget ind</h2>
                      <a href="admin">Tryk her, for at gå til redigering af menukort</a>
                  </div>
              <?php endif; ?>
             </div>   
        </div>
                
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script> <!-- migrate plugin for old jQuery-->  
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/general.js"></script>
        <script type="text/javascript">
           var url = window.location.search.substring(7);
           if (url === "false") {
               $("#loginButton").before("<div id='WrongPassword'><p>Email eller kodeord er forkert</p></div>");
           }
           if(url === "nocafe"){
               $("#loginButton").before("<div id='WrongPassword'><p>Du har endnu ikke oprettet et sted</p><p>Vi har sendt en registrerings mail til dig.</p></div>");             
               $('html,body').animate({scrollTop: $("#loginButton").offset().top},'fast');
           }
           if(url === "Account_locked"){
               $("#loginButton").before("<div id='WrongPassword'><p>Kontoen er blevet låst i 2 timer pga. for mange log ind forsøg</p></div>");             
               $('html,body').animate({scrollTop: $("#loginButton").offset().top},'fast');    
          }
          if(url === "newCode"){
               $("#LoginBox h2").text('Nyt kodeord');
               $("#LoginEmail").remove();
               $("#LoginPassword").remove();
               $("#loginButton").before("<div id='WrongPassword'><input type='text' placeholder='Email' id='forgotpassMail'><input type='button' value='Send nyt kodeord til email' class='btn' onclick='SendResetPasswordRequest();'><a style='background: none; color:#FCA041; padding:0 3px; display: inline-block;' href='login-page#LogInd'>tilbage</a></div>");             
               $('html,body').animate({scrollTop: $("#loginButton").offset().top},'fast');    
               $("#loginButton").remove();
               $('.forgotpassword').hide();
          }

        </script>
    </body>
</html>
