<?php

use App\Weather;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

$process = new Process(['/usr/local/bin/python3', '/Applications/MAMP/htdocs/RD1_Laravel/app/Http/Controllers/getWeek.py']);
$process->setTimeout(120);
$process->setIdleTimeout(120);
$process->run();


// //抓取一週天氣概況
$week = file_get_contents("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-BE1D27BE-4C21-406E-A26B-AA5B70F2D141");
$week = json_decode($week,true);

$citys = $week['records']['locations']['0']['location'];

$row = Weather::all();


if(count($row) == 0){
    foreach($citys as $city){
        $name = $city['locationName'];
        $weathers = array();

        for($i=0;$i<14;$i++){
            $weather = $city['weatherElement']['10']['time'][$i]['elementValue']['0']['value'];
            $weather = str_replace("。","<br>",$weather);
            array_push($weathers,$weather);
        }

        DB::insert("insert into weathers(city,firstDay,firstNight,secondDay,secondNight,thirdDay,thirdNight,fourthDay,fourthNight,fifthDay,fifthNight,sixthDay,sixthNight,seventhDay,seventhNight) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [$name,$weathers[0],$weathers[1],$weathers[2],$weathers[3],$weathers[4],$weathers[5],$weathers[6],$weathers[7],$weathers[8],$weathers[9],$weathers[10],$weathers[11],$weathers[12],$weathers[13]]);
    
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
    
        DB::update("update weathers set firstDay=?,firstNight=?, secondDay=?, secondNight=?, thirdDay=?, thirdNight=?, fourthDay=?, fourthNight=?, fifthDay=?, fifthNight=?, sixthDay=?, sixthNight=?, seventhDay=?, seventhNight=? where city=?",
            [$weathers[0],$weathers[1],$weathers[2],$weathers[3],$weathers[4],$weathers[5],$weathers[6],$weathers[7],$weathers[8],$weathers[9],$weathers[10],$weathers[11],$weathers[12],$weathers[13],$name]);
    
    }
}


?>