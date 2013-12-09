<?php
//Check if user is logged in
//require 'Controllers/SecurityController.php';
//$oSecurityController = new SecurityController();
//$oSecurityController->sec_session_start(); // Our custom secure way of starting a php session.
//if($oSecurityController->login_check() == true) { ?>
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
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.autogrow.js"></script>
        
    
    </head>
    <body>
        <?php
        // put your code here
        ?>
        
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
            <div class="wrapper">
                <div class="Restaurant Name">
                    <h1>King of chicken</h1>
                    <h2>Rottiserie og Take away</h2>            
                </div>
                <div class="Restaurant info">
                    <div class="RestaurantPhone"><img src="img/phone.png"><h2>33 23 21 40</h2></div>
                    <div class="RestaurantAdresse"><img src="img/ic_pin.png"><h4>Oehlenslægersgade 50<br>1663 Vesterbro</h4></div>
                </div>        
                <div class="Restaurant OpeningHours"><h4><b>Åbningstider:</b></h4><h4>I dag: 11:00 - 22.00</h4><h5 class="open">åben</h5></div>
                <div class="Restaurant Delivery"><h4><b>Udbringning:</b></h4><h4>I dag: 16:00 - 21:00</h4><h5 class="closed">ikke mulig</h5></div>
                <div class="buttonEdit top" onclick="HideShowSwitch('PopUpWindowEditManuInfo');"><img src="img/edit.png">Resturent info</div>
                <div id="EditMenuButton"><div class="buttonEdit" onclick="HideShowSwitch('HideSortableEdits');"><img src="img/edit.png">Menukort</div></div>

             </div>          
        </div>
        
        <div class="menuWrapper">
            <div class="wrapper">
                <div class="menuWrapperInner" id="wrapper">
                    <div>                        
