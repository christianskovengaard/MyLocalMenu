<?php
ob_start(); 
require 'Controllers/SecurityController.php';
$oSecurityController = new SecurityController();
$oSecurityController->sec_session_start();


//If sUserToken is valid get the user
require_once('./Controllers/UserController.php');
$oUserController = new UserController();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimun-scale=1.0, initial-scale=1.0" />
        <title>My Local Menu</title>
        <link rel="stylesheet" type="text/css" href="css/general_index.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 500px)" href="css/general_index_small.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width: 850px)" href="css/general_index_medium.css" />
                
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/general.js"></script>
        <script type="text/javascript" src="js/jsencrypt.js"></script>
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
            </div>
        </div> 
        
<!--        <div class="info01">
            <div class="wrapper">

            </div>
        </div> -->
        
        <?php if(isset($_GET['sUserToken']) && $oUserController->ChecksUserToken() == true) : ?>
    
        <div class="info03" id="info03register">
            <div class="wrapper">
                <h1>Sæt dit nye kodeord</h1>

                <div class="inputFrameWrapper">
                    <form action="" method="" id="register_form">
                        <div class="inputFrame A">
                            <h5>Vælg din kode</h5>
                            <input value="" id="NewPassword" type="password" onblur="ValidateRegSwitch('password',this);" placeholder="Indtast en kode">
                            <input value="" type="password" onblur="ValidateRegSwitch('passwordRetype',this);" placeholder="Gentag koden">
                            <div onclick="SubmitFormNewPassword();" class="button01">OK</div>
                        </div>
                        <input type="hidden" id="sUserToken" value="<?= $_GET['sUserToken']?>"/>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript" >
                $(document).ready(function() {
                    $('#NewPassword').focus();                   
                });
        </script>
        <?php elseif($oSecurityController->login_check() == true) :?>         
            <div class="info03" id="info03register">
                <div class="wrapper">
                    <h1>Bruger & firma information</h1>
                    <div class="inputFrameWrapper" style="height: 400px;">
                        <div class="inputFrame">
                            <input type="text" id="sUsername" placeholder="Brugernavn">
                            <input type="text" id="sCompanyName" placeholder="Firmanavn">
                            <input type="text" id="iCompanyTelefon" onblur="ValidateRegSwitch('phone',this);" maxlength="8" placeholder="Firma telefon">
                            <input type="text" id="sCompanyAddress" placeholder="Firma adresse">
                            <input type="text" id="iCompanyZipcode" onblur="ValidateRegSwitch('zipcode',this);" maxlength="4" placeholder="Firma postnummer">
                            <input type="text" id="sCompanyCVR" placeholder="CVR nr.">                           
                            <div onclick="UpdateUserinformation();" class="button01">Opdater</div>
                        </div>
                    </div>
                </div>
            </div>        
            <script type="text/javascript" >
                $(document).ready(function() {
                   $('#sUsername').focus();
                   GetUserinformation();
                });
            </script>  
        <?php else: header("location: index.php"); endif;?>
<!--        <div class="info03">
            <div class="wrapper">
                  
            </div>
        </div>-->
        
        <div class="footer">
            <div class="wrapper">
                <h2>Sprøgsmål?</h2>
                <p>ring: 88 88 88 88 </p>
            </div>
        </div> 


    </body>
</html>