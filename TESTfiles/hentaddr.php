<?php
/**
 * Created by PhpStorm.
 * User: Bejamco
 * Date: 22-01-2015
 * Time: 17:18
 */

set_time_limit(0);

?>

    <pre>

<?php

function getCoordinates($address)
{


    $address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern

    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";

    $response = file_get_contents($url);

    $json = json_decode($response, TRUE); //generate array object from the response from the web

    print_r($json);
    print_r($address);

    return array(
        "lat" => $json['results'][0]['geometry']['location']['lat'],
        "lng" => $json['results'][0]['geometry']['location']['lng']
    );

}



$con = mysqli_connect("localhost","root","root","mylocalmenu");



$sel = mysqli_query($con,"SELECT * FROM `restuarentinfo`");

while ($row = mysqli_fetch_array($sel)) {

    $data = getCoordinates($row["sRestuarentInfoAddress"] . ", ".$row['iRestuarentInfoZipcode']." danmark");




    mysqli_query($con,"UPDATE restuarentinfo SET sRestuarentInfoLat='".$data['lat']."', sRestuarentInfoLng='".$data['lng']."' WHERE iRestuarentInfoId = ".$row["iRestuarentInfoId"],$s);



    sleep(2);
}
