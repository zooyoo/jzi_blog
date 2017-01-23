<?php

namespace App\Http\Controllers\crawler;

use App\Services\CurlKernel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\CrawlerJobBclc;
use app\CrawlerEvent;



class BclcController extends Controller
{

//    protected $fields = [
//        'curlTime' => 0,
//        'drawNbr' => 0,
//        'drawDateTime' => '',
//        'nums' => '',
//        'num1' => 0,
//        'num2' => 0,
//        'num3' => 0,
//        'num4' => 0,
//        'num5' => 0,
//        'num6' => 0,
//        'num7' => 0,
//        'num8' => 0,
//        'num9' => 0,
//        'num10' => 0,
//        'num11' => 0,
//        'num12' => 0,
//        'num13' => 0,
//        'num14' => 0,
//        'num15' => 0,
//        'num16' => 0,
//        'num17' => 0,
//        'num18' => 0,
//        'num19' => 0,
//        'num20' => 0,
//        'bonus' => 0,
//        'insertTime' => '',
//        'error' => ''
//    ];

    public function __construct()
    {

    }

    public function index(Request $request)
    {
        //$this->dispatch(new CrawlerJobBclc());

        return view('crawler.show');
    }

    public function bclcInfo(){
        //return view('crawler.bclcInfo');
    }

    public function bclcsingle(){
        //echo  '112233';
        return view('crawler.bclcsingle');
    }

}
