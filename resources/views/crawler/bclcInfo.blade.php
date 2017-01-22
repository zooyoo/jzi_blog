<?php

print_r('333');

//这段AJAX请求时间永不过期
set_time_limit(0);

//$pdo = new PDO('mysql:dbname=test;host=127.0.0.1','root','root');
//
//$resource = $pdo->query('select * from t1');
//
//$result = $resource->fetchall();
$result = ['date' => '2015', 'nums' => '2.6.9'];

print_r($result);

while (true) {

    if ($result) {

        //exits data
        print_r(json_encode($result));
        //print_r(json_encode(array('success'=>'存在数据，返回')));

        exit(); //输出数据，退出。然后客户端不间断继续发起请求

    }

    //数据不存在，继续循环。

}

?>