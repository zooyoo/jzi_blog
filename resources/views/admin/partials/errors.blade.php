@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>哎呀!</strong>
    你的输入有一些问题.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif