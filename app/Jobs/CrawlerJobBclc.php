<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\CurlKernel;
use Noodlehaus\Config;
use Carbon\Carbon;
use App\Bclc;

class CrawlerJobBclc implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $curlKernel;
    protected $conf;
    protected $configFilePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->curlKernel = new CurlKernel();
        $this->configFilePath = base_path('crawlerConfig/bclc.json');
        $this->conf = $this->readUpdateConfig($this->configFilePath);
    }

    /**
     * Execute the job.
     *
     * @return array of fieldnames => values
     */
    public function handle()
    {
        $curlResult = $this->curlKernel->doCurl($this->conf->get('curlParaArr'));
        $parseResult = $this->doParse($curlResult);

        if ($this->IsNewData($parseResult)){
            $this->store($parseResult);
        }

        return $parseResult;
    }

    private function saveConfig($conf){
        $json_string = json_encode($conf->all());
        file_put_contents($this->configFilePath, $json_string);
    }

    public function store($parseResult){
        $bclc = new Bclc();
        foreach (array_keys($parseResult) as $field){
            $bclc->$field = $parseResult[$field];
        }
        $bclc->save();
    }

    /*
     * 重复判断
     */
    private function IsNewData($parseResult){
        $drawNbr = $parseResult['drawNbr'];
        if ($drawNbr == $this->conf->get('draoNbrCache')){
            return false;
        }
        else{
            $this->conf->set('draoNbrCache', $drawNbr);
            $this->saveConfig($this->conf);
            return true;
        }
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

        $this->saveConfig($conf);
        return $conf;
    }

    /*
     * 解析
     */
    private function doParse($curlResult){
        $pregs = $this->conf->get('preg');
        $pregResult = $pregs;

        foreach ($pregs as $preg){
            preg_match($preg, $curlResult['curlResult'], $pregResult[key($pregs)]);
            next($pregs);
        }

        $numArr = explode(',',$pregResult['nums'][1]);

        $parseResult = [
            'curlTime' => $curlResult['info']['total_time'],
            'drawNbr' => $pregResult['drawNbr'][1],
            'drawDateTime' => date('Y-m-d H:i:s',strtotime($pregResult['drawDate'][1] . $pregResult['drawTime'][1])),
            'nums' => $pregResult['nums'][1],
            'num1' => $numArr[0],
            'num2' => $numArr[1],
            'num3' => $numArr[2],
            'num4' => $numArr[3],
            'num5' => $numArr[4],
            'num6' => $numArr[5],
            'num7' => $numArr[6],
            'num8' => $numArr[7],
            'num9' => $numArr[8],
            'num10' => $numArr[9],
            'num11' => $numArr[10],
            'num12' => $numArr[11],
            'num13' => $numArr[12],
            'num14' => $numArr[13],
            'num15' => $numArr[14],
            'num16' => $numArr[15],
            'num17' => $numArr[16],
            'num18' => $numArr[17],
            'num19' => $numArr[18],
            'num20' => $numArr[19],
            'bonus' => $pregResult['Bonus'][1],
            'insertTime' => date('Y-m-d H:i:s',strtotime(Carbon::now())),
            'error' => $curlResult['err']
        ];

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
