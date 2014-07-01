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
            <a class="logindtop" href="login-page#LogInd">log ind</a>
            <div class="wrapper">
              <div class="left">
                  <img src="img/IphoneB.png">
              </div>
              <div class="rigth">
               

                  <h1>Kære Café ejer</h1>
                  <h3>Få din egen App, og kommunikér direkte med dine kunder, helt gratis.</h3> 
                  
                  <h3>Opret en profil og få en app i dag, det er helt gratis.</h3>
                   <input id="sEmailToSubmit" type="text" placeholder="Indtast din email">
                   <!--<div onclick="HideShowSwitch('Email');" class="button01">Opret</div>-->
                   <input type="submit" onclick="HideShowSwitch('Email');" id="addUserBtn" value="Opret din café" class="btn"/>
                                
              </div>
           </div>
        </div> 
        <div class="body">
            <div class="wrapper">
                <div class="left login-page">
                    <h3>Du kan:</h3>
                      <ul>
                          <li> Promover tilbud til dine kunder</li>
                          <li> Få nye kunder</li>
                          <li> Få flere loyale kunder</li>
                          <li> Mål løbende på dine salg</li>
                          <li> Skab omtale om dit sted</li>
                          <li> Forøg din omsætning</li>
                      </ul>

                      <img style="width:300px;" src="img/Iphone_CutB.png"> 

                      <h3>Sådan virker det</h3>
                      <p>Dine Café kunder henter MyLocalCafé's app. De indtaster jeres cafénavn, og får vist jeres personlige café app.</p>
                </div>
                <div class="rigth login-page">
                    <img style="width:300px;" src="img/Iphone_CutA.png"> 
                    <h3>Du kan som café ejer oprette en gratis profil. Med denne profil er det muligt, at tilføje oplysninger om din café. Disse oplysninger er individuelle, men kan bl.a. være:</h3>
                     <ul>
                         <li> Åbningstider</li>
                         <li> Menukort</li>
                         <li> Tilbud</li>
                         <li> Service info</li>
                         <li> Wi-fi adgang</li>
                         <li> Beliggenhed</li>
                         <li> Mærkedage</li>
                         <li> Konkurrencer</li>
                         <li> Send push beskeder</li>
                         <li> Opret online klippekort</li>
                         <li> Opret online stempelkort</li>
                         <li> Og meget mere</li>
                     </ul>
                 </div>    
                  <div class="wrapper">   
                     <h3>Dine café oplysninger kommunikeres direkte til dine kunder igennem MyLocal Café´s app.</h3>
                     <br><br><br><br>
                  </div>
                
            </div>
        </div>

        <div class="loginBlock">
            <div class="wrapper">
              <a name="LogInd"></a> <!-- Anchor for link to logind on page -->
             <?php if ($oSecurityController->login_check() == false) : ?>
                  <form name="login" method="POST" action="login.php">
                      <div id="LoginBox" class="inputFrame">
                      <img class="logo" src="img/logo_4.png"> 
                      <h1>MyLocal<span>Café</span></h1>
                        <h2>Log Ind</h2>
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
                      <h1>MyLocal<span>Café</span></h1>
                      <h2>Du er logget ind</h2>
                      <a href="admin">Tryk her, for at gå til redigering af menukort</a>
                  </div>
              <?php endif; ?>
             </div>   
        </div>

        <!--   over sat ind nu   -->

        <!--<div id="NewUser" class="inputFrame ligth">
           <h3>Opret en profil og få en app i dag, det er helt gratis.</h3>
           <input id="sEmailToSubmit" type="text" placeholder="Indtast din email">
           <input type="submit" onclick="HideShowSwitch('Email');" value="Opret en bruger" class="button"/>
        </div> -->    
        <script type="text/javascript">
           var url = window.location.search.substring(7);
           if (url === "false") {
               $("#loginButton").before("<div id='WrongPassword'><p>Email eller kodeord er forkert</p></div>");
               //$("#loginButton").after("<div id='WrongPassword'><p>Skift kodeord</p><input type='text' placeholder='Email' id='forgotpassMail'><input type='button' value='Skift koderord' class='button' onclick='SendResetPasswordRequest();' ></div>");
               //Scroll to WrongPassword
               //$('html,body').animate({scrollTop: $("#WrongPassword").offset().top},'fast');
               //$("#forgotpassMail").focus();
           }
           if(url === "nocafe"){
               $("#loginButton").before("<div id='WrongPassword'><p>Du har endnu ikke oprettet en café</p><p>Vi har sendt en registrerings mail til dig.</p></div>");             
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
