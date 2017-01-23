<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>


</head>

<body>

<div id="result"></div>

</body>



<script>
//    $(document).ready(function(){
//        setInterval(function() {
//            $("#result").load("http://localhost/bclc.php");
//        }, 5000);
//    });
    $("#result").load("/crawler/bclcsingle");

    setInterval(function() {
        $("#result").load("/crawler/bclcsingle");
    }, 5000);
</script>

<!--<script type="text/javascript">-->
<!--    //前端Ajax持续调用服务端，称为Ajax轮询技术-->
<!--    var getting = {-->
<!--        url:'http://localhost/bclc.php',-->
<!--        dataType:'html',-->
<!--        success:function(res) {-->
<!--            $('#result').html(res);-->
<!--            //$.ajax(getting); //关键在这里，回调函数内再次请求Ajax-->
<!--        },-->
<!--        //当请求时间过长（默认为60秒），就再次调用ajax长轮询-->
<!--        error:function(res){-->
<!--            $.ajax($getting);-->
<!--        }-->
<!--    };-->
<!--    $.ajax(getting);-->
<!---->
<!--    window.setInterval(function(){$.ajax(getting)},5000);-->
<!--</script>-->


<!---->
<!--<script type="text/javascript">-->
<!--    $(function () {-->
<!---->
<!--        (function longPolling() {-->
<!---->
<!--            $.ajax({-->
<!--                url: "http://localhost/bclc.php",-->
<!--                data: {"timed": new Date().getTime()},-->
<!--                dataType: "text",-->
<!--                timeout: 5000,-->
<!--                error: function (XMLHttpRequest, textStatus, errorThrown) {-->
<!--                    $('#test').text(errorThrown);-->
<!--                    if (textStatus == "timeout") { // 请求超时-->
<!--                        longPolling(); // 递归调用-->
<!---->
<!--                        // 其他错误，如网络错误等-->
<!--                    } else {-->
<!--                        longPolling();-->
<!--                    }-->
<!--                },-->
<!--                success: function (data, textStatus) {-->
<!--                    $('#test').text(res);-->
<!---->
<!--                    if (textStatus == "success") { // 请求成功-->
<!--                        longPolling();-->
<!--                    }-->
<!--                }-->
<!--            });-->
<!--        })();-->
<!---->
<!--    });-->
<!--</script>-->