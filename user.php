<?php
require 'Controllers/SecurityController.php';
$oSecurityController = new SecurityController();
$oSecurityController->sec_session_start();


//If sUserToken is valid get the user
require_once('./Controllers/UserController.php');
$oUserController = new UserController();
if(isset($_GET['sUserToken']) && $oUserController->ChecksUserToken() == true) :  
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimun-scale=1.0, initial-scale=1.0" />
        <title>My Local Menu</title>
        <link rel="icon" href="img/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="css/general_index.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 500px)" href="css/general_index_small.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width: 850px)" href="css/general_index_medium.css" />
                
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/general.js"></script>
        <script type="text/javascript" src="js/jsencrypt.js"></script>
    </head>
    <body>
         
        <div class="info03" id="info03register">
            <div class="wrapper">
                <h1>Sæt dit nye kodeord</h1>

                <div class="inputFrameWrapper">
                    <form action="" method="" id="register_form">
                        <div class="inputFrame A">
                            <h5>Vælg din kode</h5>
                            <input value="" id="NewPassword" type="password" onblur="ValidateRegSwitch('password',this);" placeholder="Indtast en kode">
                            <input value="" type="password" onblur="ValidateRegSwitch('passwordRetype',this);" placeholder="Gentag koden">
                            <input type="button" onclick="SubmitFormNewPassword();" class="button" value="Ok">
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
    </body>
</html>
<?php
else : header('location: index'); endif;
?>