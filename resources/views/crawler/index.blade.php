<!DOCTYPE html>
<html lang="en">
<head>
    <title>JZiCrawler</title>
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
</head>
<body>

    {{--<script type="text/javascript">--}}

        {{--//前端Ajax持续调用服务端，称为Ajax轮询技术--}}
        {{--document.write('111');--}}

        {{--var getting = {--}}

            {{--url:'http://jziblog.app/crawler/bclcInfo',--}}

            {{--dataType:'json',--}}

            {{--success:function(res) {--}}

                {{--console.log(res);--}}

                {{--$.ajax(getting); //关键在这里，回调函数内再次请求Ajax--}}

            {{--},--}}

            {{--//当请求时间过长（默认为60秒），就再次调用ajax长轮询--}}
            {{--error:function(res){--}}
                {{--$.ajax($getting);--}}
            {{--}--}}

        {{--};--}}

        {{--document.write('222');--}}

        {{--$.ajax(getting);--}}

        {{--document.write(getting);--}}

    {{--</script>--}}


    <b>耗时： </b> <span style="color: #0000ff;"> {{ $curlTime }} </span>
    <br>

    <b>期号： </b> <span style="color: #0000ff;"> {{ $drawNbr }} </span>
    <br>

    <b>开奖时间： </b> <span style="color: #0000ff;"> {{ $drawDateTime }} </span>
    <br>

    <b>开奖号： </b> <span style="color: #0000ff;"> {{ $nums }} </span>
    <br>

    <b>奖金倍数： </b> <span style="color: #0000ff;"> {{ $bonus }} </span>
    <br>

    <b>错误： </b> <span style="color: #0000ff;"> {{ $error }} </span>

</body>
</html>

