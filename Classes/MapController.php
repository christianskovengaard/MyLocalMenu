<?php

/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 17-01-2015
 * Time: 21:52
 */
class MapController
{
    static public function UpdateJSON(pdo $con)
    {

        $output = array();
        $id = 0;


        $sQuery = $con->prepare("SELECT sRestuarentInfoName, sRestuarentInfoAddress, sRestuarentInfoLat, sRestuarentInfoLng FROM restuarentinfo WHERE iRestuarentInfoActive = 1 AND sRestuarentInfoLng != '0.0'");
        $sQuery->execute();


        //Count number of results
        while ($result = $sQuery->fetch(PDO::FETCH_ASSOC)) {
            $output[]=array(
                "id"=>$id,
                "navn"=>utf8_encode($result['sRestuarentInfoName']),
                "addr"=>utf8_encode($result['sRestuarentInfoAddress']),
                "lat"=>utf8_encode($result['sRestuarentInfoLat']),
                "lng"=>utf8_encode($result['sRestuarentInfoLng'])
            );
            $id++;
        }

        file_put_contents(__DIR__ . "/../API/map_data.json", json_encode($output));


    }
}