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
        <link rel="icon" href="img/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="css/general_register.css" />
        <link rel="stylesheet" type='text/css' href="css/jquery-ui-1.8.16.custom.css"/>          
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
    </head>
    <body>
        
        <div class="header">               
                    <img class="logo M" src="img/logo_4.png">
                    <h3>Opret din café profil</h3>
        </div> 
        
            <div class="wrapper">
                    <form action="" method="" id="register_form">
                        <div class="inputFrame A">
                            <h2>Vælg din kode</h2>
<!--                            <input type="text" placeholder="Din email">
                            <input type="password" placeholder="Kode fra modtaget email">-->
                            <input value="" id="NewPassword" type="password" onblur="ValidateRegSwitch('password',this);" placeholder="Indtast en kode">
                            <input value="" id="NewPasswordRetype" onblur="ValidateRegSwitch('passwordRetype',this);" type="password" placeholder="Gentag koden">
                            <!--<div onclick="registerNext(1);" class="button Reg">Næste</div>-->
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
                            <input type="text" id="sRestuarentSlogan" style="background: #eee; " placeholder="Evt. slogan">
                            <input type="text" id="iRestuarentTel" onblur="ValidateRegSwitch('phone',this);" maxlength="8" placeholder="Telefonnummer">
                            <input type="text" id="sRestuarentAddress" onblur="ValidateRegSwitch('MustFill',this);" placeholder="Gadenavn og nummer">
                            <input type="text" id="iRestuarentZipcode" onblur="ValidateRegSwitch('zipcode',this);" style="display: inline-block;" size="4" maxlength="4" placeholder="Postnr">
                            <div class="RegCity"></div>
                            <div id="google_map_my_cafe">
                                <div id="google_map_my_cafe_map"></div>
                                <div id="google_map_my_cafe_hent">
                                    <div id="google_map_my_cafe_hent_fail">
                                        Kunne ikke finde din adresse, kilk på kort hvor din cafe er
                                    </div>
                                    <div id="google_map_my_cafe_hent_fail_2">
                                        Intast cafens adresse førest
                                    </div>
                                    <div id="google_map_my_cafe_hent_button" onclick="BrugerCafePlacering.hentPlacering($('#sRestuarentAddress').val(), $('#iRestuarentZipcode').val())">
                                        Find addresse
                                    </div>
                                </div>
                            </div>
                            <!--<div onclick="registerNext(0);" class="button prev">Tilbage</div>
                            <div onclick="registerNext(2);" class="button Reg">Næste</div>-->
                        </div>

                        <div class="inputFrame C">
                            <h2>Åbningstider</h2>
                            <div id="OpeningHours" class="Hours Opening"></div>
                            <!--<div onclick="registerNext(1);" class="button prev">Tilbage</div>-->
                            <div onclick="SubmitFormRegister();" class="btn">OK</div>
                        </div>
                        <input type="hidden" id="sUserToken" value="<?= $_GET['sUserToken']?>"/>
                    </form>
                
            </div>
        
        <div id="mustache_template">
        </div>
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script> <!-- migrate plugin for old jQuery-->  
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script src="http://maps.googleapis.com/maps/api/js"></script>
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
                google.maps.event.addDomListener(window, 'load', function () {
                    BrugerCafePlacering.initMap();
                });
                window.onbeforeunload = function() {
                    //Check for validationTag
                    if($(".creatingProfile")[0]){
                        //Ingen fejl
                    }else{
                        return "Du er ved at lukke siden. Hvis du forlader siden går alle data tabt!";
                    }
                   
                };
        </script>

    </body>
</html>
<?php
    }else{
        header("location: index");
    }
}
else{
    header("location: index");
}
?>