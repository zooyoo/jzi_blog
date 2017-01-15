@extends('layouts.app')

@section('content')
    <!-- Bootstrap 样板文件 -->

    <div class="panel-body">
        <!-- 显示验证错误 -->
        @include('errors.503')

        <!-- 新任务表单 -->
        <form action="/task" method="post" class="form-horizontal">
            {{ csrf_field() }}

            <!-- 任务名称 -->
            <div class="form-group">
                <label for="task" class="col-sm-3 control-label">任务</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="task-name" class="form-control">
                </div>
            </div>

            <!-- 添加任务按钮 -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> 添加任务
                    </button>
                </div>
            </div>
        </form>

    </div>

    <!-- 当前任务列表 -->
    @if (count($tasks) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                当前任务列表
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- 表头 -->
                    <thead>
                        <th>任务</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- 表体 -->
                    <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <!-- 任务名称 -->
                            <td class="table-text">
                                <div>{{ $task -> name }}</div>
                            </td>

                            <!-- 删除按钮 -->
                            <td>
                                <form action="/task/{{ $task->id }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button>删除任务</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection