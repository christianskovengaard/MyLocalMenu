<?php
//Check if user is logged in
require 'Controllers/SecurityController.php';
$oSecurityController = new SecurityController();
$oSecurityController->sec_session_start(); // Our custom secure way of starting a php session.
if($oSecurityController->login_check() == true) { ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimun-scale=1.0, initial-scale=1.0" />
        <title>My Local Menu</title>
        <link rel="stylesheet" type="text/css" href="css/general_admin.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 700px)" href="css/general_admin_small.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:701px) and (max-width: 1170px)" href="css/general_admin_medium.css" />
                
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/general.js"></script>
        <script type="text/javascript" src="js/mustache.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.autogrow.js"></script> 
    </head>
    <body>       
        <div class="header">
            <div class="wrapper">
                <div class="logoWrapper">                        
                    <img src="img/logo_4.png">
                    <div class="logoText">
                         <h5>MyLocalCafé</h5>
                    </div>
                    <div class="appGetInfo">
                        <h6>Hent MyLocalCafé appen nu</h6>
                        <img src="img/getAppleApp.png"><img src="img/getAndroidApp.png"><img src="img/getWindowsApp.png">
                    </div>
                </div>
            </div>            
        </div>
        
        <div class="RestaurantInfo">                  
        </div>
        
        <div class="TabMenu">
            <div id="TabsMenu" class="Tab On" onclick="TapChange('sMenu');">Menu</div>
            <div id="TabsMessenger" class="Tab" onclick="TapChange('sMessenger');">Beskeder</div>
            <div id="TabsStamp" class="Tab" onclick="TapChange('sStamp');">Stemplekort</div>
            <div id="TabsEdit" class="Tab" onclick="TapChange('sEdit');">Indstillinger</div>
        </div>
        
        <div id="TabWrappersMenu" class="menuWrapper">
            <div class="wrapper">
                <div class="menuWrapperInner" id="wrapper">
                    <div class="sortablediv" id='restuarantInfo'>                       
                    </div>
                    
                    <div onclick="CreateNewSortableList();" class="newsortablediv"><h3>+</h3></div>
                    <div class="newsortabledivbuffer"></div>     
                </div>
                
            </div> 
        </div>
        
        <!-- Messages -->
        <div id="TabWrappersMessenger" class="menuWrapper" style="display: none;" >
            <div class="wrapper">
                <div class="menuWrapperInner" id="wrapper">
                    <input id="sMessageHeadline" type="text" value="" placeholder="Overskrift"/>
                    <textarea id="sMessengerTextarea" placeholder="Skriv en ny besked"></textarea>
                    <p>Beskeden skal være aktiv frem til:</p>
                    <a href="#">[DD MM YYYY]</a>
                    <div class="button" onclick="SaveMessage();">Send</div>
                    <br><br>
                    <h2>Gamle beskeder:</h2>
                    <div id="oldMessages" class="oldMessenge"></div>
                          
                </div>
            </div>
        </div>
        <!-- end Messages -->
        
        <!-- Stampcard and QRcode -->
        <div id="TabWrappersStamp" class="menuWrapper" style="display: none;">
            <div class="wrapper">
                <div class="menuWrapperInner" id="wrapper">
                    <p>Sådan ser dit stemplkort ud:</p>
                    <div class='StampEX' id='StampEX'>
                        <h3>STEMPLEKORT</h3>
                        <h4></h4>
                    </div>
                    <div class='StampWrapper'>
                        <p>Antal stempler på stempelkortet:</p>
                        <input value="" placeholder="" id="iMaxStamps">
                        <div class='button StampButton' onclick="MakeStampcard();">Gem</div>
                        
                        <div class='StampStat'>
                            <div> <span id="iStampsgiven"></span> stempler er uddelt</div><br/>
                            <p>Hvor mange kopper gratis mad/kaffe giver det</p><br/>
                            <p>Stempler uddelt i år</p>
                            <img src="" id="stampchart" title="Uddelte stempler" alt="Chart"><br/>
                            <p>Info om de enkelte brugere som har fået stempler og kaffe</p>
                        </div>
   
                        <h3>QR kode</h3>
                        <div>
                            <!--<span>Brug denne QR kode til stempelkort</span>-->
                            <!--<div id="currentQRcode"></div>-->
                            
                            <div class='button StampButton' onclick="PrintQRcode();">Print din QR kode</div>
<!--                        </div>
                        <h2>Lav ny QR kode</h2>
                        <div>
                            <span>Her kan du lave en ny QR kode</span>
                            <br>-->
                            <div class='button StampButton'onclick='GenerateQRcode();'>Lav en ny QR kode</div>
                            <div id="currentQRcode"></div>
                        </div>
                        <br><br><br>
                    </div>    
                </div>
            </div>
        </div>
        <!-- end Stampcard and QRcode -->
        
        <!-- Settings -->
        <div id="TabWrappersEdit" class="menuWrapper" style="display: none;">   
            <div class="EditRestaurantInfoWrapper">
                    <h3>Ret Café oplysninger</h3>
                    <div>
                        <p>Café navn</p>
                        <input id="MenuName" type="text" value="" placeholder="Restuarent navn"> <br/>
                        <p>evt Slogan</p>
                        <input id="MenuSubName" type="text" value="" placeholder="slogan"> <br/>
                        <p>Vejnavn og nummer</p>
                        <input id="MenuAdress" type="text" value="" placeholder="Adresse"> <br/>
                        <p>Postnr. og by</p>
                        <input id="MenuZip" type="text" value="" placeholder="Post nr." maxlength="4">
                        <input id="MenuTown" type="text" value=""> <br/>
                        <p>Caféns telefonnr.</p>
                        <input id="MenuPhone" type="text" value="" placeholder="Telefonnummer" maxlength="8">
                        
                    </div>

                    <div>
                        <p>Åbningstider</p>
                        <div id="OpeningHours" class="Hours Opening"></div>
                        <input type="button" class="button pushdown" onclick="UpdateRestuarentInfo();" value="Opdater oplysninger"/>
                    </div>
            </div>
            
            <div class='line'>.</div>
            
            <div class="EditRestaurantInfoWrapper">        
                <h3>Bruger & firma information</h3>
                <div>
                    <p>Brugernavn</p>
                    <input type="text" id="sUsername" placeholder="Brugernavn"><br/>
                    <p>Firmanavn</p>
                    <input type="text" id="sCompanyName" placeholder="Firmanavn"><br/>
                    <p>CVR nr.</p>
                    <input type="text" id="sCompanyCVR" placeholder="CVR nr.">     <br/>  
                    <p>Firma telefonnr.</p>
                    <input type="text" id="iCompanyTelefon" onblur="ValidateRegSwitch('phone',this);" maxlength="8" placeholder="Firma telefon"><br/>
                    <p>Firma adresse</p>
                    <input type="text" id="sCompanyAddress" placeholder="Firma adresse"><br/>
                    <p>Postnr.</p>
                    <input type="text" id="iCompanyZipcode" onblur="ValidateRegSwitch('zipcode',this);" maxlength="4" placeholder="Firma postnummer"><br/>                    
                    <input type="button" class="button" onclick="UpdateUserinformation();" value="Opdater informationer"/>
                </div>
            </div>
            
        </div>
    <!-- end Settings -->
        
        
    <div id="mustache_template">           
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            GetMenucard(true);
            makeOpeningHours();
            GetMessages();
            GetStampcard();
            GetUserinformation();
        });
    </script>    
    </body>
</html>
<?php  } else {
    header("location: index.php");
    //$asd = $oSecurityController->login_check();
    /*var_dump($asd);
    echo $_SESSION['user_id'] .'<br>'; 
    echo $_SESSION['username'] .'<br>';
    echo $_SESSION['login_string'] .'<br>';*/
}

?>