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
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 800px)" href="css/general_admin_small.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:801px) and (max-width: 1170px)" href="css/general_admin_medium.css" />
                
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
                    <img src="img/logo.png">
                    <div class="logoText">
                         <h5>MyLocalMenu</h5>
                         <h6>Menukort på mobile</h6>
                    </div>
                    <div class="appGetInfo">
                        <h6>Hent MyLocalMenu appen nu</h6>
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
                    
                    <textarea id="sMessengerTextarea" placeholder="Skriv en ny besked"></textarea>
                    <p>Hvor længe skal beskeden vises:</p>
                    <select style="width: 80px;" id="iNewEventRsvp">
                           <option value = "0">1 dag</option>
                           <option value = "1">2 dage</option>
                           <option value = "2">3 dage</option>
                    </select> 
                    <div class="button">Send</div>
                    <h2>Gamle beskeder:</h2>
                    <div class="oldMessenge">EN GAMMEL BESKED</div>
                          
                </div>
            </div>
        </div>
        <!-- end Messages -->
        
        <!-- Stampcard and QRcode -->
        <div id="TabWrappersStamp" class="menuWrapper" style="display: none;">
            <div class="wrapper">
                <div class="menuWrapperInner" id="wrapper">
                    <h1>Stempler</h1>
                    <div>
                        <p>Her skal der vises info om stempler</p><br/>
                        <p>Hvor mange stempler er blevet givet ud</p><br/>
                        <p>Hvor mange koppe gratis mad/kaffe giver det</p><br/>
                        <p>Lav evt. noget lev graf med Google Chart API</p><br/>
                        <p>Info om de enkelte brugere som har fået stempler og kaffe</p>
                    </div>
                    <span><------------------------------------------------------></span>
                    <h1>QR koder</h1>
                    <div>
                        <span>Brug denne QRcode til stempelkort</span>
                        <div id="currentQRcode"></div>
                        <button onclick="PrintQRcode();">Print QRkode</button>
                    </div>
                    <h2>Lav ny QR kode</h2>
                    <div>
                        <span>Her kan du lave en ny QR kode</span>
                        <br>
                        <button onclick='GenerateQRcode();'>Lav ny QR kode</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="TabWrappersEdit" class="menuWrapper" style="display: none;">
            <div class="wrapper">
                <div class="menuWrapperInner" id="wrapper">
                    <p>Indstillinger</p>
                </div>
            </div>
        </div>
        <!-- end Stampcard and QRcode -->
        
        <!-- Restuarent info -->        
        <div id="EditRestaurantInfo" class="EditRestaurantInfo">
            <div class="EditRestaurantInfoWrapper">
                <h3>Ret oplysninger</h3>
                <div>
                    <div class="buttonEdit" onclick="HideShowSwitch('PopUpWindowEditManuInfo');">Luk</div>
                    <p>Restuarent navn</p>
                    <input id="MenuName" type="text" value="" placeholder="Restuarent navn">
                    <p>evt Slogan</p>
                    <input id="MenuSubName" type="text" value="" placeholder="slogan">
                    <p>Vejnavn og nummer</p>
                    <input id="MenuAdress" type="text" value="" placeholder="Adresse">
                    <p>Postnr. og by</p>
                    <input id="MenuZip" type="text" value="" placeholder="Post nr." maxlength="4">
                    <input id="MenuTown" type="text" value="">
                    <p>Telefonnr.</p>
                    <input id="MenuPhone" type="text" value="" placeholder="Telefonnummer" maxlength="8">
                    <input type="button" onclick="UpdateRestuarentInfo()" value="Opdater"/>
                </div>
                
                <div>
                    <p>Åbningstider</p>
                    <div id="OpeningHours" class="Hours Opening"></div>
                </div>
                
            </div>             
        </div>
        <!-- end Restuarent info -->
        
    <div id="mustache_template">           
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            GetMenucard(true);
            makeOpeningHours();
        });
    </script>    
    </body>
</html>
<?php  } else {
      header("location: index.php");
}

?>
