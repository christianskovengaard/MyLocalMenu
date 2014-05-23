<?php

echo "<h1>Import cafe</h1>";

//Connect to database
require_once '../Controllers/DatabaseController.php';
$oDatabase = new DatabaseController();
$conPDO =  $oDatabase->ConnectToDatabase();


//Read from the csv file
$file = fopen("Cafénavne_Frederiksberg.csv","r");
while($result = fgetcsv($file, 'EOF', ";")) {
    $i++;
    if($i >= 4) {
        var_dump($result);
               
        //Import format:
        //[0] = name
        //[1] = tlf
        //[2] = address
        //[3] = zipcode & city
        //[4] = webpage
        
        //Insert data into database
        $sQuery = $conPDO->prepare("INSERT INTO restuarentname_search (sRestuarentInfoName,sRestuarentInfoPhone,sRestuarentInfoAddress,iRestuarentInfoZipcode) VALUES (:name,:telephone,:address,:zipcode)");
        $sQuery->bindValue(":name", $result[0]);
        $sQuery->bindValue(":telephone", $result[1]);
        $sQuery->bindValue(":address", $result[2]);
        $sQuery->bindValue(":zipcode", intval($result[3]));
        //$sQuery->execute();
    }
}
fclose($file);









