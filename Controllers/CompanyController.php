<?php

class CompanyController 
{
    public function __construct() {
        
       define('ROOT_DIRECTORY', realpath(dirname(__FILE__).'/..'));
       require_once(ROOT_DIRECTORY . '/Classes/CompanyClass.php');
    }
    
    
}
?>
