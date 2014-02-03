<?php


class TimeController 
{  
    
    public function __construct() 
    {
        //Connect to database
        require 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();
       
    }
    
    public function GetOpeningHours()
    {
        $aOpeningHours = array(
                'sFunction' => 'GetOpeningHours',
                'result' => false
            );
        
        $sQuery = $this->conPDO->prepare("SELECT * FROM time");
        $sQuery->execute(); 
        
        $i = 0;
        
        while ($aResult = $sQuery->fetch(PDO::FETCH_ASSOC)) 
        {
            $aOpeningHours['Hours'][$i]['iTimeId'] = $aResult['iTimeId'];
            $aOpeningHours['Hours'][$i]['iTime'] = substr($aResult['iTime'],0, -3);
            $i++;
        }
        
        $aOpeningHours['result'] = true;
        //var_dump($aOpeningHours);
        return $aOpeningHours;
        
     }

}

?>
