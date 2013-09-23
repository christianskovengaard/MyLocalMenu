<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimun-scale=1.0, initial-scale=1.0" />
        <title>My Local Menu</title>
        <link rel="stylesheet" type="text/css" href="css/general_admin.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 500px)" href="css/general_admin_small.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width: 850px)" href="css/general_admin_medium.css" />
                
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/general.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        
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
                    <div class="RestaurantPhone"><h2>☎ 33 23 21 40</h2></div>
                    <div class="RestaurantAdresse"><h4>Oehlenslægersgade 50, 1663 Vesterbro</h4></div>
                </div>        
                <div class="Restaurant OpeningHours"><h4>Åbningstider:</h4><h4>Man-Fre: 11:00 - 22.00</h4><h4>Lør-Søn: 11:00 - 22.00</h4></div>
                <div class="Restaurant Delivery"><h4>Udbringning: kl 16:00 - 21:00</h4><h4>Vesterbro - Enghave 35,- kr</h4><h4>Sydhavnen - Frederiksberg 45,- kr</h4></div>
                <div class="buttonEdit" onclick="HideShowSwitch('PopUpWindow','EditRestaurantInfo');">Rediger</div>
             </div>          
        </div>
        
        <div class="menuWrapper">
            <div class="wrapper">
                <div class="menuWrapperInner" id="wrapper">
                    <div>                        
                        <input type="button" value="Gem lister" onclick="SaveSortableLists();">
                        <div class="buttonEdit" onclick="HideShowSwitch('HideSortableEdits','0');">Rediger</div>
                    </div>
                    <div class="sortablediv">
                        <h3>King of chicken</h3>
                        <div Class="InfoSlide"><h1>Vi laver firmaaftaler og mad til receptioner</h1><h2>Spydstegte franske kyllinger i ægte rotisserie-over, salatbar, sandwich, bagte kartofter, bigger fries, flødekartofler, biggerfries, flødekartofler, ovnbagte kartofler i kyllingefond, aioli, coleslaw, tzatziki, hjemmelavede saucer, marinader, dressinger</h2></div>
                        <div Class="InfoSlide"><h1>Take-away røtisserie</h1><h2>Vi får leveret friske franske kyllinger. Disse bliver marineret i hjemmelavet lage og langtidsstegte i røstisserie-ovne, hvor hovedparten af fedtet steges væk. Der er altså tale om et produkt, som er lækkert og med saftig smag. Vi er leveringdygtige til enhver lejlighed, bl.a. firmaordninger, receptioner og catering. Står De og mangler gode forslag til Deres fest, så kom ind og lad os lave et godt tilbud til Dem.</h2></div>
                    </div>
                    <div class="sortablediv">
                        <h3>Liste 1</h3>
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
                                        <div class="moveDish" onclick="DeleteLiSortable(this);"><img src="img/moveIcon.png"></div>
                                        <div class="DeleteDish" onclick="DeleteLiSortable(this);"><p>╳</p></div>
                                    </div>                                    
                                </div>
                            </li>                             
                            
                            <li onclick="DeleteLiSortable(this);" class="sortableLi">
                               <div class="DishWrapper">
                                    <div class="DishNumber"><h1>2</h1></div>
                                    <div class="DishText">
                                        <div class="DishHeadline"><h1>Pizza Meatlover</h1></div>
                                        <div class="DishDescription"><h2>Tomat, ost, peproni, bacon, pølse, ris, tun, gryderet, smør & skinke</h2></div>
                                    </div>
                                    <div class="DishPrice"><h2>...</h2><h2>105</h2><h2>kr</h2></div>
                                    
                                    <div class="DishEditWrapper">
                                        <div class="moveDish" onclick="DeleteLiSortable(this);"><img src="img/moveIcon.png"></div>
                                        <div class="DeleteDish" onclick="DeleteLiSortable(this);"><p>╳</p></div>
                                    </div> 
                                </div>
                            </li>                            
                          <li onclick="CreateNewLiInSortableList('sortable1')" class="AddLiButton non-dragable">
                             +
                          </li>
                        </ul>
                    </div>
                    <div onclick="CreateNewSortableList();" class="newsortablediv"><h3>+</h3></div>
                </div>
                
            </div> 
        </div>
        
        
                <!--        POPUP WINDOWS        -->
        
        <div id="EditRestaurantInfo" class="EditRestaurantInfo">
            <div class="EditRestaurantInfoWrapper">
                [Rediger Restaurant Info]
                <div class="buttonEdit" onclick="HideShowSwitch('PopUpWindow','EditRestaurantInfo');">[X]</div>
                <br>[Navn]
                <br>[evt Slogan]
                <br>[Adresse x 2]
                <br>[Telefonnummer]
                <br>[åbningstider]
                <br>[Udbringning]
                <br>[Info]
                <br>[modtager kort]
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
