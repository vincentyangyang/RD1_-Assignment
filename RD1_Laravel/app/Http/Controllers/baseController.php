<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gethtml;
use App\Rainfall;
use App\Weather;
use App\Twoday;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class baseController extends Controller
{
    public function index(Request $request){
        if($request->input("id")){
            $html = Gethtml::where('hId',$request->input("id"))->first();
            $rainfalls = Rainfall::where('city',$html['city'])->get();
            $weathers = Weather::where('city',$html['city'])->get();

            $data = ['html'=>$html, 'rainfalls'=>$rainfalls, 'weathers'=>$weathers,'id'=>$request->input("id")];

            return view('index',$data);
        }

        $data = ['html'=>[], 'rainfalls'=>[], 'weathers'=>[],'id'=>$request->input("id")];

        return view('index',$data);
    }

    public function getWeek(){
        include_once("getWeek.php");

        //更新現在及未來兩天逐三小時天氣
        include_once("getData.php");
        
        return redirect()->route('index');
    }

    public function getTwoDay(Request $request){
        $twoDay = Twoday::where('city',$request->input('city'))->first();
        return $twoDay;
    }

    public function getRain(){
        //執行python檔，更新雨量

        $process = new Process(['/usr/local/bin/python3', '/Applications/MAMP/htdocs/RD1_Laravel/app/Http/Controllers/getRain.py']);
        
        $process->setTimeout(1200);
        $process->setIdleTimeout(1200);

        $process->run();

        return redirect()->route('index');
    }
}
