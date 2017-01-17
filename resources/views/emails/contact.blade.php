<p>
    您已收到来自您的网站联系方式的新消息.</p><p>
    详细如下:
</p>
<ul>
    <li>姓名: <strong>{{ $name }}</strong></li>
    <li>邮箱: <strong>{{ $email }}</strong></li>
    <li>电话: <strong>{{ $phone }}</strong></li>
</ul>
<hr>
<p>
    @foreach ($messageLines as $messageLine)
        {{ $messageLine }}<br>
    @endforeach
</p>
<hr>