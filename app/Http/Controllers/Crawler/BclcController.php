<?php

namespace App\Http\Controllers\crawler;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CurlKernel;
use Noodlehaus\Config;

class BclcController extends Controller
{

    protected $curlKernel;
    protected $conf;

    public function __construct(CurlKernel $curlKernel)
    {
        $this->curlKernel = $curlKernel;
        $this->conf = $this->readUpdateConfig(base_path('crawlerConfig/bclc.json'));
    }

    public function index(Request $request)
    {
        $curlResult = $this->curlKernel->doCurl($this->conf->get('curlParaArr'));
        $parseResult = $this->doParse($curlResult);

        return view('crawler.index',[
            'time' => $curlResult['info']['total_time'],
            'drawNbr' => $parseResult['drawNbr'][1],
            'drawDateTime' => date('Y-m-d H:i:s',strtotime($parseResult['drawDate'][1] . $parseResult['drawTime'][1])),
            'num' => $parseResult['nums'][1],
            'bonus' => $parseResult['Bonus'][1] . 'X',
            'error' => $curlResult['err']
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

    /*
     * 解析
     */
    private function doParse($src){
        $pregs = $this->conf->get('preg');
        $parseResult = $pregs;

        foreach ($pregs as $preg){
            preg_match($preg, $src['curlResult'], $parseResult[key($pregs)]);
            next($pregs);
        }

        return $parseResult;
        /*        print_r($pregs);
                echo '<br>';
                print_r($parseResult);

                preg_match($this->conf-->get('preg.drawNbr'), $src[0], $drawNbrArr);
                preg_match($this->conf-->get('preg.drawDate'), $src[0], $drawDateArr);
                preg_match($this->conf-->get('preg.drawTime'), $src[0], $drawTimeArr);
                preg_match($this->conf-->get('preg.nums'), $src[0], $numArr);
                preg_match($this->conf-->get('preg.Bonus'), $src[0], $bonusArr);*/
    }

}
