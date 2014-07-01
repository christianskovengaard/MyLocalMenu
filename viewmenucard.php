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
        <script type="text/javascript" src="js/mustache.js"></script>
    </head>
    <body>
        <div class="header">
            <div class="wrapper">               
                <div onclick="PageChange('index');" class="logoWrapper">  
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
        
        <div class="menuWrapper">
            <div class="wrapper">
                <div class="menuWrapperInner" id="wrapper">                  
                    <div class="sortablediv" id='restuarantInfo'>                       
                    </div>                    
                    <div class="newsortabledivbuffer"></div>     
                </div>              
            </div> 
        </div>
        <div id="mustache_template">           
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                GetMenucard(false);
            });
        </script>
    </body>
</html>