<!--                        <input type="button" value="Gem lister" onclick="SaveSortableLists();"/>-->
                        <!--<div class="buttonEdit" onclick="HideShowSwitch('HideSortableEdits','0');"><img src="img/edit.png">Rediger Menukort</div>-->
                    </div>
                    <div class="sortablediv" id='restuarantInfo'>
                        <h3>Info</h3>
                        <div class="InfoSlide top">
                            <div class="InfoSlidebox">
                                <h3>Åbningstider</h3>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                            </div>
                            <div class="InfoSlidebox">
                                <h3>Udbrigning</h3>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                                <h4>man: 09:00-18:00</h4>
                            </div>
                            <div class="InfoSlidebox">
                                <h3>Smileys</h3>
                            </div>
                        </div>
                        <div Class="InfoSlide"><h1>Vi laver firmaaftaler og mad til receptioner</h1><h2>Spydstegte franske kyllinger i ægte rotisserie-over, salatbar, sandwich, bagte kartofter, bigger fries, flødekartofler, biggerfries, flødekartofler, ovnbagte kartofler i kyllingefond, aioli, coleslaw, tzatziki, hjemmelavede saucer, marinader, dressinger</h2>
                            <div class="DishEditWrapper">
                                <div class="EditDish" onclick="EditInfo(this)"><img src="img/edit.png"></div>
                                <div class="DeleteDish" onclick="DeleteSortableList(this)"><p>╳</p></div>
                            </div>
                        </div>
                            
                        <div Class="InfoSlide"><h1>Take-away røtisserie</h1><h2>Vi får leveret friske franske kyllinger. Disse bliver marineret i hjemmelavet lage og langtidsstegte i røstisserie-ovne, hvor hovedparten af fedtet steges væk. Der er altså tale om et produkt, som er lækkert og med saftig smag. Vi er leveringdygtige til enhver lejlighed, bl.a. firmaordninger, receptioner og catering. Står De og mangler gode forslag til Deres fest, så kom ind og lad os lave et godt tilbud til Dem.</h2>
                            <div class="DishEditWrapper">
                                <div class="EditDish" onclick="EditInfo(this)"><img src="img/edit.png"></div><div class="DeleteDish" onclick="DeleteSortableList(this)"><p>╳</p></div>
                            </div>
                        </div>
                        <div Class="AddLiButton info" onclick="CreateNewDivresturanatInfo()"><h5>+</h5></div>
                    </div>
                    <div class="sortablediv sortableList">
                        <h3>Liste 1</h3>
                        <h4>Beskrivelse</h4>
                        <div class="DishEditWrapper">
                            <div class="moveDish"><img src="img/moveIcon.png"></div>
                            <div class="EditDish" onclick="EditListHeadline(this)"><img src="img/edit.png"></div>
                            <div class="DeleteDish" onclick="DeleteSortableList(this)"><p>╳</p></div>
                        </div>
                        <ul id="sortable1" class="connectedSortable">                        
                            
                            <li class="sortableLi"> 
                                <div class="DishWrapper">    
                                    <div class="DishNumber"><h1>1</h1></div>
                                    <div class="DishText">
                                        <div class="DishHeadline"><h1>Pizza Hawaii</h1></div>
                                        <div class="DishDescription"><h2>Tomat, ost, ananas & skinke</h2></div>
                                    </div>
                                    <div class="DishPrice"><h2>...</h2><h2>65</h2><h2>kr</h2></div>     
                                    
                                    <div class="DishEditWrapper">
                                        <div class="moveDish"><img src="img/moveIcon.png"></div>
                                        <div class="EditDish" onclick="EditSortableList(this)"><img src="img/edit.png"></div>
                                        <div class="DeleteDish" onclick="DeleteLiSortable(this);"><p>╳</p></div>
                                    </div>                                    
                                </div>
                            </li>                             
                            
                            <li class="sortableLi">
                               <div class="DishWrapper">
                                    <div class="DishNumber"><h1>2</h1></div>
                                    <div class="DishText">
                                        <div class="DishHeadline"><h1>Pizza Meatlover</h1></div>
                                        <div class="DishDescription"><h2>Tomat, ost, peproni, bacon, pølse, ris, tun, gryderet, smør & skinke</h2></div>
                                    </div>
                                    <div class="DishPrice"><h2>...</h2><h2>105</h2><h2>kr</h2></div>
                                    
                                    <div class="DishEditWrapper">
                                        <div class="moveDish"><img src="img/moveIcon.png"></div>
                                        <div class="EditDish" onclick="EditSortableList(this)"><img src="img/edit.png"></div>
                                        <div class="DeleteDish" onclick="DeleteLiSortable(this);"><p>╳</p></div>
                                    </div> 
                                </div>
                            </li>                            
                          <li onclick="CreateNewLiInSortableList('sortable1')" class="AddLiButton non-dragable">
                             <h5>+</h5>
                          </li>
                        </ul>
                    </div>
                    <div onclick="CreateNewSortableList();" class="newsortablediv"><h3>+</h3></div>
                    <div class="newsortabledivbuffer"></div>     
                </div>
                
            </div> 
        </div>
        
        
                <!--        POPUP WINDOWS        -->
        
        <div id="EditRestaurantInfo" class="EditRestaurantInfo">
            <div class="EditRestaurantInfoWrapper">
                <h3>Ret oplysninger</h3>
                <div>
                    <div class="buttonEdit" onclick="HideShowSwitch('PopUpWindowEditManuInfo');">[X]</div>
                    <p>Menukorts navn</p>
                    <input id="MenuName" type="text" value="">
                    <p>evt Slogan</p>
                    <input id="MenuSubName" type="text" value="">
                    <p>Vejnavn og nummer</p>
                    <input id="MenuAdress" type="text" value="">
                    <p>Postnr. og by</p>
                    <input id="MenuZip" type="text" value="">
                    <input id="MenuTown" type="text" value="">
                    <p>Telefonnr.</p>
                    <input id="MenuPhone" type="text" value="">
                </div>
                <div>
                    <p>Åbningstider</p>
                    <p>Udbringning</p>     
                </div>
            </div>             
        </div>
        
    <script>
        $(document).ready(function() {
            //Function to initiate all sortable lists 
            UpdateSortableLists(); 
            
        });  
    </script>
        
    </body>
</html>
<?php // } else {
//   echo 'You are not authorized to access this page, please login. <br/>';
//   echo "Login <a href='fakeLogin.php'>here</a> with username: admin and password: admin";
//}

?>
