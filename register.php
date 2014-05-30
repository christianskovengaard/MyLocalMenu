<?php

//Check if the sUserToken is set
if(isset($_GET['sUserToken']))
{
    //If sUserToken is valid get the user
    require_once('./Controllers/UserController.php');
    $oUserController = new UserController();
    if($oUserController->ChecksUserToken() == true)
    {
   
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0" />
        <title>MyLocalCafé - Register</title>
        <title>MyLocalCafé</title>
        <link rel="icon" href="img/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="css/general_index.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 500px)" href="css/general_index_small.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width: 850px)" href="css/general_index_medium.css" />
        <link rel="stylesheet" type='text/css' href="css/jquery-ui-1.8.16.custom.css"/>          
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
    </head>
    <body>
        
        <div class="header">                    
                    <img class="logo M" src="img/logo_4.png">
                    <h1>Opret din café profil</h1>
        </div> 
        
            <div class="Register">
                
                    <form action="" method="" id="register_form">
                        <div class="inputFrame A">
                            <h2>Vælg din kode</h2>
<!--                            <input type="text" placeholder="Din email">
                            <input type="password" placeholder="Kode fra modtaget email">-->
                            <input value="" id="NewPassword" type="password" onblur="ValidateRegSwitch('password',this);" placeholder="Indtast en kode">
                            <input value="" type="password" onblur="ValidateRegSwitch('passwordRetype',this);" placeholder="Gentag koden">
                            <div onclick="registerNext(1);" class="button Reg">Næste</div>
                        </div>

                        <div class="inputFrame B">
                            <h2>Firma info</h2>
                            <input type="text" id="sCompanyName" onblur="ValidateRegSwitch('MustFill',this);" placeholder="Firmanavn">
                            <input type="text" id="iCompanyTelefon" onblur="ValidateRegSwitch('phone',this);" maxlength="8" placeholder="Firma telefon">
                            <input type="text" id="sCompanyAddress" onblur="ValidateRegSwitch('MustFill',this);" placeholder="Firma adresse">
                            <input type="text" id="iCompanyZipcode" onblur="ValidateRegSwitch('zipcode',this);" maxlength="4" placeholder="Firma postnummer">
                            <input type="text" id="sCompanyCVR" placeholder="CVR nr.">
                            <h2>Din Café</h2>
                            <input type="text" id="sRestuarentName" onblur="ValidateRegSwitch('MustFill',this);" placeholder="Cafénavn">
                            <input type="text" id="sRestuarentSlogan" style="background: #ddd; " placeholder="Evt. slogan">
                            <input type="text" id="sRestuarentAddress" onblur="ValidateRegSwitch('MustFill',this);" placeholder="Gadenavn og nummer">
                            <input type="text" id="iRestuarentZipcode" onblur="ValidateRegSwitch('zipcode',this);" style="display: inline-block;" size="4" maxlength="4" placeholder="Postnr">
                            <div class="RegCity"></div>
                            <input type="text" id="iRestuarentTel" onblur="ValidateRegSwitch('phone',this);" maxlength="8" placeholder="Telefonnummer">
                            <div onclick="registerNext(0);" class="button prev">Tilbage</div>
                            <div onclick="registerNext(2);" class="button Reg">Næste</div>
                        </div>

                        <div class="inputFrame C">
                            <h2>Åbningstider</h2>
                            <div id="OpeningHours" class="Hours Opening"></div>
                            <div onclick="registerNext(1);" class="button prev">Tilbage</div>
                            <div onclick="SubmitFormRegister();" class="button Reg">OK</div>
                        </div>
                        <input type="hidden" id="sUserToken" value="<?= $_GET['sUserToken']?>"/>
                    </form>
                
            </div>
        
        <div id="mustache_template">
        </div>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/general.js"></script>
        <script type="text/javascript" src="js/jsencrypt.js"></script>
        <script type="text/javascript" src="js/mustache.js"></script>
        <script type="text/javascript" >
                window.onload = function()
                {
                    $('#NewPassword').focus();
                    
                };
                $(document).ready(function() {
                    makeOpeningHours();
                    InitiateAutocompleteForRegister();
                });
        </script>

    </body>
</html>
<?php

    }else{
        header("location: index.php");
    }
}
else{
    header("location: index.php");
}
?>