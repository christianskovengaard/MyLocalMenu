<?php

echo "<h1>Import cafe</h1>";

//Connect to database
require_once '../Controllers/DatabaseController.php';
$oDatabase = new DatabaseController();
$conPDO =  $oDatabase->ConnectToDatabase();


//Read from the csv file
$file = fopen("cafenavne1.csv","r");

$x = 1;

$aCafe = array(
  'name' => '',
  'address' => '',
  'city' => '',
  'phonenumber' => '',
  'webpage' => ''
  
);

while(! feof($file)) {
    //Print array
    //var_dump(fgetcsv($file));
    
    $result = fgetcsv($file);
    //Insert value into cafe array
    if($x == 1){
        $aCafe['name'] = utf8_decode($result[0]);
        //var_dump($aCafe);
    }
    if($x == 2){
        
        $aCafe['phonenumber'] = $result[0];
        //var_dump($aCafe);
    }
    if($x == 3){
        $aCafe['address'] = utf8_decode($result[0]);
        //var_dump($aCafe);
    }
    if($x == 4){
        
        $aCafe['city'] = intval($result[0]);
        //var_dump($aCafe);
    }
    if($x == 5){
        $aCafe['webpage'] = $result[0];
        //Reset $x
        $x = 0;      
        var_dump($aCafe);
        echo "<br>5. gang Insert to database";
        
        //Insert data into database
        $sQuery = $conPDO->prepare("INSERT INTO restuarentinfo_copy (sRestuarentInfoName,sRestuarentInfoPhone,sRestuarentInfoAddress,iRestuarentInfoZipcode) VALUES (:name,:telephone,:address,:zipcode)");
        $sQuery->bindValue(":name", $aCafe['name']);
        $sQuery->bindValue(":telephone", $aCafe['phonenumber']);
        $sQuery->bindValue(":address", $aCafe['address']);
        $sQuery->bindValue(":zipcode", $aCafe['city']);
        $sQuery->execute();
        
    }
    
    $x++;
}

fclose($file);









