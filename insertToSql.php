<?php

// exec("/usr/local/bin/python3 getWeek.py");
pclose(popen('/usr/local/bin/python3 getWeek.py', 'r'));

header("content-type:text/html; charset=utf-8");

$db = new PDO("mysql:host=127.0.0.1;dbname=meteorological", "root", "root");
$db->exec("SET CHARACTER SET utf8");

$contents = file_get_contents("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-BE1D27BE-4C21-406E-A26B-AA5B70F2D141");

$contents = json_decode($contents,true);

$citys = $contents['records']['locations']['0']['location'];

$sth = $db->prepare("select * from weather");
$sth->execute();
$row = $sth->fetch();

if(empty($row)){
    foreach($citys as $city){
        $name = $city['locationName'];
        $weathers = array();
    
        for($i=0;$i<14;$i++){
            $weather = $city['weatherElement']['10']['time'][$i]['elementValue']['0']['value'];
            $weather = str_replace("。","<br>",$weather);
            array_push($weathers,$weather);
        }

        $sth = $db->prepare("insert into weather(city,firstDay,firstNight,secondDay,secondNight,thirdDay,thirdNight,fourthDay,fourthNight,fifthDay,fifthNight,sixthDay,sixthNight,seventhDay,seventhNight) values(:city,:firstDay,:firstNight,:secondDay,:secondNight,:thirdDay,:thirdNight,:fourthDay,:fourthNight,:fifthDay,:fifthNight,:sixthDay,:sixthNight,:seventhDay,:seventhNight)");
        execute($sth,$weathers,$name);
    
    }
}else{
    foreach($citys as $city){
        $name = $city['locationName'];
        $weathers = array();
    
        for($i=0;$i<14;$i++){
            $weather = $city['weatherElement']['10']['time'][$i]['elementValue']['0']['value'];
            $weather = str_replace("。","<br>",$weather);
            array_push($weathers,$weather);
        }
    
        $sth = $db->prepare("update weather set firstDay = :firstDay,firstNight = :firstNight,secondDay = :secondDay,secondNight = :secondNight,thirdDay = :thirdDay,thirdNight = :thirdNight,fourthDay = :fourthDay,fourthNight = :fourthNight,fifthDay = :fifthDay,fifthNight = :fifthNight,sixthDay = :sixthDay,sixthNight = :sixthNight,seventhDay = :seventhDay,seventhNight = :seventhNight where city = :city");
        execute($sth,$weathers,$name);
    
    }
}


function execute($sth,$weathers,$name){
    $sth->bindParam("city", $name, PDO::PARAM_STR,50);  
    $sth->bindParam("firstDay", $weathers[0], PDO::PARAM_STR,3000); 
    $sth->bindParam("secondDay", $weathers[2], PDO::PARAM_STR,3000);  
    $sth->bindParam("thirdDay", $weathers[4], PDO::PARAM_STR,3000);  
    $sth->bindParam("fourthDay", $weathers[6], PDO::PARAM_STR,3000);    
    $sth->bindParam("fifthDay", $weathers[8], PDO::PARAM_STR,3000);  
    $sth->bindParam("sixthDay", $weathers[10], PDO::PARAM_STR,3000);  
    $sth->bindParam("seventhDay", $weathers[12], PDO::PARAM_STR,3000);
    $sth->bindParam("firstNight", $weathers[1], PDO::PARAM_STR,3000); 
    $sth->bindParam("secondNight", $weathers[3], PDO::PARAM_STR,3000);  
    $sth->bindParam("thirdNight", $weathers[5], PDO::PARAM_STR,3000);  
    $sth->bindParam("fourthNight", $weathers[7], PDO::PARAM_STR,3000);    
    $sth->bindParam("fifthNight", $weathers[9], PDO::PARAM_STR,3000);  
    $sth->bindParam("sixthNight", $weathers[11], PDO::PARAM_STR,3000);  
    $sth->bindParam("seventhNight", $weathers[13], PDO::PARAM_STR,3000);  
    $sth->execute();
}


?>