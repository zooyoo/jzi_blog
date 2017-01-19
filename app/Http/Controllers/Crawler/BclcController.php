<?php

namespace App\Http\Controllers\crawler;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CurlKernel;
use Noodlehaus\Config;

class BclcController extends Controller
{

    protected $curlKernel;

    public function __construct(CurlKernel $curlKernel)
    {
        $this->curlKernel = $curlKernel;
    }

    public function index(Request $request)
    {
        $configFilePath = base_path('crawlerConfig/bclc.json');

        $conf = $this->readUpdateConfig($configFilePath);
//        var_dump($urlParamNewVal);
//        var_dump($WT_FPC_lv_NewVal);
//        var_dump($WT_FPC_ss_NewVal);
//        print_r($conf->all());
        //print_r($conf->get('curlParaArr'))
        $curlResult = $this->curlKernel->doCurl($conf->get('curlParaArr'));

        $time = $curlResult[1]['total_time'];
        $error = $curlResult[2];

        preg_match($conf->get('preg_drawNbr'), $curlResult[0], $drawNbrArr);
        preg_match($conf->get('preg_drawDate'), $curlResult[0], $drawDateArr);
        preg_match($conf->get('preg_drawTime'), $curlResult[0], $drawTimeArr);
        preg_match($conf->get('preg_nums'), $curlResult[0], $numArr);
        preg_match($conf->get('preg_Bonus'), $curlResult[0], $bonusArr);

        //var_dump($content);

        return view('crawler.index',[
            'time' => $time,
            'drawNbr' => $drawNbrArr[1],
            'drawDateTime' => date('Y-m-d H:i:s',strtotime($drawDateArr[1] . $drawTimeArr[1])),
            'num' => $numArr[1],
            'bonus' => $bonusArr[1] . 'X',
            'error' => $error
        ]);
    }


    /*
     *读取并更新配置
     */
    private function readUpdateConfig($configFilePath){
        $conf = Config::load($configFilePath);

        $addVal = $conf->get('base.addVal');

        $urlParamNewVal = $conf->get('base.urlParamVal') + $addVal;
        $url = $conf->get('base.urlMain') . '?_=' . $urlParamNewVal;


        $WT_FPC_lv_NewVal = $conf->get('base.cookie_arr.WT_FPC_lv_val') + $addVal;
        $WT_FPC_ss_NewVal = $conf->get('base.cookie_arr.WT_FPC_ss_val') + $addVal;
        $cookie_WT_FPC = $conf->get('base.cookie_arr.WT_FPC_id_val')
            . ':lv=' . $WT_FPC_lv_NewVal . ':ss=' . $WT_FPC_ss_NewVal;

        $conf->set('curlParaArr.url', $url);
        $conf->set('curlParaArr.cookie_arr.WT_FPC', $cookie_WT_FPC);
        $conf->set('base.urlParamVal', strval($urlParamNewVal));
        $conf->set('base.cookie_arr.WT_FPC_lv_val', strval($WT_FPC_lv_NewVal));
        $conf->set('base.cookie_arr.WT_FPC_ss_val', strval($WT_FPC_ss_NewVal));

        $json_string = json_encode($conf->all());
        file_put_contents($configFilePath, $json_string);

        return $conf;
    }

}
