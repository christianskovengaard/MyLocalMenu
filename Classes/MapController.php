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


        $sQuery = $con->prepare("SELECT sRestuarentInfoName, sRestuarentInfoAddress, sRestuarentInfoLat, sRestuarentInfoLng FROM restuarentinfo WHERE iRestuarentInfoActive = 1 AND sRestuarentInfoLng != ''");
        $sQuery->execute();


        //Count number of results
        while ($result = $sQuery->fetch(PDO::FETCH_ASSOC)) {
            $output[]=array(
                utf8_encode($result['sRestuarentInfoName']),
                utf8_encode($result['sRestuarentInfoAddress']),
                utf8_encode($result['sRestuarentInfoLat']),
                utf8_encode($result['sRestuarentInfoLng'])
            );
        }

        file_put_contents(__DIR__ . "/../API/map_data.json", json_encode($output));


    }
}