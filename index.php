<?php 

$contents = file_get_contents("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-BE1D27BE-4C21-406E-A26B-AA5B70F2D141");
$rain = file_get_contents("https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-BE1D27BE-4C21-406E-A26B-AA5B70F2D141");

$contents = json_decode($contents,true);
$rain = json_decode($rain,true);

$citys = $contents['records']['locations']['0']['location'];
$rows = $rain['records']['location'];

foreach($rows as $row){
    print($row['parameter']['0']['parameterValue']."：");
    print($row['locationName']."  ");
    print($row['weatherElement']['6']['elementValue']."<br>");
    print("<hr>");
}

// foreach($citys as $city){

//     $name = $city['locationName'];

//     for($i=0;$i<14;$i++){
//             for($i=0;$i<14;$i++){
//             $weather = $city['weatherElement']['10']['time'][$i]['elementValue']['0']['value'];
//             $startTime = $city['weatherElement']['10']['time'][$i]['startTime'];
//             $endTime = $city['weatherElement']['10']['time'][$i]['endTime'];
//             print($name."<br>");
//             print($startTime."至".$endTime."<br>");
//             print($weather."<br>"); 
//             print("<hr>");
//         }
//         print("<br><br><br>#############################################################<br><br><br>");
//     }

// }


?>