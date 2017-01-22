<?php
/**
 * Created by PhpStorm.
 * User: zoyo
 * Date: 2017/1/21
 * Time: 10:53
 */

require 'vendor/autoload.php';

use Noodlehaus\Config;
use Carbon\Carbon;

$configPath = 'bclc.json';
$crawler = new Crawler($configPath);
$crawlerResult = $crawler->do();
print_r($crawlerResult);
exit;


class Crawler
{
    protected $curlKernel;
    protected $conf;
    protected $configFilePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($configPath)
    {
        $this->curlKernel = new CurlKernel();
        $this->configFilePath = $configPath;
        $this->conf = $this->readUpdateConfig($this->configFilePath);
    }

    /**
     * Execute the job.
     *
     * @return array of fieldnames => values
     */
    public function do()
    {
        $curlResult = $this->curlKernel->doCurl($this->conf->get('curlParaArr'));
        $parseResult = $this->doParse($curlResult);

        $isNewData = $this->IsNewData($parseResult);
//        if ($isNewData){
//            $this->store($parseResult);
//        }

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

    private function readUpdateConfig($configFilePath){
        $conf = Config::load($configFilePath);

        $addVal = $conf->get('base.urlParamVal');

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

class CurlKernel
{
    private function genCookie($curlParaArr) {
        $cookie = '';

        foreach ($curlParaArr['cookie_arr'] as $key => $value) {
            if($key != $curlParaArr['cookie_key'])
                $cookie .= $key . '=' . $value . ';';
            else
                $cookie .= $key . '=' . $value;
        }

        return $cookie;
    }

    public function doCurl($curlParaArr)
    {
        $ch = curl_init();

        /*      $proxy = '127.0.0.1';
                $proxyport = '8087';
                curl_setopt ($ch, CURLOPT_PROXY, $proxy);
                curl_setopt ($ch, CURLOPT_PROXYPORT, $proxyport);*/

        curl_setopt($ch, CURLOPT_URL, $curlParaArr['url']);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIE, $this->genCookie($curlParaArr));
        curl_setopt($ch, CURLOPT_USERAGENT, $curlParaArr['useragent']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $curlParaArr['timeout']);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return [
            "curlResult" => $result,
            "info" => $info,
            "err" => $err
        ];
    }
}