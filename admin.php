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
                [Spisested info]
                <div class="buttonEdit" onclick="HideShowSwitch('EditRestaurantInfo');">Rediger</div>
            </div>            
        </div>
        
        <div class="menuWrapper">
            <div class="wrapper">
                <div class="menuWrapperInner" id="wrapper">
                    <div style="margin-top: 10px;">
                        <input type="button" value="Lav ny liste" onclick="CreateNewSortableList();">
                        <input type="button" value="Gem lister" onclick="SaveSortableLists();">
                    </div>
                    <div class="sortablediv">
                        <h3>Liste 1</h3>
                        <ul id="sortable1" class="connectedSortable">
                          <li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Item 1</li>
                          <li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Item 2</li>
                          <li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Item 3</li>
                          <li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Item 4</li>
                          <li onclick="DeleteLiSortable(this);" class="sortableLi ui-state-default">Item 5</li>
                          <li onclick="CreateNewLiInSortableList('sortable1')" class="AddLiButton ui-state-default non-dragable">Tilføj nyt li</li>
                        </ul>
                    </div> 
                </div>
            </div> 
        </div>
        
        <div id="EditRestaurantInfo" class="EditRestaurantInfo">
            <div class="EditRestaurantInfoWrapper">
                [Rediger Restaurant Info]
                <div class="buttonEdit" onclick="HideShowSwitch('EditRestaurantInfo');">[X]</div>
                <br>[Navn]
                <br>[Adresse]
                <br>[Telefonnummer]
                <br>[åbningstider]
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
