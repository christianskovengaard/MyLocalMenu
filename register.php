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
        <script type="text/javascript" src="js/mustache.js"></script>
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
        
        <div class="info03" id="info03register">
            <div class="wrapper">
                <h1>Opret dit menukort</h1>
                <h3>➊➁➂</h3>
                <div class="inputFrameWrapper">
                    <form action="" method="" id="register_form">
                        <div class="inputFrame A">
                            <h5>Vælge din kode</h5>
<!--                            <input type="text" placeholder="Din email">
                            <input type="password" placeholder="Kode fra modtaget email">-->
                            <input value="" id="NewPassword" type="password" onblur="ValidateRegSwitch('password',this);" placeholder="Indtast en kode">
                            <input value="" type="password" onblur="ValidateRegSwitch('passwordRetype',this);" placeholder="Gentag koden">
                            <div onclick="registerNext(1);" class="button">næste</div>
                        </div>

                        <div class="inputFrame B">
                            <h5>Spisestedet</h5>
                            <input type="text" id="sCompanyName" placeholder="Firmanavn">
                            <input type="text" id="iCompanyTelefon" onblur="ValidateRegSwitch('phone',this);" maxlength="8" placeholder="Firma telefon">
                            <input type="text" id="sCompanyAddress" placeholder="Firma adresse">
                            <input type="text" id="iCompanyZipcode" onblur="ValidateRegSwitch('zipcode',this);" maxlength="4" placeholder="Firma postnummer">
                            <input type="text" id="sCompanyCVR" placeholder="CVR nr.">
                            <input type="text" id="sRestuarentName" placeholder="Spisesteds navn">
                            <input type="text" id="sRestuarentSlogan" style="background: #ddd; " placeholder="evt Spisestets slogan">
                            <input type="text" id="sRestuarentAddress" placeholder="Gadenavn og nummer">
                            <input type="text" id="iRestuarentZipcode" onblur="ValidateRegSwitch('zipcode',this);" style="display: inline-block;" size="4" maxlength="4" placeholder="Postnr">
                            <div class="RegCity"></div>
                            <input type="text" id="iRestuarentTel" onblur="ValidateRegSwitch('phone',this);" maxlength="8" placeholder="Telefonnummer">
                            <div onclick="registerNext(0);" class="button prev">tilbage</div>
                            <div onclick="registerNext(2);" class="button">næste</div>
                        </div>

                        <div class="inputFrame C">
                            <h5>Åbningstider</h5>
                            <div id="OpeningHours" class="Hours Opening"></div>
                            <!--<h5>Bringer I ud?</h5><div id="TakAwayYes" onclick="makeTakeAwayHours(1);" class="button01 prev">Ja</div><div id="TakAwayNo" onclick="makeTakeAwayHours(0);" class="button01 prev">Nej</div>-->
                            <br><br>
                            <div class="Hours TakeAway"></div>
                            <!--<input type="text" style="background: #ccc ; " placeholder="evt Note">-->
                            <div onclick="registerNext(1);" class="button prev">tilbage</div><br>
                            <div onclick="SubmitFormRegister();" class="button">OK</div>
                        </div>
                        <input type="hidden" id="sUserToken" value="<?= $_GET['sUserToken']?>"/>
                    </form>
                </div>
            </div>
        </div> 
        
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
        <div id="mustache_template">
        </div>
        <script type="text/javascript" >
                window.onload = function()
                {
                    $('#NewPassword').focus();
                    
                };
                $(document).ready(function() {
                    makeOpeningHours();
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