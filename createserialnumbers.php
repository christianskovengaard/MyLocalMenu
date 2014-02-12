<?php

    //Create serialnumber format AA0000 (2 letter and 4 numbers)
        
        
    //Create the first 9999 numbers with only the AA



    require_once 'Controllers/DatabaseController.php';
    $oDatabase = new DatabaseController();
    $conPDO = $oDatabase->ConnectToDatabase();
        

      for($i = 0; $i <= 9999; $i++)
      {

          $paddedNum = sprintf("%04d", $i); //http://stackoverflow.com/questions/6457937/how-do-i-use-4-digit-numbers
          //$paddedNum = str_pad($i, 4, '0', STR_PAD_LEFT);
          $sQuery = $conPDO->prepare("INSERT INTO serialnumbers (sSerialnumber) VALUES (:serialnumber)");
          $sQuery->bindValue(":serialnumber", 'AA'.$paddedNum);
          $sQuery->execute();
      }
    

    
?>
