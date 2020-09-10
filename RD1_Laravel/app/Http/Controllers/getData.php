<?php
    use App\Weather;
    use App\Twoday;

    use Illuminate\Support\Facades\DB;

    $twoDay = file_get_contents("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-BE1D27BE-4C21-406E-A26B-AA5B70F2D141&elementName=WeatherDescription");
    $twoDay = json_decode($twoDay,true);
    $nowWeathers = $twoDay['records']['locations']['0']['location'];

    $weather = Weather::all();

        //抓未來兩天(逐3小時)放到twoDays
        $k = 0;

        $data = Twoday::all();

        $startTime = $nowWeathers["0"]['weatherElement']['0']['time']['0']['endTime'];
        $startTimeArray = preg_split("/[\s]+/",$startTime);
        $startTimeArray = preg_split("/:/",$startTimeArray[1]);
        $index = ( (24 - $startTimeArray[0]) / 3 ) +1;
    
        //twoDay資料表沒資料
        if (count($data) == 0){ 

            foreach($nowWeathers as $nowWeather){
                $twoDayArray = array();
    
                for ($j=$index; $j<($index+16); $j++){
                    $twoDay = $nowWeather['weatherElement']['0']['time'][$j]['elementValue']['0']['value'];
                    array_push($twoDayArray,$twoDay);
                }

                DB::insert("insert into twodays(city,one,two,three,four,five,six,seven,eight,nine,ten,eleven,twelve,thirteen,fourteen,fifteen,sixteen) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                    [$weather[$k]['city'],$twoDayArray[0], $twoDayArray[1],$twoDayArray[2],$twoDayArray[3],$twoDayArray[4],$twoDayArray[5],$twoDayArray[6],$twoDayArray[7],$twoDayArray[8],$twoDayArray[9],$twoDayArray[10],$twoDayArray[11],$twoDayArray[12],$twoDayArray[13],$twoDayArray[14],$twoDayArray[15]]);
    
                $k++;

            }
        }
        //twoDays資料表有資料
        else{
            foreach($nowWeathers as $nowWeather){
                $twoDayArray = array();
    
                for ($j=$index; $j<$index+16; $j++){
                    $twoDay = $nowWeather['weatherElement']['0']['time'][$j]['elementValue']['0']['value'];
                    array_push($twoDayArray,$twoDay);
                }
    
                DB::update("update twodays set one=?,two=?,three=?,four=?,five=?,six=?,seven=?,eight=?,nine=?,ten=?,eleven=?,twelve=?,thirteen=?,fourteen=?,fifteen=?,sixteen=? where city = ?",
                    [$twoDayArray[0],$twoDayArray[1],$twoDayArray[2],$twoDayArray[3],$twoDayArray[4],$twoDayArray[5],$twoDayArray[6],$twoDayArray[7],$twoDayArray[8],$twoDayArray[9],$twoDayArray[10],$twoDayArray[11],$twoDayArray[12],$twoDayArray[13],$twoDayArray[14],$twoDayArray[15],$weather[$k]['city']]);
    
                $k++;
            }
        }


    $i = 0;

    //抓當前天氣放到weather
    foreach($nowWeathers as $nowWeather){
        $now = $nowWeather['weatherElement']['0']['time']['0']['elementValue']['0']['value'];

        DB::update("update weathers set now = ? where city = ?",
            [$now, $weather[$i]['city']]);

        $i++;
    }



?>