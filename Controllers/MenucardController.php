<?php

class MenucardController
{
    public function __construct() {
        ;
    }
    
    public function SaveMenucard ()
    {
        if(isset($_GET['sJSONMenucard']))
        {
            $sJSONMenucard = $_GET['sJSONMenucard'];
            echo '<pre>';
                print_r(json_decode($sJSONMenucard));
            echo '</pre>';
            //TODO: Get all the data and save it in the database
        }
        return true;
    }
}
?>
