<?php

namespace App\Services;

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