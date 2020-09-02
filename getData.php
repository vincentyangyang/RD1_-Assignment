<?php

$db = new PDO("mysql:host=127.0.0.1;dbname=meteorological", "root", "root");
$db->exec("SET CHARACTER SET utf8");

$twoDay = file_get_contents("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-BE1D27BE-4C21-406E-A26B-AA5B70F2D141&elementName=WeatherDescription");
$twoDay = json_decode($twoDay,true);
$nowWeathers = $twoDay['records']['locations']['0']['location'];


$sth = $db->prepare("select city,now from weather");
$sth->execute();
$rows = $sth->fetchAll();

$i = 0;

//抓當前天氣放到weather
foreach($nowWeathers as $nowWeather){
    $now = $nowWeather['weatherElement']['0']['time']['0']['elementValue']['0']['value'];

    $sth = $db->prepare("update weather set now = :now where city = :city");
    $sth->bindParam("now", $now, PDO::PARAM_STR,1000); 
    $sth->bindParam("city", $rows[$i]['city'], PDO::PARAM_STR,50); 
    $sth->execute();

    $i++;
}



//抓未來兩天放到twoDay
$k = 0;

$sth = $db->prepare("select * from twoDay");
$sth->execute();
$data = $sth->fetchAll();

$startTime = $nowWeathers["0"]['weatherElement']['0']['time']['0']['endTime'];
$startTimeArray = preg_split("/[\s]+/",$startTime);
$startTimeArray = preg_split("/:/",$startTimeArray[1]);
$index = ( (24 - $startTimeArray[0]) / 3 ) +1;

if (empty($data)){ 

    foreach($nowWeathers as $nowWeather){
        $twoDayArray = array();

        for ($j=$index; $j<($index+16); $j++){
            
            $twoDay = $nowWeather['weatherElement']['0']['time'][$j]['elementValue']['0']['value'];
            array_push($twoDayArray,$twoDay);
        }

        $sth = $db->prepare("insert into twoDay(city,one,two,three,four,five,six,seven,eight,nine,ten,eleven,twelve,thirteen,fourteen,fifteen,sixteen) values(:city,:one,:two,:three,:four,:five,:six,:seven,:eight,:nine,:ten,:eleven,:twelve,:thirteen,:fourteen,:fifteen,:sixteen)");
        excute($sth,$rows[$k]['city'],$twoDayArray);

        $k++;
    }
}else{ 

    foreach($nowWeathers as $nowWeather){
        $twoDayArray = array();

        for ($j=$index; $j<$index+16; $j++){
            $twoDay = $nowWeather['weatherElement']['0']['time'][$j]['elementValue']['0']['value'];
            array_push($twoDayArray,$twoDay);
        }

        $sth = $db->prepare("update twoDay set one=:one,two=:two,three=:three,four=:four,five=:five,six=:six,seven=:seven,eight=:eight,nine=:nine,ten=:ten,eleven=:eleven,twelve=:twelve,thirteen=:thirteen,fourteen=:fourteen,fifteen=:fifteen,sixteen=:sixteen where city = :city");
        excute($sth,$rows[$k]['city'],$twoDayArray);

        $k++;
    }
}



function excute($sth,$city,$twoDayArray){ 
        $sth->bindParam("city", $city, PDO::PARAM_STR,100); 
        $sth->bindParam("one", $twoDayArray[0], PDO::PARAM_STR,1000); 
        $sth->bindParam("two", $twoDayArray[1], PDO::PARAM_STR,1000); 
        $sth->bindParam("three", $twoDayArray[2], PDO::PARAM_STR,1000); 
        $sth->bindParam("four", $twoDayArray[3], PDO::PARAM_STR,1000); 
        $sth->bindParam("five", $twoDayArray[4], PDO::PARAM_STR,1000); 
        $sth->bindParam("six", $twoDayArray[5], PDO::PARAM_STR,1000); 
        $sth->bindParam("seven", $twoDayArray[6], PDO::PARAM_STR,1000); 
        $sth->bindParam("eight", $twoDayArray[7], PDO::PARAM_STR,1000); 
        $sth->bindParam("nine", $twoDayArray[8], PDO::PARAM_STR,1000); 
        $sth->bindParam("ten", $twoDayArray[9], PDO::PARAM_STR,1000); 
        $sth->bindParam("eleven", $twoDayArray[10], PDO::PARAM_STR,1000); 
        $sth->bindParam("twelve", $twoDayArray[11], PDO::PARAM_STR,1000); 
        $sth->bindParam("thirteen", $twoDayArray[12], PDO::PARAM_STR,1000); 
        $sth->bindParam("fourteen", $twoDayArray[13], PDO::PARAM_STR,1000); 
        $sth->bindParam("fifteen", $twoDayArray[14], PDO::PARAM_STR,1000); 
        $sth->bindParam("sixteen", $twoDayArray[15], PDO::PARAM_STR,1000); 
    
        $sth->execute();
        
}


$db = null;

?>