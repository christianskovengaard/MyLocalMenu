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
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0" />
        <title>MyLocalCafé - Admin</title>
        <link rel="icon" href="img/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="css/general_admin.css" />
<!--        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 700px)" href="css/general_admin_small.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:701px) and (max-width: 1170px)" href="css/general_admin_medium.css" />-->
        
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 461px)" href="css/general_admin_small.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:462px) and (max-width: 790px)" href="css/general_admin_medium.css" />
        <link rel="stylesheet" type='text/css' href="css/jquery-ui-1.8.16.custom.css"/>        
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>       
        <div class="RestaurantInfo">     
        </div>
        
        <div class="TabMenu">
            <div id="TabsMenu" class="Tab On" onclick="TapChange('sMenu');">Menu</div>
            <div id="TabsMessenger" class="Tab" onclick="TapChange('sMessenger');">Beskeder</div>
            <div id="TabsGallery" class="Tab" onclick="TapChange('sGallery');">Billeder</div>
            <div id="TabsStamp" class="Tab" onclick="TapChange('sStamp');">Stempelkort</div>
            <div id="TabsEdit" class="Tab" onclick="TapChange('sEdit');">Indstillinger</div>
        </div>
        
        <div id="TabWrappersMenu" class="menuWrapper">
            <div class="wrapper">
                <div class="menuWrapperInner" id="wrapper">
                    <div class="sortablediv" id='restuarantInfo'>                       
                    </div>
                    
                    <div onclick="CreateNewSortableList();" class="newsortablediv"><h3>Tilføj ny kategori</h3><div>+</div></div>
                    <div class="newsortabledivbuffer"></div>     
                </div>
                
            </div> 
        </div>
        
        <!-- Messages -->
        <div id="TabWrappersMessenger" class="menuWrapper" style="display: none;" >
            <div class="wrapper">


                <div id="upload">
                    <div id="toggleImageButton">
                        Vis/Skjul billedebibliotek
                    </div>
                    <div id="upload_inner" onscroll="this.scrollLeft = 0">
                        <div id="drop_image_here">
                            Slip billede her
                        </div>
                        <div id="find_billede">
                            <p class="upload_eller">Eller</p>
                            <div id="upload_feild">
                                <p id="uploadFile">Fil(er) ej valgt, klik for at vælg fil</p>
                                <input id="uploadBtn" type="file" accept="image/*" multiple />

                            </div>
                            <input id="amlUploadBtn" type="button"  onclick="uploadFraKnap()" value="Upload">
                        </div>
                        <div id="upload_in_progress">

                        </div>
                        <div id="mine_uploaded_billeder">
                            <p class="uploadarea">Mit billede biblotek</p>
                            <div id="mit_billede_biblotek"></div>
                        </div>
                    </div>

                </div>


                <div class="menuWrapperInner uploadWrappers" id="beskedWrapper">
                    <div class="MessageText">Her kan du skrive beskeder ud til dine kunder, i forbindelse med tilbud, events m.m.</div>


                    <div class="MessageImage" id="MessageImage" data-urlid="">
                        <p id="MessageImageBC">Slip billede her</p>
                        <p id="MessageImageBC2">Eller klik for at vælge fra biblottek</p>
                        <p id="MessageImageRemove">FJERN</p>
                        <div id="findImage">
                            <div id="findImageInner">

                                <div id="findImageTopBar">
                                    <p>Vælg billede fra biblotek</p>
                                    <button id="lukFindImage">LUK</button>
                                </div>
                                <div id="findImages">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="Messagepreview">
                    <textarea id="sMessageHeadline" type="text" value="" placeholder="Overskrift"></textarea>
                    <textarea id="sMessengerTextarea" placeholder="Skriv en ny besked"></textarea>
                    </div>
                    <p>Beskeden skal være aktiv</p>
                    <br>
                    <p>fra</p>
                    <input type='text' id='dMessageStart' class="datepicker" placeholder="">
                    <p>til</p>
                    <input type='text' id='dMessageEnd' class="datepicker" placeholder="">
                    <br>
                    <div class="button" onclick="SaveMessage();">Send</div>
                    <br><br>
                    <h2>Sidst sendte besked:</h2>
                    <div id="currentMessages" class="oldMessenge"></div>
                    <h2>Gamle beskeder:</h2>
                    <div id="oldMessages" class="oldMessenge"></div>

                </div>
                <div class="galleryWrapperInner" id="galleriWrapper">
                    <div id="galleryImages">


                    </div>



                    <div id="addImageToGallery" class="galleryImageItem">
                        <p>Tryk eller slip for at tilføje billeder</p>
                    </div>


                    <div id="findImage2">
                        <div id="findImageInner2">

                            <div id="findImageTopBar2">
                                <p>Vælg billede fra biblotek</p>
                                <button id="lukFindImage2">LUK</button>
                            </div>
                            <div id="findImages2">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div id="imageEidter" onclick="lukMaaskeImageEidter(event)">
            <div id="imageEidterInner">
                <div id="imageArea">
                    <div id="imageAreaImageOuter">
                        <img id="imageSrc" src=""/>
                    </div>

                    <div id="custum_crop_resizer" style="display: none" draggable="true"></div>
                    <div id="custum_crop_resizer_hivimig" style="display: none" draggable="true">
                        <div id="custum_crop_resizer_hivimig_inner">

                        </div>
                    </div>

                </div>
                <div id="toolLine">
                    <div class="toolL" id="imageEidterAmlToolBar">
                        <span onclick="editImageSetupCrop()" id="imageEidterCropButton">
                            BESKÆR
                        </span>
                        <span onclick="editImageSortHvid()">
                            SORT/HVID
                        </span>
                        <span onclick="editImageRotate('Hojre')" class="ImageControllCanBeDisabled">
                            FLIP HØJRE
                        </span>
                        <span onclick="editImageRotate('Halv')">
                            FLIP HALV OMGANG
                        </span>
                        <span onclick="editImageRotate('Venstre')"  class="ImageControllCanBeDisabled">
                            FLIP VENSTRE
                        </span>
                    </div>
                    <div class="toolL" id="imageEidterCropToolBar">
                        <span onclick="editImageCancelCrop()">
                            ANNULLER BESKÆRING
                        </span>
                        <span onclick="editImageSaveCrop()">
                            GEM BESKÆRING
                        </span>
                        <div id="toSmallToFlipOpOnSide" title="Det vil ikke være mulig at lippe billedet op på siden hvis du gemmer denne ændring da billedet vill bliver for småt">
                            <span class="disable">
                                FLIP HØJRE
                            </span>

                            <span class="disable">
                                FLIP VENSTRE
                            </span>
                        </div>
                    </div>
                    <div id="toolR">
                        <span onclick="editImageSaveImage()" id="imageEidterSave" class="button disable">
                            GEM OG LUK
                        </span>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

        </div>


        <!-- end Messages -->
        
        <!-- Stampcard and QRcode -->
        <div id="TabWrappersStamp" class="menuWrapper" style="display: none;">
            <div class="wrapper">
                <div class="menuWrapperInner" id="wrapper">
                    <!-- <p>Sådan ser dit stemplkort ud:</p><br>                    -->
                    <div class='StampEX' id='StampEX'>
                        <!-- <div class="stampCircle"></div> -->
                    </div>
                    <div class='StampWrapper'>
                        <p>Antal stempler på stempelkortet:</p>
                        <input value="" placeholder="" id="iMaxStamps" maxlength="2">
                        <div class='button StampButton' onclick="SaveStampcard();">Gem</div>
                        <br><br>
                        <div id="sStampcardTextExample">Stempelkort tekst...</div><br>
                        <input type="text" placeholder="Stempelkort tekst" id="sStampcardText" style="width: 100%;"/>
                        <br><br>
                        <div class="button StampButton" onclick="UpdateStampcardText();">Opdater stempelkort tekst</div><br>
                        <p>Stempelkort kode: </p><p id="RedemeCode"></p><br>
                        <input type="text" id="RedemeCode1" maxlength="1">
                        <input type="text" id="RedemeCode2" maxlength="1">
                        <input type="text" id="RedemeCode3" maxlength="1">
                        <input type="text" id="RedemeCode4" maxlength="1"><br><br>
                        <div class="button StampButton" onclick="UpdateRedemeCode();">Sæt stempelkort kode</div>
                        <!-- <div class='StampStat'> -->
                            <!-- <h3>Stempler uddelt i år</h3> -->
                            <!--Div that will hold the pie chart-->
                            <!-- <div id="chart_div"></div> -->
                        <!-- </div> -->
   
                        <!--<h3>QR kode</h3>
                        <div>
                            <div class='button StampButton' onclick="PrintQRcode();">Print din QR kode</div>
                            <div class='button StampButton'onclick='GenerateQRcode();'>Lav en ny QR kode</div>
                            <div id="currentQRcode"></div>
                        </div>-->
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
                        <input id="MenuName" type="text" value="" placeholder="Café navn"> <br/>
                        <p>evt Slogan</p>
                        <input id="MenuSubName" type="text" value="" placeholder="slogan"> <br/>
                        <p>Vejnavn og nummer</p>
                        <input id="MenuAdress" type="text" value="" placeholder="Adresse"> <br/>
                        <p>Postnr. og by</p>
                        <input id="MenuZip" type="text" value="" placeholder="Post nr." maxlength="4">
                        <input id="MenuTown" type="text" value=""> <br/>
                        <p>Caféns telefonnr.</p>
                        <input id="MenuPhone" type="text" value="" placeholder="Telefonnummer" maxlength="11">
                        
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
                    <p>Ny adgangskode</p>
                    <input type='password' id='NewPassword' placeholder="Adgangskode">
                    <p>Gentag ny adgangskode</p>
                    <input type="password" id='NewPasswordRepeat' placeholder="Gentag adgangskode"><br>
                    <input type="button" class="button" onclick="SubmitFormNewPasswordNoToken();" value="Skift adgangskode">
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
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script> <!-- migrate plugin for old jQuery-->
    <script type="text/javascript" src="js/jquery-da-calendar.js"></script> <!-- danish jQuery calendar-->
    <script type="text/javascript" src="js/general.js"></script>
    <script type="text/javascript" src="js/mustache.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.autogrow.js"></script>
    <script type="text/javascript" src="js/jsencrypt.js"></script>
    <!--Load the Google chart API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            GetMenucard(true);
            makeOpeningHours();
            GetMessages();
            GetStampcard();
            GetUserinformation();
            $('.datepicker').datepicker();
            AutomaticUpdateMenucard();
            InitiateAutocomplete();
            InitFileManeger();
            InitGallery();
            
            //TODO: Changed this Quick fix
            //Set menucard in edit mode 
            setTimeout(function(){ HideShowSwitch('HideSortableEdits');},1000);
            
        });
        // Load the Google Visualization API and the piechart package.
        google.load('visualization', '1.0', {'packages':['corechart']});
    </script>    
    </body>
</html>
<?php  } else {
    header("location: login-page");
    //$asd = $oSecurityController->login_check();
    /*var_dump($asd);
    echo $_SESSION['user_id'] .'<br>'; 
    echo $_SESSION['username'] .'<br>';
    echo $_SESSION['login_string'] .'<br>';*/
}

?>